<?php
/**
 * Created by PhpStorm.
 * Author: Ren    wechat: yyloon
 * Date: 2017/7/25 0025
 * Time: 上午 11:04
 */
session_start();
require substr(dirname(__FILE__), 0, -7).'/init.inc.php';
//$_SESSION['apply_id'] = 3;
//if (isset($_SESSION['apply_id'])) {
//    unset($_SESSION['apply_id']);
//    session_destroy();
//}
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>联创人推广</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>
<div class="topbar">
    联创人推广
    <a href="http://uniteedu.cn/yxh" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
</div>

<div class="container">
    <h1 class="text-center"><i class="fa fa-lock"></i></h1>
    <h5 class="text-center">您没有推广权限，详情请咨询客服 <a href="tel:053188822881">点击拨打</a></h5>
</div>

<?php include ROOT_PATH."/tabbar.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
