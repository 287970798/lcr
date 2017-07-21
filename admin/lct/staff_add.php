<?php
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('agent', WEB_PATH.'/admin/login.php');
$consultantA = new ConsultantAction();
if (isset($_POST['submit'])){
    $consultantA->add('staff.php');
}

?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新增员工</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <link rel="stylesheet" href="../../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>

<div class="topbar">
    联创团管理中心
    <a href="<?php echo WEB_PATH?>/admin/lct" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="staff_add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="glyphicon glyphicon-plus""></i> 加员工</a>
</div>

<div class="weui-grids mygrid" style="background-color: #fff; margin-bottom: 10px; margin-top: 10px; letter-spacing: 1px;">
    <a href="<?php echo WEB_PATH;?>/admin/lct/staff.php" class="weui-grid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #6cc76f;">
            <i class="fa fa-user" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            员工管理
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/admin/lct/apply.php" class="weui-grid">
        <div class="weui-grid__icon"  style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #5eb9ff;">
            <i class="fa fa-graduation-cap" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            联创人管理
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/admin/lct/student.php" class="weui-grid cellgrid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #ed8d76;">
            <i class="fa fa-tasks" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            学员管理
        </p>
    </a>
</div>
<div class="weui-cells__title hidden" style="margin-top: auto;">新增员工</div>
<form action="" method="post">
    <input type="hidden" name="pid" value="<?php echo $_SESSION['agent']->id;?>">
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="name" type="text" placeholder="请输入姓名"/>
        </div>
    </div>
    <div class="weui-cell weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="phone" type="tel" placeholder="请输入手机号">
        </div>
    </div>
    <div class="weui-cell weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">微信号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" name="wechat" type="wechat" placeholder="请输入微信号">
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