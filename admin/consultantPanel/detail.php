<?php
session_start();
require substr(dirname(__FILE__), 0, -22).'/init.inc.php';
Validate::checkSession('consultant', 'login.php');
    $apply = new ApplyAction();
    if (isset($_POST['send'])){
        $apply->update();
    } else {
        $object = $apply->show();
        if ($object->parent_id != 0){
            $_GET['id'] = $object->parent_id;
            $referee = $apply->show();
            //如果没有设置顾问，则采用上级联创人的顾问
            if (!$object->consultantId) $object->consultantId = $referee->consultantId;
        }

        //顾问列表
        $consultantA = new ConsultantAction();
        $consultants = $consultantA->getAll();
        if (!empty($consultants)){
            $object->projectHtml = '';
            foreach ($consultants as $consultant){
                $selected = $object->consultantId == $consultant->id ? 'selected = "selected"' : '';
                $object->projectHtml .= '<option value="' . $consultant->id . '" ' . $selected . '>' . $consultant->name . '</option>';
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详细信息</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <script type="text/javascript" src="<?php echo WEB_PATH;?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo WEB_PATH;?>/js/apply.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="<?php echo WEB_PATH;?>/images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">优学顾问管理面板</a>
                <a href="logout.php" class="btn btn-danger btn-xs" style="display: inline-block;float: right;margin-right: 15px;margin-top: 15px;">退出</a>
            </div>
        </div>
    </nav>
</header>
<div class="container lcr-detail">
    <div class="lcr-list"><h3><span class="label label-success"><span class="glyphicon glyphicon-education lcr-list-icon"></span> 联创人信息</span></h3></div>
    <?php if (!empty($referee)){?>
    <div class="panel panel-success">
        <div class="panel-body">
            <h5 class="text-center">
                <span class="label label-default">推荐人</span>
            </h5>
            <div class="container">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span class="glyphicon glyphicon-user"></span> <?php echo $referee->name;?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <span class="glyphicon glyphicon-phone"></span><?php echo $referee->phone;?>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <form id="applyForm" method="post" action="" role="form" onsubmit="javascript:return confirm('定修改该联创人信息吗？') ? true : false;">
        <fieldset disabled>
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="请输入姓名" value="<?php echo $object->name;?>">
        </div>
        <div class="form-group">
            <label for="phone">手机号</label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="请输入手机号" value="<?php echo $object->phone;?>">
        </div>
        <div class="form-group">
            <label for="wechat">微信号</label>
            <input type="text" class="form-control" name="wechat" id="wechat" placeholder="请输入微信号" value="<?php echo $object->wechat;?>">
        </div>
        <div class="form-group">
            <label for="apply_time">申请时间</label>
            <input type="text" class="form-control" id="apply_time" value="<?php echo $object->apply_time;?>" disabled>
        </div>

        <div class="form-group">
            <label for="status">审核</label>
            <select class="form-control" name="status">
                <?php echo $object->selectHtml;?>
            </select>
        </div>
        <div class="form-group">
            <label for="consultantId">服务人员</label>
            <select name="consultantId" id="consultantId" class="form-control">
                <?php echo $object->projectHtml;?>
            </select>
        </div>
        <div class="form-group hidden">
            <button type="submit" name="send" class="btn btn-md btn-success btn-block submit">修改</button>
        </div>
        </fieldset>
        <div class="form-group">
            <a href="javascript:;" onclick="javascript:history.back();" class="btn btn-danger btn-md btn-block ">返回</a>
        </div>

    </form>

</div>
<?php include_once ROOT_PATH."/admin/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>