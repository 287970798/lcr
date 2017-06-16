<?php
    session_start();
    require substr(dirname(__FILE__), 0, -14) . '/init.inc.php';
Validate::checkSession();
    $nav = '招生管理';
    $studentsAction = new StudentAction();
    $students = $studentsAction->allStudents();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <title>学员管理</title>
</head>
<body>
    <?php include '../header.php'?>
    <div class="table-responsive container main">
        <table class="table table-bordered table-striped table-hover lcr-list">
            <caption>
                <h3>
                    <span class="label label-success"><span class="glyphicon glyphicon-th-list lcr-list-icon"></span> 学员列表 <span class="badge lcr-list-badge"><?php echo count($students);?></span></span>
                    <a href="./add.php" class="btn btn-success pull-right" style="margin-right: 15px"><span class="glyphicon glyphicon-plus"></span> 新增</a>
                </h3>
            </caption>
            <thead>
            <tr>
                <th>姓名</th>
                <th>录入人</th>
                <th>项目</th>
                <th>时间</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (!empty($students)){
                foreach ($students as $student){
                    ?>
                    <tr>

                        <td>
                            <a href="detail.php?id=<?php echo $student->id;?>"><?php echo $student->name;?></a>
                        </td>
                        <td class="text-center">
                            <?php
                                if ($student->owner_id){
                                    echo '<a href="'.WEB_PATH.'/admin/detail.php?id='.$student->owner_id.'">'.$student->owner_name.'</a>';
                                } else {
                                    echo $student->owner_name;
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $student->brief_project;?>
                        </td>
                        <td>
                            <?php echo $student->ctime;?>
                        </td>
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
    <?php include '../footer.php'?>
    <script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>