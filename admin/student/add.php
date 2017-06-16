<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/27 0027
 * Time: 下午 2:46
 */
session_start();
require substr(dirname(__FILE__), 0, -14) . '/init.inc.php';
Validate::checkSession();
$nav = '招生管理';
$studentAction  = new StudentAction();
//异步获取项目积分-begin
if (isset($_GET['js'])){
    $projectsAction = new ProjectAction();
    $project = $projectsAction->showOne();
    if (!empty($project)){
        echo $project->point;
    } else {
        echo 0;
    }
    exit;
}
//end
$studentAction->addStudent();
//项目下拉列表选项
$projectsAction = new ProjectAction();
$projects = $projectsAction->show();
if (!empty($projects)){
    $projectHtml = '';
    foreach ($projects as $project){
        $projectHtml .= '<option value="' . $project->id . '">' . $project->name . '</option>';
    }
}
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
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <script type="text/javascript" src="<?php echo WEB_PATH;?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>/student/js/addStudent.js"></script>
</head>
<body>
<header>
<?php include_once '../header.php'?>
<div class="container lcr_detail">
    <div class="lcr-list"><h3><span class="label label-success"><span class="glyphicon glyphicon-education lcr-list-icon"></span> 新增学员</span></h3></div>
    <form action="" id="studentForm" method="post" role="form">
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="请输入姓名">
        </div>
        <div class="form-group">
            <label for="phone">手机号</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="请输入手机号">
        </div>
        <div class="form-group">
            <label for="sex">性别</label>
            <div>
                <label class="checkbox-inline">
                    <input type="radio" name="sex" id="optionsRadios3" value="1">男
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="sex" id="optionsRadios4" value="0">女
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="project">项目</label>
            <select name="project" id="project" class="form-control">
                <?php echo $projectHtml;?>
            </select>
        </div>

        <div class="form-group">
            <label for="hedu">最高学历</label>
            <select name="hedu" id="hedu" class="form-control">
                <option value="高中">高中</option>
                <option value="中专">中专</option>
                <option value="大专">大专</option>
                <option value="本科">本科</option>
            </select>
        </div>
        <div class="form-group">
            <label for="note">备注</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>
        <input type="hidden" name="owner_id" id="owner_id" value="0">
        <div class="form-group">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">提交</button>
        </div>
        <div class="form-group">
            <a href="." class="btn btn-danger btn-md btn-block ">返回</a>
        </div>

    </form>
</div>
<?php include_once '../footer.php'?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
