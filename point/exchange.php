<?php
session_start();
require substr(dirname(__FILE__), 0, -6) . '/init.inc.php';
//获取学员、联创人、积分等总数
$indexA = new IndexAction();
$countO = $indexA->getCount();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>申请兑换</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
</head>
<body>
<div class="topbar">
    填写申请信息
    <a href="<?php echo @WEB_PATH?>/point/" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="fa fa-user-plus""></i> 新增</a>
</div>
<form id="accountForm">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">兑换人</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" value="<?=@$_SESSION['apply']->name;?>" disabled/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">兑换金额</label></div>
            <div class="weui-cell__bd">
                <input name="money" id="money" class="weui-input" type="number" pattern="[0-9]*" placeholder="当前可兑换金额为 <?=@$countO->availablePoint;?> 元"/>
                <input type="hidden" name="deduct_point" class="deduct" id="deduct_point" value="">
            </div>
            <div class="weui-cell__ft">
                <i class="weui-icon-warn"></i>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label for="" class="weui-label">消耗积分</label></div>
            <div class="weui-cell__bd">
                <input name="deduct_point2" id="deduct_point2" class="weui-input deduct" type="text" value="0"/>
            </div>
        </div>
    </div>
    <div class="weui-cells__tips">当前可兑换积分 <span id="availablePoint"><?=@$countO->availablePoint;?></span></div>
    <div class="weui-btn-area">
        <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
    </div>
</form>
<?php include_once ROOT_PATH."/tabbar.php"?>
<script src="https://cdn.bootcss.com/jquery/3.2.0/jquery.min.js"></script>
<script>
    var form = document.getElementById('accountForm');
    // 积分随金额
    form.money.onkeyup = function () {
        if (this.value > parseInt($("#availablePoint").html())) {
            this.value = parseInt($("#availablePoint").html());
        }
        form.deduct_point.value = this.value;
        form.deduct_point2.value = this.value;
    }
    form.deduct_point2.onfocus = function () {
        this.blur();
    }


    //查询已消耗积分
    var data = {
        apply_id : <?=$_SESSION['apply_id'];?>
    }
    $.ajax({
        url: "http://uniteedu.cn/work/public/lcr/exchange/exchangesum",
        type: 'get',
        data: data
    }).done(function(result){
        var availablePoint = <?= @$countO->availablePoint;?> - parseInt(result);
        $("#availablePoint").html(availablePoint);
        form.money.setAttribute('placeholder', '当前可兑换金额为' + availablePoint);

        console.log(result);
    }).fail(function(err){
        console.log(err);
    });

//    提交
    $('#showTooltips').click(function () {
        var aForm = document.getElementById('accountForm');
        // 数据
        var data = {
            "apply_id" : <?=@$_SESSION['apply_id']?:0;?>,
            "deduct_point" : aForm.money.value,
            "money" : aForm.money.value
        };
        /*验证*/

        /*提交*/
        $.ajax({
            url: "http://uniteedu.cn/work/public/lcr/exchange/addexchange",
            type: 'POST',
            data: data
        }).done(function(result){
            console.log(result);
            if (parseInt(result.code) === 2002) {
                weui.toast(result.msg, {
                    callback : function () {
                        console.log('成功回调');
                    }
                });
            } else {
                var message = '';
                //判断返回msg是否是对象，如果是则拼接该对象属性的值为字符串
                if (Object.prototype.toString.call(result.msg) == '[object Object]') {
                    for (var i in result.msg) {
                        message += result.msg[i] + '<br>';
                    }
                } else {
                    message = result.msg;
                }
                weui.alert(message, {title : '警告'});
            }
            console.log(result);
        }).fail(function(err){
            weui.alert(err.statusText);
            console.log(err);
        });
    });

</script>
</body>
</html>
