<?php
/**
 * Created by PhpStorm.
 * User: Jed
 * Date: 14-3-31
 * Time: 10:50
 */

/**
 * 定义后台管理员用户，与普通用户区分开来
 * 这样可以让前台和管理员用户同时登陆
 * 在对应的模块的Module.php中配置
 * Class AdminWebUser
 */
class CompanyWebUser extends CWebUser
{
    public function __get($name)
    {
        if ($this->hasState('__companyInfo')) {
            $user=$this->getState('__companyInfo',array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }

        return parent::__get($name);
    }

    public function login($identity, $duration=0) {
        $this->setState('__companyInfo', $identity->getUser());
        parent::login($identity, $duration);
    }
}
?>