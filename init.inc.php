<?php
header("content-type:text/html;charset=utf-8");
//网站目录
define('ROOT_PATH', dirname(__FILE__));
//引入配置信息
require ROOT_PATH.'/config/profile.inc.php';
//设置中国时区
date_default_timezone_set('Asia/Shanghai');

//自动加载类
function __autoLoad($classname){
    if (substr($classname, -6) == 'Action') {
        require ROOT_PATH.'/action/'.$classname.'.class.php';
    } elseif (substr($classname, -5) == 'Model') {
        require ROOT_PATH.'/model/'.$classname.'.class.php';
    } else {
        require ROOT_PATH.'/includes/'.$classname.'.class.php';
    }
}
require ROOT_PATH.'/includes/function.php';