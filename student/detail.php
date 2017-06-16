<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/27 0027
 * Time: 下午 2:46
 */
session_start();
require substr(dirname(__FILE__), 0, -8) . '/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$studentAction = new StudentAction();
$studentAction->updateStudent_t();
$student = $studentAction->oneStudent();
//项目下拉列表选项
$projectsAction = new ProjectAction();
$projects = $projectsAction->show();
if (!empty($projects)){
    $student->projectHtml = '';
    foreach ($projects as $project){
        $selected = $student->project_id == $project->id ? 'selected = "selected"' : '';
        $student->projectHtml .= '<option value="' . $project->id . '" ' . $selected . '>' . $project->name . '</option>';
    }
}

$nav = 'student';
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学员详情</title>


    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

    <script type="text/javascript" src="<?php echo WEB_PATH?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH?>/js/addstudent.js"></script>
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

<div class="topbar topbar-bottom-border">
    学员详情
    <a href="javascript:;" onclick="window.history.back();" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
</div>

<div class="container lcr_detail" style="margin-top: 15px; ">
    <div class="lcr-list hidden"><h3><span class="label label-success"><span class="glyphicon glyphicon-education lcr-list-icon"></span> 学生信息</span></h3></div>
    <form action="" id="studentForm" method="post" role="form">
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="请输入姓名" value="<?php echo $student->name;?>">
        </div>
        <div class="form-group">
            <label for="phone">手机号</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="请输入手机号" value="<?php echo $student->phone;?>">
        </div>
        <div class="form-group">
            <label for="sex">性别</label>
            <div>
                <label class="checkbox-inline">
                    <input type="radio" name="sex" id="optionsRadios3" value="1" <?php if ($student->sex == 1) echo 'checked'?>>男
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="sex" id="optionsRadios4" value="0"  <?php if ($student->sex == 0) echo 'checked'?>>女
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="project">项目</label>
            <select name="project" id="project" class="form-control">
                <?php echo $student->projectHtml;?>
            </select>
        </div>
        <div class="form-group">
            <label for="point">积分</label>
            <span class="help-block"><?php echo $student->point;?></span>
            <input type="text" class="form-control hidden" name="point" id="point" placeholder="请输入积分" value="<?php echo $student->point;?>">

        </div>

        <div class="form-group">
            <label for="hedu">最高学历</label>
            <select name="hedu" id="hedu" class="form-control">
                <option value="高中" <?php if ($student->hedu == '高中') echo 'selected'?>>高中</option>
                <option value="中专" <?php if ($student->hedu == '中专') echo 'selected'?>>中专</option>
                <option value="大专" <?php if ($student->hedu == '大专') echo 'selected'?>>大专</option>
                <option value="本科" <?php if ($student->hedu == '本科') echo 'selected'?>>本科</option>
            </select>
        </div>
        <div class="form-group">
            <label for="note">备注</label>
            <textarea name="note" class="form-control" rows="3"><?php echo $student->note;?></textarea>
        </div>
        <div class="form-group">
            <label for="ctime">录入时间</label>
            <input type="text" class="form-control" id="ctime" value="<?php echo $student->ctime;?>" disabled>
        </div>
        <input type="hidden" name="id" value="<?php echo $student->id;?>">
        <input type="hidden" name="owner_id" value="<?php echo $_SESSION['apply_id']?>">
        <div class="form-group hidden">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">修改</button>
        </div>
        <div class="form-group hidden">
            <button type="submit" name="delete" class="btn btn-md btn-default btn-block submit" disabled>删除</button>
        </div>
        <div class="form-group">
            <a href="." class="btn btn-danger btn-md btn-block ">返回</a>
        </div>

    </form>
</div>
<?php include_once ROOT_PATH.'/tabbar.php'?>
</body>
</html>
