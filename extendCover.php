<?php
session_start();
require dirname(__FILE__) . '/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$apply_id = $_SESSION['apply_id'];
$_GET['id'] = $apply_id;
$apply = new ApplyAction();
$object = $apply->show();
if (empty($object)) Tool::alertBack('警告：不存在此联创人！');

//获取学员、联创人、积分等总数
$indexA = new IndexAction();
$countO = $indexA->getCount();

$nav = 'index';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>联创人服务</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style/admin.css">
    <link rel="stylesheet" href="../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>
<div class="hidden" style="height: 50px;line-height: 50px;border-bottom: 1px solid #CCC;text-align: center;position: relative;background-color: #EFEFF4">
    个人中心
    <a href="javascript:;" onclick="weui.alert('联创优学');" style="position:absolute;right: 15px;font-size: 12px;">反馈</a>
</div>

<div class="container-fluid" style="margin-bottom: 15px;">
        <img src="<?php echo $object->wx_headimgurl;?>" alt="" class="img-circle center-block" style="width: 100px; height: 100px; margin-top: 20px;">
        <div class="text-center"><?php echo $object->wx_nickname;?></div>
</div>

<div class="weui-grids hidden">
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="font-size: 25px">
            <i class="fa fa-file-pdf-o"></i>
        </div>
        <p class="weui-grid__label">
            总积分 1680
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="<?php echo WEB_PATH;?>/images/weui/icon_nav_toast.png" alt="">
        </div>
        <p class="weui-grid__label">
            可用积分 1100
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon">
            <img src="<?php echo WEB_PATH;?>/images/weui/icon_nav_feedback.png" alt="">
        </div>
        <p class="weui-grid__label">
            禁用积分 251
        </p>
    </a>
</div>

<div class="weui-cells__title">学员管理</div>
<div class="weui-cells">

    <a class="weui-cell weui-cell_access" href="./student/?id=<?php echo $apply_id?>">
        <div class="weui-cell__hd"><i class="fa fa-user" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>全部学员</p>
        </div>
        <div class="weui-cell__ft"><span class="weui-cell__ft__text">共有 <?php echo $countO->student;?> 个学员</div>
    </a>
    <a class="weui-cell weui-cell_access" href="./student/add.php?id=<?php echo $apply_id?>">
        <div class="weui-cell__hd"><i class="fa fa-user-plus" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>新增学员</p>
        </div>
        <div class="weui-cell__ft">录入学员</div>
    </a>
</div>

<div class="weui-cells__title">推荐联创人</div>
<div class="weui-cells">

    <a class="weui-cell weui-cell_access" href="getSub/">
        <div class="weui-cell__hd"><i class="fa fa-group" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>全部联创人</p>
        </div>
        <div class="weui-cell__ft">您共推荐 <?php echo $countO->apply;?> 个联创人</div>
    </a>
<!--    <a class="weui-cell weui-cell_access" href="javascript:;">-->
<!--        <div class="weui-cell__hd"><i class="fa fa-user-secret" style="width:20px;margin-right:5px;display:block"></i></div>-->
<!--        <div class="weui-cell__bd">-->
<!--            <p>新增联创人</p>-->
<!--        </div>-->
<!--        <div class="weui-cell__ft">录入您要推荐的联创人</div>-->
<!--    </a>-->
</div>

<div class="weui-cells__title">积分</div>
<div class="weui-cells">

    <a class="weui-cell weui-cell_access" href="./point/">
        <div class="weui-cell__hd"><i class="fa fa-hourglass-2" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>查看积分明细</p>
        </div>
        <div class="weui-cell__ft">共有 <?php echo @$countO->point;?> 个积分</div>
    </a>
    <a class="weui-cell weui-cell_access" href="./project">
        <div class="weui-cell__hd"><i class="fa fa-object-group" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>项目积分</p>
        </div>
        <div class="weui-cell__ft">每个项目可得积分查看</div>
    </a>
</div>

<div class="weui-cells__title">分享</div>
<div class="weui-cells">

    <a class="weui-cell weui-cell_access" href="./getQrcode">
        <div class="weui-cell__hd"><i class="fa fa-qrcode" style="width:20px;margin-right:5px;display:block"></i></div>
        <div class="weui-cell__bd">
            <p>我的推广二维码</p>
        </div>
        <div class="weui-cell__ft">生成推广二维码</div>
    </a>
</div>

<?php include 'tabbar.php'?>

</body>
</html>