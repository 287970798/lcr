<?php
session_start();
require substr(dirname(__FILE__), 0, -6) . '/init.inc.php';
?>
<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>帐户信息</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <style>
         .photo.weui-cells:before{
            border: 0 solid #CCC;
        }
         .photo.weui-cells:after{
             border: 0 solid #CCC;
         }
    </style>
</head>
<body>
<div class="topbar">
    完善帐户信息
    <a href="<?php echo WEB_PATH?>/point/" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="fa fa-user-plus""></i> 新增</a>
</div>

<form id="accountForm">
<div class="weui-cells__title">基本信息</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
        <div class="weui-cell__bd">
            <input name="real_name" class="weui-input" type="text" placeholder="请输入真实姓名"/>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">身份证号</label></div>
        <div class="weui-cell__bd">
            <input name="credit_card" class="weui-input" type="text" placeholder="身份证号"/>
        </div>
        <div class="weui-cell__ft">
            <i class="weui-icon-warn"></i>
        </div>
    </div>

    <div class="weui-cell">
        <div class="weui-cell__hd"><label for="" class="weui-label">银行卡号</label></div>
        <div class="weui-cell__bd">
            <input name="bank_card" class="weui-input" type="number" pattern="[0-9]*" placeholder="提现银行卡号"/>
        </div>
        <div class="weui-cell__ft">
            <i class="weui-icon-warn"></i>
        </div>
    </div>
</div>

<div class="weui-cells__title">开户行</div>
<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <textarea name="deposit_bank" class="weui-textarea" placeholder="请输入开户行" rows="3"></textarea>
            <div class="weui-textarea-counter hidden"><span>0</span>/200</div>
        </div>
    </div>
</div>

<div class="weui-cells__title">请上传手持身份证照片</div>
<input type="text" name="credit_card_photo" id="imgsrc" class="hidden">
<input type="file" name="myFile" id="file" class="hidden">
<div class="photo weui-cells weui-cells_form text-center" style="background-color: transparent;border: none;">
    <div style="border: 1px solid #CCC;height: 200px;width: 90%;position: relative;left: 5%;text-align: center;line-height: 200px;background-color: #fff">
        <button class="btn btn-success center-block" id="btn" style="position:absolute;top: 40%;left:40%;">选择照片</button>
        <img src="" alt="" id="image">
        <span id="tip" style="position: absolute;left: 10%;top: 85%;" class="label label-info"></span>
    </div>
</div>


<div class="weui-cells__title">请认真填写以上信息，错误信息会影响提现 </div>

<div class="weui-btn-area">
    <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips" style="color: #FFF;">确定</a>
</div>
</form>
<?php include_once ROOT_PATH."/tabbar.php"?>
<script src="https://cdn.bootcss.com/jquery/3.2.0/jquery.min.js"></script>
<script>
    var file = document.getElementById('file');
    var image = document.getElementById('image');
    var imgsrc = document.getElementById('imgsrc');
    var btn = document.getElementById('btn');
    //模拟点击选择按钮
    btn.addEventListener('click',function (e) {
        e.preventDefault();
        $(file).click();
    })

    file.addEventListener('change',function () {
        $(btn).animate({top:150},1000);
//        getFileSize(this.value);
        image.src=window.URL.createObjectURL(file.files[0]);
        image.style.width = '90%';
        image.style.maxHeight = '200px';
        $('#tip').removeClass().addClass('label label-info');
        $('#tip').html('正在上传！');
        if (file.files[0].size > 2048000){
            imgsrc.value = '';
            $('#tip').removeClass().addClass('label label-danger').html('照片不能大于2M');
            $(btn).html('另选照片');
            return;
        }
        var fd = new FormData();
        fd.append('myfile',file.files[0]);
        $.ajax({
            url: "response.php",
            type: 'POST',
            data: fd,
            contentType:false,
            processData:false
        }).done(function(result){
            var text = JSON.parse(result);
            $('#tip').html(text.mes);
            if (text.dest){
                imgsrc.value = text.dest;
                $('#tip').removeClass().addClass('label label-success');
                $(btn).html('更改照片');
            }else{
                imgsrc.value = '';
                $('#tip').removeClass().addClass('label label-danger');
                $(btn).html('另选照片');
            }
            console.log(result);
        }).fail(function(err){
            console.log(err);
        });
    });
    $('#showTooltips').click(function () {
        var aForm = document.getElementById('accountForm');
        // 数据
        var data = {
            "apply_id" : <?=$_SESSION['apply_id']?:0;?>,
            "real_name" : aForm.real_name.value,
            "credit_card" : aForm.credit_card.value,
            'bank_card' : aForm.bank_card.value,
            'deposit_bank' : aForm.deposit_bank.value,
            'credit_card_photo' : aForm.credit_card_photo.value
        };
        /*验证*/

        /*提交*/
        $.ajax({
            url: "http://uniteedu.cn/work/public/lcr/account/accountInfo/type/add",
            type: 'POST',
            data: data
        }).done(function(result){
            if (parseInt(result.code) === 1) {
                weui.toast(result.message, {
                    callback : function () {
                        location.href = 'http://uniteedu.cn/lcyx/lcr/point/exchange.php';
                        console.log('成功回调');
                    }
                });
            } else {
                weui.alert(result.message, {title : '警告'});
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