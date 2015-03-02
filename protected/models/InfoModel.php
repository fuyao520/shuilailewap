<?php
class InfoModel extends CActiveRecord{
	public $models=array();
	public function tableName() {
		return '{{model}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}	
	/*初始化获取所有栏目
	 * */
	public function __construct($scenario='insert'){
		parent::__construct($scenario);
		$this->models=$this->get_model();

	
	}
	public function get_model(){	
		$sql="select * from model  ";
		$data=Yii::app()->db->createCommand($sql)->queryAll();
		$redata=array();
		foreach($data as $r){
			$r['id']=$r['model_id'];
			$r['parentid']=$r['parent_model_id'];
			$redata[$r['model_id']]=$r;
		}
		return $redata;
	}
	public function get_model_tree(){
		$model_cates=$this->get_model();
		$str  = "<tr>
					<td>\$id</td>
					<td class='alignleft'>\$spacer\$model_name</td>
					<td>\$model_table_name</td>
					<td>\$model_type_name</td>
					<td>\$info_totals</td>
					<td>\$str_manage</td>
				</tr>";
		$tree=new tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$tree->init($model_cates);
		$model_code = $tree->get_tree(0, $str);
		return $model_code;		
	}
	public function get_info_total($table){
		return Dtable::model($table)->count();
	}
	public function get_model_option_tree($select_id){
		$model_cates=$this->get_model();
		$str  = "<option value=\$id \$selected>\$spacer\$model_name</option>";
		$tree=new tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$tree->init($model_cates);
		$model_code = $tree->get_tree(0, $str,$select_id);
		return $model_code;
	}
	public function getone_model($model_id){
		$sql="select * from model where model_id=$model_id ";
		$data=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($data)){
			return $data[0];
		}else{
			return array();
		}
	}
	//取所有子模型
	public function get_child_model_cates($model_cates,$parent_id){
		$bb=array();
		foreach($model_cates as $c){
			if($c['parent_model_id']==$parent_id){
				$bb[]=$c;
				$son=$this->get_child_model_cates($model_cates,$c['model_id']);
				$bb=array_merge($bb,$son);
			}
		}
		return $bb;
	}
	
	public function get_info_info_relation_infos($info_id,$model_id){
		global $dbm;
		$rearr=array();
		$info_id=intval($info_id);
		$sql="select * from info_info_relation a
		left join model as m on m.model_id=a.model_id_related
		where a.info_id=$info_id and a.model_id=$model_id ";
		$rsarrs=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsarrs)==0){
			return array();
		}
		$a=$rsarrs;
		foreach($a as $r){
			$r['info_title']='';
			$sql=" select info_title from ".$r['model_table_name']." as a  where info_id=".$r['info_id_related']." ";
			$c=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($c)>0){
				$r['info_title']=$c[0]['info_title'];
			}
			$rearr[]=$r;
		}
		//print_r($rearr);
		return $rearr;
	
	}
		
	/**保存相关推荐  ,
	 * @params int $info_id 信息id
	 * @params int $info_model_id  信息的模型id
	* @params array $relation_recommend
	* @Params return boolean
	*/
	public function save_info_relation_recommend($info_id,$info_model_id,$relation_recommend){
		$relation_data=array();
		if(isset($relation_recommend['relation_id'])){
			foreach($relation_recommend['relation_id'] as $k=>$r){
				$relation_data[]=array(
						'relation_id'=>$r,
						'model_id'=>$info_model_id,
						'displayorder'=>$relation_recommend['displayorder'][$k],
						'info_id_related'=>$relation_recommend['info_id_related'][$k],
						'model_id_related'=>$relation_recommend['model_id_related'][$k],
						'type'=>isset($relation_recommend['type'][$k])?intval($relation_recommend['type'][$k]):0,
				);
			}
		}
	
		$info_id=intval($info_id);
		$oldarr=$this->get_info_info_relation_infos($info_id,$info_model_id);
		//print_r($relation_data);print_r($oldarr);die();
		foreach($oldarr as $r){  //遍历 清除不存在的 数据
			$in=0;//老的数组 的信息ID 是否 在新的数组上
			$fdata=array();
			foreach($relation_data as $r2){
				if($r2['info_id_related']==$r['info_id_related'] && $r2['model_id_related']==$r['model_id_related'] ){
					$in=1;
					$fdata=$r2;
					break;
				}
			}
			$post=Dtable::model('info_info_relation')->findByAttributes(array('relation_id'=>$r['relation_id']));
			if($in==0){
				$post->delete();
			}else{
				$post->displayorder=$fdata['displayorder'];
				$post->type=$fdata['type'];
				$post->save();
			}
		}//print_r($relation_data);die();
		foreach($relation_data as $r){
			$post=Dtable::model('info_info_relation')->findByAttributes(array('info_id_related'=>$r['info_id_related'],'model_id_related'=>$r['model_id_related']));
			if(!$post){
				$post=new Dtable('info_info_relation');
				$post->info_id=$info_id;
				$post->model_id=$info_model_id;
				$post->info_id_related=$r['info_id_related'];
				$post->model_id_related=$r['model_id_related'];
				$post->displayorder=$r['displayorder'];
				$post->type=$r['type'];
				$post->save();
			}
		}
		return true;
	}
	
	public function create_table($model_type,$parent_model_id,$model_id,$model_table_name){
		if($model_type==0){
			if($parent_model_id==0){
				$m_key_name='model_default_fields';
			}else{
				$m_key_name='modelc_default_fields';
			}				
		}else if ($model_type==1){
			$m_key_name='modeld_default_fields';
		}else if ($model_type==2){
			$m_key_name='modelm_default_fields';
		}
		if($parent_model_id){
			//自动注入新的字段，保存上级模型的 " 表名_id  "
			$arr=$this->get_parent_model_arr($model_id,'',0);//print_r($arr);die();
			if(count($arr)>1){
				$i=0;foreach($arr as $r){$i++;if($i==count($arr))break;
				vars::$fields[$m_key_name][]=array('field_txt'=>$r['model_name'].'ID','field_name'=>$r['model_table_name'].'_id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>0);
				}
			}
		}
		
		
		//插入初始字段
		foreach(vars::$fields[$m_key_name] as $f){
			$f['model_id']=$model_id;
			$sql2=helper::get_sql('model_field','insert',$f);//echo $sql2;
			Yii::app()->db->createCommand($sql2)->execute();
		}//die();
		//拼装和创建数据表
		$cs=" create table if not exists `".$model_table_name."`(\n ";
		foreach(vars::$fields[$m_key_name] as $f){
			$w=vars::get_field_str('form_types',$f['form_type'],'type');
			if($w=='int' || $w=='decimal'){
				if($m_key_name=='model_default_fields'&&$f['field_name']=='info_id'){
					$primarykey=$f['field_name'];
					$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"."  auto_increment comment '".$f['field_txt']."',\n ";
				}else if($m_key_name=='modelc_default_fields'&&$f['field_name']=='id'){
					$primarykey=$f['field_name'];
					$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"."  auto_increment comment '".$f['field_txt']."',\n ";
				}else if($m_key_name=='modeld_default_fields'&&$f['field_name']=='id'){
					$primarykey=$f['field_name'];
					$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"."  auto_increment comment '".$f['field_txt']."',\n ";
				}else if($m_key_name=='modelm_default_fields'&&$f['field_name']=='id'){
					$primarykey=$f['field_name'];
					$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"."  auto_increment comment '".$f['field_txt']."',\n ";
				}else{
					$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"." not null   default 0 comment '".$f['field_txt']."',\n ";
				}
			}
			if($w=='varchar'||$w=='char'){
				$cs.="  `".$f['field_name']."` ".$w."(".$f['length'].")"." not null default '' comment '".$f['field_txt']."',\n";
			}
			if($w=='text'){
				$cs.="  `".$f['field_name']."` ".$w."  not null  comment '".$f['field_txt']."', \n";
			}
		}
		$cs .=" primary key(`$primarykey`)\n)engine=myisam default charset=utf8; ";
		Yii::app()->db->createCommand($cs)->execute();//die($cs);
	}
	//根据 ID 取得父栏目的 ID，返回数组
	public function  get_parent_model_arr($myid,$m='',$flip=1){
		global $dbm;
		$rearr=array();
		$sql="select * from model  where model_id=".$myid;
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$rsarr=$a['list'][0];
		//if(!isset($rsarr['model_id']))return false;
		while($rsarr['parent_model_id']<>0){
			$sql="select * from model  where model_id=".$rsarr['parent_model_id'];
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			$rsarr=$a['list'][0];
			if($m=='id'){
				$rearr_[]=$rsarr['model_id'];
			}else{
				$rearr_[]=$rsarr;	
			}
		}
		if($flip==1){
			for($i=count($rearr_)-1;$i>=0;$i--){
				$rearr[]=$rearr_[$i];
			}
		}else{
			$rearr=$rearr_;
		}
		return $rearr;
	}
	
}