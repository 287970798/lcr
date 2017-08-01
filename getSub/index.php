<?php
session_start();
require substr(dirname(__FILE__), 0, -7).'/init.inc.php';
$_SESSION['apply_id'] = 300;
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$_GET['id'] = $_SESSION['apply_id'];
$apply = new ApplyAction();

//权限：是否为优学顾问，如果不是则跳转，是则显示列表///////
$one = $apply->getOne(null,$_SESSION['apply_id']);
if(!$one) Tool::alertLocation(null,'warning.php');
$consultant = new ConsultantAction();
$oneConsultant = $consultant->one('phone',$one->phone);
if(!$oneConsultant) Tool::alertLocation(null,'warning.php');
////////////////////////////////////////////////////

$objects = $apply->getSub();
$winCount = $apply->getWinSubCount()->winCount;

$newApply = 0;
$status0 = $status1 = $status2 = 0;

if(!empty($objects)){
    foreach ($objects as $object){
        if ($object->status == 0) $newApply ++;
        $object->apply_time = date('Y-m-d', strtotime($object->apply_time));
        switch ($object->status){
            case 0:
                $object->statusClass = 'dangerx';
                $object->status = '<span class="label label-warning">审核中</span>';
                $status0 ++;
                break;
            case 1:
                $object->statusClass = 'successx';
                $object->status = '<span class="label label-success">已通过</span>';
                $status1 ++;
                break;
            case 2:
                $object->statusClass = 'warningx';
                $object->status = '<span class="label label-danger">已拒绝</span>';
                $status2 ++;
        }
    }
}

$nav = 'getsub';
?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我推荐的联创人</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>

<div class="topbar">
    联创人
    <a href="../my.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="<?php echo WEB_PATH;?>/getQrcode" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right">推广二维码</a>
</div>

<div class="weui-grids">
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: #5eb9ff;">
            <i class="fa fa-address-book"></i>
        </div>
        <p class="weui-grid__label">
            通过 <?php echo $status1;?>
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: #09bb07;">
            <i class="fa fa-address-book-o"></i>
        </div>
        <p class="weui-grid__label">
            未审核 <?php echo $status0;?>
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: orange;">
            <i class="fa fa-check-square-o"></i>
        </div>
        <p class="weui-grid__label">
            赢单 <?php echo $winCount;?>
        </p>
    </a>
</div>

<div class="table-responsive container main">
    <table class="table table-hover table-striped lcr-list">
        <captionc class="hidden">
            <h3>
                <span class="label label-success"><span class="glyphicon glyphicon-th-list lcr-list-icon"></span> 推荐的联创人列表 <span class="badge lcr-list-badge"><?php echo $newApply;?></span></span>
            </h3>
        </captionc>
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机号</th>
            <th>时间</th>
            <th>状态</th>
            <th>顾问</th></tr>
        </thead>
        <tbody>
        <?php
        if (!empty($objects)){
            foreach ($objects as $object){
                ?>
                <tr class="<?php echo $object->statusClass;?>">
                    <td><?php echo $object->name;?></td>
                    <td><?php echo $object->phone; ?></td>
                    <td><?php echo date('y-m-d',strtotime($object->apply_time)); ?></td>
                    <td><?php echo $object->status; ?></td>
                    <td><?php echo $object->cName; ?></td>
                </tr>
                <?php
            }
        }else{
            echo '<tr><td colspan="5" class="text-center text-warning">无推荐联创人</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php include ROOT_PATH."/tabbar.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>