<?php
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('agent', WEB_PATH.'/admin/login.php');
$consultantA = new ConsultantAction();
if (isset($_POST['submit'])){
    $consultantA->update('staff_detail.php');
}
$consultant = $consultantA->getOne();

?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $consultant->name;?> - 员工详情</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH;?>/style/admin.css">
    <link rel="stylesheet" href="../../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">

</head>
<body>

<div class="topbar">
    联创团管理中心
    <a href="<?php echo WEB_PATH?>/admin/lct" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="staff_add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right"><i class="glyphicon glyphicon-plus""></i> 加员工</a>
</div>

<div class="weui-grids mygrid" style="background-color: #fff; margin-bottom: 10px; margin-top: 10px; letter-spacing: 1px;">
    <a href="<?php echo WEB_PATH;?>/admin/lct/staff.php" class="weui-grid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #6cc76f;">
            <i class="fa fa-user" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            员工管理
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/admin/lct/apply.php" class="weui-grid">
        <div class="weui-grid__icon"  style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #5eb9ff;">
            <i class="fa fa-graduation-cap" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            联创人管理
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/admin/lct/student.php" class="weui-grid cellgrid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #ed8d76;">
            <i class="fa fa-tasks" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            学员管理
        </p>
    </a>
</div>
<div class="weui-cells__title hidden" style="auto;">新增优学顾问</div>
<form action="" method="post">
    <fieldset disabled>
    <input type="hidden" name="id" value="<?php echo $consultant->id;?>">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="name" type="text" value="<?php echo $consultant->name;?>" placeholder="请输入姓名"/>
            </div>
        </div>
        <div class="weui-cell weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">手机号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone" type="tel" value="<?php echo $consultant->phone;?>" placeholder="请输入手机号">
            </div>
        </div>
        <div class="weui-cell weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">微信号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="wechat" type="wechat" value="<?php echo $consultant->wechat;?>" >
            </div>
        </div>

        <div class="weui-btn-area">
<!--            <button class="weui-btn weui-btn_primary" type="submit" name="submit" href="javascript:" id="showTooltips">确定</button>-->
            <a class="weui-btn btn-primary" style="color: #FFF!important;" id="goBack" href="staff.php">返回</a>
<!--            <button class="weui-btn weui-btn_warn" id="del">删除</button>-->
        </div>
    </div>
    </fieldset>
</form>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var del = document.getElementById('del');
    del.onclick = function (e) {
        var e = e || window.event;
        e.preventDefault() || (e.returnValue = false);
        weui.actionSheet([
            {
                label: '删除',
                onClick: function () {
                    ajax({
                        method : 'get',
                        url : 'delete_staff.php',
                        data : {
                            'id' : <?php echo $consultant->id;?>
                        },
                        success: function (text) {
                            if (parseInt(text) === 1){
                                weui.toast('删除成功!', {
                                    duration: 3000,
                                    className: 'custom-classname',
                                    callback: function(){
                                        location.href='staff.php';

                                    }
                                });
                            }else{
                                weui.alert('删除失败！'+text);
                            }
                        },
                        async : true
                    });
                }
            }, {
                label: '取消',
                onClick: function () {
                    console.log('取消');
                }
            }
        ], [
            {
                label: '取消',
                onClick: function () {
                    console.log('取消');
                }
            }
        ], {
            className: 'custom-classname'
        });
    }




////////////////////////////////////////
    //ajax
    //创建XHR
    function createXHR() {
        if (typeof XMLHttpRequest != 'undefined'){
            return new XMLHttpRequest();
        }else if (typeof ActiveXObject != 'undefined'){
            var versions = [
                'MSXML2.XMLHttp6.0',
                'MSXML2.XMLHttp3.0',
                'MSXML2.XMLHttp'
            ];
            for (var i = 0; i < versions.length; i++){
                try {
                    return new ActiveXObject(versions[i]);
                } catch (e){
                    //跳过
                }
            }
        }else{
            throw new Error('您的浏览器不支持XHR对象！');
        }
    }
    //ajax请求
    var obj = {
        method : null,
        url : null,
        data : {},
        success: function (text) {
            return text;
        },
        async : true
    }
    function ajax(obj) {
        var xhr = createXHR();
        obj.url = obj.url + '?rand=' + Math.random();
        obj.data = params(obj.data);
        if (obj.method === 'get'){
            obj.url = obj.url.indexOf('?') == -1 ? obj.url + '?' + obj.data : obj.url + '&' + obj.data;
        }
        if (obj.async === true){
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4){
                    callback();
                }
            }
        }
        xhr.open(obj.method, obj.url, obj.async);
        if (obj.method === 'post'){
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(obj.data);
        }else{
            xhr.send(null);
        }
        if (obj.async === false){
            callback();
        }

        function callback() {
            if (xhr.status == 200){
                obj.success(xhr.responseText);
            }else{
                alert('数据返回失败！状态码：' + xhr.status + ',状态信息:' + xhr.statusText);
            }
        }
    }
    //键值对处理
    function params(data) {
        var arr = [];
        for (var i in data){
            arr.push(encodeURIComponent(i) + '=' + encodeURIComponent(data[i]));
        }
        return arr.join('&');
    }
</script>
</body>
</html>