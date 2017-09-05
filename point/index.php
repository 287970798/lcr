<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/10 0010
 * Time: 下午 2:04
 */
session_start();
//$_SESSION['apply_id'] = 3;
require substr(dirname(__FILE__), 0, -6) . '/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$pointA = new PointAction();
$point = $pointA->getPoint();
$streamA = new PointStreamAction();
$streams = $streamA->getOwnStreams();

$nav = 'point';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>积分管理</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <script type="text/javascript" src="../../../plug/weui/weui.min.js"></script>
    <style>
        .point-type{
            /*display: inline-block;*/
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            border-radius: 50%;
            font-size: 12px;
            background-color: #09bb07;
            color: #FFF;
            float: left;
        }
        .point-value{
            margin-left: 15px;
            /*display: inline-block;*/
            height: 25px;
            line-height: 25px;
            font-size:20px;
            float: left;
            color: #09bb07;
        }
        .point-type-2{
            background-color: #f0ad4e;
        }
        .point-value-2{
            color: orange;
        }

        #pointDesc{
            text-align: left;
        }
        #pointDesc ol,ul{
            list-style: inside;
            list-style-type: none;
        }
        #pointDesc li{
            font-size: 16px;
        }
        #pointDesc h4{
            margin-top: 25px;
        }

        .panel-body ul,.panel-body ol{
            list-style-type: none;
        }

    </style>
</head>
<body>
<?php
//    include '../header.php';
?>
<div id="pointDescBox" class="hidden">
    <div id="pointDesc" class="">
        <h4><span class="label label-success">积分获得</span></h4>
        <ol type="1">
            <li>1、新增学员</li>
            <li>2、参加积分活动</li>
        </ol>
        <h4><span class="label label-success">积分状态</span></h4>
        <ul>
            <li>可用积分：可兑换</li>
            <li>不可用积分：可在赢单后转换为可用积分</li>
        </ul>
        <h4><span class="label label-success">积分兑换</span></h4>
        <ul>
            <li>1可用积分=1元</li>
        </ul>
        <a href="../project" class="weui-btn weui-btn_mini weui-btn_primary center-block" style="margin-top: 15px;">查看项目积分</a>
    </div>


</div>
<div class="topbar">
    积分明细
    <a href="../my.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left"><i class="fa fa-mail-reply"></i> 返回</a>
    <a href="javascript:;" onclick="weui.alert(document.getElementById('pointDescBox').innerHTML, {title:'积分说明'});"><img src="<?php echo WEB_PATH;?>/images/weui/icon_intro.png" alt="" style="width: 15px;margin-top: -3px;"></a>
    <a href="account.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden" "><i class="fa fa-money"></i> 兑换</a>
</div>
<div class="weui-grids">
    <a href="../project" class="weui-grid">
        <div class="weui-grid__icon" style="color: #5eb9ff;">
            <i class="fa fa-cubes"></i>
        </div>
        <p class="weui-grid__label">
            项目积分
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: #09bb07;">
            <i class="fa fa-unlock"></i>
        </div>
        <p class="weui-grid__label">
            可用积分 <span id="availablePoint"><?php echo $point->availablePoint;?></span>
        </p>
    </a>
    <a href="javascript:;" class="weui-grid">
        <div class="weui-grid__icon" style="color: orange;">
            <i class="fa fa-lock"></i>
        </div>
        <p class="weui-grid__label">
            锁定积分 <?php echo $point->unavailablePoint;?>
        </p>
    </a>
</div>
<!--////////////////////////-->
<div class="container-fluid" style="background: #FFF;padding-bottom: 15px;padding-top: 15px;margin-bottom: 15px;border-bottom: 1px solid #d9d9d9;">
    <a href="javascript:;" id="exchange" class="btn btn-success btn-lg center-block" style="width: 90%;background-color: #5eb9ff;border-color: #5eb9ff;"><i class="fa fa-money"></i> 积分兑换</a>
</div>
<!--////////////////////////-->
<div class="weui-cells__title">积分明细</div>
<div class="weui-cells">
<?php
if (!empty($streams)){
    foreach ($streams as $stream) {
        ?>

            <a class="weui-cell weui-cell_access" href="javascript:;" onclick="weui.alert('<?php echo $stream->description;?>',{title:'积分明细详情'});">
                <div class="weui-cell__bd">
                    <p style="font-size: 15px;color: #666;">
                        <?php
                        if($stream->briefDesc && false){
                            echo mb_substr($stream->briefDesc, 0, 18,'utf8');
                        } else {
                            //提取简短描述
                            $descA = $descU = '';
                            if (preg_match('/[^不]可用积分\s*([\+\-]\d+)/', $stream->description, $m)){
//                                $descA ='<h4 style="display: inline-block;margin: 0;padding: 0;"><i class="label label-success" style="font-style: normal;font-weight: normal;">可用&nbsp;&nbsp;'.$m[1].'</i></h4>&nbsp;&nbsp;';
                                $descA = '<div class="point-type"><i class="fa fa-unlock"></i></div><div class="point-value">'.$m[1].'</div>';
                            };
                            if (preg_match('/不可用积分\s*([\+\-]\d+)/', $stream->description, $m2)){
//                                $descU ='<h4 style="display: inline-block;margin: 0;padding: 0;"><i class="label label-warning" style="font-style: normal;font-weight: normal;">不可用&nbsp;&nbsp;'.$m2[1].'</i></h4>';
                                $descU = '<div class="point-type point-type-2"><i class="fa fa-lock"></i></div><div class="point-value point-value-2">'.$m2[1].'</div>';
                            };
//                            echo mb_substr($desc, 0, -1, 'utf-8');
                            echo $descA ? $descA : $descU;
                        }
                        ?>
                    </p>
                </div>
                <div class="weui-cell__ft">
                    <?php echo $stream->ctime?>
                </div>
            </a>

        <?php
    }
}
?>
</div>
<?php include ROOT_PATH.'/tabbar.php';?>
<script src="https://cdn.bootcss.com/jquery/3.2.0/jquery.min.js"></script>
<script>
    $('#exchange').click(function () {
        var data = {
            'apply_id' : '<?=@$_SESSION['apply_id']?>'
        };
        $.ajax({
            url : 'http://uniteedu.cn/work/public/lcr/exchange/checkAccountAndExchange',
            type : 'get',
            data : data
        }).done(function (result) {
            console.log(result);
            if (result.code == 4004) {
                location.href = 'http://uniteedu.cn/lcyx/lcr/point/account.php';
            } else if (result.code == 4002) {
                weui.toast(result.msg);
            } else if (result.code == 2004) {
                location.href = 'http://uniteedu.cn/lcyx/lcr/point/exchange.php';
            }
        }).fail(function (error) {
            console.log(error.statusText);
        });
    });
</script>
<script>
    //查询已消耗积分
    var data = {
        apply_id : <?=$_SESSION['apply_id'];?>
    }
    $.ajax({
        url: "http://uniteedu.cn/work/public/lcr/exchange/exchangesum",
        type: 'get',
        data: data
    }).done(function(result){
        var availablePoint = <?= @$point->availablePoint;?> - parseInt(result);
        $("#availablePoint").html(availablePoint);
        console.log(result);
    }).fail(function(err){
        console.log(err);
    });
</script>
</body>
</html>