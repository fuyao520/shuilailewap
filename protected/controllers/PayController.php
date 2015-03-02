<?php
class PayController extends HomeController{
	public $uid=0;
	public function init(){
		parent::init();
		$this->uid=0;
		if(Yii::app()->user->isGuest==0){
			$this->uid=Yii::app()->user->uid;
		}
		
		//与支付无关的GET参数过滤掉  ，这点很重要
		unset($_GET['p']);
		
	}
	//根据订单付款
	public function actionSubmit(){
		//事物回滚
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$pay_type=$this->post('pay_type');
			$order_id=$this->post('order_id');
			$ip=helper::getip();
			$uid=$this->uid;
			$sessionid=Yii::app()->session->sessionID;
			$user_order_row=UserOrder::model()->findByAttributes(array('order_state'=>0,'user_order_id'=>$order_id));
			//echo "select * from user_order where order_state=1 and user_order_id=".$field['order_id'];
			if(!$user_order_row){
				$this->msg(array('state'=>-2,'msgwords'=>'商品订单出错'));
			}
			$m=new UserPay();
			$order_info=Dtable::toArr($user_order_row);
			$m->money=$money=$order_info['order_money_count'];
			$m->sessionid=0;
			$m->pay_type=$pay_type;
			$m->order_id=$order_id;
			$m->ip=$ip;
			$m->uid=$uid;
			if($this->uid>0){
				$m->sessionid=$sessionid;
			}
			$m->pay_time=time();
			$m->trade_no=date("YmdHis").substr(microtime(),2,4);
			if(!preg_match('~^\d+(\.\d{1,2})?$~',$money)){
				$this->msg(array('state'=>-2,'msgwords'=>'充值出错'));
			}
			if(!$order_id){
				die('订单空的出错！');
			}
			$result=$m->save();
			if($result===false) die('错误002');
			$transaction->commit();//提交事务
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			echo $e->getMessage();
			die('{"code":"0","statewords":"订单创建失败，数据出错"}');
		}
		
		$goods_desc='';
		$goods_list=OrderGoods::model()->get_order_goods($order_id);
		foreach($goods_list as $r){
			$goods_desc .=$r['goods_number'].'份'.$r['goods_name'].';';
		}
		
		$order_info['goods_desc']=$goods_desc;
		$order_info['trade_no']=$m->trade_no;
		//支付宝
		if($pay_type==1){
			$this->alipay($order_info);
		}elseif($pay_type==3){//银联
			$this->unionpay($order_info);
		
		}else{
			$this->msg(array('state'=>-2,'msgwords'=>'充值类型不存在'));
		}
	}
	
	//充值
	public function actionPaySubmit(){
		//事物回滚
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$money=$this->post('pay_money');
			$pay_type=$this->post('pay_type');
			$ip=helper::getip();
			$uid=$this->uid;
			$sessionid=Yii::app()->session->sessionID;
			if($money<=0 || !preg_match('~^\d+\.\d{2}~')){
				$this->msg(array('state'=>-2,'msgwords'=>'充值金额错误'));
			}
			$m=new UserPay();
			$m->money=$money;
			$m->pay_type=$pay_type;
			$m->order_id=$order_id;
			$m->ip=$ip;
			$m->uid=$uid;
			if($this->uid>0){
				$m->sessionid=$sessionid;
			}
			$m->pay_time=time();
			$m->trade_no=date("YmdHis").substr(microtime(),2,4);
			if(!preg_match('~^\d+(\.\d{1,2})?$~',$money)){
				$this->msg(array('state'=>-2,'msgwords'=>'充值出错'));
			}
			$result=$m->save();
			if($result===false) die('错误002');
			$transaction->commit();//提交事务
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			echo $e->getMessage();
			die('{"code":"0","statewords":"订单创建失败，数据出错"}');
		}
		
		$goods_desc='水来了-水币充值';
		$order_info['goods_desc']=$goods_desc;
		$order_info['trade_no']=$m->trade_no;
		$order_info['consignee']='';
		$order_info['mobile']='';
		//支付宝
		if($pay_type==1){
			$this->alipay($order_info);
		}elseif($pay_type==3){//银联
			$this->unionpay($order_info);
	
		}else{
			$this->msg(array('state'=>-2,'msgwords'=>'充值类型不存在'));
		}
	}
	
	//支付宝支付通知
	public function actionAlipayNotify(){
		AdminAclog::model()->logs('开始处理订单');
		helper::logs('alipay','coming..');
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipaySubmit.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayHelper.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayNotify.php");
		$page['pay']=array();
		//计算得出通知验证结果
		if(!isset($_GET["sign"])) $_GET["sign"]='';
		$alipay_config=Yii::app()->params['alipay'];
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		AdminAclog::model()->logs('verify_result:'.$verify_result);
		helper::logs('alipay','verify_result:'.$verify_result);
		if($verify_result) {//验证成功
			//事物回滚
			$transaction = Yii::app()->db->beginTransaction();
			try {
				AdminAclog::model()->logs('付款成功开始处理');
				helper::logs('alipay','付款成功开始处理');
				//echo '到这里是交易成功aaaaaa';
				$is_danbao=0; //是否是担保交易，如果是的话，则视为无效
				//本站订单号
				$out_trade_no =$this->get('out_trade_no');
				//支付宝交易号
				$trade_no = $this->get('trade_no');
				$trade_status=$this->get('trade_status');
				//AdminAclog::model()->logs('判断类型..');
				//担保交易自动发货
				if($trade_status=='WAIT_SELLER_SEND_GOODS'){
					AdminAclog::model()->logs('担保交易');
					helper::logs('alipay','担保交易');
					//构造要请求的参数数组，无需改动
					$parameter = array(
							"service" => "send_goods_confirm_by_platform",
							"partner" => trim($alipay_config['partner']),
							"trade_no"	=> $trade_no,
							"logistics_name"	=> "韵达",
							"invoice_no"	=> "000000000",
							"transport_type"	=> "EXPRESS",
							"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
					);
					//建立请求
					$alipaySubmit = new AlipaySubmit($alipay_config);
					$html_text = $alipaySubmit->buildRequestHttp($parameter);
					
					
					$is_danbao=1;
					$m_p=UserPay::model()->findByAttributes(array('trade_no'=>$out_trade_no)); //根据订单号查找对应付款记录
					if(!$m_p){
						helper::logs('alipay','支付订单不存在');
						AdminAclog::model()->logs('支付订单不存在');
						$this->msg(array('state'=>-2,'msgwords'=>'支付订单不存在'));
					}
					$m_p->pay_state=2;
					$m_p->save();
					$m_o=UserOrder::model()->findByAttributes(array('user_order_id'=>$m_p->order_id)); //根据 付款记录里的本站订单ID  查找 订单 
					if(!$m_o){
						helper::logs('alipay','订单不存在');
						AdminAclog::model()->logs('订单不存在');
						$this->msg(array('state'=>-2,'msgwords'=>'订单不存在'));
					}
					/************担保交易调整 2013-10-24 **********/
					//担保交易的话，交易状态改成 担保交易
					$m_o->order_state=3;
					$m_o->pay_trade_no=$trade_no;
					$m_o->pay_type=10;
					$m_o->save();
						
					$page['pay']['result']=2;
					$page['pay']['trade_status']=$trade_status ;//交易状态
				}
				AdminAclog::model()->logs('判断担保交易');
				//如果不是担保交易， 则判断为成功付款
				if($is_danbao==0){
					helper::logs('alipay','即时到帐开始处理');
					AdminAclog::model()->logs('即时到帐开始处理');
					$page['pay']=UserPay::model()->pay_return($out_trade_no);
					helper::logs('alipay','即时到帐处理完成');
					AdminAclog::model()->logs('即时到帐处理完成');
				}
				$transaction->commit();//提交事务
			} catch (Exception $e) {
				$transaction->rollback(); //如果操作失败, 数据回滚
				AdminAclog::model()->logs('订单数据处理失败'.$e->getMessage());
				helper::logs('alipay',$e->getMessage());
				$this->msg(array('state'=>-2,'msgwords'=>'订单数据处理失败，请联系客服'));
			}
				
				
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			$page['pay']['result']=0;
			//AdminAclog::model()->logs(json_encode($_GET));
		}
		helper::logs('alipay',json_encode($page['pay']));
		AdminAclog::model()->logs(json_encode($page['pay']));
		//$this->render('/mall/payback',array('page'=>$page));
	}
	//支付宝返回
	public function actionAlipayReturn(){
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipaySubmit.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayHelper.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayNotify.php");
		$page['pay']=array();
		//计算得出通知验证结果
		if(!isset($_GET["sign"])) $_GET["sign"]='';
		$alipay_config=Yii::app()->params['alipay'];
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			//echo '到这里是交易成功aaaaaa';
			$is_danbao=0; //是否是担保交易，如果是的话，则视为无效 	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//本站订单号
			$out_trade_no = $_GET['out_trade_no'];
			//支付宝交易号
			$trade_no = $_GET['trade_no'];
			$trade_status=$_GET['trade_status'];
			//担保交易自动发货
			if($trade_status=='WAIT_SELLER_SEND_GOODS'){
				
				$page['pay']['result']=2;
				$page['pay']['trade_status']=$trade_status ;//交易状态
			}
			//如果不是担保交易， 则判断为成功付款
			if($is_danbao==0){
				$page['pay']['result']=1;
				$page['pay']['trade_status']=$trade_status;
				$page['pay']['money']=$_GET['total_fee'] ;
			}
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			$page['pay']['result']=0;
		}
		$this->render('/mall/payback',array('page'=>$page));
		
	}
	public function actionPaybackTest(){
		$page=array();
		$page['pay']=array('result'=>1,'money'=>80.00,'order_id'=>100);
		$this->render('/mall/payback',array('page'=>$page));
		
	}
	//支付宝及时到账接口
	private function alipay($order_info){
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipaySubmit.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayHelper.php");
		$siteurl=Yii::app()->params['basic']['siteurl'];
		$sitename=Yii::app()->params['basic']['sitename'];
		$alipay_config=Yii::app()->params['alipay'];
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url =$siteurl."/pay/alipayNotify";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		//页面跳转同步通知页面路径
		$return_url = $siteurl."/pay/alipayReturn";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		//卖家支付宝帐户
		$seller_email =$alipay_config['seller_email'];
		//必填
		//商户订单号
		$out_trade_no =$order_info['trade_no'];
		//商户网站订单系统中唯一订单号，必填
		
		//订单名称
		$subject =$sitename.'商品购买-'.$order_info['consignee'].'('.$order_info['mobile'].')（'.$siteurl.'）';
		//必填
		
		//付款金额
		$price = $order_info['order_money_count'];
		//必填
		
		//商品展示地址
		$show_url=$siteurl;
		//防钓鱼时间戳
		$anti_phishing_key = "";
		//若要使用请调用类文件submit中的query_timestamp函数
		
		//客户端的IP地址
		$exter_invoke_ip = '';
		//非局域网的外网IP地址，如：221.0.0.1
		$body='水来了商品消费';
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
			"partner" => trim($alipay_config['partner']),
			"payment_type"	=> $payment_type,
			"notify_url"	=> $notify_url,
			"return_url"	=> $return_url,
			"seller_email"	=> $seller_email,
			"out_trade_no"	=> $out_trade_no,
			"subject"	=> $subject,
			"total_fee"	=> $price,
			"body"	=> $body,
			"show_url"	=> $show_url,
			"anti_phishing_key"	=> $anti_phishing_key,
			"exter_invoke_ip"	=> $exter_invoke_ip,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo '<div style="display:none;">'.$html_text.'</div>';
	}
	
	private function alipay_shuanggongneng($order_info){
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipaySubmit.php");
		require_once(dirname(__FILE__)."/../components/payment/alipay/AlipayHelper.php");
		$siteurl=Yii::app()->params['basic']['siteurl'];
		$sitename=Yii::app()->params['basic']['sitename'];
		$alipay_config=Yii::app()->params['alipay'];
		//支付类型
		$payment_type = "1";
		//必填，不能修改
		//服务器异步通知页面路径
		$notify_url =$siteurl."/pay/alipayNotify";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		
		//页面跳转同步通知页面路径
		$return_url = $siteurl."/pay/alipayReturn";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		//卖家支付宝帐户
		$seller_email =$alipay_config['seller_email'];
		//必填
		//商户订单号
		$out_trade_no =$order_info['trade_no'];
		//商户网站订单系统中唯一订单号，必填
		
		//订单名称
		$subject =$sitename.'商品购买-'.$order_info['consignee'].'('.$order_info['mobile'].')（'.$siteurl.'）';
		//必填
		
		//付款金额
		$price = $order_info['order_money_count'];
		//必填
		
		//商品数量
		$quantity = "1";
		//必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
		//物流费用
		$logistics_fee = "0.00";
		//必填，即运费
		//物流类型
		$logistics_type = "EXPRESS";
		//必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
		//物流支付方式
		$logistics_payment = "SELLER_PAY";
		//必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
		//订单描述
		$body =$order_info['goods_desc'];
		//商品展示地址
		$show_url=$siteurl;
		
		//需以http://开头的完整路径，如：http://www.xxx.com/myorder.html
		
		//收货人姓名
		$receive_name =$order_info['consignee'];
		//如：张三
		//收货人地址
		$receive_address =$order_info['address'];
		//收货人邮编
		$receive_zip ='-';
		//收货人电话号码
		$receive_phone =$order_info['tel'];
		//收货人手机号码
		$receive_mobile =$order_info['mobile'];
		
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "trade_create_by_buyer",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"price"	=> $price,
				"quantity"	=> $quantity,
				"logistics_fee"	=> $logistics_fee,
				"logistics_type"	=> $logistics_type,
				"logistics_payment"	=> $logistics_payment,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"receive_name"	=> $receive_name,
				"receive_address"	=> $receive_address,
				"receive_zip"	=> $receive_zip,
				"receive_phone"	=> $receive_phone,
				"receive_mobile"	=> $receive_mobile,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo '<div style="display:none;">'.$html_text.'</div>';
		
	}
	private function unionpay(){
		//技术帮助地址 https://online.unionpay.com/mer/pages/merser/helper.jsp?pid=2&cid=5#3
		
		//echo '<meta charset="utf-8"/>银联支付正在升级，请先使用支付宝!';
		//前台支付接口示例
		require_once(dirname(__FILE__).'/common/payment/unionpay/quickpay_service.php');
		//下面这行用于测试，以生成随机且唯一的订单号
		//mt_srand(quickpay_service::make_seed());
		
		$param['transType']             = quickpay_conf::CONSUME;  //交易类型，CONSUME or PRE_AUTH
		
		$param['orderAmount']           = $field['money']*100;        //交易金额
		$param['orderNumber']           = $field['trade_no']; //订单号，必须唯一
		$param['orderTime']             = date('YmdHis');   //交易时间, YYYYmmhhddHHMMSS
		$param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //交易币种，CURRENCY_CNY=>人民币
		
		$param['customerIp']            = $field['ip'];  //用户IP
		$param['frontEndUrl']           = $config['basic']['siteurl']."/unionpay_return.php";    //前台回调URL
		$param['backEndUrl']            = $config['basic']['siteurl']."/unionpay_return.php";    //后台回调URL
		
		/* 可填空字段*/
		
		$param['commodityUrl']          = "";  //商品URL
		$param['commodityName']         = $config['basic']['sitename'].'订餐购买';;   //商品名称
		$param['commodityUnitPrice']    = '';        //商品单价
		$param['commodityQuantity']     = '';            //商品数量
		
		/*可填空字段结束*/
		
		//其余可填空的参数可以不填写
		
		$pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
		$html = $pay_service->create_html();
		
		header("Content-Type: text/html; charset=" . quickpay_conf::$pay_params['charset']);
		echo $html; //自动post表单
	}
	
	
	
	
}