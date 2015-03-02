<div class="unav02 border-out fl">
        	   <div class="hd"><h2><a href="<?php echo $this->createUrl('site/index');?>">管理首页</a></h2>
               </div>
               <div class="border-in">
                   <ul class="news-list">
                        <li class="utopli">我的水来了</li>
                        <li><a href="<?php echo $this->createUrl('infoWater/index');?>">饮水管理</a>  
                                       
                        <li class="utopli">账号信息</li>
                        <li><a href="<?php echo $this->createUrl('companyProfile/index');?>">基本资料</a>
                        <li><a href="<?php echo $this->createUrl('site/editPassword');?>">修改密码</a></li>
                        <li><a href="<?php echo $this->createUrl('account/bindMobile');?>">绑定手机</a></li>
                        <li><a href="<?php echo $this->createUrl('points/index');?>">我的积分</a>  
                        <li><a href="<?php echo $this->createUrl('pmList/index');?>">消息通知<?php $a=PmList::model()->get_unread_total(Yii::app()->company_user->uid);echo $a?'<font color=red>('.$a.')</font>':''; ?></a>
                        </li>
                        <!--<li><a href="/">我的主页</a></li>-->
                        <li><a href="<?php echo $this->createUrl('site/logout');?>" class="noborder">[退出]</a></li>
                    </ul>
                </div>    
        </div>