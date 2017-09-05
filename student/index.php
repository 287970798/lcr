<?php
    session_start();
    require substr(dirname(__FILE__), 0, -8) . '/init.inc.php';
//$_SESSION['apply_id'] = 3;
    Validate::checkSession('apply_id', WEB_PATH.'/login.php');
    $studentsAction = new StudentAction();
    $students = $studentsAction->ownStudents();

    $status0 = $status1 = $status2 = 0;
    if (!empty($students)) {
        foreach ($students as $student) {
            switch ($student->status){
//                case 0:
//                    $status0 ++;
//                    break;
                case 1:
                    $status1 ++;
                    break;
                case 2:
                    $status2 ++;
                    break;
                default:
                    $status0 ++;
            }
        }
    }

    $nav = 'student';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学员管理</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>
<header class="hidden">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">学员管理</a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tel:<?php echo TEL?>"><span class="glyphicon glyphicon-phone-alt"></span> 电话咨询</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="topbar">
    学员管理
    <a href="<?php echo WEB_PATH?>/admin/lct/" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="fa fa-user-plus""></i> 学员报名</a>
</div>

<!--//////////////////////////////////////////-->
<div class="container-fluid hidden" style="background: #FFF;padding-left: 0px;padding-right: 0px;">
    <a href="images/2pointdetail.png"><img src="../images/2point.png" alt="" style="width: 100%;"></a>
    <!--
    <a href="http://uniteedu.cn/xmjz/item.php?id=13"><img src="http://uniteedu.cn/yxh/images/yxh_ui_qd.png" alt="" style="width: 100%;margin-bottom: 10px"></a>
    <a href="http://uniteedu.cn/xmjz/?id=8"><img src="<?php /*echo WEB_PATH;*/?>/images/whlg_zsb_ad.png" alt="" style="width: 100%;margin-bottom: 10px"></a>
    -->
</div>
<!--//////////////////////////////////////////-->
<div class="weui-grids">
    <a href="<?php echo WEB_PATH;?>/student/add.php" class="weui-grid">
        <div class="weui-grid__icon" style="color: #5eb9ff;">
            <i class="fa fa-user-plus"></i>
        </div>
        <p class="weui-grid__label">
            学员报名
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: #09bb07;">
            <i class="fa fa-user-o"></i>
        </div>
        <p class="weui-grid__label">
            营销中 <?php echo $status0;?>
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: orange;">
            <i class="fa fa-user-o"></i>
        </div>
        <p class="weui-grid__label">
            赢单 <?php echo $status1;?>
        </p>
    </a>
</div>

<div class="table-responsive container main">
    <table class="table table-hover table-striped lcr-list">
        <caption class="hidden">
            <h3>
                <span class="label label-success"><span class="glyphicon glyphicon-th-list lcr-list-icon"></span> 学员列表 <span class="badge lcr-list-badge"><?php echo count($students);?></span></span>
                <a href="./add.php" class="btn btn-success pull-right" style="margin-right: 15px;"><span class="glyphicon glyphicon-plus"></span> 新增</a>
            </h3>
        </caption>
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机号</th>
            <th>项目</th>
            <th>时间</th>
            <!--<th>跟踪</th>-->
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($students)){
            foreach ($students as $student){
                ?>
                <tr>

                    <td><a href="detail.php?id=<?php echo $student->id;?>"><?php echo $student->name;?></a></td>
                    <td><?php echo $student->phone;?></td>
                    <td><?php echo $student->brief_project;?></td>
                    <td><?php echo $student->ctime;?></td>
                    <!--<td><a href="" class="btn btn-warning btn-xs">跟踪</a></td>-->
                </tr>
                <?php
            }
        }else{
            echo '<tr><td colspan="4" class="text-center text-warning">无学生数据</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php include_once ROOT_PATH."/tabbar.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>