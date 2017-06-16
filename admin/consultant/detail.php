<?php
session_start();
require substr(dirname(__FILE__), 0, -17).'/init.inc.php';
$consultantA = new ConsultantAction();
if (isset($_POST['submit'])){
    $consultantA->update();
}
$consultant = $consultantA->getOne();

?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>服务中心</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <link rel="stylesheet" href="../style/admin.css">

</head>
<body>

<?php include_once "../header.php"?>
<div class="weui-cells__title" style="margin-top: 70px;">新增优学顾问</div>
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $consultant->id;?>">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="name" type="text" value="<?php echo $consultant->name;?>" placeholder="请输入姓名"/>
            </div>
        </div>
        <div class="weui-cell weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone" type="tel" value="<?php echo $consultant->phone;?>" placeholder="请输入手机号">
            </div>
        </div>
        <div class="weui-cell weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">微信号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="wechat" type="wechat" value="<?php echo $consultant->wechat;?>" placeholder="请输入微信号">
            </div>
        </div>

        <div class="weui-btn-area">
            <button class="weui-btn weui-btn_primary" type="submit" name="submit" href="javascript:" id="showTooltips">确定</button>
        </div>
    </div>
</form>

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>