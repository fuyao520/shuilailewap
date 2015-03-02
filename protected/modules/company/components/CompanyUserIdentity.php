<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CompanyUserIdentity extends CUserIdentity
{
    private $_id;
    private $company_user;
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
		);
        $user = CompanyUser::model()->findByAttributes(array('uname' => $this->username));
        
        if ($user === null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }else{
        	
        	$company=Company::model()->findByAttributes(array('company_id'=>$user->uid));        	
        	$this->errorCode=self::ERROR_NONE;
            //以下值可用 Yii:app()->company_user->属性 获取
        	
        	$this->setState('isGuest',0);
        	$this->setState('company_id',$user->company_id);
        	$this->setState('company_name',$company->company_name);
            $this->setState('uid',$user->uid);
            $this->setState('uname',$user->uname);
        }
		return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }
    public function getUser()
    {
    	return $this->company_user;
    }
    
}