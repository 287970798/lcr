<?php

if (isset($_POST)){
    print_r($_POST);
}
$readOnly = 'onfocus="this.defaultIndex = this.selectedIndex;" onchange="this.selectedIndex = this.defaultIndex;"';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
<form action="" role="form" method="post">
    <div class="form-group">
        <label for="project"></label>
        <select name="project" id="project" class="form-control" <?=$readOnly;?>>
            <option value="0">咨询中</option>
            <option value="1" selected="selected">成功</option>
            <option value="2">失败</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">username:</label>
        <input type="text" name="username" id="username" class="form-control">
    </div>
    <button class="btn btn-success">提交</button>
</form>

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
