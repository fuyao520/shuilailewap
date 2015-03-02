<?php
class Cms extends CActiveRecord{
	public $categorys=array();
	public $models=array();
	public $seoData=array();
	
	public function tableName() {
		return '{{info_category}}';
	}
	public function __construct($scenario='insert'){
		parent::__construct($scenario);
		$this->categorys=InfoCategory::model()->categorys;
		$this->models=InfoModel::model()->get_model();
		$this->seoData=SiteSeo::model()->getSeodata();
	}	
		
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	/********************分类方法******************************************/
	//取分类的父分类（所有上级），返回数组
	public function cate_father($cate_id){//echo($cate_id.'<br>');
		$top_cate=array();
		array_push($top_cate,$this->categorys[$cate_id]);
		$tmp=array(0=>array());
		$parent_id=$this->categorys[$cate_id]['parent_id'];
		if(intval($parent_id)>0){
			$top_cate=$this->cate_father($parent_id);
			array_push($top_cate,$this->categorys[$cate_id]);
		}
		return $top_cate;
	}
	//取分类的子分类，返回数组，树状
	public function cate_son($cate_id=0){
		$ret=array();
		foreach($this->categorys as $c){
			if($c['parent_id']==$cate_id){
				$c['son']=$this->cate_son($c['cate_id']);
				array_push($ret,$c);
			}
		}
		$ret=helper::array_sort($ret,'corder');
		return $ret;
	}
	//取某个分类所有的子分类，作为数组，不是树状
	function cate_son_arr($parent_id){
		$bb=array();
		foreach($this->categorys as $c){
			if($c['parent_id']==$parent_id){
				$bb[]=$c['cate_id'];
				$son=$this->cate_son_arr($c['cate_id']);
				$bb=array_merge($bb,$son);
			}
		}
		return $bb;
	}
	//取分类的平级分类，返回数组
	public function cate_brother($cate_id){
		$pson=$this->cate_son($this->categorys[$cate_id]['parent_id']);
		$brother=array();
		foreach($pson as $c){
			array_push($brother,$c);
		}
		return $brother;
	}


	/********************信息内容正文方法******************************************/
	//取内容，返回数组
	public function info_content($table,$info_id){
		$sql="select * from $table where info_id=$info_id and audit=1 ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0) return false;
		$c=$a['list'][0];
		$c['comments_total']=0;
		$c['title']=$c['info_title'];
		$c['thumb']=$c['info_img'];
		$c['info_body']=$this->nlink($c['info_body']);
		$c['extern_array']=helper::json_decode_cn($c['info_extern'],1);
		$c['tag_list']=$this->get_info_tags($c['info_tags']);
		//检测文档是否设置拼音别名
		if(trim($c['info_py'])){
			$z=$c['info_py'];
		}else{
			$z=$c['info_id'];
		}
		$c['url']=$this->set_info_url($c);
		$sql="select * from resource_list where fromid='$table-$info_id'";//echo $sql;
		$b['list']=Yii::app()->db->createCommand($sql)->queryAll();
		for($i=0;$i<count($b['list']);$i++){
			$tmp_img=$b['list'][$i]['resource_url'];
			$b['list'][$i]['thumb']=substr($tmp_img,0,strrpos($tmp_img,'/')+1).'thumb_'.substr($tmp_img,strrpos($tmp_img,'/')+1);
		}
		$c['cate_now']=$this->categorys[$c['last_cate_id']];
		$c['resource']=$b['list'];
		return $c;
	}
	
	//取得html代码中的所有图片
	public function get_html_img($html){
		$re=array();
		if(preg_match_all('~<img[^>]*src=(\'|")(.*?)\\1[^>]*>~i',$html,$result)){
			foreach($result[2] as $r){
				$s=array();
				$s['resource_url']=$r;
				$s['thumb']=Attachment::simg($r);
				$re[]=$s;
			}
		}
		return $re;
	}
	
	public function get_info_tags($str){
		$str=trim($str);
		if($str=='') return array();
		$str=str_replace('，',',',$str);
		$a=explode(',',$str);
		return $a;
	}
	//根据标签获取相关数据
	public function get_tag_info_list($model,$info_tag,$pagesize=10){
		$arr=$this->get_info_tags($info_tag);
		if(count($arr)==0){
			return array();
		}
		$where=" and l.info_tags  like '%".$arr[0]."%' ";
		$a=Cms::model()->info_list(array('model'=>$model,'andwhere'=>$where,'pagesize'=>$pagesize));
		return $a;
	}
	
	//详情页的时候把文章内容分页
	public function info_content_page($info,$p=1){
		//拆分文档
		$carr=explode('<p class="pagebreak"></p>',$info['info_body']);
		if(count($carr)<2){
			return array('pagebar'=>array(),'content'=>$info['info_body']);
		}

		$cate=$this->categorys[$info['last_cate_id']];
		$host='';
		if($this->categorys[$info['last_cate_id']]['cate_host']){
			$host=$this->categorys[$info['last_cate_id']]['cate_host'];
		}else{
			$host=Yii::app()->params['basic']['siteurl'];
		}
		//检测文档是否设置拼音别名
		if(trim($info['info_py'])){
			$z=$info['info_py'];
		}else{
			$z=$info['info_id'];
		}
		$year=date("Y",$info['create_time']);
		$month=date("m",$info['create_time']);
		$day=date("d",$info['create_time']);//print_r($cate['csetting']['detail_rewrites']);
		$page_rule=$cate['csetting']['detail_rewrites']['rewrite_page_rule'];
		url::$url_config['info_detail']['page_rule']=$page_rule;
		$pageurl=url::encode('info_detail',array('host'=>$host,'cate_id'=>$info['last_cate_id'],'cname_py'=>$cate['cname_py'],'info_id'=>$z,'year'=>$year,'month'=>$month,'day'=>$day),'page_rule');
		$pagearr=helper::pagehtml(array('total'=>count($carr),"pagesize"=>1,'list_str'=>$pageurl,'show'=>2));
		return array('pagebar'=>$pagearr,'content'=>'test'.$carr[$p-1]);

	}
	//设置 文档 的 url
	public function set_info_url($info){
		if(!isset($info['last_cate_id'])) return false;
		if(!isset($this->categorys[$info['last_cate_id']])) return false;
		$cate=$this->categorys[$info['last_cate_id']];
		$re='';
		if(isset($info['info_jump_url']) && $info['info_jump_url']!=''){
			$re=$info['info_jump_url'];
		}else{
			//检测分类是否设置了详细页的伪静态
			if(isset($cate['csetting']['detail_rewrites']['rewrite_rule']) && $cate['csetting']['detail_rewrites']['rewrite_rule']){
				$rule=$cate['csetting']['detail_rewrites']['rewrite_rule'];
				url::$url_config['info_detail']['rule']=$rule;
			}
			$host='';
			if($this->categorys[$info['last_cate_id']]['cate_host']){
				$host=$this->categorys[$info['last_cate_id']]['cate_host'];
			}else{
				$host=Yii::app()->params['basic']['siteurl'];
			}
			//检测文档是否设置拼音别名
			if(trim($info['info_py'])){
				$z=$info['info_py'];
			}else{
				$z=$info['info_id'];
			}
			$year=date("Y",$info['create_time']);
			$month=date("m",$info['create_time']);
			$day=date("d",$info['create_time']);
			$re=url::encode('info_detail',array('host'=>$host,'cate_id'=>$info['last_cate_id'],'cname_py'=>$cate['cname_py'],'info_id'=>$z,'year'=>$year,'month'=>$month,'day'=>$day));
		}
		return $re;
	}
	//內链关键词替换，返回替换后的文本
	public function nlink($content){
		$sql="select * from nlink";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($a['list'] as $key){
			$content=preg_replace('~([^>])('.$key['nlink_txt'].')([^<])~u','$1<a class="nlink" target=_blank href="'.$key['nlink_url'].'">'.$key['nlink_txt'].'</a>$3',$content,1);
		}
		return $content;
	}


	/********************列表方法******************************************/

	//取分类列表，返回数组
	/*

	*/
	public function info_list($params=array()){
		//传入的是数组
		$ret=array(); //返回的数据
		$ret['list']=array();
		$ret['pagecode']='';
		$ret['total']='';
		$table='';
		$params['cate_id']=isset($params['cate_id'])?$params['cate_id']:0;
		$bak_cate_id=$params['cate_id'];
		$params['model']=isset($params['model'])?$params['model']:'';
		if($params['cate_id']==0&&$params['model']==''){
			return;
		}
		
	    if($params['cate_id']){
			$true_cate_id=explode(',',$params['cate_id']);  
			$table=$this->categorys[$true_cate_id[0]]['model_table_name'];  //如果有 cate_id  的形式为  3,4,5,9  ，则表采用 第一个 3的模型表
		}
		if($params['model']){
		    $table=$params['model'];	
		}
		
		$params['pagesize']=isset($params['pagesize'])?intval($params['pagesize']):10;
		$params['ordersql']=isset($params['ordersql'])?$params['ordersql']:'';
		$params['andwhere']=isset($params['andwhere'])?$params['andwhere']:'';
		$params['joinsql']=isset($params['joinsql'])?$params['joinsql']:'';
		$params['selectsql']=isset($params['selectsql'])?$params['selectsql']:' l.* ';
		$params['recommend_id']=isset($params['recommend_id'])?intval($params['recommend_id']):0;
		$params['pageshowtype']=isset($params['pageshowtype'])?$params['pageshowtype']:8;
		$params['rand']=isset($params['rand'])?$params['rand']:'';
		$params['like']=isset($params['like'])?$params['like']:'';
		$params['fullsearch']=isset($params['fullsearch'])?$params['fullsearch']:'';
		
		//处理
		$params['andwhere']=' where l.last_cate_id>0 and l.audit=1 '.$params['andwhere'];
		
		if($params['recommend_id']){
			$inid=$this->get_recommend_inid($params['recommend_id']);
			$params['andwhere'].=" and l.info_id in($inid)";
			$params['ordersql']=" order by substring_index('$inid',info_id,1) desc ";
		}
		
		if($params['like']&&!$params['fullsearch']){
			$params['andwhere'].=" and (l.info_title like '%".$params['like']."%')";
		}
		if($params['fullsearch']){			
			$params['like']=str_replace(',',' OR ',$params['like']);
			$params['like']=str_replace(array('《','》','"',"'"),'',$params['like']);
			$se=Yii::app()->search_article;
			$docs =$se->setLimit($params['pagesize'],($_GET['p']-1)*$params['pagesize'])
			->setSort('create_time') // 按 chrono 字段的值倒序
			->search($params['like']); // 取得搜索结果文档
			$se_list=array();//print_r($docs);
			foreach ($docs as $mr){
				$se_list[]=$mr->info_id;
			}
			$inid=implode(',',$se_list);
			if($inid){
				$params['andwhere'].=" and l.info_id in($inid)";
			}else{
				$params['andwhere']=' where 1=2 ';
			}
		}		
		
		if($params['model']==''){
			if(is_numeric($params['cate_id'])){
				//如果传入的是 'cate_id'=>6 这种形式
				//拼装where id in()
				$gidarr=array();
				//获取子栏目
				$gidarr=$this->cate_son_arr($params['cate_id']);
				//加上自己
				$gidarr[]=$bak_cate_id;
				//同时获取指定栏目的内容
				$gids=array();
				foreach($gidarr as $a){
					if($this->categorys[$a]['getcateids']){
						$gidarr2=explode(',',$this->categorys[$a]['getcateids']);
						foreach($gidarr2 as $r5){
							$gidarr3=$this->cate_son_arr($r5);
							if(count($gidarr3)){
								$gids[]=implode(',',$gidarr3);	
							}
						}
						$gids[]=$this->categorys[$a]['getcateids'];  
					}
				}
				$params['cate_id']=implode(',',$gidarr);
				if(count($gids)) $params['cate_id'].=','.implode(',',$gids);
			}else{  //如果是 'cate_id'=>'2,5,7'这种形式
				//拼装where id in()
				$gidarr=explode(',',$params['cate_id']);
				$newgidarr2=array();
				$newgidarr=array();
				foreach($gidarr as $a){
					$newgidarr=$this->cate_son_arr($a);	
					$newgidarr2=array_merge($newgidarr2,$newgidarr);
				}
				
				//print_r($newgidarr);
				//同时获取指定栏目的内容
				$gids=array();
				foreach($gidarr as $a){
					if($this->categorys[$a]['getcateids']) $gids[]=$this->categorys[$a]['getcateids']; 
				}
				$params['cate_id'].=','.implode(',',$newgidarr2);
				if(count($gids)){
					$params['cate_id'].=','.implode(',',$gids);
				}
				if(preg_match('~,$~',$params['cate_id'])){
					$params['cate_id']=substr($params['cate_id'],0,strlen($params['cate_id'])-1);	
				}
			}
		}

		if($params['cate_id']){
			$params['andwhere'] .=" and (l.last_cate_id in(".$params['cate_id'].")) ";
		}
		
		
		//强制设置 where 语句
		if(isset($params['setwhere'])){
			$params['andwhere']=$params['setwhere'];
		}
	
		//$params['ordersql']=$params['ordersql']?$params['ordersql']:" order by l.info_order,l.create_time desc ";
		$params['ordersql']=$params['ordersql']?$params['ordersql']:" order by l.create_time desc ";
		if($params['ordersql']=='no'){
		    $params['ordersql']='';	
		}
		
		if($params['rand']==1){
			$randwhere='';
			if($params['cate_id']){
				$randwhere.=" and (last_cate_id in(".$params['cate_id'].")) ";
				$rwhere=" where t3.last_cate_id in(".$params['cate_id'].") ";
			}
			$params['joinsql'] .=" JOIN (SELECT ROUND(RAND() * (SELECT MAX(info_id) FROM `$table` as t3  )) AS info_id) AS t2 ";
			$params['andwhere'] = "  where l.info_id >= t2.info_id ".$randwhere;
			$params['ordersql']='';
			//$params['debug']=1;
		}
		
		$count=0;
		$suffix='';
        //设置分页大小和页码默认值
        if(!isset($params['pagesize']) || !is_numeric($params['pagesize'])) $params['pagesize']=10; //默认分页大小
        if(!isset($params['p']) || !is_numeric($params['p'])){$params['p']=1;}else{$count=1;} //默认页码，如果传入了该值，则会进行分页统计
        //拼接 order by 和 limit 语句
		$suffix.=" limit ".($params['p']-1)*$params['pagesize'].",".$params['pagesize'];
		$sql="select ".$params['selectsql']." from  ".$table."  l  ".$params['joinsql']." ".$params['andwhere']." ".$params['ordersql']." $suffix ";
		$count_sql="select count(1) as total from  ".$table."  l  ".$params['joinsql']." ".$params['andwhere']."";
		if(isset($params['debug'])){
		    echo($sql);
		}
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if($count==1){
		    $cr['list']=Yii::app()->db->createCommand($count_sql)->queryAll();
			$rsarrs['total']=$cr['list'][0]['total'];	
		}
		foreach($rsarrs['list'] as $a){
			$a['cate']=$this->categorys[$a['last_cate_id']];
			$a['url']=$this->set_info_url($a);
			$a['comments_total']=0;
			$a['tag_list']=$this->get_info_tags($a['info_tags']);
			if(isset($a['ftitle'])&&$a['ftitle']){
				$a['title']=$a['ftitle'];
			}else{
				$a['title']=$a['info_title'];
			}
			$a['thumb']=Attachment::simg($a['info_img']);
			$a['extern_array']=helper::json_decode_cn($a['info_extern'],1);
			$ret['list'][]=$a;
		}
		if($count==1) {			
			$pageurl='';
			if(url::$rewrite==1&&is_numeric($bak_cate_id)){
				//这里很可能要变更
				$page_rule=$this->categorys[$bak_cate_id]['csetting']['list_rewrites']['rewrite_page_rule'];
				url::$url_config['info_list']['page_rule']=$page_rule;//echo $page_rule;
				$host='';
				if($this->categorys[$bak_cate_id]['cate_host']){
					$host=$this->categorys[$bak_cate_id]['cate_host'];
				}else{
					$host=Yii::app()->params['basic']['siteurl'];	
				}
				$pageurl=url::encode('info_list',array('host'=>$host,'cate_id'=>$this->categorys[$bak_cate_id]['cate_id'],'cname_py'=>$this->categorys[$bak_cate_id]['cname_py']),'page_rule');
				//echo $pageurl;die();
			}
			if(isset($params['pageurl'])){
			    $pageurl=$params['pageurl'];	
			}
			$pagearr=helper::pagehtml(array('total'=>$rsarrs['total'],"pagesize"=>$params['pagesize'],'list_str'=>$pageurl,'show'=>$params['pageshowtype']));
		    $ret['pagearr']=$pagearr;
			$ret['total']=$pagearr['total'];
		}
		return $ret;
	}
	//上一篇下一篇
	public function info_prev_next($table,$info_id,$cate_id){
		$ret=array();
		$ret['prev']=array();
		$ret['next']=array();
		//查询数据量有多少，超过5万条的话就不处理，否则很慢
		$sql="select count(1) as total from $table ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if($a['list'][0]['total']>50000) return;		
			//上一篇
			$sql="select * from $table where info_id<$info_id and last_cate_id=$cate_id order by info_id desc limit 1";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])>0){
			$ret['prev']=$this->info_content($table,$a['list'][0]['info_id']);
		}
		//下一篇
		$sql="select * from $table where info_id>$info_id  and last_cate_id=$cate_id order by info_id asc limit 1";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])>0){
		$ret['next']=$this->info_content($table,$a['list'][0]['info_id']);
		}
		return $ret;
	}

	


    /********************其它方法******************************************/
	//取友情连接，返回数组 ,$get_type ， 0=取所有， 1=取文字， 2=取图片
	public function flink($get_type=0,$city_id=0){
		$andwhere='';
		if($get_type==1){
		$andwhere=" and(flink_img='')";
		}else if($get_type==2){
		$andwhere=" and(flink_img!='')";
				}
				if($city_id){
				$sql="select * from flink  where city_id=$city_id $andwhere ";
				$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
						if(count($a['list'])==0){
						$sql="select * from flink  where city_id=0 $andwhere ";
						$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
				}
				}else{
				$sql="select * from flink  where 1 $andwhere ";
				$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		}
		return $a['list'];
	}
/********************输出HTML方法范例******************************************/
//面包屑导航
	public function html_snav($parent=array()){
		global $config;
		$html=array();
		foreach($parent as $c){
			$html[]='<a href="'.$c['curl'].'">'.$c['cname'].'</a>';
		}
		
		return implode(' > ',$html);
	}
	//所有顶级分类
	public function html_nav($categorys=array()){
		$categorys=$this->categorys;
		$html='';
		foreach($categorys as $c){
			if($c['parent_id']==0) $html.='<a href="'.$c['curl'].'">'.$c['cname'].'</a>';
		}
		return $html;
	}
	
	
	function get_info_cate_model_field($model_id){
		$rearr=array();
		$sql="select * from model_field where model_id=".intval($model_id);
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			foreach($a['list'] as $r){
				$rearr[$r['field_name']]=$r;
			}
		return $rearr;
	}

/***************
	
	//缓存入口
	array(
			'cachekey'=>'',  //缓存键名
			'cachetime'=>''  //缓存时间 ，默认24小时
			'funcname'=>''    //调用函数，支持任何函数 ，处理 这个是  eval的方式 ,注意 这个函数 的参数方式 必须是 array()
			'type'=>'', //缓存的数据类型， 默认是 数组
		  ..   //其余的参数会自动传入  funcname里
		   
	)
	
	public function cache($params=array()){
			$params['cachekey']=isset($params['cachekey'])?$params['cachekey']:'';
			$params['cachetime']=isset($params['cachetime'])?$params['cachetime']:3600*24;
			$params['type']=isset($params['type'])?$params['type']:'array';
			
			if($params['cachekey']=='') return '未定义cachekey';
			$cache=helper::file_cache($params['cachekey'],'',$params['cachetime']);
			if($cache=='timeout'){//echo $params['funcname']."(\$params)";
				if(preg_match('~\(.*?\)~',$params['funcname'])){
					eval('$content='.$params['funcname'].";");
				}else{	
					eval('$content='.$params['funcname']."(\$params);");
				}
				if(isset($content)) $content='';
				if($params['type']=='array'){
				    $ca=json_encode($content);	
				}else{
				    $ca=$content;	
				}
				helper::file_cache($params['cachekey'],$ca);
				return $content;
			}else{
				if($params['type']=='array'){
				    $ca=json_decode($cache,1);	
				}else{
				    $ca=$cache;	
				}
			    return $ca;
			}
	}
	*/
	//获取标签
	public function tag_list($params){
		$ret=array();
		$params['get_total']=isset($params['get_total'])?$params['get_total']:'';
		$params['table']=isset($params['table'])?$params['table']:'';
		$params['cate_id']=isset($params['cate_id'])?$params['cate_id']:'';
		$where=' where 1 ';
		if($params['cate_id']){
			$where .="and tag_cate_id=".$params['cate_id']." ";
		}
		$sql="select * from tag  $where order by tag_order,tag_id desc ";
	
		$arr['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if($params['get_total']==1){
			foreach($arr['list'] as $r){
				$a2=$this->dbm->query("select count(1) as total from ".$params['table']." where info_title like '%".$r['tag_txt']."%' or info_tags like '%".$r['tag_txt']."%' ");
				$r['info_totals']=$a2['list'][0]['total'];
				$ret[]=$r;
			}
		}else{
			$ret=$arr['list'];
		}
		return $ret;
	}
	//取得某两个时间段之内的文章数量,mindate和maxdate都 是时间戳
	public function get_date_info_totals($params){
		$ret=0;
		$params['table']=isset($params['table'])?$params['table']:'';
		$params['mindate']=isset($params['mindate'])?$params['mindate']:'';
		$params['maxdate']=isset($params['maxdate'])?$params['maxdate']:'';
		$sql="select count(1) as total from ".$params['table']." where create_time>=".$params['mindate']." and create_time<".$params['maxdate']."";//echo $sql;
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$ret=$a['list'][0]['total'];
		return $ret;
	}
	//js广告
	public function get_ad($params=array()){
		$re='';
		$id=intval($params['ad_id']);
		$sql="select * from ad_list where ad_id=$id  ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0) return false;
		$b=$a['list'][0];
		if($b['url_cate_id']) $b['ad_url']=$this->categorys[$b['url_cate_id']]['curl'];
		if($b['show_type']==0){
			$re=$b['ad_code'];
		}else if($b['show_type']==1){
			$code='<a href="'.$b['ad_url'].'" target="_blank">'.$b['ad_words'].'</a>';
			$re='document.write("'.$code.'")';
		}else if($b['show_type']==2){
			$code='<a href="'.$b['ad_url'].'" target="_blank">'.$b['ad_img'].'</a>';
			$re='document.write("'.$code.'")';
		}
		return $re;
	}
	//调用单条广告，生成了广告代码
	public function get_ad_code($area_id,$extern='',$city_ids=''){
		$re='';
		$id=intval($area_id);
		if($city_ids){
			$sql=" select * from ad_list where area_id=$area_id and city_id in($city_ids) and expire_date>".time()."  order by ad_order,ad_id  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$sql=" select * from ad_list where area_id=$area_id and city_id=0 and expire_date>".time()."  order by ad_order,ad_id  ";
				$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			}
		}else{
	
			$sql="select * from ad_list where area_id=$id and expire_date>".time()."  ";//echo $sql;
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		}
	
		if(count($a['list'])==0) return false;
		$b=$a['list'][0];
		if($b['url_cate_id']) $b['ad_url']=$this->categorys[$b['url_cate_id']]['curl'];
		if($b['show_type']==0){
			$re=$b['ad_code'];
		}else if($b['show_type']==1){
			if($b['ad_url']){
				$code='<a href="'.$b['ad_url'].'" target="_blank">'.$b['ad_words'].'</a>';
			}else{
				$code=$b['ad_words'];
			}
			$re=$code;
		}else if($b['show_type']==2){
			$code='<a href="'.$b['ad_url'].'" target="_blank"><img src="'.$b['ad_img'].'" border=0 /></a>';
			$re=$code;
		}
	
		if($extern){
			$re=$b[$extern];
		}
		return $re;
	}
	//调用某广告位的广告列表，返回数组
	//支持城市不同的广告，  如果本城市下面没有广告的话会调用默认没有城市的广告
	public function ad_list($params){
		$re=array();
		$area_id=isset($params['area_id'])?intval($params['area_id']):'';
		$city_ids=isset($params['city_ids'])?$params['city_ids']:'';
	
	
		if($city_ids){
			$sql=" select * from ad_list where area_id=$area_id and city_id in($city_ids) order by ad_order,ad_id  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$sql=" select * from ad_list where area_id=$area_id and city_id=0 order by ad_order,ad_id  ";
				$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			}
		}else{
			$sql=" select * from ad_list where area_id=$area_id and expire_date>".time()."  order by ad_order,ad_id  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		}
		foreach($a['list'] as $r){
			if($r['url_cate_id']) $r['ad_url']=$this->categorys[$r['url_cate_id']]['curl'];
			$re[]=$r;
		}
		$re=$a['list'];
		return $re;
	}
	// 获取推荐位的 ID集合
	public function get_recommend_inid($recommend_id){
		$sql="select * from recommend where recommend_id=".intval($recommend_id).' limit 0,1 ';
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
			return '0';
		}
		if($a['list'][0]['inid']==''){
			return '0';
		}
		return $a['list'][0]['inid'];
	}
	
	
	/*
	 取得字段里面  文本区域的 值与值之间用逗号隔开，单位与单位之间用回车隔开 作为数组
	*/
	public static function get_field_types($str){
		$types=array();
		$t=$str;
		$t=json_decode($t,true);
		$t=urldecode($t['ini_value']);	//echo $t;
		$a=explode('<br />',nl2br($t));
		foreach($a as $r){
			$b=explode(',',$r);
			$b[1]=isset($b[1])?$b[1]:'';
			$types[trim($b[0])]=$b[1];
				
		}
		return $types;
	
	}
	
	/*根据参数获取信息数量*/
	public static function get_linkage_info_total($linkages,$id,$filed_name,$table,$cate_id=0){
		$idarr=Linkage::get_linkage_child_idarr($linkages,$id);
		$idarr[]=$id;
		$idstr=implode(',',$idarr);		
		$where='';
		if($cate_id){
			$where=" and last_cate_id=$cate_id ";
		}
		$sql="select count(*) as total from $table where audit=1 and $filed_name in($idstr) $where  ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a[0]['total'];
				
	}
	/*根据linkage_id得到 所有子菜单包括它自己的id集合 */
	public function get_linkage_inid($linkages,$linkage_id){
		$idarr=Linkage::get_linkage_child_idarr($linkages,$linkage_id);
		$idarr[]=$linkage_id;
		$idstr=implode(',',$idarr);
		return $idstr;
	}
	
	/*获取某个模型的信息数量*/
	public static function get_info_total($table,$cate_id=0){
		$where=" ";
		if($cate_id){
			$where=" and last_cate_id=$cate_id ";
		}
		$sql="select count(*) as total from $table where 1  $where ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a[0]['total'];
	}
		
	/*获取子表数据*/
	public function get_model_list_data($table,$info_id){
		$sql="select * from $table where info_id=$info_id order by corder,id ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;	
	}
	
//获取关联信息,主动关联+被动关联
	public function get_info_info_relation_infos($info_id,$model_id){
		global $dbm;
		$rearr=array();
		$info_id=intval($info_id);
		$sql="select * from info_info_relation a 
		where (a.info_id=$info_id and a.model_id=$model_id) or (a.info_id_related=$info_id and a.model_id_related=$model_id)  ";
		$rsarrs=Yii::app()->db->createCommand($sql)->queryAll();	
		if(count($rsarrs)==0){
			return array();
		}
		$b=array();
		foreach($rsarrs as $r){
			
			if($r['info_id']==$info_id && $r['model_id']==$model_id){
				$r['id']=$r['info_id_related'];
				$r['m_id']=$r['model_id_related'];				
			}else{
				$r['id']=$r['info_id'];
				$r['m_id']=$r['model_id'];
			}
			//$m2=InfoModel::model()->findByPk($r['m_id']);
			//$r['model_table_name']=$m2->model_table_name;
			$r['model_table_name']='goods';
			$b[]=$r;
		}
		
		$a=$b;
		foreach($a as $r){
			$r['info_title']='';
			$sql=" select * from ".$r['model_table_name']." as a  where info_id=".$r['id']." ";
			$c=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($c)>0){
				$r['title']=$r['info_title']=$c[0]['info_title'];
				$r['url']=$this->set_info_url($c[0]);
				$r['thumb']=Attachment::simg($c[0]['info_img']);			
				$r=array_merge($r,$c[0]);
			}else{
				$r['title']=$r['info_title']='';
				$r['url']='';
				$r['thumb']='';
				$r['last_cate_id']='';
			}
			
			$rearr[]=$r;
		}
		//print_r($rearr);
		return $rearr;
	
	}
	
	//获取今日的数量
	public function get_today_goods_total($p_cates,$product_cate_id){
		$time=strtotime(date("Y-m-d 00:00:00"));
		$inid=Linkage::get_linkage_child_id_str($p_cates,$product_cate_id);
		$sql="select count(*) as total from goods where product_cate_id in ($inid) and create_time>=".$time;
		//echo $sql;die();
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a[0]['total'];
	}
	
	
	/*智能获取seo标题
	 * 可强制单独定义seo标题，$page['seo_title']='';
	 *  
	 */
	public function seo_title($page=array()){
		$title='';
		$url=helper::get_page_url();
		foreach($this->seoData as $r){
			if($url==$r['url']){
				return $r['seo_title'];
			}
			if(preg_match('~^http~',$r['url'])){
				$url2=helper::get_page_url(1);
				if($url2==$r['url']){
					return $r['seo_title'];
				}
			}
		}
		
		$sitename=Yii::app()->params['basic']['sitename'];
		if(isset($page['seo_title'])){
			$title=$page['seo_title'];
		}else{		
			if(isset($page['id'])&& $page['id']=='home'){    //主页
				$title=Yii::app()->params['basic']['seo_title'];  
			 }else{ 	 
				 if(isset($page['cate']['cname'])){   //列表页
				 	$pcode=$_GET['p']>1?'第'.$_GET['p'].'页_':'';
				 	$title= $pcode.$page['cate']['cname'].'_';
				 }
				 if(isset($page['info']['info_title'])){  //详细页
				 	$title= $page['info']['info_title'].'_';
				 }
				 if(isset($_GET['search_txt'])&&$_GET['search_txt']){
				 	$title= $_GET['search_txt'].'_';
				 }
				$title.=$sitename;
			}
		}
		return $title;
	}
	
	/*
	 * 只能获取seo关键词
	*/
	public function seo_keyword($page=array()){
		$key='';
		$url=helper::get_page_url();
		foreach($this->seoData as $r){
			if($url==$r['url']){
				return $r['seo_keyword'];
			}
			if(preg_match('~^http~',$r['url'])){
				$url2=helper::get_page_url(1);
				if($url2==$r['url']){
					return $r['seo_keyword'];
				}
			}
		}
		
		if(isset($page['info']['info_tags'])){
			$key=$page['info']['info_tags'];
		}else{
			$key=Yii::app()->params['basic']['seo_keyword'];
		}
		return $key;
	
	}
	
	/*
	 * 只能获取seo描述
	 */
	public function seo_description($page=array()){
		$desc='';
		$url=helper::get_page_url();
		foreach($this->seoData as $r){
			if($url==$r['url']){
				return $r['seo_description'];
			}
			if(preg_match('~^http~',$r['url'])){
				$url2=helper::get_page_url(1);
				if($url2==$r['url']){
					return $r['seo_description'];
				}
			}
		}
		if(isset($page['info']['info_desc'])){
			$desc=$page['info']['info_desc'];
		}else{
			$desc=Yii::app()->params['basic']['seo_description'];
		}
		return $desc;		
	}
	
			
}
?>
