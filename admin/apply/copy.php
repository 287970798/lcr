<?php
session_start();
require substr(dirname(__FILE__), 0, -12).'/init.inc.php';
Validate::checkSession();
$nav = '联创人';
$applyModel = new ApplyModel();
$objects = $applyModel->getApply();
$newApply = 0;
if(!empty($objects)){
    foreach ($objects as $object){
        if ($object->status == 0) $newApply ++;
        $object->apply_time = date('Y-m-d', strtotime($object->apply_time));
        switch ($object->status){
            case 0:
                $object->statusClass = 'danger';
                $object->status = '<span class="label label-warning">审核中</span>';
                break;
            case 1:
                $object->statusClass = 'success';
                $object->status = '<span class="label label-success">已通过</span>';
                break;
            case 2:
                $object->statusClass = 'warning';
                $object->status = '<span class="label label-danger">已拒绝</span>';
        }
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
    <title>联创人申请管理系统</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
</head>
<body>
<?php include_once "../header.php"?>
<div class="table-responsive container main">
    <table class="table table-hover table-bordered table-striped lcr-list">
        <caption>
            <h3>
                <span class="label label-success"><span class="glyphicon glyphicon-th-list lcr-list-icon"></span> 申请列表 <span class="badge lcr-list-badge"><?php echo $newApply;?></span></span>
                <a href="../apply/" class="btn btn-success pull-right" style="margin-right: 15px"><span class="glyphicon glyphicon-plus"></span> 新增</a>
            </h3>
        </caption>
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>推荐人</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($objects)){
            foreach ($objects as $object){
                ?>
                <tr class="<?php echo $object->statusClass;?>">
                    <td><?php echo $object->name;?></td>
                    <td><?php echo $object->phone; ?></td>
                    <td><?php echo $object->parent_name; ?></td>
                </tr>
                <?php
            }
        }else{
            echo '<tr><td colspan="4" class="text-center text-warning">无下级联创人</td></tr>';
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