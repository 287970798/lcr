<?php
session_start();
require substr(dirname(__FILE__), 0, -10).'/init.inc.php';
Validate::checkSession('agent', 'login.php');
$applyA = new ApplyAction();
$applys = $applyA->getApplyFromConsultant($_SESSION['agent']->id);
$counsultantA = new ConsultantAction();
$studentCount = $counsultantA->getSubApplysStudentsCount($_SESSION['agent']->id)->c;
$applyCount = $counsultantA->getSubApplysCount($_SESSION['agent']->id)->c;
?>
<!doctype html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>联创团管理面板</title>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/admin.css">
    <link rel="stylesheet" href="../../../../plug/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/1.1.0/weui.min.css">
    <script type="text/javascript" src="../../../../plug/weui/weui.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_PATH?>/style/weui.reset.css">
    <script src="https://cdn.bootcss.com/template_js/0.7.1/template.min.js"></script>
</head>
<body style="background: #eee">
<header class="hidden">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand logo">
                    <img src="<?php echo WEB_PATH;?>/images/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">代理商管理面板</a>
                <a href="logout.php" class="btn btn-danger btn-xs" style="display: inline-block;float: right;margin-right: 15px;margin-top: 15px;">退出</a>
            </div>
        </div>
    </nav>
</header>
<div class="topbar">
    联创团管理面板
    <a href="<?php echo WEB_PATH?>/my.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-left">返回</a>
    <a href="add.php" class="weui-btn weui-btn_mini weui-btn_plain-default topbar-btn-right hidden"><i class="glyphicon glyphicon-off""></i> 退出</a>
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
        <div class="weui-grid__icon"  style="border-radius: 50%;width: 60px; height: 60px; line-height:63px;text-align: center; background: #5eb9ff;">
            <i class="fa fa-graduation-cap" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            联创人管理
        </p>
    </a>
    <a href="<?php echo WEB_PATH;?>/admin/lct/student.php" class="weui-grid cellgrid">
        <div class="weui-grid__icon" style="border-radius: 50%;width: 60px; height: 60px; line-height:63px;text-align: center; background: #ed8d76;">
            <i class="fa fa-tasks" style="color: #fff;"></i>
        </div>
        <p class="weui-grid__label" style="color: #444;">
            学员管理
        </p>
    </a>
</div>

<!--/////////////////////////////-->
<style>
    .weui-flex__item{
        text-align: center;
        padding: 15px 5px;
        font-size: 18px;
    }
    .shortcut .weui-cell{
        font-size:15px;
    }
    .shortcut a.weui-cell{
        padding-left:20px;
    }
</style>
<div class="weui-flex" style="background-color: #fff;padding: 0px; margin: 10px auto;font-size: 18px;margin-bottom: 10px;border-bottom: 1px solid #ddd;">
<div class="weui-flex__item" style="padding-left: 20px;"><i class="fa fa-paste"></i> 联创人</div>
<div class="weui-flex__item" style="border-right: 1px solid #EEE;color: #aaa;padding-left: 0px;padding-right: 0px;"><?php echo  $applyCount ?></div>
<div class="weui-flex__item" style="padding-left: 20px;"><i class="fa fa-tasks"></i> 学员</div>
    <div class="weui-flex__item" style="color: #aaa;padding-left: 0px;padding-right: 0px;"><?php echo  $studentCount ?></div>
</div>
<!--/////////////////////////////////-->
<div class="weui-cells__title hidden"><i class="fa fa-bell"></i> 客户服务</div>
<div class="weui-cells shortcut">

    <a class="weui-cell weui-cell_access" href="tel:053188822881">
        <div class="weui-cell__hd"><span class="glyphicon glyphicon-phone"  style="width:20px;margin-right:5px;display:block"></span></div>
        <div class="weui-cell__bd">
            <p>咨询电话</p>
        </div>
        <div class="weui-cell__ft">0531-88822881</div>
    </a>
    <a class="weui-cell weui-cell_access" href="http://p.qiao.baidu.com/cps/chat?siteId=10420840&userId=23167175">
        <div class="weui-cell__hd"><span class="fa fa-commenting-o"  style="width:20px;margin-right:5px;display:block"></span></div>
        <div class="weui-cell__bd">
            <p>意见反馈</p>
        </div>
        <div class="weui-cell__ft">您的意见我们将及时改进</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;" data-toggle="modal" data-target="#help">
        <div class="weui-cell__hd"><span class="fa fa-question-circle-o"  style="width:20px;margin-right:5px;display:block"></span></div>
        <div class="weui-cell__bd">
            <p>使用帮助</p>
        </div>
        <div class="weui-cell__ft">系统功能使用帮助</div>
    </a>
</div>
<!--/////////////////////////////////-->

<div class="weui-cells__title"><span class="glyphicon glyphicon-list-alt"></span> 联创平台新闻公告 <a href="#" class="pull-right" style="color: #aaa;">查看全部 <i class="glyphicon glyphicon-chevron-right"></i></a></div>
<style>
    .gallery{

    }
</style>
<div class="weui-cells">
    <a class="weui-cell weui-cell_access" href="javascript:;" data-toggle="modal" data-target="#kaiban">
        <div class="weui-cell__bd">
            <p>【新闻】青岛创优翼9.4青岛开班</p>
        </div>
        <div class="weui-cell__ft">2017-09-02</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;"  data-toggle="modal" data-target="#agent30">
        <div class="weui-cell__bd">
            <p>【公告】联创团首批30团免费</p>
        </div>
        <div class="weui-cell__ft">2017-08-22</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;" data-toggle="modal" data-target="#gengxin">
        <div class="weui-cell__bd">
            <p>【更新】手机营销推广功能更新介绍</p>
        </div>
        <div class="weui-cell__ft">2017-08-05</div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;"  data-toggle="modal" data-target="#agent">
        <div class="weui-cell__bd">
            <p>【公告】联创团招商加盟正式启动</p>
        </div>
        <div class="weui-cell__ft">2017-08-01</div>
    </a>

</div>
<!--/////////////////////////////////-->
<div class="container table-responsive hidden" style="padding: 0;">

    <table class="table table-hover table-bordered table-striped">
        <thead>
        <tr>
            <th>姓名</th>
            <th>手机</th>
            <th>注册时间</th>
            <th>推荐人</th>
            <th>备注</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($applys){
                foreach ($applys as $apply){
                    echo '<tr>
                            <td><a href="detail.php?id='.$apply->id.'">'.$apply->name.'</a></td>
                            <td>'.$apply->phone.'</td>
                            <td>'.date('Y-m-d', strtotime($apply->apply_time)).'</td>
                            <td>'.$apply->parentName.'</td>
                            <td>'.$apply->note.'</td>
                          </tr>';
                }
            }else{
                echo '<tr>
                        <td colspan="5">无数据</td>
                      </tr>';
            }
        ?>


        </tbody>
    </table>
</div>

<!--/////////////////////////////////-->
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
                                2.当联创人推荐学员报名后，推荐人的锁定积分转为可用积分。
                            </p>
                        </section>
                        <section>
                            <h3>积分相关</h3>
                            <p>
                                1.新增学员、参加积分活动可积分获得积分。
                            </p>
                            <p>
                                2.可用积分可对兑换现金。
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
<!--模板渲染输出-->
<div id="result"></div>
<!--//模板渲染输出-->
<!--模板片段-->
<script id="tpl" type="text/html">
<%for (var i in newsData) {%>
<div class="modal fade" id="<%=newsData[i].id%>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><%=newsData[i].title%></h4>
            </div>
            <div class="modal-body" style="padding-top: 0;">
                <%if (newsData[i].topText){%>
                <p><%:=newsData[i].topText%></p>
                <%}%>
                <%if (newsData[i].img){%>
                    <img src="<%=newsData[i].img%>" class="img-responsive">
                <%}%>
                <%if (newsData[i].bottomText){%>
                    <p><%=newsData[i].bottomText%></p>
                <%}%>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<%}%>
</script>
<!--//模板片段-->
<?php include_once ROOT_PATH."/tabbar.php"?>
<script>
    //模板数据
    var newsData = {
        agent30 : {
            id : 'agent30',    // 模态框ID
            title : '【公告】联创团首批30团免费', //标题
            img : '<?=WEB_PATH . "/images/agent30.png"?>',   //图片URL
            topText : '',   //文字内容
            bottomText: ''
        },
        agent : {
            id : 'agent',    // 模态框ID
            title : '【公告】联创团招商加盟正式启动', //标题
            img : '<?=WEB_PATH . "/../topic/agent/images/agent.png"?>',   //图片URL
            topText : '',   //文字内容
            bottomText: ''
        },
        kaiban : {
            id : 'kaiban',    // 模态框ID
            title : '开班详情', //标题
            img : '<?=WEB_PATH . "/images/kaiban.png"?>',   //图片URL
            topText : '',   //文字内容
            bottomText: ''
        },
        gengxin : {
            id : 'gengxin',    // 模态框ID
            title : '功能更新', //标题
            img : '<?=WEB_PATH . "/images/gengxin.gif"?>',   //图片URL
            topText : '平台新增功能：<br>1.项目资料实时更新。<br>2.项目资料一键转发。',   //文字内容
            bottomText: ''
        }
    };
    template.config("escape", true);
    //模板内容
    var tpl = document.getElementById('tpl').innerHTML;
    //渲染
    var result = template(tpl, newsData);
    //写入
    document.getElementById('result').innerHTML = result;
</script>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>