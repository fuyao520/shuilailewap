<?php
//通用函数类
class helper{
	//密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,-
    static $lockstream = 'st=lDEFABCkVWXYZabc89LMmGH012345uvdefIJK6NOPyzghijQRSTUwx7nopqr';
	public static function pagehtml($params){
		$params['total']=isset($params['total'])?intval($params['total']):0;
		$params['is_html']=isset($params['is_html'])?intval($params['is_html']):0;
		$params['pagesize']=isset($params['pagesize'])&&$params['pagesize']>0?intval($params['pagesize']):10;
		$params['page_name']=isset($params['page_name'])?$params['page_name']:'';
		$params['file_name']=isset($params['file_name'])?$params['file_name']:'';
		$params['page_folder']=isset($params['page_folder'])?$params['page_folder']:'';
		$params['list_str']=isset($params['list_str'])?$params['list_str']:'';
		$params['show']=isset($params['show'])?$params['show']:1;
		
		$pageclass=new page(array('total'=>$params['total'],'perpage'=>$params['pagesize'],'is_html'=>$params['is_html'],'page_name'=>$params['page_name'],'file_name'=>$params['file_name'],'page_folder'=>$params['page_folder'],'list_str'=>$params['list_str']));		
		$revalue['pagecode']=$pageclass->show($params['show']);  //分页代码
        $revalue['limit']=$pageclass->offset();
		$revalue['totalpage']=$pageclass->totalpage;
		$revalue['total']=$params['total'];	
		return $revalue;
	}
	//中文字符截取
	public static function utf8_substr($str, $start, $length) {
		if (function_exists('mb_substr')) {
			return mb_substr($str, $start, $length, 'UTF-8');
		}
		preg_match_all("/./u", $str, $arr);
		return implode("", array_slice($arr[0], $start, $length));
	}
	// 获取制定url的内容
	public static function get_contents($url,$charset='UTF-8') {
		$retry = 5;
		$content = '';
		while(empty($content) && $retry > 0) {
			$content = @file_get_contents($url);
			$retry--;
		}
		if(!preg_match('~<meta[^>]*charset=utf-8\"[^>]*>~i',$content)){			
			if(strtoupper($charset)!='UTF-8') $content=@iconv($charset."//IGNORE","UTF-8",$content);//die($contents);
		}
		return $content;
	}
	function get_curl_contents($url,$charset='UTF-8'){//获取远程内容的函数
		//echo $url;
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10 ); //设置连接等待时间
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 	
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.baidu.com/'); //最重要的一步，手动指定Referer
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		$content = curl_exec($ch); 
		// 检查是否有错误发生
		if(curl_errno($ch)){
		//	echo 'Curl error: ' . curl_error($ch);
		}
		curl_close($ch);//echo '--end<br>';
		if(!preg_match('~<meta[^>]*charset=utf-8\"[^>]*>~i',$content)){
		if(strtoupper($charset)!='UTF-8') $content=@iconv($charset."//IGNORE","UTF-8",$content);//die($contents);
		}//return '';
		return $content;
    }
	    /** 
     * curl POST 
     * 
     * @param   string  url 
     * @param   array   数据 
     * @param   int     请求超时时间 
     * @param   bool    HTTPS时是否进行严格认证 
     * @return  string 
     */  
    public static function curl_post($url, $data = array(), $timeout = 30, $CA = false){    
      
        $cacert = getcwd() . '/cacert.pem'; //CA根证书  
        $SSL = substr($url, 0, 8) == "https://" ? true : false;  
          
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);  
        if ($SSL && $CA) {  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书  
            curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
        } else if ($SSL && !$CA) {  
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名  
        }  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  
      
        $ret = curl_exec($ch);  
        $error=curl_error($ch);  //查看报错信息  
        if(!empty($error)) print_r($error);
        curl_close($ch);  
        return $ret;    
    }    
	// 构造绝对url
	public static function abs_url($base, $url) {
		if(strpos($url, "http://") === 0) {
			return $url;
		}
		$urlInfo = parse_url($base);
		$absUrl = "http://".$urlInfo["host"];
		if($url{0} == "/") {
			$absUrl .= $url;
		} elseif($url{0} == "?") {
			$absUrl .= $urlInfo["path"].$url;
		} else {
			$pos = strrpos($urlInfo["path"], "/");
			if($pos === false) {
				$absUrl .= "/".$url;
			} else {
				$absUrl .= substr($urlInfo["path"], 0, $pos + 1).$url;
			}
		}
		return $absUrl;
	}
	//获取客户端IP地址
	public static function getip(){
		$onlineip = '';    
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR'); 
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) { 
			$onlineip = $_SERVER['REMOTE_ADDR'];    
		}    
		return $onlineip;
	}
    //创建多级目录
    public static function mkdirs($dir){
        if(!is_dir($dir)){
            if(!helper::mkdirs(dirname($dir))){
                return false;  
            }
            if(!mkdir($dir,0777)){
                return false;  
            }
        }
        return true;
    } 
	//删除文件夹
	public static function deldir($dir) {
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
		  if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				self::deldir($fullpath);
			}
		  }
		}
		closedir($dh);
		if(rmdir($dir)) {
		  return true;
		} else {
		  return false;
		}
	}
	public static function xCopy($source, $destination, $child){ 
	/*
	　　//用法：   
	　　// xCopy("feiy","feiy2",1):拷贝feiy下的文件到 feiy2,包括子目录   
	　　// xCopy("feiy","feiy2",0):拷贝feiy下的文件到 feiy2,不包括子目录   
	　　//参数说明：   
	　　// $source:源目录名   
	　　// $destination:目的目录名   
	　　// $child:复制时，是不是包含的子目录   	
	*/
	   if(!is_dir($source)){
		    //echo("Error:the $source is not a direction!");
			return 0;
	   }
	   if(!is_dir($destination)){
		   mkdir($destination,0777);
	   }
	   $handle=dir($source);
	   while($entry=$handle->read()) {
		   if(($entry!=".")&&($entry!="..")){
			   if(is_dir($source."/".$entry)){
				   if($child) { 
				   		self::xCopy($source."/".$entry,$destination."/".$entry,$child);  
				   }
			   }else{
				   copy($source."/".$entry,$destination."/".$entry);
	           }
			}
		}
		return 1;   
	}  
	 /**
     * 获取某个文件夹下面的所有文件
     *
     * @param  $dir 某个文件夹所在的路径
     * @return array
     */
    public static function get_dir_files($dir) {
        $files = array();
        if (!file_exists($dir)) return $files;
        $key = 0;
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                $key++;
                if ($file != ".." && $file != ".") {
                    if (is_dir($dir . "/" . $file)) {

                    } else {
                        $files[$key]['name'] = $file;
                        $files[$key]['size'] = filesize($dir . "/" . $file);
                        $files[$key]['update_time'] = filemtime($dir . "/" . $file) ;
						$files[$key]['is_folder']=is_dir($dir.'/'.$file)?1:0;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }
	//得到文件夹的大小
	public static function dirsize($dir) {
	   $handle=opendir($dir); 
	   $size = 0;
	   while ( $file=readdir($handle) ) 
	   {
	       if ( ( $file == "." ) || ( $file == ".." ) ) continue;
	       if ( is_dir("$dir/$file") )
	           $size += self::dirsize("$dir/$file");
	       else
	           $size += filesize("$dir/$file");
	   }
	   closedir($handle);
	   return $size;
	}
	// 单位自动转换函数
    public static function getRealSize($size){ 
        $kb = 1024;         // Kilobyte
        $mb = 1024 * $kb;   // Megabyte
        $gb = 1024 * $mb;   // Gigabyte
        $tb = 1024 * $gb;   // Terabyte
        
        if($size < $kb)
        { 
            return $size." B";
        }
        else if($size < $mb)
        { 
            return round($size/$kb,2)." KB";
        }
        else if($size < $gb)
        { 
            return round($size/$mb,2)." MB";
        }
        else if($size < $tb)
        { 
            return round($size/$gb,2)." GB";
        }
        else
        { 
            return round($size/$tb,2)." TB";
        }
    }
    //内容  保存远程图片 
    static function saveHttpImg($content,$extern=0){
    	$code=$content;
    	$newcode=$code;
    	if(preg_match_all('~<img([^>]*)src=("|\')(http://.*?)\\2~i',$code,$result)){
    		$nimg=array_unique($result[3]);
    		foreach($nimg as $r){
    			if($extern==0 && stripos($r,Yii::app()->params['basic']['sitedomain'])){
    				continue;
    			}
    			$newimg=helper::save_img($r,0,$extern);
    			$newcode=str_ireplace($r,$newimg,$newcode);
    				
    				
    		}
    	}
    	return $newcode;
    }
	//保存远程缩略图
	 static function save_img($img_url,$fromid=0,$extern=0){	 
		 if(preg_match('~\.(jpg|png|gif|jpeg)~i',$img_url,$r)){
			 $img_name=date("YmdHis").substr(microtime(),2,4).'.'.$r[1];
			 $imgcode=helper::get_curl_contents($img_url);
			 if(!$imgcode) return;
			 if(preg_match('~<title>.*?<\/title>[\w\W]*?<body[^>]*>~i',$imgcode)) return;
			 $save_path='uploadfile/'.''.date('Y/m/d').'/';
			 // CLI模式下好像必须用全路径
			 $all_path=dirname(__FILE__).'/../../'.$save_path;   
			 if(!is_dir($all_path)){
			  	 helper::mkdirs($all_path);
		     }
			 $save_file=$save_path.'';
			 $fopen=fopen($all_path.$img_name,'w');
			 fwrite($fopen,$imgcode);	 
			 $reurl='/'.$save_path.$img_name;
			 
			 //生成缩略图
			 $createthumb=new CreateThumb();
			 
			 
			 $createthumb->SetVar($all_path.$img_name, 'file');
			 $createthumb->PRorate($all_path.'thumb_'.$img_name,'300',300);			 			 
			 //把图片写进数据库
			 $field=array();
			 $field['resource_url']=$reurl;
			 if(preg_match('~\/([^/]*?)\.'.$r[1].'~',$img_url,$r2)){
				 $field['r_name']=$r2[1];
			 }else{
				 $field['r_name']='';
			 }
			 $field['fromid']=$fromid;
			 $sql=helper::get_sql('resource_list','insert',$field);
			 if(!$extern){
			 	Yii::app()->db->createCommand($sql)->execute();	
			 }	
			 if($extern==2){
			 	global $dbm;
			 	$dbm->query_insert($sql);
			 } 
			 return $reurl;
		 }else{
		     return $img_url;	 
		 }
		 
	 }
	 //从正文中获取封面图片
	 static  function get_cover($content){
	 	$img='';
	 	if(preg_match('~<img([^>]*)src=("|\')(.*?)\\2[^>]*>~i',$content,$result)){
	 		$img=$result[3];
	 	}
	 	return trim($img);
	 }
	 
	 //写入文件
    public static function file_save($file,$content){
		$fp = fopen($file, 'w');// or die("无法写入缓存文件：{$logfile} 请给予{$logfile}写入权限！");
		fwrite($fp, $content);
		fclose($fp);
	}
	
	//转换IP为真实地址
	public static function convertip($ip,$gettype='city',$default_charset='GBK') {
		$return = '';
		if(preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
			$iparray = explode('.', $ip);
			if($iparray[0] == 10 || $iparray[0] == 127 || ($iparray[0] == 192 && $iparray[1] == 168) || ($iparray[0] == 172 && ($iparray[1] >= 16 && $iparray[1] <= 31))) {
				$return = '- LAN';
			} elseif($iparray[0] > 255 || $iparray[1] > 255 || $iparray[2] > 255 || $iparray[3] > 255) {
				$return = '- Invalid IP Address';
			} else {
				$tinyipfile = dirname(__FILE__).'/../data/ipdata/tinyipdata.dat';
				$fullipfile =dirname(__FILE__).'/../data/ipdata/wry.dat';
				if(@file_exists($tinyipfile)) {
					$return = helper::convertip_tiny($ip, $tinyipfile);
				} elseif(@file_exists($fullipfile)) {//die($fullipfile);
					$return = helper::convertip_full($ip, $fullipfile);
				}else{
				    echo 'ipdata file is not exists';
					return;
				}
			}
		}
		$return=iconv($default_charset."//IGNORE","UTF-8",$return);//echo '<font color=red>'.$return.'</font>';
		switch($gettype){
			case 'city':
			$c=$return;
			if(preg_match('~省?(.*?)市~',$c,$result)){   //普通省份
			    $return=$result[1];	
			}else if(preg_match('~(内蒙古|西藏|新疆)(.*?)(市|地区)~',$c,$result)){  //内幕古
			    $return=$result[2];	
			}else if(preg_match('~(澳门|香港|台湾)~',$c,$result)){  //内幕古
			    $return=$result[1];	
			}else if(preg_match('~(北京|天津|重庆|上海)~',$c,$result)){  //直辖市
			    $return=$result[1];	
			}else{
			    $return='';	
			}
			break;
			case 'all':break;
		}
		return $return;
	}
	//隐藏IP最后一段
	public static function ip_hide($ip){
		$t=strrpos($ip,".");
		$sr=substr($ip,0,$t);
		return$sr.".*";
	}
	public static function convertip_tiny($ip, $ipdatafile) {
		static $fp = NULL, $offset = array(), $index = NULL;
		$ipdot = explode('.', $ip);
		$ip    = pack('N', ip2long($ip));

		$ipdot[0] = (int)$ipdot[0];
		$ipdot[1] = (int)$ipdot[1];

		if($fp === NULL && $fp = @fopen($ipdatafile, 'rb')) {
			$offset = @unpack('Nlen', @fread($fp, 4));
			$index  = @fread($fp, $offset['len'] - 4);
		} elseif($fp == FALSE) {
			return  '- Invalid IP data file';
		}

		$length = $offset['len'] - 1028;
		$start  = @unpack('Vlen', $index[$ipdot[0] * 4] . $index[$ipdot[0] * 4 + 1] . $index[$ipdot[0] * 4 + 2] . $index[$ipdot[0] * 4 + 3]);

		for ($start = $start['len'] * 8 + 1024; $start < $length; $start += 8) {

			if ($index{$start} . $index{$start + 1} . $index{$start + 2} . $index{$start + 3} >= $ip) {
				$index_offset = @unpack('Vlen', $index{$start + 4} . $index{$start + 5} . $index{$start + 6} . "\x0");
				$index_length = @unpack('Clen', $index{$start + 7});
				break;
			}
		}

		@fseek($fp, $offset['len'] + $index_offset['len'] - 1024);
		if($index_length['len']) {
			return '- '.@fread($fp, $index_length['len']);
		} else {
			return '- Unknown';
		}
	}
	public static function convertip_full($ip, $ipdatafile) {
		if(!$fd = @fopen($ipdatafile, 'rb')) {
			return '- Invalid IP data file';
		}
		$ip = explode('.', $ip);
		$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

		if(!($DataBegin = fread($fd, 4)) || !($DataEnd = fread($fd, 4)) ) return;
		@$ipbegin = implode('', unpack('L', $DataBegin));
		if($ipbegin < 0) $ipbegin += pow(2, 32);
		@$ipend = implode('', unpack('L', $DataEnd));
		if($ipend < 0) $ipend += pow(2, 32);
		$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

		$BeginNum = $ip2num = $ip1num = 0;
		$ipAddr1 = $ipAddr2 = '';
		$EndNum = $ipAllNum;

		while($ip1num > $ipNum || $ip2num < $ipNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);

			fseek($fd, $ipbegin + 7 * $Middle);
			$ipData1 = fread($fd, 4);
			if(strlen($ipData1) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip1num = implode('', unpack('L', $ipData1));
			if($ip1num < 0) $ip1num += pow(2, 32);

			if($ip1num > $ipNum) {
				$EndNum = $Middle;
				continue;
			}

			$DataSeek = fread($fd, 3);
			if(strlen($DataSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($fd, $DataSeek);
			$ipData2 = fread($fd, 4);
			if(strlen($ipData2) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip2num = implode('', unpack('L', $ipData2));
			if($ip2num < 0) $ip2num += pow(2, 32);

			if($ip2num < $ipNum) {
				if($Middle == $BeginNum) {
					fclose($fd);
					return '- Unknown';
				}
				$BeginNum = $Middle;
			}
		}


		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(1)) {
			$ipSeek = fread($fd, 3);
			if(strlen($ipSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
			fseek($fd, $ipSeek);
			$ipFlag = fread($fd, 1);
		}

		if($ipFlag == chr(2)) {
			$AddrSeek = fread($fd, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}

			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr2 .= $char;

			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($fd, $AddrSeek);

			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;
		} else {
			fseek($fd, -1, SEEK_CUR);
			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr1 .= $char;

			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}
			while(($char = fread($fd, 1)) != chr(0))
			$ipAddr2 .= $char;
		}
		fclose($fd);

		if(preg_match('/http/i', $ipAddr2)) {
			$ipAddr2 = '';
		}
		$ipaddr = "$ipAddr1 $ipAddr2";
		$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
		$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
		$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
		if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
			$ipaddr = '- Unknown';
		}
		return '- '.$ipaddr;
	}
	//记录文本日志
	public static function logs($logs_type,$logs_txt){
		$fp = fopen(dirname(__FILE__).'/../runtime/'.$logs_type.'_'.date('Y-m-d').'.log', 'a');// or die("无法写入缓存文件：{$logfile} 请给予{$logfile}写入权限！");
		fwrite($fp, date('Y-m-d H:i:s').' '.self::getip().' '.$logs_txt.' '.chr(10));
		fclose($fp);
	}
	//URL重定向
	public static function redirect($url, $time=0, $msg='') {
		if(empty($msg)) $msg = "系统将在 {$time} 秒之后自动跳转到 {$url}";
		$str = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$str .= '<script type="text/javascript">setTimeout(function(){window.location.href="'.$url.'";},'.($time*1000).');</script>';
		if($time!=0) $str .= $msg;
		exit($str);
	}
	//根据IP获取城市
	static function get_ip_city($ip,$type){  //IP归属地
		if(!$ip){return false;}
	
		$content = helper::get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?ip=".$ip,'GBK');   
		$s_arr = explode("	",$content); 
		switch($type){
			case 'city':$str=$s_arr[5]?$s_arr[5]:$s_arr[5];break;
			case 'country':$str=$s_arr[3];break;
			case 'business':$str=$s_arr[7];break;
			case 'business_city':$str=$s_arr[7].($s_arr[5]?$s_arr[5]:$s_arr[5]);break;
			case 'city_business':$str=($s_arr[5]?$s_arr[5]:$s_arr[5]).$s_arr[7];break;
			}
		return $str;
	}
	
	
	public static function url_replace($p,$get){
			$url=$_SERVER['REQUEST_URI'];
			if(preg_match('~('.$get.'=\d+)~',$url)){
				return preg_replace('~('.$get.'=\d+)~',''.$get.'='.$p,$url);
			}else if(!stristr($url,'?')){
				return $url.'?'.$get.'='.$p;
			}else{
				return $url.'&'.$get.'='.$p;
			}
	}
	//分割中英文字符串
	public static function mb_str_split ($string, $len=1) {
		$start = 0;
		$strlen = mb_strlen($string);
		while ($strlen) {
			$array[] = mb_substr($string,$start,$len,"utf8");
			$string = mb_substr($string, $len, $strlen,"utf8");
			$strlen = mb_strlen($string);
		}
		return $array;
	}
    //加密
    public static function encrypt($txtStream,$password){
        //随机找一个数字，并从密锁串中找到一个密锁值
        $lockLen = strlen(self::$lockstream);
        $lockCount = rand(0,$lockLen-1);
        $randomLock = self::$lockstream[$lockCount];
        //结合随机密锁值生成MD5后的密码
        $password = md5($password.$randomLock);
        //开始对字符串加密
        $txtStream = base64_encode($txtStream);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for ($i=0; $i<strlen($txtStream); $i++) {
            $k = $k == strlen($password) ? 0 : $k;
            $j = (strpos(self::$lockstream,$txtStream[$i])+$lockCount+ord($password[$k]))%($lockLen);
            $tmpStream .= self::$lockstream[$j];
            $k++;
        }
        return $tmpStream.$randomLock;
    }
	//解密
    public static function decrypt($txtStream,$password){
        $lockLen = strlen(self::$lockstream);
        //获得字符串长度
        $txtLen = strlen($txtStream);
        //截取随机密锁值
        $randomLock = $txtStream[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount = strpos(self::$lockstream,$randomLock);
        //结合随机密锁值生成MD5后的密码
        $password = md5($password.$randomLock);
        //开始对字符串解密
        $txtStream = substr($txtStream,0,$txtLen-1);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for ($i=0; $i<strlen($txtStream); $i++) {
            $k = $k == strlen($password) ? 0 : $k;
            $j = strpos(self::$lockstream,$txtStream[$i]) - $lockCount - ord($password[$k]);
            while($j < 0){
                $j = $j + ($lockLen);
            }
            $tmpStream .= self::$lockstream[$j];
            $k++;
        }
        return base64_decode($tmpStream);
    }
	//返回时间，单位是毫秒 ms 
	public static function getmicrotime(){   
		list($usec, $sec) = explode(" ",microtime());   
		$tim=((float)$usec + (float)$sec)*1000;
		return $tim;
	}
	//登录密钥加密
	static function  lastvisit_encryption($string){
			$string=md5(md5(md5($string)));
			return $string;	
		}   
	static function send_email($username,$to,$mail_title = "",$mail_body = ""){	
		$mail_body=stripslashes($mail_body);
		$mail= new PHPMailer(); //new一个PHPMailer对象出来
		$mail->CharSet =Yii::app()->params['mail']['charset'];//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
		$mail->IsSMTP(); // 设定使用SMTP服务
		$mail->SMTPDebug  = false;                     // 启用SMTP调试功能
		$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
		$mail->SMTPSecure = "SSL";                 // 安全协议
		$mail->Host       = Yii::app()->params['mail']['host'];      // SMTP 服务器
		$mail->Port       =Yii::app()->params['mail']['port'];                   // SMTP服务器的端口号
		$mail->Username   = Yii::app()->params['mail']['username'];  // SMTP服务器用户名
		$mail->Password   = Yii::app()->params['mail']['password'];            // SMTP服务器密码
		$mail->SetFrom(Yii::app()->params['mail']['setfrom']);
		$mail->AddReplyTo(Yii::app()->params['mail']['addreplyto']);
		$mail->AltBody= "来自".Yii::app()->params['basic']['sitename']."的邮箱"; // optional, comment out and test			
		$mail->ClearAddresses();
		$mail->Subject= $mail_title;
		$mail->MsgHTML($mail_body);
		$mail->AddAddress($to,$username);	
		if(!$mail->Send()){
		   return false;
		} 
		return true;						 									 		
    }
    //发送短信
    static function send_message($params){
    	$re=array();
    	$re['code']=1;
    	return $re;
    }
	public static function escape($str, $urldecode = 0) {
        if ($urldecode == 1) $str = urldecode($str); 
        // PHP版本大于5.4.0，直接转义字符
        if (strnatcasecmp(PHP_VERSION, '5.4.0') >= 0) {
            $str = addslashes($str);
        } else {
            // 魔法转义没开启，自动加反斜杠
            if (!get_magic_quotes_gpc()) {
                $str = addslashes($str);
            } 
        } 
        return $str;
    }

	static function stringFilter($str)
	 {  
	 if (!empty($str)) {
	 if (ini_set('magic_quotes_gpc')) {
	 return $str;
	 } else {
	 return addslashes($str);
	 }
	 } else {
	 return false;
	 }
	 }
	static function get_fields_txt($name,$value,$re_field='txt',$from_value_field='value'){
	    global $fields;
		foreach($fields[$name] as $r){
			if($r[$from_value_field]==$value){
			    return $r[$re_field];	
			}
		}	
	}
	//拼装 插入 和 修改  的 sql语句
	static function  get_sql($table,$action,$field,$where=''){
		if($action=='insert'){
			$field_str='';
			$field_to_str='';
			foreach ($field as $key=>$cord){
				$field_str .='`'.helper::escape($key).'`,' ;
				$field_to_str .='\''.helper::escape($cord).'\',';
			}
			$field_str=substr($field_str,0,strlen($field_str)-1);
			$field_to_str=substr($field_to_str,0,strlen($field_to_str)-1);
			$sql="insert into `$table` ($field_str) values ($field_to_str)";
			return $sql;
		}elseif($action=='update'){
			$set_str='';
			if(!trim($where)){
				exit('修改记录请用where');
			}
			foreach ($field as $key=>$cord){
				$set_str .='`'.helper::escape($key).'`=\''.helper::escape($cord).'\',' ;
			}
			$set_str=substr($set_str,0,strlen($set_str)-1);
			$sql="update `$table` set $set_str  $where ";
			return $sql;
		}
	}
	static function fields_to_select($name,$type='select',$default_value,$radio_name){
	    global $fields;
		$revalue='';
		foreach($fields[$name] as $r){
			if($type=='radio'){
			    $revalue .='<label><input type="radio" name="'.$radio_name.'" value="'.$r['value'].'" '.($default_value==$r['value']?'checked':'').'> '.$r['txt'].'</label> ';	
			}
			if($type=='select'){
			    $revalue .='<option value="'.$r['value'].'" '.($default_value==$r['value']?'selected':'').'>'.$r['txt'].'</option>';	
			}
		}
		return $revalue;	
	}
	static function get_arr_txt($arr,$value,$re_field='txt',$from_value_field='value'){
		if(!is_array($arr)) return;
		foreach($arr as $r){
			if($r[$from_value_field]==$value){
			    return $r[$re_field];	
			}
		}	
	}
	static function arr_to_select($arr,$type='select',$default_value,$radio_name){
		$revalue='';
		foreach($arr as $r){
			if($type=='radio'){
			    $revalue .='<label><input type="radio" name="'.$radio_name.'" value="'.$r['value'].'" '.($default_value==$r['value']?'checked':'').'> '.$r['txt'].' </label> ';	
			}
			if($type=='select'){
			    $revalue .='<option value="'.$r['value'].'" '.($default_value==$r['value']?'selected':'').'>'.$r['txt'].'</option>';	
			}
		}
		return $revalue;	
	}
	
	
	static function get_option($params){ 		
		$options='';
		$id_field_name=isset($params['id_field_name'])&&$params['id_field_name']!=''?$params['id_field_name']:'';
		$txt_field_name=isset($params['txt_field_name'])&&$params['txt_field_name']!=''?$params['txt_field_name']:'';
		$txt_field_name2=isset($params['txt_field_name2'])&&$params['txt_field_name2']!=''?$params['txt_field_name2']:'';
		$table_name=isset($params['table_name'])&&$params['table_name']!=''?$params['table_name']:'';
		$select_value=isset($params['select_value'])&&$params['select_value']!=''?$params['select_value']:'';
		$wheresql=isset($params['wheresql'])&&$params['wheresql']!=''?$params['wheresql']:'';
		$ordersql=isset($params['ordersql'])&&$params['ordersql']!=''?$params['ordersql']:'';
		
		$sql="select * from ".$table_name." ".$wheresql." ".$ordersql;echo $sql;
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll($sql);
		if(count($rsarrs['list'])){
			foreach ($rsarrs['list'] as $rs){
				$options .='<option title="'.$rs[$txt_field_name].'" value="'.$rs[$id_field_name].'"  '.($select_value==$rs[$id_field_name]?'selected':'').' >'.$rs[$txt_field_name].''.($txt_field_name2?'-'.$rs[$txt_field_name2]:'').'</option>';
			}
		}   
		return $options;
	}
	/**************************************************************
     *
     *  使用特定function对数组中所有元素做处理
     *  @param  string  &$array     要处理的字符串
     *  @param  string  $function   要执行的函数
     *  @return boolean $apply_to_keys_also     是否也应用到key上
     *  @access public
     *
     *************************************************************/
	static function arrayRecursive(&$array, $function, $apply_to_keys_also = false){
        static $recursive_counter = 0;
        if (++$recursive_counter > 1000) {
            die('possible deep recursion attack');
        }
		if(is_array($array)){
			foreach ($array as $key => $value) {
				if (is_array($value)) {
					helper::arrayRecursive($array[$key], $function, $apply_to_keys_also);
				} else {
					$array[$key] = $function($value);
				}
		  
				if ($apply_to_keys_also && is_string($key)) {
					$new_key = $function($key);
					if ($new_key != $key) {
						$array[$new_key] = $array[$key];
						unset($array[$key]);
					}
				}
        }
		}
        $recursive_counter--;
    }
	 /**************************************************************
     *
     *  将数组转换为JSON字符串（兼容中文）
     *  @param  array   $array      要转换的数组
     *  @return string      转换得到的json字符串
     *  @access public
     *
     *************************************************************/
    static function json_encode_cn($array) {
        helper::arrayRecursive($array, 'urlencode', true);
        $json = json_encode($array);
        return $json;
    }	
		
	//json字符串 变成数组
	static function json_decode_cn($json) {
		$arr = json_decode($json,true);//print_r($arr);
        if(!is_array($arr)) $arr=array();
		helper::arrayRecursive($arr, 'urldecode',true);//print_r($arr);
        return $arr;
    }	
	// 对html 进行过滤  ，常用于前台用户发布的时候过滤干净
	static function escape_html($str){
		$farr = array(
		"/\s+/", //过滤多余空白
		//过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤
		"/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",
		"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件
		);
		$tarr = array(
		" ",
		" ",//如果要直接清除不安全的标签，这里可以留空
		" ",
		);
		$str = preg_replace( $farr,$tarr,$str);
		return $str;
    }
	//两个时间相减，得到天数
	static function get_days($params){
	   $time1=$params['time1'];
	   $time2=$params['time2'];
	   $days=(strtotime($time1)-strtotime($time2))/86400;
	   $days=intval($days)<0?0:intval($days);
	   return $days;	
	} 
	static function timeop($time,$type="talk") {
		$ntime=time()-$time;
		if ($ntime<60) {
			return("$ntime 秒前");
		} elseif ($ntime<3600) {
			return(intval($ntime/60)."分钟前");
		} elseif ($ntime<3600*24) {
			return(intval($ntime/3600)."小时前");
		} elseif ($ntime<3600*24*7) {
			return(intval($ntime/3600/24)."天前");
		} else {
			if ($type=="talk") {
				return(gmdate('m月d日 h:i',$time+8*3600));
			} else {
				return(gmdate('y-m-d h:i',$time+8*3600));
			}
		}
	}
	
	static function  field_paixu($param=array()){  //倒序降序排列
	    $param['url']=isset($param['url'])?$param['url']:'';
		$_GET['order']=isset($_GET['order'])?$_GET['order']:'';
	    if($param['url']==''){
		  $url='?';   
		}else if(stristr($param['url'],'?')){
		  $url=$param['url']."&";	
		}else{
		  $url=$param['url']."?";	
		}
		if ($_GET['order']==$param['field'] and $_GET['xu']=='desc'){     
		    return '<a href="'.$url.'order='.$param['field'].'&xu=asc" title="点击'.$param['field_cn'].'顺序排序">▼'.$param['field_cn'].'</a>';
		}elseif ($_GET['order']==$param['field'] and $_GET['xu']=='asc'){    
		    return '<a href="'.$url.'order=&xu=" title="恢复默认排序">▲'.$param['field_cn'].'</a>';
		}else{
		    return '<a href="'.$url.'order='.$param['field'].'&xu=desc" title="点击'.$param['field_cn'].'倒序排序">'.$param['field_cn'].'</a>'; 
		}	
	}
	
	 //二维数组排序
    static function array_sort($arr,$keys,$type='asc'){
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{ 
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            //$new_array[$k] = $arr[$k];
        	$new_array[] = $arr[$k];
         }
        return $new_array;
    } 
    //将'2,7,1'这样的 改成 '1,7,2' 倒着
    static function inid_sort($str){
		$arr=explode(',',$str);
		$arr2=array_reverse($arr);
		
		return implode(',',$arr2);   	
    }
    
	/**
     * 采用google API 生成二维码
     * 
     * @param  $content 二维码要存储的文字内容
     * @param  $widthHeight 宽高
     * @param  $EC_level 纠错级别
     * @param  $margin 间距
     */
    public static function google_qrcode($content, $widhtHeight = '150', $EC_level = 'L', $margin = '0') {
        $url = urlencode($content);
        return '<img title="用你的手机扫描这里" src="http://chart.apis.google.com/chart?chs=' . $widhtHeight . 'x' . $widhtHeight . '&cht=qr&chld=' . $EC_level . '|' . $margin . '&chl=' . $content . '"/>';
    } 
    /*http://www.liantu.com/pingtai/生成二维码
     * 
     * */
    public static function create_qrcode($content,$width=150){
    	return 'http://qr.liantu.com/api.php?m=0&w='.$width.'&text='.$content;
    }
	/**
     * 检测来源是手机用户
     *
     * @return boolean true 是手机端  false 是其他终端
     */
    public static function from_mobile() {
        $regex_match = "/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
        $regex_match .= "htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|meizu|miui|ucweb";
        $regex_match .= "blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
        $regex_match .= "symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
        $regex_match .= "jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
        $regex_match .= ")/i";

        if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) || (isset($_SERVER['HTTP_USER_AGENT']) && preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])))) {
            return true;
        }
        return false;
    }
		//字符串截取
	public static function cut_str($sourcestr,$cutlength)  
	{  
	   $returnstr='';  
	   $i=0;  
	   $n=0;  
	   $str_length=strlen($sourcestr);//字符串的字节数  
	   while (($n<$cutlength) and ($i<=$str_length))  {  
		  $temp_str=substr($sourcestr,$i,1);  
		  $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码  
		  if ($ascnum>=224)    //如果ASCII位高与224，  
		  {  
	$returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符          
			 $i=$i+3;            //实际Byte计为3  
			 $n++;            //字串长度计1  
		  }  
		  elseif ($ascnum>=192) //如果ASCII位高与192，  
		  {  
			 $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符  
			 $i=$i+2;            //实际Byte计为2  
			 $n++;            //字串长度计1  
		  }  
		  elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，  
		  {  
			 $returnstr=$returnstr.substr($sourcestr,$i,1);  
			 $i=$i+1;            //实际的Byte数仍计1个  
			 $n++;            //但考虑整体美观，大写字母计成一个高位字符  
		  }  
		  else                //其他情况下，包括小写字母和半角标点符号，  
		  {  
			 $returnstr=$returnstr.substr($sourcestr,$i,1);  
			 $i=$i+1;            //实际的Byte数计1个  
			 $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...  
		  }  
	   }  
			 if ($str_length>$i){  
			  $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号  
		  }  
		return $returnstr;  
	} 
	
	 /**
     * 根据百度搜索结果自动提取关键词
     * @param $title 要提取关键词的标题
     * @param $filter_words1 精准过滤词数组 array('过滤词1','过滤词2')
     * @param $filetr_words2 模糊过滤词数组 array('过滤词1','过滤词2')
     */
    public static function get_tags_baidu($title,$filter_words1=array(),$filter_words2=array()) {
        if (strlen($title) <= 4) {
        	//echo ('{"code":1,"msg":"","data":["' . $title . '"]}');
        	return '';
        }
        $ret = helper :: get_contents('http://www.baidu.com/s?wd=' . urlencode($title));
        preg_match_all('~<em>(.*?)</em>~', $ret, $keys);
        //过滤字符
        for($i=0;$i<count($keys[1]);$i++){
            $keys[1][$i] = preg_replace('~"|\'|"|"|【|】|\(|\)|（|）|:|：|\-|—~','',$keys[1][$i]);
        }
        //去重并过滤
        $nkeys = array();
        foreach($keys[1] as $a) {
            //去重
            $is_key = 0;
            for($b = 0;$b < count($nkeys);$b++) {
                if ($a == $nkeys[$b]['k']) {
                    $is_key = 1;
                    $nkeys[$b]['t'] = 1 + $nkeys[$b]['t'];
                    break;
                }
            }
            //过滤
            $is_k1=0;
            foreach($filter_words1 as $b){
                if($b==$a) {$is_k1=1;break;}
            }
            $is_k2=0;
            foreach($filter_words2 as $b){
                if(strstr($a,$b)) {$is_k2=1;break;}
            }
            if ($is_key == 0 && $is_k1==0 && $is_k2==0) array_push($nkeys, array('k' => $a, 't' => 1,'l'=>strlen($a)));
        }
        //过滤字符长度
        $tags = array();
        for($i = 0;$i < count($nkeys);$i++) {
            if (strlen($nkeys[$i]['k']) >= 6 && strlen($nkeys[$i]['k']) <= 12) array_push($tags, $nkeys[$i]);
        }
        //排序
        $tags = helper :: array_sort($tags, 'l');//print_r($info_tags);
        $ntags=array();
        //重做数组
        foreach($tags as $a){
            array_push($ntags,$a);
        }

        return $ntags;
    }
	//转为钱，两个小数
	public static function money($money){
		return	sprintf('%.2f',$money);
	}
	
	// 分割where范围
	public function explode_andwheresql($str,$field,$explode_str='_'){
		if(stristr($str,$explode_str)){
			$strings=explode($explode_str,$str);
			if(intval($strings[1])>intval($strings[0])){
				$wheresql="and (".$field.">='".intval($strings[0])."' and ".$field."<='".intval($strings[1])."') ";
			}else{
				$wheresql="and (".$field.">='".intval($strings[0])."')";
			}
		}else{
			$wheresql="and (".$field."='".intval($str)."') ";
		}
		return $wheresql;
	}
	//验证码
	public static function verify_code($session_name='rancode'){
		/** 初始化*/
		$border = 0; //是否要边框 1要:0不要
		$how = 4; //验证码位数
		$w = $how*20; //图片宽度
		$h = 24; //图片高度
		$fontsize = 5; //字体大小
		$alpha = "abcdefghijkmnpqrstuvwxyz"; //验证码内容1:字母
		$number = "23456789"; //验证码内容2:数字
		$randcode = ""; //验证码字符串初始化
		srand((double)microtime()*1000000); //初始化随机数种子
		$im = ImageCreate($w, $h); //创建验证图片
		/** 绘制基本框架*/
		$bgcolor = ImageColorAllocate($im, 255, 255, 255); //设置背景颜色
		ImageFill($im, 0, 0, $bgcolor); //填充背景色
		if($border){
			$black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
			ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//绘制边框
		}
		/** 逐位产生随机字符*/
		for($i=0; $i<$how; $i++){
			$alpha_or_number = mt_rand(0, 1); //字母还是数字
			$str = $alpha_or_number ? $alpha : $number;
			$which = mt_rand(0, strlen($str)-1); //取哪个字符
			$code = substr($str, $which, 1); //取字符
			$j = !$i ? 20 : $j+15; //绘字符位置
			$color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //字符随即颜色
			ImageChar($im, $fontsize, $j, 3, $code, $color3); //绘字符
			$randcode .= $code; //逐位加入验证码字符串
		}
		/** 添加干扰*/
		for($i=0; $i<3; $i++){//绘背景干扰线
			$color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰线颜色
			ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //干扰线
		}
		for($i=0; $i<$how*40; $i++){//绘背景干扰点
			$color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //干扰点颜色
			ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); //干扰点
		}
	
	
		//把验证码字符串写入session
		
		
		$_SESSION[$session_name] = $randcode;
		
		//die(print_r($_SESSION));
		header("Content-type: image/gif");
		/*绘图结束*/
		Imagegif($im);
		ImageDestroy($im);
		/*绘图结束*/
		die();
	}
	//随机字符串
	public static function randstr($len=6) {
		$chars='0123456789';
		#characters to build the password from
		mt_srand((double)microtime()*1000000*getmypid());
		#seed the random number generater (must be done)
		$password='';
		while(strlen($password)<$len)
			$password.=substr($chars,(mt_rand()%strlen($chars)),1);
		return $password;
	}
	
	//获取字符串长度
	public static function dstrlen($str) {
		
		$count = 0;
		for($i = 0; $i < strlen($str); $i++){
			$value = ord($str[$i]);
			if($value > 127) {
				$count++;
				if($value >= 192 && $value <= 223) $i++;
				elseif($value >= 224 && $value <= 239) $i = $i + 2;
				elseif($value >= 240 && $value <= 247) $i = $i + 3;
			}
			$count++;
		}
		return $count;
	}
	
	/**
	 *@author mckee
	 *@blog  http://www.phpddt.com
	 */
	public static function get_page_url($domain=0){
		$url='';
		if($domain==1){
			$url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
			$url .= $_SERVER['HTTP_HOST'];
		}
		$url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);
		return $url;
	}
	
	/**
	 *计算某个经纬度的周围某段距离的正方形的四个点
	 *
	 *@param lng float 经度
	 *@param lat float 纬度
	 *@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
	 *@return array 正方形的四个点的经纬度坐标
	 //$info_sql = "select id,locateinfo,lat,lng from `lbs_info` where lat<>0 and lat>{$squares['right-bottom']['lat']} and lat<{$squares['left-top']['lat']} and lng>{$squares['left-top']['lng']} and lng<{$squares['right-bottom']['lng']} ";
	 */
	public static function returnSquarePoint($lng, $lat,$distance = 0.5){
		$EARTH_RADIUS=6371;//地球半径，平均半径为6371km
		$dlng =  2 * asin(sin($distance / (2 * $EARTH_RADIUS)) / cos(deg2rad($lat)));
		$dlng = rad2deg($dlng);
			
		$dlat = $distance/$EARTH_RADIUS;
		$dlat = rad2deg($dlat);
			
		return array(
				'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
				'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
				'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
				'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
		);
	}
	
	 
}

?>