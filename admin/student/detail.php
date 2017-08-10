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
$studentAction = new StudentAction();
//修改学员
$studentAction->updateStudent_t();
//学员详细信息
$student = $studentAction->oneStudent();
//状态下拉列表
$student->statusHtml = '';
$readOnly = '';
$submitBtnClass = '';

//如果不是超级管理员，当状态为赢单或输单时，下拉框设为只读
if ($_SESSION['admin'] != 'admin') {
    if ($student->status == 1 || $student->status == 2){
        $readOnly = 'onfocus="this.defaultIndex = this.selectedIndex;" onchange="this.selectedIndex = this.defaultIndex;"';
        $submitBtnClass = 'hidden';
    }
}

foreach (array('咨询中', '赢单', '输单','已报名','已缴费','已录取') as $k=>$v){
    //当不是超级管理员，并且不是学员状态不为赢单或输单时，删除这两个选项
    if ($_SESSION['admin'] != 'admin') {
        if ($k != $student->status) { //当前循环值不是学员状态
            if ($k == 1 || $k == 2) {   //并且循环值为1，或2
                continue;   //跳出当前循环
            }
        }
    }
    $k == $student->status ? $selected ='selected = "selected"' : $selected = '';
    $student->statusHtml .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
}
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
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <script type="text/javascript" src="<?php echo WEB_PATH?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH?>/student/js/addstudent.js"></script>
</head>
<body>
<?php include_once '../header.php'?>
<div class="container lcr_detail">
    <div class="lcr-list">
        <h3>
            <span class="label label-success"><span class="glyphicon glyphicon-education lcr-list-icon"></span> 学生信息</span>
            <a href="#" class="btn btn-default pull-right" style="margin-right: 15px"><span class="glyphicon glyphicon-transfer"></span> 跟踪</a>
        </h3>
    </div>

    <form action="" id="studentForm" method="post" role="form">
        <input type="hidden" name="oldStatus" value="<?php echo $student->status?>">
        <div class="form-group">
            <label for="status">营销状态</label>
            <select name="status" id="status" class="form-control" <?=$readOnly;?>>
                <?php echo $student->statusHtml;?>
            </select>
        </div>
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
        <div class="form-group ">
            <label for="point">积分</label>
            <input type="text" class="form-control" name="point" id="point" placeholder="请输入积分" value="<?php echo $student->point;?>">
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
        <input type="hidden" name="owner_id" value="<?php echo $student->owner_id?>">
        <div class="form-group">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit <?=$submitBtnClass?>">修改</button>
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
