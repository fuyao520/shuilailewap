<?php 
//根据 common/config.php 里的 form_types 定义的表单类型  来 初始化对应的表单 html 
////根据定义的表单字段类型，对 表单的提交的 值 进行处理，过滤，转换，等，入库之前的 数据处理
class form_type_code{
	static function get_html($params){ //$type,$default_value='',$form_name=''
	    //print_r($params);
	   if(!isset($params['type'])) $params['type']='';
	   if(!isset($params['default_value'])) $params['default_value']='';
	   if(!isset($params['form_name'])) $params['form_name']='';
	   if(!isset($params['m'])) $params['m']='';
	   if(!isset($params['field_value'])) $params['field_value']='';
	   if(!isset($params['get_post_value'])) $params['get_post_value']='';
	   if(!isset($params['post_value'])) $params['post_value']='';
	   if(!isset($params['ini_value'])) $params['ini_value']='';
	   if(!isset($params['linkage_type_id'])) $params['linkage_type_id']=0;
	   if(!isset($params['linkage_attr'])) $params['linkage_attr']=array("parent_id"=>0,"select_num"=>0);
	   if(!isset($params['id'])) $params['id']='';
	   
	   
	   eval("\$recode=self::".$params['type']."(\$params);");//echo "\$recode=self::".$params['type']."(\$params);";
	   return $recode; 	
	}
	//单行文本
	static function varchar_single_line($params){
		if($params['m']==''){
	        $recode='<input type="text"  class="ipt"  id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.$params['default_value'].'" >';
		}else if($params['m']=='list_show_value'){
		    $recode=$params['field_value'];   
		}else if($params['m']=='get_post_value'){
			$recode=trim($params['post_value']);
		}
	    return $recode;
	}
	//char当行文本
	static function char_single_line($params){
	    $recode=self::varchar_single_line($params);
		return $recode;	 
	}
	//varchar多行文本
	static function multi_line($params){
		if($params['m']==''){
		    $recode='<textarea style="width:400px; height:80px;"  id="'.$params['form_name'].'" name="'.$params['form_name'].'">'.$params['default_value'].'</textarea>';
		}else if($params['m']=='list_show_value'){
			$recode=$params['field_value'];
		}else if($params['m']=='get_post_value'){
			$recode=trim($params['post_value']);
		}
		return $recode; 	
	}
	static function text_area($params){
	    $recode=self::multi_line($params);	
		return $recode;
	}
	//编辑器简洁
	static function html_editor_simple($params){
		if($params['m']==''){
	        $recode='<textarea style="width:100%; height:300px;"  id="'.$params['form_name'].'" name="'.$params['form_name'].'">'.htmlspecialchars($params['default_value']).'</textarea>';
		    $recode .='<script>var '.$params['form_name'].'=$("#'.$params['form_name'].'").xheditor({tools:"simple",skin:"nostyle"});</script><span class="upbtn_box" id="upbtn_box"><script>load_editor_upload("'.$params['form_name'].'");</script></span>';	
		}else if($params['m']=='list_show_value'){
			$recode=$params['field_value'];
		}else if($params['m']=='get_post_value'){
			$recode=trim($params['post_value']);
		}
		return $recode;
	}
	//编辑器普通
	static function html_editor_complex($params){
	    if($params['m']==''){
	        $recode='<textarea style="width:100%; height:300px;"  id="'.$params['form_name'].'" name="'.$params['form_name'].'">'.htmlspecialchars($params['default_value']).'</textarea>';
		    $recode .='<script>var '.$params['form_name'].'=$("#'.$params['form_name'].'").xheditor({plugins:allplugin,internalScript:true,tools:"mfull",skin:"nostyle"});</script><span class="downhttpimgbtn" id="downbtn_'.$params['form_name'].'"><a href="javascript:void(0);" onclick="download_http_img(\''.$params['form_name'].'\');">下载远程图片</a></span><span class="upbtn_box" id="upbtn_box"><script>load_editor_upload("'.$params['form_name'].'");</script></span>';	
		}else if($params['m']=='list_show_value'){
			$recode=$params['field_value'];
		}else if($params['m']=='get_post_value'){
			$recode=trim($params['post_value']);
		}
		return $recode;
	}
    static function int_($params){
		if($params['m']=='get_post_value'){
	        $recode=intval($params['post_value']);
		}else{
		    $recode=self::varchar_single_line($params);
		}
		return $recode;	
	}
	static function decimal_($params){
		$recode=self::varchar_single_line($params);
		return $recode;
	}
	//时间戳（时间格式）
	static function sjc($params){
		if($params['m']==''){
			$params['default_value']=$params['default_value']?$params['default_value']:time();
	        $recode='<input type="text" class="ipt"   id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.(date('Y-m-d H:i:s',intval($params['default_value']))).'"  onclick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\'})">';
		}else if($params['m']=='list_show_value'){
			$recode='<span title="'.date("Y-m-d H:i:s",$params['field_value']).'">'.date("Y-m-d",$params['field_value']).'</span>';
		}else if($params['m']=='get_post_value'){
		    $recode=strtotime($params['post_value']);	
		}
		return $recode; 	
	}
	//时间戳（日期格式）
	static function sjc_date($params){
		if($params['m']==''){
			$params['default_value']=$params['default_value']?$params['default_value']:time();
	        $recode='<input type="text" class="ipt"   id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.(date('Y-m-d',intval($params['default_value']))).'"  onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'})">';
		}else if($params['m']=='list_show_value'){
			$recode='<span title="'.date("Y-m-d",$params['field_value']).'">'.date("Y-m-d",$params['field_value']).'</span>';
		}else if($params['m']=='get_post_value'){
		    $recode=strtotime($params['post_value']);	
		}
		return $recode; 	
	}
	//缩略图
	static function simage($params){
		if($params['m']==''){
	        $recode='<div class=l><input type="text"  class="ipt"  id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.$params['default_value'].'" /> <span id="span_'.$params['form_name'].'"></span></div> <div class=l id="'.$params['form_name'].'_span"></div> <script>create_upload_iframe(\'{"func":"callback_upload","Eid":"'.$params['form_name'].'","is_thumb":1,"thumb":{"width":"300","height":"300"},"water":1}\');</script>'; 	
		}else if($params['m']=='list_show_value'){
			$recode='';
			if($params['field_value']!=''){
			    $recode='<img src="'.$params['field_value'].'" width=20 height=20 class="slider-simage '.$params['form_name'].'" data-field="'.$params['form_name'].'" data-id="'.$params['id'].'" />';
			}
		}if($params['m']=='get_post_value'){
		    $recode=$params['post_value'];	
		}
		return $recode;
	}
	//image
	static function image($params){
	    self::simage($params);
		return $recode;
	}
	//file
	static function file_($params){
		if($params['m']==''){
	        self::simage($params);
		}else if($params['m']=='list_show_value'){
			$recode='附件：大小20KB';
		}if($params['m']=='get_post_value'){
		    $recode=$params['post_value'];	
		}
		return $recode;
	}
	//下拉菜单
	static function option($params){
		if($params['linkage_type_id']>0){
			$sql="select * from linkage where linkage_type_id=".$params['linkage_type_id'];
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list=$a;
			if($params['m']==''){
				$scode='';
				foreach($list as $r){
					$scode .='<option value="'.($r['linkage_id']).'" '.($params['default_value']==$r['linkage_id']?'selected':'').'>'.$r['linkage_name'].'</option>';
				}
				$recode='<select id="'.$params['form_name'].'" name="'.$params['form_name'].'" >'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				foreach($list as $r){
					if($params['field_value']==$r['linkage_id']){
						$scode[]=$r['linkage_name'];
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=intval($params['post_value']);
			}
			return $recode;
		}else{
			if($params['m']==''){
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					if(count($b)>=2){
						$scode .='<option value="'.$b[0].'" '.($params['default_value']==$b[0]?'selected':'').'>'.$b[1].'</option>';
					}
				}
				$recode='<select id="'.$params['form_name'].'" name="'.$params['form_name'].'" >'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				$scode=array();
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					if(count($b)>=2){
						if($params['field_value']==$b[0]){
							$scode[]=$b[1];
						}
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=intval($params['post_value']);
			}
			return $recode;
		}
	}
	//下拉菜单 ，值是文本，下拉的时候 option的值和option的文字是一样的
	static function option_text($params){
		if($params['linkage_type_id']>0){
			$sql="select * from linkage where linkage_type_id=".$params['linkage_type_id'];
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list=$a;
			if($params['m']==''){
				$scode='';
				foreach($list as $r){
					$scode .='<option value="'.($r['linkage_name']).'" '.($params['default_value']==$r['linkage_name']?'selected':'').'>'.$r['linkage_name'].'</option>';
				}
				$recode='<select id="'.$params['form_name'].'" name="'.$params['form_name'].'" >'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				foreach($list as $r){
					if($params['field_value']==$r['linkage_name']){
						$scode[]=$r['linkage_name'];
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=$params['post_value'];
			}
			return $recode;
			
		}else{
			if($params['m']==''){
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$scode .='<option value="'.trim($r).'" '.($params['default_value']==trim($r)?'selected':'').'>'.trim($r).'</option>';
				}
				$recode='<select id="'.$params['form_name'].'" name="'.$params['form_name'].'" >'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				$scode='';
				$recode=$params['field_value'];
			}else if($params['m']=='get_post_value'){
				$recode=$params['post_value'];
			}
			return $recode;
		}
	}
	//下拉菜单
	static function option_for_text($params){
		if($params['linkage_type_id']>0){
			$sql="select * from linkage where linkage_type_id=".$params['linkage_type_id'];
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list=$a;
			if($params['m']==''){
				
				 $recode='<input type="text"  class="ipt"  id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.$params['default_value'].'" >'; 
				 $scode='';
				foreach($list as $r){
					$scode .='<option value="'.$r['linkage_name'].'" '.($params['default_value']==$r['linkage_name']?'selected':'').'>'.$r['linkage_name'].'</option>';
				}
				$recode .='<select onchange="$(\'#'.$params['form_name'].'\').val(this.value);" id="'.$params['form_name'].'" name="'.$params['form_name'].'" ><option value="">--选择--</option>'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				$scode='';
				$recode=$params['field_value'];
			}else if($params['m']=='get_post_value'){
				$recode=$params['post_value'];
			}
			return $recode;
		}else{
			if($params['m']==''){
				 $recode='<input type="text"  class="ipt"  id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.$params['default_value'].'" >';
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$scode .='<option value="'.$r.'" '.($params['default_value']==$r?'selected':'').'>'.$r.'</option>';
				}
				$recode .='<select onchange="$(\'#'.$params['form_name'].'\').val(this.value);" id="'.$params['form_name'].'" name="'.$params['form_name'].'" ><option value="">--选择--</option>'.$scode.'</select>';
			}else if($params['m']=='list_show_value'){
				$scode='';
				$recode=$params['field_value'];
			}else if($params['m']=='get_post_value'){
				$recode=$params['post_value'];
			}
			return $recode;
			
		}
	}
	//单选按钮
	static function radio($params){	
		if($params['linkage_type_id']>0){
			$sql="select * from linkage where linkage_type_id=".$params['linkage_type_id'];
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list=$a;
			if($params['m']==''){
				$scode='';
				foreach($list as $r){
					$scode .=' <label><input type="radio" name="'.$params['form_name'].'" id="'.$params['form_name'].'"  value="'.($r['linkage_id']).'" '.($params['default_value']==$r['linkage_id']?'checked':'').' /> '.$r['linkage_name'].' </label> ';
				}
				$recode=$scode;
			}else if($params['m']=='list_show_value'){
				$scode=array();
				foreach($list as $r){
					if($params['field_value']==$r['linkage_id']){
						$scode[]=$r['linkage_name'];
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=intval($params['post_value']);
			}
			return $recode;
		}else{
			if($params['m']==''){
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					if(count($b)>=2){
						$scode .=' <label> <input type="radio"  id="'.$params['form_name'].'" name="'.$params['form_name'].'" value="'.$b[0].'" '.($params['default_value']==$b[0]?'checked':'').'>  '.$b[1].' </label> ';
					}
				}
				$recode=$scode;
			}else if($params['m']=='list_show_value'){
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					if(count($b)>=2){
						if($params['field_value']==$b[0]){
							$scode[]=$b[1];
						}
					}
				}
				$recode=@implode(',',$scode);
				if(preg_match('~未|不|下架|待~',$recode,$r2)){
					$recode='<font color=red>'.$recode.'</font>';	
				}
			}else if($params['m']=='get_post_value'){
				$recode=intval($params['post_value']);
			}
			return $recode;
		}
	}
	//复选框
	static function checkbox($params){
		if($params['linkage_type_id']>0){
			$sql="select * from linkage where linkage_type_id=".$params['linkage_type_id'];
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list=$a;
			if($params['m']==''){
				$scode='';
				foreach($list as $r){
					$e=helper::json_decode_cn($params['default_value']);
					$scode .=' <label><input type="checkbox" name="'.$params['form_name'].'[]" id="'.$params['form_name'].'"  value="'.($r['linkage_id']).'" '.(in_array($r['linkage_id'],$e)?'checked':'').'/> '.$r['linkage_name'].' </label> ';
				}
				$recode=$scode;
			}else if($params['m']=='list_show_value'){
				$scode=array();
				$e=helper::json_decode_cn($params['field_value']);
				foreach($list as $r){
					if(in_array($r['linkage_id'],$e)){
						$scode[]=$r['linkage_name'];
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=helper::json_encode_cn($params['post_value']);
			}
			return $recode;
		}else{
			if($params['m']==''){
				$scode='';
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					$b[0]=trim($b[0]);
					if(count($b)>=2){
						$e=helper::json_decode_cn($params['default_value']);
						$scode .='<label><input type="checkbox"  id="'.$params['form_name'].'[]" name="'.$params['form_name'].'[]" value="'.$b[0].'" '.(in_array($b[0],$e)?'checked':'').'> '.$b[1].' </label>';
					}
				}
				$recode=$scode;
			}else if($params['m']=='list_show_value'){
				$scode=array();
				$a=explode('<br />',nl2br($params['ini_value']));
				foreach($a as $r){
					$b=explode(',',$r);
					if(count($b)>=2){
						$e=helper::json_decode_cn($params['field_value']);
						if(in_array($b[0],$e)){
							$scode[]=$b[1];
						}
					}
				}
				$recode=implode(',',$scode);
			}else if($params['m']=='get_post_value'){
				$recode=helper::json_encode_cn($params['post_value']);
			}
			return $recode;
		}
		
	}
	//联动类型
	static function linkage($params){
		$recode='';
		if(!isset($params['linkage_type_id'])||!$params['linkage_type_id']) return '联动类型出错';
		if($params['m']==''){
			$recode=' <span id="t_s_'.$params['form_name'].'">
        </span>
        <span id="t_s_'.$params['form_name'].'_load"></span> 
           <script>cg_edit_sele_cc("'.intval($params['default_value']).'","'.$params['form_name'].'[]","t_s_'.$params['form_name'].'","'.$params['linkage_type_id'].'","'.$params['linkage_attr']['parent_id'].'",'.$params['linkage_attr']['select_num'].');</script>
	        
		';	
		}else if($params['m']=='list_show_value'){
			if($params['field_value']){
			    $a=Yii::app()->db->createCommand("select * from linkage where linkage_id=".intval($params['field_value']))->queryAll();
				if(count($a)) $recode=$a[0]['linkage_name'];
			}else{
			    $recode='-';
			}
		}if($params['m']=='get_post_value'){
			if(isset($params['post_value'][count($params['post_value'])-1])){
		    	$recode=intval($params['post_value'][count($params['post_value'])-1]);//die($recode.'ee');
			}
		}
		return $recode;
	}
	
	



}


?>