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
$projectAction = new ProjectAction();
$projectAction->update();
$project = $projectAction->showOne();
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>项目详情</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
</head>
<body>
<?php include_once '../header.php'?>
<div class="container lcr_detail">
    <div class="lcr-list"><h3><span class="label label-success"><span class="glyphicon glyphicon-education lcr-list-icon"></span> 项目信息</span></h3></div>
    <form action="" id="studentForm" method="post" role="form">
        <div class="form-group">
            <label for="name">项目名称</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="请输入项目名称" value="<?php echo $project->name;?>">
        </div>
        <div class="form-group">
            <label for="brief_name">项目简称</label>
            <input type="text" class="form-control" name="brief_name" id="brief_name" placeholder="请输入项目简称" value="<?php echo $project->brief_name;?>">
        </div>
        <div class="form-group">
            <label for="point">项目积分</label>
            <input type="text" class="form-control" name="point" id="point" placeholder="请输入项目积分" value="<?php echo $project->point;?>">
        </div>
        <div class="form-group">
            <label for="catalogLink">项目简章</label>
            <input type="text" class="form-control" name="catalogLink" id="catalogLink" placeholder="请输入项目简章地址" value="<?php echo $project->catalogLink;?>">
        </div>
        <div class="form-group">
            <label for="note">备注</label>
            <textarea name="note" class="form-control" rows="3"><?php echo $project->note;?></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $project->id;?>">
        <div class="form-group">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">修改</button>
        </div>
        <div class="form-group">
            <button type="submit" name="delete" class="btn btn-md btn-default btn-block submit" disabled>删除</button>
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
