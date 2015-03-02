<?php 
die();
//本页为在CLI模式下执行 该文件的
include('protected/components/helper.php');
include('protected/components/CreateThumb.php');
//error_reporting(E_ALL & ~E_STRICT);  //php 5.4 以上 对方法重写参数需要一致，不一致需要加上 默认值,问题出现在 Dtable里面

//mysql数据库操作类
class db_mysql{
	//数据库操作次数
	public $query_count = 0;
	public $conn;
	//初始化类，根据传入的数据库参数连接数据库
	public function __construct($db_config){
		$conn = mysql_connect($db_config['host'],$db_config['user'],$db_config['pass'],true) or die("do not connect database");
		$this->conn=$conn;
		mysql_select_db($db_config['dbname'],$conn) or die("do not open database");
		mysql_query("set names ".$db_config['query_charset'],$conn);
	}
	//销毁类
	public function __destory(){
		mysql_close();
	}
	//执行查询语句返回结果集，$suffix 为where条件完毕之后的sql语句如order by 和 limit 等，$is_total 用于获取分页数据的总记录数
	public function query($sql,$suffix='',$is_total=0){
		//判断是否取记录总数,0为不取，1为取
		$_start = helper::getmicrotime();//echo $sql.';<br>';
		$total=0;$sql_count_time=0;
		if($is_total>0){
			$total=mysql_num_rows(mysql_query($sql,$this->conn));
			$this->query_count++;
			$sql_count_time = helper::getmicrotime()-$_start;
		}

		//查询取得记录列表
		$rs=mysql_query($sql.' '.$suffix,$this->conn);
		$this->query_count++;
		$i=0;$list=array();
		if($rs){
			while($rows=@mysql_fetch_assoc($rs)){
				$list[$i]=$rows;
				$i++;
			}
		}
		//返回该查询的记录总数和记录列表
		$querys=array(
				'sql'=>$sql.' '.$suffix,//SQL
				'error'=>mysql_error(),//SQL报错信息
				'sql_time'=>helper::getmicrotime()-$_start,//整个SQL完成耗费时间
				'sql_time_count'=>$sql_count_time,//统计行数耗费时间
				'total'=>$total,//记录总数，如果$is_total=0，则该值为0
				'list'=>$list,
		);
		return $querys;
	}
	//执行插入操作
	public function query_insert($sql){
		$_start = helper::getmicrotime();
		mysql_query($sql,$this->conn);
		$this->query_count++;
		$querys=array(
				'sql'=>$sql,
				'error'=>mysql_error(),
				'sql_time'=>helper::getmicrotime()-$_start,//整个SQL完成耗费时间
				'autoid'=>mysql_insert_id($this->conn),
		);
		return $querys;
	}
	//执行查询，更新、删除操作，返回影响行数
	public function query_update($sql){
		$_start = helper::getmicrotime();
		mysql_query($sql,$this->conn);
		$this->query_count++;
		$querys=array(
				'sql'=>$sql,
				'error'=>mysql_error($this->conn),
				'sql_time'=>helper::getmicrotime()-$_start,//整个SQL完成耗费时间
		);
		return $querys;
	}
	//事物处理，执行多条sql, $sql是一个数组
	public function Tran($sql) {
		$judge = 1;
		mysql_query("SET AUTOCOMMIT=0",$this->conn);//设置为不自动提交，因为MYSQL默认立即执行
		mysql_query('begin',$this->conn);
		foreach ($sql as $v) {
			if ( !mysql_query($v,$this->conn) ) {
				$judge = 0;
			}
		}
		if($judge == 0) {
			mysql_query('rollback',$this->conn);
			return false;
		}
		elseif ($judge == 1) {
			mysql_query('commit',$this->conn);
			return true;
		}
	}

}

$config=array(
		//mysql 数据库组
		'db_mysql'=>array(
				'default'=>array(
						'host'=>'localhost', //数据库主机
						'user'=>'root', //数据库用户
						'pass'=>'zhoufei', //数据库密码
						'dbname'=>'shouyou_data', //数据库
						'query_charset'=>'utf8', //编码
				)
		),
	);



$dbm=new db_mysql($config['db_mysql']['default']);

$smartCollect=new taskCollect();
$smartCollect->runAll();

echo '---------------------------completed!';

//采集手机游戏
class taskCollect {
	public $url='http://www.5253.com/gameList/{p}-0-0-0-0-0-0-0.html';
	public $detailurl='http://www.5253.com/{id}/download.html';
	public $pagetotal=1010;
	public $game_types=array();
	public function __construct(){
		global $dbm;
		$sql="select * from linkage where linkage_type_id=16";
		$a=$dbm->query($sql);
		$this->game_types=$a['list'];
		//print_r($this->game_types);die();
	}
	//采集所有
	public function runAll(){
		if(isset($_SERVER['argv'][1])){
			$this->pagetotal=intval($_SERVER['argv'][1]);
		}
		for($i=$this->pagetotal;$i>0;$i--){
			echo 'starting collect no.'.$i.' page run ..'.chr(10);
			sleep(1);
		    $this->checklist($i);	
		    echo 'no.'.$i.' page end '.chr(10);
		}
	}
	
	//只采集第一页，用作计划任务
	public function taskRun(){
		echo 'first no.1 page starting... '.chr(10);
		$this->checklist(1);
		
		
	}
	public function checklist($pagenum){	
		$url=str_replace('{p}',$pagenum,$this->url);
		$rule='~<li>[^<]*<a\shref=\"http://www\.5253\.com\/(\d+)\/download.html\"[^>]*title=\"(.*?)\"[\w\W]*?下载：(\d+)[\w\W]*?</li>~';
		$a=helper::get_contents($url);
		if(!preg_match_all($rule,$a,$result)){
			die('任务正则出错'.chr(10));			
		}	
		foreach($result[1] as $k=>$r){
			$id=$r;
			$this->single($id,$result[3][$k]);
				
		}
		
	}
	//采集某一篇
	public function single($collect_id,$downloads){
		//sleep(15);
		global $dbm;
		$collect_id=intval($collect_id);
		$detailurl=str_replace('{id}',$collect_id,$this->detailurl);
	
		//判断是否采集过
		$sql="select * from game_mobile where collect_type=1 and collect_id=$collect_id ";
		$m3=$dbm->query($sql);
		if(count($m3['list'])){
			echo('目标站ID:'.$collect_id.' ,  已存在 exists'.chr(10));
			return;
		}
	
		//内容页规则
		$detail_rule=array();
		$detail_rule['info_title']='~<h2>(.*?)<\/h2>~';
		$detail_rule['info_img']='~<span[^>]*class=\"pic\">[^<]*<img[^>]*src=\"(.*?)\"~';
		$detail_rule['score']='~<span[^>]*class=\"num\">(.*?)<\/span>~';
		$detail_rule['gfilesize']='~<em[^>]*class=\"size\">大小：(.*?)<\/em>~';
		$detail_rule['en_title']='~<span[^>]*class=\"en\">(.*?)<\/span>~';
		$detail_rule['language']='~<em[^>]*class=\"tag\">语言<\/em>：(.*?)<\/li>~';
		$detail_rule['business']='~<em[^>]*class=\"tag\">厂商<\/em>：(.*?)<\/li>~';
		$detail_rule['plat']='~<em[^>]*class=\"tag\">平台<\/em>：(.*?)<\/li>~';
		$detail_rule['create_time']='~<em[^>]*class=\"tag\">创建时间<\/em>：(.*?)<\/li>~';
		$detail_rule['game_type']='~<em[^>]*class=\"tag\">类型<\/em>：(.*?)<\/li>~';
		$detail_rule['apple_url']='~<a[^>]*href=\"(https:\/\/itunes\.apple\.com\/[^\"]*)\"~';
		$detail_rule['down_url']='~<li><a\sclass="item4"[^>]*href="([^\"]*\.apk)"[^>]*>~';
		$detail_rule['info_body']='~<h3[^>]*>游戏简介：<\/h3><\/div>[^<]*<div[^>]*class=\"bd\">([\w\W]*?)<\/div>[^<]*<\/div>[^<]*<!--游戏截图 ~';
		//print_r($detail_setting);die('aaa');
		$content=helper::get_contents($detailurl);
		if(preg_match('~<title><\/title>~',$content,$result)){
			echo('目标站ID:'.$collect_id.' ,  内容获取失败，请检查网络或程序 01'.chr(10));
			return;
		}
		$field=array();
		foreach($detail_rule as $k=>$rule){
			if(preg_match($rule,$content,$result)){
				if($k=='score'){
					$field['score']=sprintf('%.1f',strip_tags($result[1]));	
				}else if($k=='language'){
					if(trim($result[1])=='英文'){
						$field['language']=1;
					}else{
						$field['language']=0;
					}
				}else if($k=='plat'){
					if(preg_match('~ios.*?安卓~',$result[1])){
						$field['plat']=3;
					}else if(preg_match('~安卓~',$result[1])){
						$field['plat']=1;
					}else if(preg_match('~ios~',$result[1])){
						$field['plat']=2;
					}else{
						$field['plat']=0;
					}
					
				}else if($k=='create_time'){
					strtotime('2014-09-24');
					$field['create_time']=strtotime($result[1]);
				}else if($k=='gfilesize'){
					$field['gfilesize']=sprintf('%.2f',trim($result[1]));	
				}else if($k=='game_type'){
					if(preg_match_all('~<a[^>]*>(.*?)<\/a>~',$result[1],$result2)){
						$type_id_arr=array();
						foreach($result2[1] as $k=>$r3){
							if($k==count($result2[1])-1){
								continue;
							}
							$tid=$this->get_type_id($r3);
							if(!$tid){
								continue;
							}
							$type_id_arr[]=$tid;						
						}
						$field['game_type']=json_encode($type_id_arr);
					}else{
						$field['game_type']='[]';
					}

					if(preg_match('~单机~',$result[1])){
						$field['isnet']=0;
					}else{
						$field['isnet']=1;
					}
					
				}else if($k=='info_img'){	
					$field['info_img']=helper::save_img($result[1],0,1);	
				}else{
					$field[$k]=$result[1];
				}
				
			}else{
				//echo $r['field'].' ng!';
			}
		}
		if($field['info_title']=='' || $field['info_title']=='请刷新后重试' || $field['info_title']==':('){
			echo('目标站ID:'.$collect_id.' ,标题获取失败，请检查正则 02 '.chr(10));
			return;
		}
		if(!isset($field['info_desc']) || $field['info_desc']==''){
			$field['info_desc']=mb_substr(str_replace(array('　',' ','&nbsp;'),'',strip_tags($field['info_body'])),0,240);
		}
		if(!isset($field['create_time']) || !$field['create_time']){
			$field['create_time']=time();
		}
		$field['info_body']=helper::saveHttpImg($field['info_body'],1);
		//$field['info_tags']=$this->get_tags($field['info_title']);
		$field['audit']=1;
		$field['info_order']=50;
		$field['downloads']=intval($downloads);
		$field['last_cate_id']=103;
		$field['info_editor']='collector';
		$field['collect_type']=1;
		$field['collect_id']=$collect_id;
		$sql=helper::get_sql('game_mobile','insert',$field);
		$a=$dbm->query_insert($sql);
		if($a['error']==''){
			$field2=array();
			$field2['sno']=1;
			$field2['log_time']=time();
			$field2['log_ip']='@后台采集器';
			$field2['log_details']='采集手游《'.$field['info_title'].'》 目标站ID:'.$collect_id. ' 本站ID：'.$a['autoid'].' 成功';
			$sql=helper::get_sql('cservice_aclog','insert',$field2);
			$b=$dbm->query_insert($sql);
			echo('目标站ID:'.$collect_id.' ,采集成功  ok '.chr(10));
			//采集成功之后保存 系列图片
			$resource_rule='~,\"picInfo\":(\[[\w\W]*?\])~';
			if(preg_match($resource_rule,$content,$result2)){
				$resource_data=json_decode($result2[1],1);
				foreach($resource_data as $r2){
					$img=helper::save_img($r2['cover_url'],'game_mobile-'.$a['autoid'],2);
					echo $img.' download ok '.chr(10);
				}
			}
				
			return;
		}else{
			echo('目标站ID:'.$collect_id.' ,采集出错  error  '.$a['error'].chr(10));
			return;
		}
	}
	//获取标签
	private  function get_tags($title){
		if(!$title) return;
		$a=helper::get_tags_baidu($title);
		if(count($a)==0){
			return;
		}
		//print_r($a);
		$str=array();
		$i=0;foreach($a as $r){$i++;if($i==5)break;
		$str[]=$r['k'];
		}
		return implode(',',$str);
	
	}
	
	//跟据名称获取游戏分类id
	private function get_type_id($type_name){
		$type_name=str_replace('类','',$type_name);
		foreach($this->game_types as $r){
			if($r['linkage_name']==$type_name){
				return $r['linkage_id'];
			}
		}
	}
}