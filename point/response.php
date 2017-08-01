<?php
/**
 * Created by PhpStorm.
 * Author: Ren    wechat: yyloon
 * Date: 2017/8/1 0001
 * Time: 上午 10:10
 */
session_start();
require substr(dirname(__FILE__), 0, -6) . '/init.inc.php';
//echo '<pre>';
//print_r($_FILES);
//print_r($_POST);

$upload = new Upload();
$des = $upload->uploads();
echo json_encode($des[0]);