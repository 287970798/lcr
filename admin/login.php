<?php
    session_start();
    require substr(dirname(__FILE__), 0, -6).'/init.inc.php';
    if (isset($_POST['submit'])){
        $admin = new AdminAction();
        $object = $admin->login();
        if (!empty($object)){
            $_SESSION['admin'] = $object->user;
            header('Location:index.php');
        }else{
            Tool::alert('失败');
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
    <title>联创人管理系统 - <?php echo WEBNAME;?></title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../style/admin.css">
    <script type="text/javascript" src="../js/common.js"></script>
    <script type="text/javascript" src="../js/login.js"></script>

</head>
<body>
    <header>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand logo">
                        <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                    </a>
                    <a href="#" class="navbar-brand">
                        联创人管理系统
                    </a>
                    <a href="consultantPanel/" class="btn btn-danger btn-xs" style="position: absolute;top: 15px;right: 15px;">优学顾问登录入口</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <form action="" id="loginForm" method="post" role="form">
            <div class="form-group">
                <label for="user">用户名</label>
                <input type="text" class="form-control input-lg" name="user" placeholder="请输入用户名">
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" class="form-control input-lg" name="password" placeholder="请输入密码">
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-block btn-md" name="submit">登录</button>
            </div>
        </form>
    </div>
</body>
</html>