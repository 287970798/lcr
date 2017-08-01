<?php
/**
 * Created by PhpStorm.
 * Author: Ren    wechat: yyloon
 * Date: 2017/7/24 0024
 * Time: 上午 9:34
 */
require dirname(__FILE__) . '/init.inc.php';

include("../../xmjz/wx-share-inc.php"); //微信分享文件

/**
在数据源拿取项目数据
 **/
$pro_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$url = "http://uniteedu.cn/xmjz/data/projects.json";
$res = http_curl($url); //解析json文件到数组
if($pro_id > count($res['projects']) - 1) {
    echo "警告：项目不存在！";
    exit();
}
$title = $res['projects'][$pro_id]['title'];
$desc = $res['projects'][$pro_id]['desc'];
$imgUrl = $res['projects'][$pro_id]['imgUrl'];
$content = $res['projects'][$pro_id]['content'];

/**
在数据源拿取资源数据
 **/
$url = "http://uniteedu.cn/xmjz/data/resource.json";
$res = http_curl($url);
// print_r($res);
$slides = $res['slides'];
$slide_str = '';
foreach ($slides as $key => $value) {
    if ($value['id'] == $pro_id) {
        foreach ($value['images'] as $k => $v) {
            $slide_str .= '<div class="swiper-slide"><img src="'.$v['src'].'" alt="" style="width: 100%"></div>'."\r\n";
        }
        $slides_cur = $value['images'];
//        print_r($slides_cur);exit;
    }
}
if (!$slide_str) {
    $slide_str .= '<div class="swiper-slide"><img src="http://uniteedu.cn/xmjz/images/nopic.jpg" alt="" style="width: 100%"></div>';
}

//files
$files = $res['files'];
$file_str = '';
foreach($files as $key => $value){
    if($value['id'] == $pro_id){
        foreach ($value['btns'] as $v){
            $file_str .= '
            <div class="row" style="padding-top: 10px;padding-bottom:10px;font-size: 16px;border-bottom: 1px solid #eee;">
                <span style="padding-left: 15px;display:inline-block;font-size: 16px;padding-top: 3px;"><img src="'.$v['icon'].'" style="width:20px;margin-right:10px;margin-top:-3px;" alt="">'.$v['title'].'</span>
                <button class="btn btn-default pull-right btn-sm" style="margin: 0 10px;border-radius:15px;color:#666;" onclick="mail(\''.$v['src'].'\',\''.$value['name'].$v['title'].'\');">推送邮件</button>
                <a class="btn btn-default pull-right btn-sm" style="margin: 0 10px;border-radius:15px;color:#666;" href="'.$v['src'].'">查看资料 </a>
            </div>
        ';
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
    <title><?php echo $title;?></title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <style>
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>
</head>
<body style="background: #FFF;">
<!-- 轮播图 -->
<div id="myCarousel" class="carousel slide hidden">
    <ol class="carousel-indicators">
        <li class="active" data-target="#myCarousel" data-slide-to="0"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active"><a href="topic/uniteedu/" target="_blank"><img src="http://uniteedu.cn/lcyx/topic/uniteedu/images/pc_b1.png" alt="2"></a></div>
        <div class="item"><a href="topic/lcrRecruit/" target="_blank"><img src="http://uniteedu.cn/lcyx/topic/lcrRecruit/images/banner.png" alt="2"></a></div>
        <div class="item"><a href="http://uniteedu.cn/xmjz/item.php?id=14" target="_blank"><img src="http://uniteedu.cn/lcyx/images/banner_ppp.png" alt="2"></a></div>
    </div>
    <a href="#myCarousel" data-slide="prev" class="carousel-control left">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a href="#myCarousel" data-slide="next" class="carousel-control right">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>


<!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php echo $slide_str;?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>

<div class="container-fluid">
    <?php echo $file_str;?>
</div>
<?php include 'tabbar.php'?>
<!-- Swiper JS -->
<script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 2500
    });

    var mailE = '<input type="text" id="email" name="email" placeholder="请输入邮箱地址" style="width: 100%;border-radius: 5px;border: 1px solid #dedede;padding: 5px;font-size: 16px;margin: 15px auto;">';
    var mail = function (url,desc) {
        weui.dialog({
            title: '推送邮件',
            content: mailE,
            className: 'custom-classname',
            buttons: [{
                label: '取消',
                type: 'default',
                onClick: function () { }
            }, {
                label: '推送',
                type: 'primary',
                onClick: function () {
                    var address = document.getElementById('email').value;
                    var flag = true;
                     ajax({
                         method : 'post',
                         url : '../../mail/recevie-data.php?project=lcr',
                         data : {
                             'email' : address,
                             'url' : url,
                             'desc' : desc
                         },
                         success : function (text) {
                             if(1 === Number(text)){
                                 weui.toast('操作成功', 3000);
                             }else if (3 === Number(text)){
                                 alert('请填写正确的邮箱地址！');
                                 document.getElementById('email').focus();
                                 flag = false;
                             }else if(2 === Number(text)){
                                 alert('发送失败！');
                             }
                         },
                         async : false
                     });
                    return flag;
                }
            }]
        });
    }

    //封装ajax
    function ajax(obj) {
        var xhr = createXHR();
        obj.url = obj.url.indexOf('?') == -1 ? obj.url + '?rand=' + Math.random() : obj.url + '&rand=' + Math.random();
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
</script>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
