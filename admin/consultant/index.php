<?php
session_start();
require substr(dirname(__FILE__), 0, -17).'/init.inc.php';
$consultantA = new ConsultantAction();
$objects = $consultantA->getAll();

?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>优学顾问管理</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../../style/admin.css">
</head>
<body>
<?php include_once "../header.php"?>
<div class="table-responsive container main">
    <table class="table table-hover table-bordered table-striped lcr-list">
        <caption>
            <h3>
                <span class="label label-success"><span class="glyphicon glyphicon-th-list lcr-list-icon"></span> 优学顾问列表 <span class="badge lcr-list-badge">0</span></span>
                <a href="add.php" class="btn btn-success pull-right" style="margin-right: 15px"><span class="glyphicon glyphicon-plus"></span> 新增</a>
            </h3>
        </caption>
        <thead>
        <tr>
            <th>姓名</th>
            <th>电话</th>
            <th>微信</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($objects)){
            foreach ($objects as $object){
                ?>
                <tr>
                    <td><a href="detail.php?id=<?php echo $object->id;?>"><?php echo $object->name;?></a></td>
                    <td><?php echo $object->phone; ?></td>
                    <td><?php echo $object->wechat; ?></td>
                </tr>
                <?php
            }
        }else{
            echo '<tr><td colspan="4" class="text-center text-warning">无服务人员</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php include_once "../footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>