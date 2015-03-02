<?php
/**
 *  添加新的URL生成规则
 *  原理：添加一个新的标识符（1） 或 替换原有标识符（2）
 *  1)  适用于只需正向解析时，某一分类的商品URL中需要展示分类的汉语拼音时，
 *      根据分类id添加新的参数（pinyin，动态写入createUrl()中的参数$params中），
 *      然后再rules中定义次参数的位置即可
 *  2） 如果需要反向解析，需要在parseUrl()函数中添加新的反向解析方法
 * 
 *  
 */
class CategoryUrlRule extends CUrlRule{
    public static $extParamName = 'iii';
    public static $catExtFront = 'category-';
    //新添加的url对应关系
    public static $_catUrls = array();
 
    //获取新添加的URL对应关系
    public static function getFcByPinyin($show_pinyin){
        $category = Category::model()->findByAttributes(array('show_pinyin'=>$show_pinyin));
        if($category){
            $f = $category->id;
            $c = $category->property_id;
        }
        return array('f'=>$f,'c'=>$c);
    }
    //获取新添加的URL对应关系
    public static function getCatUrls(){
        if(empty(self::$_catUrls)){
            $c = Category::model()->findAll();
            $u = CHtml::listData($c, 'id', 'show_pinyin');
            self::$_catUrls = $u;
        }
        return self::$_catUrls;
    }
    /**
     *  return 新添加的rules规则
     */
    public static function getExtRules(){
        return array(
           self::$catExtFront.'<'.self::$extParamName.':\w+>*' => 'category/index',
        );
    }
    /**
     *  验证是否用心添加的rule规则，因为新的规则要兼容之前的规则
     *  $params 这个参数可能会增加新的元素
     */
    public static function addParams($manager, $route, &$params, $ampersand){
        foreach ($params as $pk => $pv){
            if(!trim($pv)){
                unset($params[$pk]);
            }
        }
        $extRules = self::getExtRules();
        if(in_array($route, $extRules) && $params){
            $iid = isset($params['f']) ? $params['f'] : 0;
            if($iid){
                $ext = self::getCatUrls();
                if(in_array($iid, array_keys($ext)) && trim($ext[$iid])){
                    unset($params['f']);
                    unset($params['c']);
                    $ename = $ext[$iid];
                    $params[self::$extParamName] = $ename;
                }
            }
        }
    }
 
    public function __construct() {
        //注册新的rules
        $extRules = self::getExtRules();
        foreach ($extRules as $pattern => $route){
            parent::__construct($route, $pattern);
        }
    }
     
    public function createUrl($manager, $route, $params, $ampersand) {
        //验证是否用新添加的rule规则
        self::addParams($manager, $route, $params, $ampersand);
        return parent::createUrl($manager, $route, $params, $ampersand);
    }
     
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
//        return parent::parseUrl($manager, $request, $pathInfo, $rawPathInfo);
        if($this->verb!==null && !in_array($request->getRequestType(), $this->verb, true))
            return false;
 
        if($manager->caseSensitive && $this->caseSensitive===null || $this->caseSensitive)
            $case='';
        else
            $case='i';
 
        if($this->urlSuffix!==null)
            $pathInfo=$manager->removeUrlSuffix($rawPathInfo,$this->urlSuffix);
 
        // URL suffix required, but not found in the requested URL
        if($manager->useStrictParsing && $pathInfo===$rawPathInfo)
        {
            $urlSuffix=$this->urlSuffix===null ? $manager->urlSuffix : $this->urlSuffix;
            if($urlSuffix!='' && $urlSuffix!=='/')
                return false;
        }
 
        if($this->hasHostInfo)
            $pathInfo=strtolower($request->getHostInfo()).rtrim('/'.$pathInfo,'/');
 
        $pathInfo.='/';
 
        if(preg_match($this->pattern.$case,$pathInfo,$matches))
        {
            foreach($this->defaultParams as $name=>$value)
            {
                if(!isset($_GET[$name]))
                    $_REQUEST[$name]=$_GET[$name]=$value;
            }
            $tr=array();
            foreach($matches as $key=>$value)
            {
                if(isset($this->references[$key]))
                    $tr[$this->references[$key]]=$value;
                else if(isset($this->params[$key]))
                    $_REQUEST[$key]=$_GET[$key]=$value;
            }
                        /**
                         * 根据提交的分类，重置$_GET/$_REQUST
                         */
                        if(isset($_GET[self::$extParamName])){
                            $fc = self::getFcByPinyin($_GET[self::$extParamName]);
                            foreach(array('f','c') as $fckey){
                                $_REQUEST[$fckey]=$_GET[$fckey]=$fc[$fckey];
                                if(isset($this->references[$fckey]))
                                    $tr[$this->references[$fckey]]=$fc[$fckey];
                                else if(isset($this->params[$fckey]))
                                    $_REQUEST[$fckey]=$_GET[$fckey]=$fc[$fckey];
                            }
                        }
                        /**
                         * 完成重置$_GET/$_REQUST
                         */
            if($pathInfo!==$matches[0]) // there're additional GET params
                $manager->parsePathInfo(ltrim(substr($pathInfo,strlen($matches[0])),'/'));
            if($this->routePattern!==null)
                return strtr($this->route,$tr);
            else
                return $this->route;
        }
        else
            return false;
    }
}
?>