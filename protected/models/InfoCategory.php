<?php
class InfoCategory extends CActiveRecord{
	public $categorys=array();
	public function tableName() {
		return '{{info_category}}';
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/*初始化获取所有栏目
	 * */	
	public function __construct($scenario='insert'){
		parent::__construct($scenario);
		$cacheId='infoCategorys';
		$cacheTime=3600*24*30*0;
		$tmp_cates=Yii::app()->cache->get($cacheId);
		if(!$tmp_cates){
			$tmp_cates=$this->get_category();
			Yii::app()->cache->set($cacheId,$tmp_cates,$cacheTime,new CDbCacheDependency('SELECT MAX(log_id) FROM cservice_aclog'));
		}
		
		foreach($tmp_cates as $r){
			$this->categorys[$r['cate_id']]=$r;
		}
		//对 设置了跳转到 第一个子分类  的 分类进行 url处理
		foreach($this->categorys as $r){
			if($r['jump_first_cate']==1 && $r['cjump_url']==''){
				$a=$this->cate_son($r['cate_id']);
				if(count($a)){
					$this->categorys[$r['cate_id']]['surl']=$a[0]['surl'];
					$this->categorys[$r['cate_id']]['curl']=$a[0]['curl'];
				}
			}
		}
	}
	public function get_category(){
		$sql="select a.*,b.* from info_category as a left join model as b on b.model_id=a.model_id  order by a.corder,a.cate_id asc ";
		$data=Yii::app()->db->createCommand($sql)->queryAll();
		$rsarr=array();
		foreach($data as $k=>$c){
			//$r['curl']=Yii::app()->createUrl('InfoCategory/index',array('cate_id'=>$c['cate_id']));	
			$c=array_merge($c,InfoModel::model()->get_model($c['model_id']));
			$c['csetting']=json_decode($c['csetting'],true);
			$c['csetting']=is_array($c['csetting'])?$c['csetting']:array();
			foreach($c['csetting'] as $k2=>$r2){
				$c['csetting'][$k2]=urldecode($r2);
			}
			//检测本分类是否设置了 伪静态规则
			if(isset($c['csetting']['list_rewrite']) && $c['csetting']['list_rewrite']){
				$a2=Rewrite::model()->findByPk(intval($c['csetting']['list_rewrite']));
				if($a2){
					$rule=$a2->rewrite_rule;
					$page_rule=$a2->rewrite_page_rule?$a2->rewrite_page_rule:$rule;
					$c['csetting']['list_rewrites']['rewrite_rule']=$rule;
					$c['csetting']['list_rewrites']['rewrite_page_rule']=$page_rule;
					url::$url_config['info_list']['rule']=$rule;
				}
			}else{
				$c['csetting']['list_rewrites']['rewrite_rule']=url::$url_config['info_list']['rule'];
				$c['csetting']['list_rewrites']['rewrite_page_rule']=$c['csetting']['list_rewrites']['rewrite_rule'];
			}
			$host='';
			if($c['cate_host']){
				$host=$c['cate_host'];
			}else{
				$host=Yii::app()->params['basic']['siteurl'];
			}
		
			$c['surl']=url::encode('info_list',array('host'=>$host,'cate_id'=>$c['cate_id'],'cname_py'=>$c['cname_py'],'p'=>1));
			$c['curl']=$c['surl'];
			if($c['cjump_url']){
				$c['curl']=$c['cjump_url'];
				$c['surl']=$c['cjump_url'];
			}		
		
			if($c['cate_host']&&$c['host_is_top']){
				$c['surl']=$c['cate_host'];
			}
			//检测本分类是否设置了详细页的伪静态规则，先赋好值
			if(isset($c['csetting']['detail_rewrite']) && $c['csetting']['detail_rewrite']){
				$a3=Rewrite::model()->findByPk(intval($c['csetting']['detail_rewrite']));
				if($a3){
					$rule=$a3->rewrite_rule;
					$page_rule=$a3->rewrite_page_rule;
					$c['csetting']['detail_rewrites']['rewrite_rule']=$rule;
					$c['csetting']['detail_rewrites']['rewrite_page_rule']=$page_rule;
				}
			}else{
				$c['csetting']['detail_rewrites']['rewrite_rule']=0;
				$c['csetting']['detail_rewrites']['rewrite_page_rule']=0;
			} 
			$rsarr[$c['cate_id']]=$c;
		}
		return $rsarr;
	}
	/*获取某个模型下面的所有分类
	 * 
	 * */
	public function get_model_info_category($model_id){
		$sql="select a.*,b.* from info_category as a left join model as b on b.model_id=a.model_id where a.model_id=$model_id";
		$data=Yii::app()->db->createCommand($sql)->queryAll();
		$rsarr=array();
		foreach($data as $k=>$r){
			$rsarr[$r['cate_id']]=$r;
		}
		return $rsarr;
	}
	
	public function category_model_tree($model_id,$select_cate_id=0){
		$catearr=$this->get_model_info_category($model_id);
		$categorys=array();
		foreach($catearr as $r){
			$new_r['id']=$r['cate_id'];
			$new_r['parentid']=$r['parent_id'];
			$new_r['cname']=$r['cname'];
			$categorys[]=$new_r;
		}
		$str  = "<option value=\$id \$selected>\$spacer\$cname</option>";
		$tree=new tree();
		$tree->init($categorys);
		//print_r($categorys);
		$category_code = $tree->get_tree(0, $str,$select_cate_id);
		return $category_code;
	}

	//根据 ID 取得父栏目的 ID，返回数组
	public function  get_parent_arr($myid,$m='id'){
		global $dbm;
		$rearr=array();
		$rearr_=array();
		$rsarr=$this->getone_info_category($myid);
		//if(!isset($rsarr['model_id']))return false;
		while($rsarr['parent_id']<>0){
			$rsarr=$this->getone_info_category($rsarr['parent_id']);
	
			if($m=='id'){
				$rearr_[]=$rsarr['cate_id'];
			}else{
				$rearr_[]=$rsarr;
	
			}
		}
		for($i=count($rearr_)-1;$i>=0;$i--){
			$rearr[]=$rearr_[$i];
		}
		return $rearr;
	}
	public  function category_tree($select_cate_id){
		$catearr=$this->categorys;
		$categorys=array();
		foreach($catearr as $r){
			$new_r['id']=$r['cate_id'];
			$new_r['parentid']=$r['parent_id'];
			$new_r['cname']=$r['cname'];
			$categorys[]=$new_r;
		}
		$str  = "<option value=\$id \$selected>\$spacer\$cname</option>";
		$tree=new tree();
		$tree->init($categorys);
		//print_r($categorys);
		$category_code = $tree->get_tree(0, $str,$select_cate_id);
		return $category_code;
	
	}
	
	//取某个分类所有的子分类的ID，作为数组，不是树状
	public function cate_son_idarr($parent_id){
		$bb=array();
		foreach($this->categorys as $c){
			if($c['parent_id']==$parent_id){
				$bb[]=$c['cate_id'];
				$son=$this->cate_son_idarr($c['cate_id']);
				$bb=array_merge($bb,$son);
			}
	
		}
		return $bb;
	}
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
}