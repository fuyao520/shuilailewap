<?php
class Special extends CActiveRecord{
	public $specials=array();
	public function tableName() {
		return '{{info_special}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	/*初始化获取所有栏目
	 * */
	public function __construct($scenario='insert'){
		parent::__construct($scenario);
		$tmp_cates=$this->get_special();
		foreach($tmp_cates as $r){
			$this->specials[$r['special_id']]=$r;
		}
	}

	//取得某条信息的推荐位
	public function get_info_specials($model_id,$info_id){
		$recommends=array();
		$sql="select * from info_special as a inner join info_special_relation as b on b.special_id=a.special_id where  b.model_id='".$model_id."' and b.info_id=$info_id";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	}
	
	//获取专题列表
	public function get_special(){
		$sql="select b.cname,a.*,(select count(1) from info_special_relation as c where c.special_id=a.special_id) as info_totals 
					from info_special as a 
			left join info_category as b on b.cate_id=a.cate_id_top ";
		$list=Yii::app()->db->createCommand($sql)->queryAll();
		return $list;
		
	}	
	
	public  function special_cate_tree($select_cate_id){
		$catearr=$this->specials;
		$categorys=array();
		foreach($catearr as $r){
			$new_r['id']=$r['special_id'];
			$new_r['parentid']=$r['special_parent_id'];
			$new_r['cname']=$r['special_name'];
			$new_r['typesetting']=urlencode($r['typesetting']);
			$categorys[]=$new_r;
		}
		$str  = "<option value=\$id data=\$typesetting \$selected>\$spacer\$cname</option>";
		$tree=new tree();
		$tree->init($categorys);
		//print_r($categorys);
		$category_code = $tree->get_tree(0, $str,$select_cate_id);
		return $category_code;
	
	}
	
	//取得某些专题
	public static function special_list($params=array()){
		$params['pagesize']=isset($params['pagesize'])&&is_numeric($params['pagesize'])?intval($params['pagesize']):10;
		$params['ordersql']=isset($params['ordersql'])?$params['ordersql']:'';
		$params['cate_id']=$cate_id=isset($params['cate_id'])?$params['cate_id']:'';
		$params['andwhere']=isset($params['andwhere'])?$params['andwhere']:'';
		$params['joinsql']=isset($params['joinsql'])?$params['joinsql']:'';
		$params['selectsql']=isset($params['selectsql'])?$params['selectsql']:' l.* ';
		$params['pageshowtype']=isset($params['pageshowtype'])?$params['pageshowtype']:1;
		$count=0;
		if(!isset($params['p']) || !is_numeric($params['p'])){
			$params['p']=1;
		}else{
			$count=1;
		} //默认页码，如果传入了该值，则会进行分页统计
	
		//处理
		$params['andwhere']=' where  a.audit=1 '.$params['andwhere'];
	
	
		if(!isset($params['p']) || !is_numeric($params['p'])) $params['p']=1; //默认页码，如果传入了该值，则会进行分页
	
		$sql="select a.*,(select count(1) from info_special_relation as c where c.special_id=a.special_id) as info_totals from info_special a  ".$params['andwhere'];
		$sql_total="select count(*) as total from info_special as a  ".$params['andwhere'];
		$suffix=" order by sorder,special_id desc limit ".($params['p']-1)*$params['pagesize'].",".$params['pagesize'];
		$sql.=$suffix;//echo $sql;
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if($count==1){
			$a_total['list']=Yii::app()->db->createCommand($sql_total)->queryAll();
			$rsarrs['total']=$a_total['list'][0]['total'];
		}
		$arr=array();
		foreach($rsarrs['list'] as $r){
			$r['url']=$this->createUrl('special/index').'?id='.$r['special_id'];
			$arr[$r['special_id']]=$r;
		}
		$ret=array('pagecode'=>'','list'=>array());
		foreach($arr as $r){
			$ret['list'][$r['special_id']]=$r;
		}
		if($count==1) {
			$pageurl='';
			if(url::$rewrite==1&&$cate_id){
				//这里很可能要变更
				$page_rule=$c->categorys[$cate_id]['csetting']['list_rewrites']['rewrite_page_rule'];
				url::$url_config['info_list']['page_rule']=$page_rule;//echo $page_rule;
				$host='';
				if($c->categorys[$cate_id]['cate_host']){
					$host=$this->categorys[$cate_id]['cate_host'];
				}else{
					$host=Yii::app()->params['basic']['siteurl'];
				}
				$pageurl=url::encode('info_list',array('host'=>$host,'cate_id'=>$c->categorys[$cate_id]['cate_id'],'cname_py'=>$c->categorys[$cate_id]['cname_py']),'page_rule');
				//echo $pageurl;die();
			}
			if(isset($params['pageurl'])){
				$pageurl=$params['pageurl'];
			}
			$pagearr=helper::pagehtml(array('total'=>$rsarrs['total'],"pagesize"=>$params['pagesize'],'list_str'=>$pageurl,'show'=>$params['pageshowtype']));
			$ret['pagecode']=$pagearr['pagecode'];
			$ret['total']=$pagearr['total'];
		}
	
		return $ret;
	}
	
//取得专题的关联文档
	public static function special_info_list($params=array()){
		$params['pagesize']=isset($params['pagesize'])&&is_numeric($params['pagesize'])?intval($params['pagesize']):10;
		$params['ordersql']=isset($params['ordersql'])?$params['ordersql']:' order by a.i_s_order  asc,relation_id desc ';
		$params['cate_id']=$cate_id=isset($params['cate_id'])?$params['cate_id']:'';
		$params['andwhere']=isset($params['andwhere'])?$params['andwhere']:'';
		$params['joinsql']=isset($params['joinsql'])?$params['joinsql']:'';
		$params['selectsql']=isset($params['selectsql'])?$params['selectsql']:' l.* ';
		$params['pageshowtype']=isset($params['pageshowtype'])?$params['pageshowtype']:1;
		$count=0;
		if(!isset($params['p']) || !is_numeric($params['p'])){
			$params['p']=1;
		}else{
			$count=1;
		} //默认页码，如果传入了该值，则会进行分页统计
	
		//处理
		$params['andwhere']=" where a.special_id=".$params['special_id']." ".$params['andwhere'];
	
	
		if(!isset($params['p']) || !is_numeric($params['p'])) $params['p']=1; //默认页码，如果传入了该值，则会进行分页
	
		$params['special_id']=isset($params['special_id'])?$params['special_id']:0;
		$params['pagesize']=isset($params['pagesize'])?$params['pagesize']:10;
	
		$list=array();
		$sql="select * from info_special_relation as a ".$params['joinsql']." ".$params['andwhere']."  ";
		$sql_total="select count(*) as total from info_special_relation as a  ".$params['andwhere'];
		$suffix= $params['ordersql']."  limit ".($params['p']-1)*$params['pagesize'].",".$params['pagesize'];
		$sql.=$suffix;//echo $sql;
		
		if($count==1){
			$a_total['list']=Yii::app()->db->createCommand($sql_total)->queryAll();
			$rsarrs['total']=$a_total['list'][0]['total'];
		}
	
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($rsarrs['list'] as $r){
			$table=InfoModel::model()->models[$r['model_id']]['model_table_name'];
			$sql="select * from $table where info_id=".$r['info_id']." limit 0,1 ";
			$b['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($b['list'])){
				$z=$b['list'][0];
				$z['url']=Cms::model()->set_info_url($z);
				$z['title']=$z['info_title'];
				$z['thumb']=Attachment::simg($z['info_img']);	
				$z['cate']=Cms::model()->categorys[$z['last_cate_id']];	
				$z['special_type']=$r['special_type'];	
				$list[]=$z;
			}
				
		}
		$ret['list']=$list;
		if($count==1) {
			$pagearr=helper::pagehtml(array('total'=>$rsarrs['total'],"pagesize"=>$params['pagesize'],'show'=>8));
			$ret['pagearr']['pagecode']=$pagearr['pagecode'];
			$ret['pagearr']['totalpage']=$pagearr['totalpage'];
		}
		return $ret;
	}
	
	
}
