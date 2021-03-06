<?php
/**
 * Created by PhpStorm.
 * Author: Ren    wechat: yyloon
 * Date: 2017/7/10 0010
 * Time: 下午 2:29
 */
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('agent', WEB_PATH.'/admin/login.php');

$consultantA = new ConsultantAction();
$students = $consultantA->getSubApplysStudents($_SESSION['agent']->id);
?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学员</title>
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
    <a href="<?php echo WEB_PATH?>/admin/lct/" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="glyphicon glyphicon-off""></i> 退出</a>
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
<div class="container table-responsive" style="padding: 0;">
    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>创建时间</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($students){
            foreach ($students as $student){
                echo '<tr>
                            <td><a href="student_detail.php?id='.$student->id.'">'.$student->name.'</a></td>
                            <td>'.$student->phone.'</td>
                            <td>'.date('Y-m-d', strtotime($student->ctime)).'</td>
                          </tr>';
            }
        }else{
            echo '<tr>
                        <td colspan="3">无数据</td>
                      </tr>';
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

