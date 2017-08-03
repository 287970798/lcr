<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/10 0010
 * Time: 下午 2:04
 */
session_start();
require substr(dirname(__FILE__), 0, -8) . '/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$projectA = new ProjectAction();
$projects = $projectA->show();
$nav = '项目管理';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $nav?></title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>

<div class="topbar topbar-bottom-margin">
    项目及积分
    <a href="../my.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
</div>

<div class="table-responsive container main">
    <table class="table table-bordered table-striped table-hover lcr-list">
        <thead>
        <tr>
            <th>项目名</th>
            <th>积分</th>
            <!--<th>简介</th>-->
            <th>简章</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($projects)){
            foreach ($projects as $project){
                ?>
                <tr>
                    <td><a href="javascript:;" onclick="weui.alert('<?php echo $project->note?>',{title:'<?php echo $project->brief_name?>'});"><?php echo $project->name;?></a></td>
                    <td><?php echo $project->point;?></td>
                    <!--<td>
                        <?php
/*                            if (mb_strlen(trim($project->note)) > 0){
                                echo '<a href="javascript:;" onclick="weui.alert(\''.$project->note.'\',{title:\''.$project->brief_name.'\'});" class="btn btn-success btn-xs">简介</a>';
                            } else {
                                echo '<a href="javascript:;" class="btn btn-warning btn-xs disabled">暂缺</a>';
                            }
                        */?>
                    </td>-->
                    <td>
                        <?php
                        if (mb_strlen(trim($project->catalogLink)) > 0){
                            echo '<a href="'.$project->catalogLink.'" class="btn btn-success btn-xs">查看简章</a>';
                        } else {
                            echo '<a href="javascript:;" class="btn btn-warning btn-xs disabled">没有简章</a>';
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }else{
            echo '<tr><td colspan="3" class="text-center text-warning">无项目数据</td></tr>';
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