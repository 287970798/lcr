<?php
session_start();
if ($_SESSION['apply_id'] == 3) {
//    if (isset($_SESSION['apply_id'])) {
//        unset($_SESSION['apply_id']);
//        session_destroy();
//    }
    $_SESSION['apply_id'] = 406;
}

require dirname(__FILE__) . '/init.inc.php';
Validate::checkSession('apply_id', WEB_PATH.'/login.php');
$apply_id = $_SESSION['apply_id'];
$_GET['id'] = $apply_id;
$apply = new ApplyAction();

//权限：是否为优学顾问/////////////////////////////////
$one = $apply->getOne(null,$_SESSION['apply_id']);
$consultant = new ConsultantAction();
$oneConsultant = $consultant->one('phone',$one->phone);
////////////////////////////////////////////////////

$object = $apply->show();
if (empty($object)) Tool::alertBack('警告：不存在此联创人！');

//获取学员、联创人、积分等总数
$indexA = new IndexAction();
$countO = $indexA->getCount();

//获取优学顾问
if ($object->consultantId){
    $consultantA = new ConsultantAction();
    $_GET['id'] = $object->consultantId;
    $consultant = $consultantA->getOne();
}

//联创人是否为优学顾问及优学顾问主管（代理商）
$consultantM = new ConsultantModel();
$consultantM->name = $object->name;
$consultantM->phone = $object->phone;
$objectC = $consultantM->getOneFromNameAndPhone();
$isAgent = false;
if (!empty($objectC)) {
    $isAgent = $objectC->isAgent;
    if ($isAgent) {
        $_SESSION['agent'] = $objectC;
    } elseif($objectC->is_manager) {
        // 获取团长信息
        $consultantM->id = $objectC->pid;
        $leader = $consultantM->getOne();
        if ($leader->isAgent){
            $isAgent = $leader->isAgent;
            $_SESSION['agent'] = $leader;
            $_SESSION['is_manager'] = true;
        }
    }
};

$nav = 'index';
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
    <link rel="stylesheet" href="../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <style>
        #help h3{
            font-weight: bold;
        }
        .tips
        {
            margin:30px;
            width:110px;
            height:30px;
            line-height:30px;
            text-align:center;
            background-color:#9bd5ff;
            position:absolute;
            left:-55px;
            top:-20px;
            font-size:12px;
            font-weight: normal;
            /* Rotate div */
            transform:rotate(320deg);
            -ms-transform:rotate(320deg); /* Internet Explorer */
            -moz-transform:rotate(320deg); /* Firefox */
            -webkit-transform:rotate(320deg); /* Safari 和 Chrome */
            -o-transform:rotate(320deg); /* Opera */
        }
    </style>
</head>
<body>

<div id="service" class="hidden">
    <?php
        if (!empty($consultant)) {
            echo "姓名： {$consultant->name}<br>手机号：{$consultant->phone}<br><a href='tel:{$consultant->phone}' class='btn btn-warning center-block' style='margin-top: 10px;'>一键拨打 <i class='fa fa-phone'></i></a>";
            echo "<p style='margin-top: 20px;font-size:11px;height: 15px;line-height: 15px;'>技术问题/投诉建议，拨打 <a href='tel:4000532050' class='btn btn-default btn-xs''><span class='glyphicon glyphicon-headphones'></span> 客服电话</a></p>";
        } else {
            echo '暂未分配顾问';
            echo "<p style='margin-top: 20px;font-size:11px;height: 15px;line-height: 15px;'>技术问题/投诉建议，拨打 <a href='tel:4000532050' class='btn btn-default btn-xs''><span class='glyphicon glyphicon-headphones'></span> 客服电话</a></p>";
        }
    ?>
</div>
<!--<a style="position: absolute; top: 5px;right: 5px; color: #FFF;" href="javascript:;" onclick="weui.alert(document.getElementById('help').innerHTML, {title:'帮助'});"><i class="fa fa-question-circle-o"></i> 帮助</a>-->
<a style="position: absolute; top: 5px;right: 0px; color: #FFF; background: #9bd5ff;padding: 1px 5px 1px 10px;border-top-left-radius: 15px;border-bottom-left-radius: 15px;" href="javascript:;" data-toggle="modal" data-target="#help"><i class="fa fa-question-circle-o"></i> 帮助</a>
<a style="z-index: 999;position: absolute; top: 85px;right: 0px; color: #FFF; text-align: center;border: none; background: #9bd5ff;font-size: 10px;padding: 5px 5px 5px 15px;border-radius:0;border-top-left-radius: 30px;border-bottom-left-radius: 30px;overflow: hidden" class="btn" href="javascript:;" onclick="weui.alert(document.getElementById('service').innerHTML,{title:'优学顾问'});" >
    <h5 style="margin: 0 auto 5px; font-size: 20px;"><i class="fa fa-user-circle-o"></i></h5>
    <span class="label label-warning">优学顾问</span>
</a>
<?php if ($isAgent){?>
<!--<a style="position: absolute; top: 40px;right: 0px; color: #FFF; background: #9bd5ff;padding: 1px 5px 1px 10px;border-top-left-radius: 15px;border-bottom-left-radius: 15px;" href="--><?php //echo WEB_PATH;?><!--/admin/consultantPanel/indexAdmin.php"><i class="fa fa-gear"></i> 管理</a>-->
<?php }?>
<div class="container-fluid" style="padding: 0 0 20px 0; color: #FFF;background:#5eb9ff url(images/arrow.png) repeat-x bottom;background-size: 5px; ">
    <img src="<?php echo $object->wx_headimgurl;?>" alt="" class="img-circle center-block" style="width: 100px; height: 100px; margin-top: 20px;z-index: 1!important;position: relative;">
<!--    <div style="width: 100px; height: 50px; border-bottom: 5px solid #f0ad4e; border-bottom-left-radius: 100px; border-bottom-right-radius: 100px; background:transparent; z-index: 99999; margin-top: -50px;text-align: center;line-height: 60px;position: relative;color:#f0ad4e;font-weight: bold;" class="center-block">代理商</div>-->
    <div class="text-center"><?php echo $object->wx_nickname;?></div>
    <?php if ($isAgent){?>
    <div class="tips"><span class="glyphicon glyphicon-fire"></span> 联创团</div>
    <?php }?>
</div>
<div class="weui-grids mygrid" style="background-color: #fff; padding-top: 20px; margin-bottom: 10px; letter-spacing: 1px;margin-top: -1px;">
    <a href="<?php echo WEB_PATH;?>/point" class="weui-grid" style="width: 50%;">
        <div class="weui-grid__icon" style="color: #ff8265; width: 100%; text-align: center;font-size: 25px;letter-spacing: normal;">
            <?php echo @$countO->point;?>
        </div>
        <p class="weui-grid__label" style="color: #555;font-size: 14px;">
            全部积分
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/point" class="weui-grid cellgrid" style="width: 50%;letter-spacing: normal;">
        <div class="weui-grid__icon" id="availablePoint"  style="color: #ff8265; width: 100%; text-align: center;font-size: 25px;letter-spacing: normal;">
            <?php echo @$countO->availablePoint;?>
        </div>
        <p class="weui-grid__label" style="color: #555;font-size: 14px;">
            可用积分
        </p>
    </a>
</div>

<div class="hidden" style="border-bottom:1px solid #d9d9d9;background: #fff;margin-top: 15px;padding: 5px 10px;color: #999; letter-spacing: 1px;">快捷操作</div>
<div class="weui-grids mygrid" style="background-color: #fff; margin-bottom: 10px; letter-spacing: 1px;">
    <a href="<?php echo WEB_PATH;?>/student/add.php" class="weui-grid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:60px;text-align: center; background: #6cc76f;">
            <i class="fa fa-user-plus" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            学员报名
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/student/" class="weui-grid">
        <div class="weui-grid__icon"  style="border-radius: 50%;width: 60px; height: 60px; line-height:63px;text-align: center; background: #5eb9ff;">
            <i class="fa fa-graduation-cap" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            全部学员
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/project/" class="weui-grid cellgrid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:63px;text-align: center; background: #ed8d76;">
            <i class="fa fa-tasks" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            项目积分
        </p>
    </a>
</div>
<?php if ($isAgent){?>
<div class="container-fluid" style="background: #FFF;padding-bottom: 15px;padding-top: 15px;margin-bottom: 15px;border-bottom: 1px solid #d9d9d9;">
    <a href="<?php echo WEB_PATH;?>/admin/lct/" class="btn btn-success btn-lg center-block" style="width: 90%;background-color: #5eb9ff;border-color: #5eb9ff;"><i class="fa fa-group"></i> 联创团管理入口</a>
</div>
<?php }?>

<?php if ($oneConsultant) { ?>
    <style>
        .project .weui-flex__item {
            background: #9bbb59;
            margin: 5px;
            border-radius: 5px;
            text-align: center;
            color: #FFF;
            padding: 10px;
            font-size: 13px;
            line-height: 18px;
        }

        .project1 .weui-flex__item {
            background-color: #9bbb59;
        }

        .project2 .weui-flex__item {
            background-color: #4f81bd;
        }

        .project3 .weui-flex__item {
            background-color: #f79646;
        }
    </style>

    <div class="container-fluid text-center text-muted hidden" style="background-color: #fff;color: #999;">
        <h4 class="h4">项目资料</h4>
    </div>
    <div class="weui-cells__title"><span class="glyphicon glyphicon-list-alt"></span> 项目资料 <a href="#" class="pull-right hidden" style="color: #aaa;">查看全部 <i class="glyphicon glyphicon-chevron-right"></i></a></div>
    <div class="container-fluid" style="background-color: #fff;padding-top:15px;padding-bottom:15px;">
        <div style="width: 100%;height: 0px;border-top:1px solid #000;text-align: center;margin: 20px auto;">
            <span
                style="background:#fff;text-align: center;padding: 0 15px;position: relative;top: -12px;">在职硕士/博士</span>
        </div>
        <div class="weui-flex project project1">
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=1'">长安大学MPA</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=18'">长安大学MBA</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=4'">武汉工程MBA</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=15'">武汉理工MPAcc</div>
        </div>

        <div class="weui-flex project project1">
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=16'">武汉工程同等学力</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=20'">西安建筑MBA</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=0'">吉林大学博士</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=19'">联考助手</div>
        </div>
    </div>

    <div class="container-fluid" style="background-color: #fff;padding-top:15px;padding-bottom:15px;">
        <div style="width: 100%;height: 0px;border-top:1px solid #000;text-align: center;margin: 20px auto;">
            <span
                style="background:#fff;text-align: center;padding: 0 15px;position: relative;top: -12px;">专升本/UI设计</span>
        </div>
        <div class="weui-flex project project2">
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=8'">武汉理工项目管理</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=17'">武汉理工视觉传达</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=5'">UI设计师培训</div>
            <div class="weui-flex__item">即将推出</div>
        </div>
    </div>

    <div class="container-fluid"
         style="background-color: #fff;padding-top:15px;padding-bottom:15px;margin-bottom: 15px;">
        <div style="width: 100%;height: 0px;border-top:1px solid #000;text-align: center;margin: 20px auto;">
            <span style="background:#fff;text-align: center;padding: 0 15px;position: relative;top: -12px;">出国留学</span>
        </div>
        <div class="weui-flex project project3">
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=6'">泰国暹罗大学</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=23'">曼谷北部大学</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=24'">曼谷皇家理工</div>
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=25'">格林威尔大学</div>
        </div>

        <div class="weui-flex project project3">
            <div class="weui-flex__item" onclick="location.href='project-item.php?id=26'">美国圣彼得大学</div>
            <div class="weui-flex__item">即将推出</div>
            <div class="weui-flex__item" style="opacity: 0;"></div>
            <div class="weui-flex__item" style="opacity: 0;"></div>
        </div>
    </div>
    <?php
}else {
    ?>
    <div class="container-fluid" style="background: #FFF;padding-bottom: 10px;">
        <div style="background: #fff;padding: 5px 10px;color: #999; letter-spacing: 1px;text-align: center">热门专题</div>
        <a href="http://uniteedu.cn/xmjz/item.php?id=13"><img src="http://uniteedu.cn/yxh/images/yxh_ui_qd.png" alt=""
                                                              style="width: 100%;margin-bottom: 10px"></a>
        <a href="http://uniteedu.cn/xmjz/?id=8"><img src="<?php echo WEB_PATH; ?>/images/whlg_zsb_ad.png" alt=""
                                                     style="width: 100%;margin-bottom: 10px"></a>
    </div>

    <div class="container-fluid hidden" style="background: #FFF;margin-bottom: 15px;padding: 0px 0 10px 0;">
        <div class="hidden"
             style="background: #fff;padding: 5px 10px;color: #999; letter-spacing: 1px;text-align: center">热门专题
        </div>
        <a href="http://uniteedu.cn/xmjz/item.php?id=13"><img src="<?php echo WEB_PATH; ?>/images/ad.png" alt=""
                                                              style="width: 100%;margin-bottom: 10px"></a>
        <div class="text-center text-warning" style="font-size: 13px;">立即查看</div>
    </div>
    <?php
}
?>
<?php include 'tabbar.php'?>

<!--///////////////////////////////////// modal -->
<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">帮助</h4>
            </div>
            <div class="modal-body" style="padding-top: 0;">
                <article class="weui-article" style="padding: 0;">
                    <section>
                        <section>
                            <h3>服务相关</h3>
                            <p>
                                1.在服务中心里点击“我的优学顾问”，可查看您的专属服务人员信息。
                            </p>
                            <p>
                                2.您有任何教育相关问题及平台使用问题都可以进行沟通咨询。
                            </p>
                        </section>
                        <section>
                            <h3>项目相关</h3>
                            <p>
                                1.平台将不断丰富项目内容，每月增加新项目
                            </p>
                            <p>
                                2.点击“项目积分”按钮可以查看项目积分、简介、简章等信息
                            </p>
                            <p>
                                3.通过公众号“优学汇”按钮查看全部项目简章
                            </p>
                        </section>
                        <section>
                            <h3>学员报名</h3>
                            <p>
                                1.学员模块，点击右上角“新增”，提交学院信息，将获得相应锁定积分。
                            </p>
                            <p>
                                2.客服向提交人确认信息后，将对学员进行后续服务，学员完成报名交费后，积 分转为可用积分。
                            </p>
                        </section>
                        <section>
                            <h3>联创人推广</h3>
                            <p>
                                1.点击右下角“推广”，分享你的专属二维码给好友。
                            </p>
                            <p>
                                2.好友扫码并提交申请后，推荐人将获得300锁定积分。
                            </p>
                            <p>
                                3.当联创人推荐学员报名后，推荐人的锁定积分转为可用积分。
                            </p>
                        </section>
                        <section>
                            <h3>积分相关</h3>
                            <p>
                                1.新增学员、新增联创人、参加积分活动可积分获得积分。
                            </p>
                            <p>
                                2.可用积分可对兑换现金或商品，5个工作日内兑换完成。
                            </p>
                        </section>
                    </section>
                </article>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div id="help" class="hidden">
    <div style="text-align: left;">

        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapseOne">
                            服务相关
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <article class="weui-article" style="padding: 0;font-size:12px;">
                            <section>
                                <section>
                                    <h3>服务相关</h3>
                                    <p>
                                        1.在服务中心里点击“我的优学顾问”，可查看您的专属服务人员信息。
                                    </p>
                                    <p>
                                        2.您有任何教育相关问题及平台使用问题都可以进行沟通咨询。
                                    </p>
                                </section>
                            </section>
                        </article>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwo">
                            服务相关
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-body">
                            <article class="weui-article" style="padding: 0;font-size:12px;">
                                <section>
                                    <section>
                                        <h3>服务相关</h3>
                                        <p>
                                            1.在服务中心里点击“我的优学顾问”，可查看您的专属服务人员信息。
                                        </p>
                                        <p>
                                            2.您有任何教育相关问题及平台使用问题都可以进行沟通咨询。
                                        </p>
                                    </section>
                                </section>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion"
                           href="#collapseThree">
                            服务相关
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-body">
                            <article class="weui-article" style="padding: 0;font-size:12px;">
                                <section>
                                    <section>
                                        <h3>服务相关</h3>
                                        <p>
                                            1.在服务中心里点击“我的优学顾问”，可查看您的专属服务人员信息。
                                        </p>
                                        <p>
                                            2.您有任何教育相关问题及平台使用问题都可以进行沟通咨询。
                                        </p>
                                    </section>
                                </section>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <article class="weui-article hidden" style="padding: 0;font-size:12px;">
            <section>
                <section>
                    <h3>服务相关</h3>
                    <p>
                        1.在服务中心里点击“我的优学顾问”，可查看您的专属服务人员信息。
                    </p>
                    <p>
                        2.您有任何教育相关问题及平台使用问题都可以进行沟通咨询。
                    </p>
                </section>
                <section>
                    <h3>项目相关</h3>
                    <p>
                        1.平台将不断丰富项目内容，每月增加新项目
                    </p>
                    <p>
                        2.点击“项目积分”按钮可以查看项目积分、简介、简章等信息
                    </p>
                    <p>
                        3.通过公众号“优学汇”按钮查看全部项目简章
                    </p>
                </section>
                <section>
                    <h3>学员报名</h3>
                    <p>
                        1.学员模块，点击右上角“新增”，提交学院信息，将获得相应锁定积分。
                    </p>
                    <p>
                        2.客服向提交人确认信息后，将对学员进行后续服务，学员完成报名交费后，积 分转为可用积分。
                    </p>
                </section>
                <section>
                    <h3>联创人推广</h3>
                    <p>
                        1.点击右下角“推广”，分享你的专属二维码给好友。
                    </p>
                </section>
                <section>
                    <h3>积分相关</h3>
                    <p>
                        1.新增学员、参加积分活动可积分获得积分。
                    </p>
                    <p>
                        2.可用积分可对兑换现金或商品，5个工作日内兑换完成。
                    </p>
                </section>
            </section>
        </article>
    </div>
</div>
<!--/////////////////////////////////////-->

<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
        var availablePoint = <?= @$countO->availablePoint;?> - parseInt(result);
        $("#availablePoint").html(availablePoint);
        console.log(result);
    }).fail(function(err){
        console.log(err);
    });
</script>
</body>
</html>
</html>
