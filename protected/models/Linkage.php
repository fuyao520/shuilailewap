<?php
class Linkage extends CActiveRecord{
	public function tableName() {
		return '{{linkage}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function get_linkage($linkage_id,$linkage_type_id){
		$sql=" select * from linkage where parent_id=$linkage_id and linkage_type_id=".$linkage_type_id."  order by linkage_order,linkage_id asc ";
		//$sql=" select * from linkage where parent_id=$linkage_id and linkage_type_id=".$linkage_type_id."   ";
		$dependency = new CDbCacheDependency('SELECT MAX(log_id) FROM cservice_aclog ');
		$a=Yii::app()->db->cache(3600*24*30, $dependency)->createCommand($sql)->queryAll();
		return $a;
	}
	
	
	//取得联动类型
	public function get_linkage_data($linkage_type_id,$deep=0,$parent_id='0',$linkage_attr=0,$linkage_remark=''){
		$andwhere='';
		if($parent_id==''){
			return array();
		}
		if($deep){
			$andwhere .=" and linkage_deep=$deep ";
		}
		if($linkage_attr){
			$andwhere .=" and linkage_attr=$linkage_attr ";
		}
		if($linkage_remark){
			$andwhere .=" and linkage_remark='$linkage_remark' ";
		}
		if($parent_id){
			$andwhere .=" and parent_id=$parent_id ";
		}
		
		
		$sql="select * from linkage where linkage_type_id=$linkage_type_id ".$andwhere." order by linkage_order,linkage_id asc";	//echo $sql;			
		$dependency = new CDbCacheDependency('SELECT MAX(log_id) FROM cservice_aclog ');
		$a['list']=Yii::app()->db->cache(3600*24*30, $dependency)->createCommand($sql)->queryAll();
		$re=array();
		foreach($a['list'] as $r){
			$re[$r['linkage_id']]=$r;			
		}
		return $re;
	}
	/* 性能非常低,尽量避免使用
	 * @params int linkage_type_id 联动类型的ID
	 * @params int parent_id 取哪个分类的所有子分类
	 */
	
	public function get_child_data($linkage_type_id,$parent_id){
		
		
	}
	//取某个联动菜单所有的子分类的ID，作为数组
	public static function get_linkage_child_idarr($linkages,$parent_id){
		$bb=array();
		foreach($linkages as $c){
			if($c['parent_id']==$parent_id){
				$bb[]=$c['linkage_id'];
				$son=self::get_linkage_child_idarr($linkages,$c['linkage_id']);
				$bb=array_merge($bb,$son);
			}
		}
		return $bb;
	}
	//取某个联动菜单所有的子分类包括自己的的ID集合，作为字符串
	public static function get_linkage_child_id_str($linkages,$parent_id){
		$bb=array();
		$bb=self::get_linkage_child_idarr($linkages,$parent_id);
		$bb[]=$parent_id;
		return implode(',',$bb);
	}
	
	//取某个联动菜单所有的子分类的py，作为数组
	public static function get_linkage_child_pyarr($linkages,$parent_id){
		$bb=array();
		foreach($linkages as $c){
			if($c['parent_id']==$parent_id){
				$bb[]=$c['linkage_name_py'];
				$son=self::get_linkage_child_idarr($linkages,$c['linkage_id']);
				$bb=array_merge($bb,$son);
			}
		}
		return $bb;
	}
	//取所有子分类，树状
	public static function get_linkage_child_catearr($linkages,$parent_id){
		$bb=array();
		foreach($linkages as $c){
			if($c['parent_id']==$parent_id){
				$bb[$c['linkage_id']]=$c;
				$son=self::get_linkage_child_catearr($linkages,$c['linkage_id']);
				$bb[$c['linkage_id']]['son']=$son;
			}
		}
		return $bb;
	}
	
	//取某个联动菜单所有的父分类，作为数组，不是树状
	public static function get_linkage_parent_catearr($linkages,$parent_id){
		$bb=array();
		foreach($linkages as $c){
			if($c['linkage_id']==$parent_id){
				$bb[]=$c;
				$parent=self::get_linkage_parent_catearr($linkages,$c['parent_id']);
				$bb=array_merge($bb,$parent);
				break;
			}
		}
		return $bb;
	}
	
	
	//根据 区域ID获取城市，作为数组
	public static function get_linkage_city($id){
		$a=$dbm->query("select * from linkage where linkage_id=$id and linkage_deep=3 ");  //直接查询城市
		if(count($a['list'])) return $a['list'][0];   //如果查询到了就返回
		//如果没有的话继续查
		$sql="select b.* from linkage as a
				left join linkage as b on b.linkage_id=a.parent_id
				where a.linkage_id=$id and a.linkage_deep=4 and b.linkage_deep=3 ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		return $a['list'];
	}
	//根据 区域ID获取街道，作为数组
	public static function get_linkage_street($id){
		//如果没有的话继续查
		$sql="select * from linkage as a where  and parent_id=$id ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		return $a['list'];
	}
	

	
	
	//根据linkage_id，取得 Linkage_name
	public static function get_linkage_one($linkage_id){
		global $dbm;
		$sql="select * from linkage where linkage_id=$linkage_id";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])){
			return $a['list'][0];
		}
		return false;
	}
	//根据某个linkage_id返回文本
	public  function get_name($linkage_id,$get_parent=0){
		$m=$this->findByPk($linkage_id);
		if(!$m) return false;
		if($get_parent==1){
			$m2=$this->findByPk($m->parent_id);
			if($m2){
				return $m2->linkage_name.'-'.$m->linkage_name;	
			}
		}
		return $m->linkage_name;
	}
	
	//获取某个菜单的 最顶层的 分类
	public static function get_top_cate($linkages,$linkage_id){
		if(!$linkage_id) return;
		$a=self::get_linkage_parent_catearr($linkages,$linkage_id);
		if(count($a)==0){
			self::get_linkage_one($linkage_id);
		}
		return $a[count($a)-1];		
	}
	
	
}
