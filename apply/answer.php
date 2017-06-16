<?php
require substr(dirname(__FILE__), 0, -6).'/init.inc.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>关注公众号</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">恭喜</a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tel:4000532050"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;&nbsp;&nbsp;电话咨询</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
    <img src="../images/apply2.jpg" alt="" class="img-responsive center-block" style="padding: 15px 0;">
    <div class="thumbnail">
        <h3 class="text-success text-center">请关注公众号</h3>
        <small class="text-success center-block text-center">长按二维码关注公众号，获取更多信息。</small>
        <img src="http://uniteedu.cn/lcyx/images/lcyx-wx-ewm.jpg" alt="">
        <div class="caption">
            <p class="text-center">我们已收到您的申请信息，工作人员将在24小时内审核，并通过公众号或电话通知您。有疑问请点击拨打 <a href="tel:053188822881" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-headphones"></span> 客服电话</a></p>
        </div>
    </div>

</div>
<?php include_once ROOT_PATH."/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>