<?php
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) Tool::alertBack('警告：非法操作！getQrcode');
$apply = new ApplyAction();
$object = $apply->show();
if (empty($object)) Tool::alertBack('警告：不存在此联创人！');
include ROOT_PATH.'/includes/wx-share-inc.php';
$title = $object->name . '推荐你加入联创人';
$desc = '联合天下人，创享优质教育资源！';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>二维码</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../style/admin.css">
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        wx.config({
            debug: false,
            appId: '<?php echo $appId;?>',
            timestamp: '<?php echo $timestamp;?>',
            nonceStr: '<?php echo $nonceStr;?>',
            signature: '<?php echo $signature;?>',
            jsApiList: ["onMenuShareAppMessage","onMenuShareTimeline"]
        });
    </script>
</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="../images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#"><?php echo $object->name;?>的专属推荐二维码</a>
            </div>
            <div class="collapse navbar-collapse pull-right" id="example-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="tel:<?php echo TEL;?>"><span class="glyphicon glyphicon-phone-alt"></span> 电话咨询</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container">
    <div class="thumbnail">
        <img src="<?php echo $object->wx_headimgurl;?>" alt="" class="img-circle" style="width: 100px; height: 100px; margin-top: 20px;">
        <div class="caption">
            <p class="text-center" style="margin-bottom: 0;"><?php echo $object->wx_nickname;?></p>
        </div>

        <img src="..\qrcode.php?id=<?php echo $object->id;?>" alt="">
        <div class="caption">
            <p class="text-center"><?php echo $object->name;?>的专属二维码，通过扫此二维码加入联创人即可获取海量优质教育资源。有疑问请点击拨打 <a href="tel:4000532050" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-headphones"></span> 客服电话</a></p>
        </div>
    </div>

</div>
<?php include_once ROOT_PATH."/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    wx.ready(function() {
        wx.onMenuShareAppMessage({

            title: '<?php echo $title ?> - 山东联创优学',
            desc: '<?php echo $desc ?>',
            link: 'http://uniteedu.cn/lcyx/lcr/getQrcode/getQrcode.php?id=<?php echo $object->id;?>',
            imgUrl: 'http://uniteedu.cn/lcyx/lcr/images/share_img.png',
            type: 'link',
            dataUrl: '',
            success: function() {},
            cancel: function() {}

        });
        wx.onMenuShareTimeline({
            title: '<?php echo $title ?> - 山东联创优学',
            link: 'http://uniteedu.cn/lcyx/lcr/getQrcode/getQrcode.php?id=<?php echo $object->id;?>',
            imgUrl: 'http://uniteedu.cn/lcyx/lcr/images/share_img.png',
            success: function () {},
            cancel: function () {}
        });

    });
    wx.error(function(res){});
</script>
</body>
</html>