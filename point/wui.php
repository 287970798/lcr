<?php
    require substr(dirname(__FILE__), 0, -6) . '/init.inc.php';
?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>服务中心</title>

    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
</head>
<body>
<div class="topbar">
    积分明细
    <a href="../my.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left"><i class="fa fa-mail-reply"></i> 返回</a>
    <a href="javascript:;" onclick="weui.alert(document.querySelector('#pointDesc').innerHTML, {title:'积分说明'});"><img src="<?php echo WEB_PATH;?>/images/weui/icon_intro.png" alt="" style="width: 15px;margin-top: -3px;"></a>
    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right" onclick="weui.alert('您没有可兑换的积分！', {title:'兑换说明'});"><i class="fa fa-money"></i> 兑换</a>
</div>

<div class="container-fluid" style="background-color: #5eb9ff; padding: 0 0 20px 0; color: #FFF;">
    <img src="http://wx.qlogo.cn/mmopen/xRtOk9KHtV8kPQPicjzrXxYakQFQrUNichEs8iaLliaXWsbl7jc2ficmFqgtkUKDr6kakibeuEWHAYaYXAoJ8tqHWt9g/0" alt="" class="img-circle center-block" style="width: 100px; height: 100px; margin-top: 20px;">
    <div class="text-center">任心伟</div>
</div>
<div class="weui-grids mygrid" style="background-color: #fff; margin-bottom: 15px; letter-spacing: 1px;">
    <a href="javascript:;" class="weui-grid" style="width: 50%;">
        <div class="weui-grid__icon" style="color: #ff8265; width: 100%; text-align: center;font-size: 25px;letter-spacing: normal;">
            2680
        </div>
        <p class="weui-grid__label" style="color: #333;font-size: 16px;">
            全部积分
        </p>
    </a>
    <a href="javascript:;" class="weui-grid" style="width: 50%;">
        <div class="weui-grid__icon"  style="color: #ff8265; width: 100%; text-align: center;font-size: 25px;letter-spacing: normal;">1562</div>
        <p class="weui-grid__label" style="color: #333;font-size: 16px;">
            可用积分
        </p>
    </a>
</div>

<div class="hidden" style="background: #fff;margin-top: 15px;padding: 5px 10px;color: #999; letter-spacing: 1px;">快捷操作</div>
<div class="weui-grids mygrid" style="background-color: #fff; margin-bottom: 15px; letter-spacing: 1px;">
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #6cc76f;">
            <i class="fa fa-user-plus" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label">
            新增学员
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon"  style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #5eb9ff;">
            <i class="fa fa-graduation-cap" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label">
            全部学员
        </p>
    </a>
    <a href="javascript:;" class="weui-grid cellgrid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #ed8d76;">
            <i class="fa fa-group" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label">
            联创人
        </p>
    </a>
</div>

<div class="container-fluid" style="background: #FFF;margin-bottom: 15px;padding-bottom: 10px;">
    <div style="background: #fff;padding: 5px 10px;color: #999; letter-spacing: 1px;text-align: center">热门专题</div>
    <a href="http://uniteedu.cn/xmjz/item.php?id=13"><img src="../images/ui_ad.png" alt="" style="width: 100%;margin-bottom: 10px"></a>
</div>

<div class="container-fluid hidden" style="background: #FFF;margin-bottom: 15px;padding: 0px 0 10px 0;">
    <div class="hidden" style="background: #fff;padding: 5px 10px;color: #999; letter-spacing: 1px;text-align: center">热门专题</div>
    <a href="http://uniteedu.cn/xmjz/item.php?id=13"><img src="../images/ad.png" alt="" style="width: 100%;margin-bottom: 10px"></a>
    <div class="text-center text-warning" style="font-size: 13px;">立即查看</div>
</div>
<div id="pointDesc">
    <table class="table" style="text-align: left;">
        <tr>
            <td>积分获得</td>
        </tr>
        <tr>
            <td>
                <ol>
                    <li>新增学员</li>
                    <li>新增联创</li>
                    <li>参加积分活动</li>
                </ol>
            </td>
        </tr>
        <tr>
            <td>积分状态</td>
        </tr>
        <tr>
            <td>
                <ul>
                    <li>可用积分：可兑换</li>
                    <li>不可用积分：可在赢单后转换为可用积分</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>积分兑换</td>
        </tr>
        <tr>
            <td>1可用积分=1元</td>
        </tr>
    </table>
</div>

</body>
</html>
</html>