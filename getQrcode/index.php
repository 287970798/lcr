<?php
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
header('location:getQrcode.php?id='.$_SESSION['apply_id']);
exit;
$wx = new WXLogin('http://uniteedu.cn/lcyx/lcr/getSub');
$apply = new ApplyAction();
if (isset($_SESSION['wx'])){
    if (isset($_POST['send'])){
        $apply->checkPhone('./getQrcode.php');
    } else {
        $apply->checkOpenid('./getQrcode.php');
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查询二维码</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../style/admin.css">
    <script type="text/javascript" src="../js/common.js"></script>
    <script type="text/javascript" src="../js/getQrcode.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">二维码查询</a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tel:053188822881"><span class="glyphicon glyphicon-phone-alt"></span> 电话咨询</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
    <form id="qrcodeForm" role="form" method="post" action="?">
        <div class="form-group">
            <label for="phone">手机号</label>
            <input type="text" class="form-control input-lg" name="phone" id="phone" placeholder="请输入手机号" value="<?php echo @$_COOKIE['phone']?>">
        </div>
        <div class="form-group">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">查询二维码</button>
        </div>
        <div class="form-group">
            <span>友情提示：</span>
            <span class="help-block">如果您已申请联创人，并通过审核，可通过手机号查询二维码。有疑问请点击拨打 <a href="tel:15966326431" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-headphones"></span> 客服电话</a></span>
        </div>
    </form>
</div>
<?php include_once ROOT_PATH."/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>