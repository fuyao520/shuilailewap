<?php
//伪静态URL类
class url{
	//内容中心伪静态规则
	//URL伪静态定义
	public static $url_config=array(
		//内容页---（这个是默认的，每个栏目也可单独设置）
		'info_detail'=>array(
			'url'=>'info.php?m=detail&info_id={info_id}&cate_id={cate_id}&p={p}',
			'rule'=>'{host}/Detail-{cate_id}-{info_id}.html',
			'page_rule'=>'{host}/Detail/{cname_py}/{info_id}/{p}.html',
		),
		//列表页---（这个是默认的，每个栏目也可单独设置）
		'info_list'=>array(
			'url'=>'info.php?m=list&cate_id={cate_id}&p={p}',
			'rule'=>'{host}/list-{cate_id}-{p}.html',
			'page_rule'=>'{host}/list-{cate_id}-{p}.html',
		),
		//投票详情页
		'vote_detail'=>array(
			'url'=>'vote_detail.php?subject_id={subject_id}',
			'rule'=>'{host}/vote-detail/{subject_id}.html',
		),
		//投票结果展示页
		'vote_detail_result'=>array(
			'url'=>'vote_detail.php?m=show_vote_result&subject_id={subject_id}',
			'rule'=>'{host}/vote-detail-result/{subject_id}.html',
		),
		
	);
	public static $rewrite=1;
    /*
	//URL转换  
	@params string $url_tag 为静态节点标识
	@params array $params  需要替换的参数
	@params string $type  要取出的是哪个规则,默认 rule ， 使用“url”也可以取出 url原型  	
	*/
    public static function encode($url_tag,$params=array(),$type='rule'){
    	global $config,$dbm;
        //判断规则定义中是否有这个URL的定义
		$sql="select * from rewrite where rewrite_ident='$url_tag'";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])){
			$b=$a['list'][0];
			self::$url_config[$url_tag]['rule']=$b['rewrite_rule'];
			self::$url_config[$url_tag]['page_rule']=$b['rewrite_page_rule'];
			self::$url_config[$url_tag]['url']=$b['true_url'];
		}
		//print_r(self::$url_config[$url_tag]);		
		if(!isset(self::$url_config[$url_tag])) return 'URL规则定义不存在';	
		$url=self::$url_config[$url_tag];	
		
        //遍历传递进来的参数进行替换
		if(!isset($params['host'])) $params['host']=Yii::app()->params['basic']['siteurl'];
		$params['host']=preg_replace('~/$~','',$params['host']);
        foreach($params as $key=>$val){
            $url['url']=preg_replace('~({'.$key.'})~',$val,$url['url']);
            $url[$type]=preg_replace('~({'.$key.'})~',$val,$url[$type]);   
        }
       
        //返回替换好的URL
        if(self::$rewrite==0) return $url['url'];
        if(self::$rewrite==1) return $url[$type];
        
        return 'URL转换失败';
    }
	
	
	
	
	
}

?>