<?php
class UserPay extends CActiveRecord{
	public function tableName() {
		return '{{user_pay}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	/* 支付成功的时候的处理，处理订单
	 *  @params string $out_trade_no 本站订单号
	 *  @return array('result'=>number,'money'=>float,'trade_status'=>string) 
	 */
	public function pay_return($out_trade_no){
		//AdminAclog::model()->logs('pay....1');
		$ret=array('result'=>0,'money'=>0,'trade_status'=>'');
		if(!$out_trade_no){
			$ret['result']=0;
			return $ret; 
		}AdminAclog::model()->logs('pay....2');
		$m_p=UserPay::model()->findByAttributes(array('trade_no'=>$out_trade_no)); //根据本站订单号，查找支付记录 
		if(!$m_p){//AdminAclog::model()->logs('pay....3');
			$ret['result']=0;
			return $ret; 
		}else{//AdminAclog::model()->logs('pay....4');
			if($m_p->pay_state==0){  //如果未付款的状态则保存付款成功的状态
				$pay_time_complete=time();
				$m_p->pay_state=1;
				$m_p->pay_time_complete=$pay_time_complete;
				$m_p->pay_trade_no=$out_trade_no;
				$m_p->save();
			}
			if($m_p->order_id){//echo 'hello';   //如果 带上了订单ID
				$m_o=UserOrder::model()->findByAttributes(array('user_order_id'=>$m_p->order_id));  //查找对应的订单
				if($m_o){  //如果找到了，修改订单的状态
					$m_o->order_state=1;
					$m_o->pay_type=1;
					$m_o->save();
				}
			}
			$ret['money']=$m_p->money;
			$ret['trade_status'] ='' ;//交易状态
			$ret['result']=1;
			$ret['order_id']=$m_p->order_id;
		}
		$ret['result']=1;
		//Goods::model()->update_goods_sales();
		return $ret;
	}

}
