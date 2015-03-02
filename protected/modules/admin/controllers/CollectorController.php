<?php
/*
 * 淘宝客采集
 * 
 * 
 * */
class CollectorController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Collector_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.displayorder , a.id desc     ";
		$params['pagesize']=200;
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Collector::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Collector_edit');			
				$info=$this->toArr(Collector::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
				$cate_id=$page['info']['cate_id'];
			}else{
				$this->auth_action('Collector_add');
				$cate_id=0;
			}
			$page['categorys']=InfoCategory::model()->category_tree($cate_id);
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=Collector::model()->findByPK($id);
			if(!$m){
				$m=new Collector();
			}
			
			$m->name=$this->post('name');
			if($m->name==''){
				$this->msg(array('state'=>0,'msgwords'=>'名称不能为空'));
			}
			$m->model_table=$this->post('model_table');
			$m->cate_id=intval($this->post('cate_id'));
			$m->pagenums=intval($this->post('pagenums'));
			$m->nowpage=intval($this->post('nowpage'));
			$m->pageurl=$this->post('pageurl');
			$m->detailurl=$this->post('detailurl');
			$m->collect_type=intval($this->post('collect_type'));
			$m->collect_id=intval($this->post('collect_id'));
			$m->list_rule=addslashes($this->post('list_rule'));
			$m->detail_rule=addslashes($this->post('detail_rule'));
			$m->list_title=addslashes($this->post('list_title'));
			$m->displayorder=intval($this->post('displayorder'));
			$m->create_time=time();
			
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Collector_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('collector/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了采集器 ID:'.$id.''.$m->name.' ';
			}else{	
				$this->auth_action('Collector_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了采集器ID：$dbresult".$m->name;
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
				$this->logs($logs);
				//成功跳转提示
				$this->msg($msgarr);
			}
	
		}
		$this->render('update',array('page'=>$page));
	}
	//复制一个采集器
	public function actionCopy(){
		$id=$this->get('id');
		$m=Collector::model()->findByPk($id);
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'采集器不存在'));
		}
		$m2=new Collector();
		$m2->name=$m->name.' 副本';
		$m2->model_table=$m->model_table;
		$m2->cate_id=$m->cate_id;
		$m2->pagenums=$m->pagenums;
		$m2->nowpage=$m->nowpage;
		$m2->pageurl=$m->pageurl;
		$m2->detailurl=$m->detailurl;
		$m2->collect_type=$m->collect_type;
		$m2->collect_id=$m->collect_id;
		$m2->list_rule=$m->list_rule;
		$m2->detail_rule=$m->detail_rule;
		$m2->list_title=$m->list_title;
		$m2->displayorder=$m->displayorder;
		$m2->create_time=time();
		$m2->save();
		$this->msg(array('state'=>1,'msgwords'=>'复制成功'));
	}
	
	public function actionDelete(){
		$this->auth_action('Collector_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Collector::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了采集器ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('Collector_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Collector::model()->findByPk($id);
			if(!$m) continue;
			$m->displayorder=$order;
			$m->save();		
		}
		$this->logs('修改了采集器的排序');
		$this->msg(array('state'=>1));
	}
	
	private function readyRun(){
		$id=intval($this->get("id"));
		$m=Collector::model()->findByPk($id);
		if(!$m){
			$this->msg(array('state'=>-2,'msgwords'=>'采集器不存在 i-0'));
		}	
		if($m->cate_id==0){
			$this->msg(array('state'=>-2,'msgwords'=>'请设置栏目分类噢 i-3'));
		}
		return $m;
	}
	
	//启动入口，用于统计运行次数和最后运行时间
	public function actionStart(){		
		$m=$this->readyRun();
		$m->runtimes++;
		$m->last_time=time();
		if($m->nowpage==0){
			$m->nowpage=1;
		}
		$m->save();
		header("location:run/?id=".$this->get('id'));
		die();
	}
	public function ActionRun(){		
		$m=$this->readyRun();
		//获取列表页的url
		$listurl=$m->pageurl;
		$listurl=str_replace('{p}',$m->nowpage,$listurl);
		//列表页规则
		$listrule='~'.stripslashes($m->list_rule).'~';
		//得到列表页html
		$charset='GBK';
		$content=helper::get_contents($listurl,$charset);//echo $content;
		//$content=helper::get_contents($listurl,'gb2312');
		//匹配出详细页url和参数
		if(!preg_match_all($listrule,$content,$result)){
			die('列表未匹配到，请手动去更改当前页数');			
		}
		if($m->nowpage<=0){
			die('当前页码已到0 ， 已经采集完毕，如需采集请设置为大于0！');
		}
			
		$page['collect']=Dtable::toArr($m);
		$page['list']=array();
		//获取到所有详细页
		foreach($result[$m->collect_id] as $k=>$r){
			$collect_id=$r;
			if(is_numeric($m->detailurl)){
				$detailurl=$result[$m->detailurl][$k];
			}else{
				$detailurl=str_replace('{id}',$collect_id,$m->detailurl);
			}
			$list_title_num=$m->list_title;
			$detailtitle=$result[$list_title_num][$k];
			$page['list'][]=array('detailurl'=>$detailurl,'detailtitle'=>$detailtitle,'detailid'=>$r);
		}				
		$this->render('run',array('page'=>$page));
		
		//print_r($result);
		
		
		//print_r($detail_setting);						
		
	}
	
	//js请求当前页应该减去1
	public function ActionCutpage(){
		$id=intval($this->get('id'));
		$m=Collector::model()->findByPk($id);
		if($m){
			if($m->nowpage<=1){
				$this->msg(array('state'=>2,'type'=>'json','msgwords'=>'已经采集完毕 '));
			}			
			$m->nowpage--;
			$m->save();
			$this->msg(array('state'=>1,'type'=>'json','msgwords'=>'采集器完成了一页 '));
		}else{
			$this->msg(array('state'=>0,'type'=>'json','msgwords'=>'采集器出现错误 '));
		}
	}
	
	//采集某一篇文章
	public function ActionRunsingle(){
		//sleep(15);
		$m=$this->readyRun();
		$collect_id=intval($this->get('collect_id'));
		$detailurl=urldecode($this->get('detailurl'));
		//判断是否采集过
		$m3=Dtable::model($m->model_table)->findByAttributes(array('collect_type'=>$m->collect_type,'collect_id'=>$collect_id));
		if($m3){
			$this->msg(array('state'=>0,'type'=>'json','msgwords'=>'目标站ID:'.$collect_id.' ,  已存在 exists'));
		}
		
	   
		//内容页规则
		$detail_setting_str=stripcslashes($m->detail_rule);
		$detail_setting_arr=json_decode($detail_setting_str,1);
		$detail_setting=array();
		foreach($detail_setting_arr as $r){
			$r['rule']='~'.urldecode($r['rule']).'~';// echo $r['rule'].'<br>';
			$detail_setting[]=$r;
		}
		//print_r($detail_setting);die('aaa');
		$content=helper::get_contents($detailurl);
		if(preg_match('~<title><\/title>~',$content,$result)){
			$this->msg(array('state'=>0,'type'=>'json','msgwords'=>'目标站ID:'.$collect_id.' ,  内容获取失败，请检查网络或程序 01'));
		}
		$m2=new Dtable($m->model_table);
		foreach($detail_setting as $r){//echo $r['rule'].'<br>';
			if(preg_match($r['rule'],$content,$result)){
				$m2->$r['field']=$result[1];
				if($r['field']=='info_body'){
					$m2->info_body=str_replace('</img</div>','</img></div>',$m2->info_body);
				}
			}else{
				//echo $r['field'].' ng!';
			}
		}
		if($m2->info_title=='' || $m2->info_title=='请刷新后重试' || $m2->info_title==':('){
			$this->msg(array('state'=>0,'type'=>'json','msgwords'=>'目标站ID:'.$collect_id.' ,标题获取失败，请检查正则 02 '));
		}
		if($m2->info_desc==''){
			$m2->info_desc=mb_substr(str_replace(array('　',' ','&nbsp;'),'',strip_tags($m2->info_body)),0,240);
		}
		$m2->create_time=strtotime($m2->create_time);
		if(!$m2->create_time){
			$m2->create_time=time();
		}
		$m2->info_body=preg_replace('~http:\/\/192\.168\.1.112:\d+\/uploads\/~','http://sfh.54114.com/uploads/',$m2->info_body);
		$m2->info_body=helper::saveHttpImg($m2->info_body);
		$m2->info_body=str_replace('<div class="pager2">', '', $m2->info_body);
		$m2->info_body=str_replace('<div align=right>【编辑：', '【编辑：', $m2->info_body);
		$m2->info_body=preg_replace('~<a[^>]*href=[^>]*shouyou\.com[^>]*>(.*?)<\/a>~', '$1', $m2->info_body);
		$m2->info_img=helper::get_cover($m2->info_body);
		if($m2->info_img){
			$m2->flag_img=1;
		}
		$m2->info_tags=$this->get_tags($m2->info_title);
		$m2->audit=1;
		$m2->info_order=50;
		$m2->last_cate_id=$m->cate_id;
		$m2->info_editor='collector';
		$m2->collect_type=$m->collect_type;
		$m2->collect_id=$collect_id;
		$m2->save();
		$m->totals++;
		$m->save();
		$this->msg(array('state'=>1,'type'=>'json','msgwords'=>'目标站ID:'.$collect_id.' ,采集成功  ok '));
		
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
	
	public function actionTest(){
		$pat='~<div[^>]*class=\"pb10\sinto\">([\w\W]*?)<div[^>]*class=\"share\">~';
		$content=helper::get_contents('http://m.nrsfh.com/xinli/20141015/arc-231902.htm');
		if(preg_match($pat,$content,$result)) print_r($result);
	}
	
	

}
?>