<?php
session_start();
require substr(dirname(__FILE__), 0, -22).'/init.inc.php';
Validate::checkSession('consultant', 'login.php');
$applyA = new ApplyAction();
$applys = $applyA->getApplyFromConsultant($_SESSION['consultant']->id);
?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>顾问面板</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
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
<div class="container table-responsive" style="padding: 0;">

    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>注册时间</th>
            <th>推荐人</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($applys){
                foreach ($applys as $apply){
                    echo '<tr>
                            <td><a href="detail.php?id='.$apply->id.'">'.$apply->name.'</a></td>
                            <td>'.$apply->phone.'</td>
                            <td>'.date('Y-m-d', strtotime($apply->apply_time)).'</td>
                            <td>'.$apply->parentName.'</td>
                            <td>'.$apply->note.'</td>
                          </tr>';
                }
            }else{
                echo '<tr>
                        <td colspan="5">无数据</td>
                      </tr>';
            }
        ?>


        </tbody>
    </table>
</div>
<?php include_once ROOT_PATH."/admin/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>