<?php
class TbkCollectController extends HomeController{
	private $detail_url='http://detail.tmall.com/item.htm?id={id}';
	private $detail_html='';
	private $comment_url='http://rate.tmall.com/list_detail_rate.htm?itemId={id}';
	public function actionIndex(){
		
	}
	public function actionTest(){
		$title='新款雪花牛仔裤女韩版排扣弹力修身小脚裤显瘦哈伦裤女式长裤子潮';
		$a=helper::get_tags_baidu($title);
		print_r($a);
		echo intval($this->mystrtotime('","date":"2014年08月27日 20:31","'));
				
	}
	public function actionSave(){
		$product_cate_id=intval($this->get('product_cate_id'));
		if($product_cate_id==0){
			$this->msg(array('state'=>0,'msgwords'=>'分类出错噢','type'=>'getjson'));
		}
		$json=$this->get('json');
		$getarr=json_decode($json,1);
		if(!is_array($getarr)){
			$this->msg(array('state'=>0,'msgwords'=>'数据格式不正确','type'=>'getjson'));
		}
		//需要的参数  ,这里的 cover 尺寸太小，90*90 ，用不了啊，要去详细页抓取
		$need_set=array('goods_id','goods_title','cover','zhekou','price','yongjin','yongjin_bl');
		foreach($need_set as $r){
			if(!isset($getarr[$r])){
				$this->msg(array('state'=>0,'msgwords'=>'参数不正确，缺少'.$r,'type'=>'getjson'));
			}
		}
		$this->detail_url=str_replace('{id}',$getarr['goods_id'],$this->detail_url);		
		//事物回滚
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$m=Dtable::model('goods')->findByAttributes(array('num_iid'=>$getarr['goods_id']));
			if($m){
				$this->msg(array('state'=>0,'msgwords'=>'已存在','type'=>'getjson'));
			}
			$this->detail_html=iconv('gbk','utf-8',helper::get_contents($this->detail_url));//$this->msg(array('state'=>0,'msgwords'=>'断点002','type'=>'getjson'));
			//$this->msg(array('state'=>1,'msgwords'=>'test..','type'=>'getjson'));
			if($this->detail_html==''){
				$this->msg(array('state'=>0,'msgwords'=>'后台请求出错','type'=>'getjson'));
			}
			$m=new Dtable('goods');			
			$m->info_order=50;
			$m->audit=1;
			$m->create_time=time();
			$m->product_cate_id=$product_cate_id;
			$m->info_title=strip_tags($getarr['goods_title']);
			$m->last_cate_id=5;
			$m->info_tags=$this->get_tags($m->info_title);
			$m->now_price=sprintf('%.2f',$getarr['price']);
			$m->yongjin=sprintf('%.2f',$getarr['yongjin']);
			$m->yongjin_bl=sprintf('%.2f',$getarr['yongjin_bl']);
			$m->discount=sprintf('%.1f',$getarr['zhekou']);
			$m->num_iid=intval($getarr['goods_id']);	
			if(preg_match('~"defaultItemPrice":"(\d+\.\d{2})"~',$this->detail_html,$result)){
				$m->market_price=sprintf('%.2f',$result[1]);
			}else{
				if(preg_match('~price:(\d+\.\d+),~',$this->detail_html,$result)){
					$m->market_price=sprintf('%.2f',$result[1]);
				}
			}	
			
			
			//取淘宝集市上的某些数据需要userid  （评论和 销量）
			$userid='';
			if(preg_match('~userid=(\d+);~',$this->detail_html,$result)){
				$userid=$result[1];
			}
			
			//销量
			if(preg_match('~&totalSQ=(\d+)~',$this->detail_html,$result)){
				$m->sales=intval($result[1]);
			}else{
				$m->sales=intval($this->GetTbSales($getarr['goods_id'],$userid));
				
			}
			
			
			$m->save();
			
			
			//采集图片和保存封面
			$m2=Dtable::model('goods')->findByPk($m->primaryKey);
			$m2->info_img=$this->save_tbk_img($m->primaryKey);
			$m2->save();
			
			//采集评论
			
			$this->SaveComment($m->primaryKey,$getarr['goods_id'],$userid);
			
			
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			$this->msg(array('state'=>0,'msgwords'=>'采集失败，数据出错'.$e->getMessage(),'type'=>'getjson'));
		}
		
		//$this->msg(array('state'=>1,'msgwords'=>$json,'type'=>'getjson'));
		
		$this->msg(array('state'=>1,'msgwords'=>'ok','type'=>'getjson'));
	}
	
	//保存 宝贝的图片集
	private function save_tbk_img($info_id){
		try{
			if($this->detail_html==''){
				return false;
			}
			$pat='~<ul\sid="J_UlThumb"[^>]*>([\w\W]*?)<\/ul>~';
			if(!preg_match($pat,$this->detail_html,$result)){
				return false;
			}
			if(!preg_match_all('~<img[^>]*src="(.*?)"[^>]*\/>~i',$result[1],$result2)){
				return false;
			}
			$imgarr=array();
			foreach($result2[1] as $r){
				$r=str_replace('60x60','430x430',$r);
				$r=str_replace('50x50','400x400',$r);
				$imgarr[]=$r;
			}//$this->msg(array('state'=>0,'msgwords'=>$r,'type'=>'getjson'));
			$cover='';
			$i=0;foreach($imgarr as $r){$i++;
				$imgfile=helper::save_img($r,'goods-'.$info_id);
				if($i==1) $cover=$imgfile;
			}
			return $cover;
		} catch (Exception $e) {  
		   $this->msg(array('state'=>0,'msgwords'=>'采集失败，数据出错'.$e->getMessage(),'type'=>'getjson'));
		   //throw new Exception($e->getMessage());  
	    }  
		
			
	}
	//天猫的
	private  function SaveComment($info_id,$goods_id,$userid=''){
		//$info_id=$this->get('info_id');
		//$goods_id=$this->get('goods_id');
		
		$url=str_replace('{id}',$goods_id,$this->comment_url);
		$a=trim(helper::get_contents($url));
		$a=iconv('gbk','utf-8',$a);  //缺少这个竟然折腾了我1个多小时
		$json='{'.$a.'}';
		$datalist=json_decode($json,1);
		//print_r($datalist);die();
		if(isset($datalist['rateDetail']['rateList']) && count($datalist['rateDetail']['rateList'])){
			$comment_list=$datalist['rateDetail']['rateList'];
			foreach($comment_list as $r){
				$m=new Dtable('comment_list');
				$m->pid=0;
				$m->fromid='goods-'.$info_id;
				$m->comment=$r['rateContent'];
				$m->create_date=strtotime($r['rateDate']);
				$m->uname=$r['displayUserNick'];
				$m->attr=$r['auctionSku'];	
				$m->ischeck=1;		
				$m->save();
			}
		}else{
			//如果没有采集到评论则去淘宝集市那里采集	
			if($userid){
				$this->saveComment_tb($info_id,$goods_id,$userid);				
			}
		}	
	
	}
	//淘宝集市
	private function saveComment_tb($info_id,$goods_id,$userid){		
		$url='http://rate.taobao.com/feedRateList.htm?userNumId='.$userid.'&auctionNumId='.$goods_id.'&currentPageNum=1';
		$a=trim(helper::get_contents($url));
		//$this->msg(array('state'=>0,'msgwords'=>'<input type=text value="'.$url.'"','type'=>'getjson'));
		$a=iconv('gbk','utf-8',$a);  //缺少这个竟然折腾了我1个多小时
		$json=preg_replace('~^\(|\)$~','',$a);
		$datalist=json_decode($json,1);
		if(!isset($datalist['comments'])|| !$datalist['comments']){
			return;
		}
		$comment_list=$datalist['comments'];
		
		foreach($comment_list as $r){
			$m=new Dtable('comment_list');
			$m->pid=0;
			$m->fromid='goods-'.$info_id;
			$m->comment=$r['content'];
			$m->create_date=intval($this->mystrtotime($r['date']));
			$m->uname=$r['user']['nick'];
			$m->attr=$r['auction']['sku'];
			$m->ischeck=1;
			$m->save();
		}
		
	}
	//采集销量 ,淘宝集市 的 要 单独发送请求去取
	private function  GetTbSales($goods_id,$userid){
		/*get测试
		$goods_id=$this->get('goods_id');
		$userid=$this->get('userid');
		$this->detail_html=helper::get_contents('http://item.taobao.com/item.htm?spm=a1z10.3.w4023-8179954192.3.KIGzKm&id=39603532935');
		*/
		if(!preg_match('~&sbn=(.*?)&isTKA=~',$this->detail_html,$result)){echo 'error';
			return;
		}
		$sbn=$result[1];
		$url='http://detailskip.taobao.com/json/ifq.htm?id='.$goods_id.'&sid='.$userid.'&sbn='.$sbn.'&q=1';
		$a=helper::get_contents($url);
		if(!preg_match('~quanity:\s*(\d+)~',$a,$result)){
			return;
		}
		return $result[1];
				
	}
	//2014年08月27日 20:31 转化成时间戳
	private function mystrtotime($str){//$this->msg(array('state'=>0,'msgwords'=>'test'.$str,'type'=>'getjson'));
		if(!preg_match('~(\d{4,}).*?(\d{2}).*?(\d{2}).*?(\d{2}):(\d{2})~',$str,$v)){
			return 0;
		}
		$datestr=$v[1].'-'.$v[2].'-'.$v[3].' '.$v[4].':'.$v[5].':00';
				
		return strtotime($datestr);
		
	}
	
	private function get_tags($title){
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
	
	
	
	
	
}