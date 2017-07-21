<?php
/**
 * Created by PhpStorm.
 * Author: Ren    wechat: yyloon
 * Date: 2017/7/11 0011
 * Time: 上午 11:21
 */
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('agent', WEB_PATH.'/admin/login.php');
$consultantA = new ConsultantAction();
$consultantA->delete();