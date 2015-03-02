<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends CUserIdentity
{
    private $_id;
    public $user;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
        $user = AdminUser::model()->findByAttributes(array('csname' => $this->username));
        if ($user === null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else{
        	$ugroup=AdminGroup::model()->findByAttributes(array('groupid'=>$user->groupid));
        	$u_private_role=AdminUser::get_user_role($user->csno); //查询私有的角色
        	$uroledata=AdminGroupRole::get_group_role($user->groupid); //查询该组的角色   
        	
        	$uroles=AdminGroupRole::role_arr($uroledata); //把角色查询结果转换成 权限数组，方便用 in_array 比较权限
        	$private_uroles=AdminGroupRole::role_arr($u_private_role);
        	foreach($private_uroles as $r){
        		$uroles[]=$r;
        	}
            $this->_id = $user->csno;
            $this->username = $user->csname;
            $this->errorCode = self::ERROR_NONE;
       		if(!$ugroup && $user->csno!=Yii::app()->params['management']['super_admin_id']){
       			die('分组出现错误');
       		}
       		
       		if(!$ugroup && $user->csno==Yii::app()->params['management']['super_admin_id']){
       			$groupname='-';
       		}else{
       			$groupname=$ugroup->groupname;
       		}
       		
            //以下值可用 Yii:app()->user->属性 获取
       		$this->setState('isGuest',0);
            $this->setState('uid',$user->csno);
            $this->setState('uname',$user->csname);
            $this->setState('groupid',$user->groupid);
            $this->setState('mylevel',$uroles);
            $this->setState('groupname',$groupname);
            $this->setState('cate_id',0);
          //  $this->setState('ustate',$user->ustate);
          //  $this->setState('cate_id',$user->cate_id);
           // $this->setState('role',$user->role);
        }
		return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }
    public function getUser()
    {
    	return $this->user;
    }
    
}