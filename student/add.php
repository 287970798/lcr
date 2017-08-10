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
$studentAction->addStudent_t();
//项目下拉列表选项
$projectsAction = new ProjectAction();
$projects = $projectsAction->show();

if (!empty($projects)){
    //组合类别二维数组
    $categories = [];
    foreach ($projects as $project) {
        $categories[$project->category_name][] = $project;
    }
    //组装列表项
    $projectHtml = '';
    $pointHtml = '';
    foreach ($categories as $key => $category) {
        $projectHtml .= "<optgroup label='{$key}'>";
        foreach ($category as $project) {
            $projectHtml .= '<option value="' . $project->id . '">' . $project->name.'</option>';
        }
        $projectHtml .= '</optgroup>';
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
    <script type="text/javascript" src="js/addstudent.js"></script>
</head>
<body>
<header class="hidden">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">新增学员</a>
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
    学员管理
    <a href="javascript:;" onclick="window.history.back();" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
</div>

<div class="container lcr_detail" style="margin-top: 15px; ">
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
            <select name="sex" id="sex" class="form-control">
                <option value="">请选择</option>
                <option value="1">男</option>
                <option value="2">女</option>
            </select>
        </div>
        <div class="form-group">
            <label for="project">意向项目</label>
            <select name="project" id="project" class="form-control">
                <option value="">请选择</option>
                <?php echo $projectHtml;?>
            </select>
        </div>
        <div class="form-group hidden">
            <label for="point">积分</label>
            <input type="text" class="form-control" name="point" id="point" placeholder="请输入积分">
        </div>

        <div class="form-group">
            <label for="hedu">最高学历</label>
            <select name="hedu" id="hedu" class="form-control">
                <option value="">请选择</option>
                <option value="高中">高中</option>
                <option value="中专">中专</option>
                <option value="大专">大专</option>
                <option value="本科">本科</option>
            </select>
        </div>
        <div class="form-group">
            <label for="note">学员需求</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>
        <input type="hidden" name="owner_id" value="<?php echo $_SESSION['apply_id']?>">
        <div class="form-group">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">提交</button>
        </div>
        <div class="form-group">
            <a href="javascript:;" onclick="javascript:history.back();" class="btn btn-danger btn-md btn-block ">返回</a>
        </div>

    </form>
</div>
<?php include_once ROOT_PATH.'/tabbar.php'?>
</body>
</html>
