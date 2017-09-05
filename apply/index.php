<?php
    require substr(dirname(__FILE__), 0, -5)."init.inc.php";
    //增加微信登陆 获取微信信息//////////////////
    $wx = new WXLogin('http://uniteedu.cn/lcyx/lcr/apply');
    ////////////////////
    if (!isset($_SESSION['wx'])) {
        exit('微信内部错误');
    }
    if (isset($_POST['type']) && $_POST['type'] == 'check'){
        $applyModel = new ApplyModel();
        $applyModel->phone = $_POST['phone'];
        $object = $applyModel->getOneApplyFromPhone();
        if (!empty($object)) {
            exit('f');
        }else{
            exit('t');
        }
    }
    if(isset($_POST['submit'])){
        $applyModel = new ApplyModel();
        if ($_POST['parent_id']){
            $applyModel->parent_id = $_POST['parent_id'];
            //获取上级推荐人作为默认服务人员
            $applyModel->id = $_POST['parent_id'];
            $parent =  $applyModel->getOneApply();
//            $applyModel->serviceName = $defaultService->servicPhone=='' ? $defaultService->name : $defaultService->serviceName;
//            $applyModel->servicePhone = $defaultService->servicPhone=='' ? $defaultService->name : $defaultService->servicePhone;
            //消息模板参数
            $from = $parent->name . '推荐';
        }else{
            $from = '系统添加';
        }
        $applyModel->name = $_POST['name'];
        $applyModel->phone = $_POST['phone'];
        $object = $applyModel->getOneApplyFromPhone();
        if (!empty($object)) {
            Tool::alertBack('您已提交过注册，请不要重复提交！');
            exit;
        }
        $applyModel->wechat = $_POST['wechat'];
        //微信帐号信息/////////////////////////////////////////////////////////
        $applyModel->openid = $_SESSION['wx']['openid'];
        $applyModel->wx_nickname = $_SESSION['wx']['nickname'];
        $applyModel->wx_sex = $_SESSION['wx']['sex'];
        $applyModel->wx_headimgurl = $_SESSION['wx']['headimgurl'];
        $applyModel->wx_province = $_SESSION['wx']['province'];
        $applyModel->wx_city = $_SESSION['wx']['city'];
        $applyModel->wx_country = $_SESSION['wx']['country'];
        //////////////////////////////////////////////////////////
        $applyModel->addApply();
        //模板消息数组
        $postArr1 = array(
            'touser'=>'oQiyJv25QmnHceul56pHMmXkpAmg',
            'template_id'=>'BPVhllnINd5nJQy8P01f-Zg0knXC4K4TfJR2ZWtAIWI',
            'data'=>array(
                'first'=>array(
                    'value'=>'有新的用户提交了注册加入联创人', 'color'=>'#173177'
                ),
                'keyword1'=>array(
                    'value'=>$applyModel->name, 'color'=>'#173177'
                ),
                'keyword2'=>array(
                    'value'=>$applyModel->phone, 'color'=>'#173177'
                ),
                'keyword3'=>array(
                    'value'=>$from, 'color'=>'#173177'
                )
            )
        );
        $postArr2 = array(
            'touser'=>'oQiyJvwCM_DIPw2g9LPWiwkqUYSw',
            'template_id'=>'BPVhllnINd5nJQy8P01f-Zg0knXC4K4TfJR2ZWtAIWI',
            'data'=>array(
                'first'=>array(
                    'value'=>'有新的用户提交了注册加入联创人', 'color'=>'#173177'
                ),
                'keyword1'=>array(
                    'value'=>$applyModel->name, 'color'=>'#173177'
                ),
                'keyword2'=>array(
                    'value'=>$applyModel->phone, 'color'=>'#173177'
                ),
                'keyword3'=>array(
                    'value'=>$from, 'color'=>'#173177'
                )
            )
        );
        $postArr3 = array(
            'touser'=>'oQiyJvywfXZKCUoTPkWbQR-rJatY',
            'template_id'=>'BPVhllnINd5nJQy8P01f-Zg0knXC4K4TfJR2ZWtAIWI',
            'data'=>array(
                'first'=>array(
                    'value'=>'有新的用户提交了注册加入联创人', 'color'=>'#173177'
                ),
                'keyword1'=>array(
                    'value'=>$applyModel->name, 'color'=>'#173177'
                ),
                'keyword2'=>array(
                    'value'=>$applyModel->phone, 'color'=>'#173177'
                ),
                'keyword3'=>array(
                    'value'=>$from, 'color'=>'#173177'
                )
            )
        );
        new WXTemplateMsg($postArr1);
        new WXTemplateMsg($postArr2);
        new WXTemplateMsg($postArr3);
        //////////////////////////////////
        if(isset($parent)){
            $postArr4 = array(
                'touser'=>$parent->openid,
                'template_id'=>'BPVhllnINd5nJQy8P01f-Zg0knXC4K4TfJR2ZWtAIWI',
                'data'=>array(
                    'first'=>array(
                        'value'=>'您推荐的用户提交了注册加入联创人', 'color'=>'#173177'
                    ),
                    'keyword1'=>array(
                        'value'=>$applyModel->name, 'color'=>'#173177'
                    ),
                    'keyword2'=>array(
                        'value'=>$applyModel->phone, 'color'=>'#173177'
                    ),
                    'keyword3'=>array(
                        'value'=>$from, 'color'=>'#173177'
                    )
                )
            );
            new WXTemplateMsg($postArr4);
        }
        /////////////////////////////////
        header('Location:answer.php');
    }
    $nav = '注册联创人';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
    <script type="text/javascript" src="../js/common.js"></script>
    <script type="text/javascript" src="../js/apply.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>

<?php include ROOT_PATH.'/header.php'?>

<div class="container">
    <img src="../images/apply1.jpg" alt="" class="img-responsive center-block" style="padding: 15px 0;">
    <form id="applyForm" role="form" method="post" action="">
        <input type="hidden" name="parent_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : 0; ?>">
        <div class="form-group">
            <label for="name">姓名 <span class="text-danger">*</span></label>
            <input type="text" class="form-control input-lg" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="phone">手机号 <span class="text-danger">*</span></label>
            <input type="text" class="form-control input-lg" name="phone" id="phone">
        </div>
        <div class="form-group">
            <label for="vcode" style="display: block">验证码 <span class="text-danger">*</span></label>
            <input type="text" class="form-control input-lg" name="vcode" id="vcode" style="width: 50%;display: inline-block;">
            <button class="btn btn-default btn-lg" style="display: inline-block" id="getVcode">获取验证码</button>
        </div>
        <!---->
        <label for="i1">联创人需要做什么？</label>
        <div class="form-group">
            <div class="checkbox">
                <label><input type="checkbox" checked name="i1" style="margin-top: 0px;"> A、充分了解项目</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" checked name="i1" style="margin-top: 0px;"> B、分享项目给身边朋友</label>
            </div>
        </div>
        <label for="i1">联创人可以得到什么？</label>
        <div class="form-group">
            <div class="checkbox">
                <label><input type="checkbox" checked name="i1" style="margin-top: 0px;"> A、成为身边朋友的教育资源专家</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" checked name="i1" style="margin-top: 0px;"> B、细致周到的对接服务</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" checked name="i1" style="margin-top: 0px;"> C、分享项目获得丰厚返利</label>
            </div>
        </div>
        <!---->
        <div class="form-group hidden">
            <label for="name">微信号（请不要填手机号）</label>
            <input type="text" class="form-control input-lg" name="wechat" id="wechat">
        </div>
        <div class="form-group" style="margin-top: 20px;margin-bottom: 25px;">
            <div class="checkbox">
                <label><input type="checkbox" name="agreement" checked style="margin-top: 0px;">阅读并接受 <a href="javascript:;" data-toggle="modal" data-target="#agreement" >《联创人创享协议》</a></label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-md btn-success btn-block submit">马上注册</button>
        </div>
        <div class="form-group">
        <span>友情提示：</span>
            <span class="help-block">请认真填写以上信息，如果信息有误，可能无法通过审核。有疑问请点击拨打 <a href="tel:4000532050" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-headphones"></span> 客服电话</a></span>
        </div>
    </form>
</div>

<div class="modal fade" id="agreement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">联创人创享协议</h4>
            </div>
            <div class="modal-body" style="padding-top: 0;">
                <article class="weui-article" style="padding: 0;">
                    <section>
                        <section>
                            <h3>特别提示</h3>
                            <p>
                                您在使用联创优学提供的各项服务之前，请您务必审慎阅读、充分理解本协议各条款内容，包括但不限于免除或者限制责任的条款。如您不同意本服务协议及/或随时对其的修改，您可以主动停止使用联创优学提供的服务；您一旦使用联创优学服务，即视为您已了解并完全同意本服务协议各项内容，包括联创优学对服务协议随时所做的任何修改，并成为联创优学用户。
                            </p>
                        </section>
                        <section>
                            <h3>细则</h3>
                            <p>
                                1. 用户应当同意本协议的条款并按照页面上的提示完成全部的注册程序。用户在进行注册程序过程中点击"马上注册"按钮即表示用户与联创优学公司达成协议，完全接受本协议项下的全部条款。
                            <p>
                                2. 联创优学帐号（即联创优学用户ID）的所有权归联创优学，用户按注册页面引导填写信息，阅读并同意本协议且完成全部注册程序后，即可获得联创优学帐号并成为联创优学用户。用户应提供及时、详尽及准确的个人资料，并不断更新注册资料，符合及时、详尽准确的要求。所有原始键入的资料将引用为注册资料。如果因注册信息不真实或更新不及时而引发的相关问题，联创优学不负任何责任。在注册后，如发现用户以虚假信息骗取帐号名称注册，或其帐号头像、简介等注册信息存在违法和不良信息的，联创优学有权不经通知单方采取限期改正、暂停使用、注销登记、收回等措施。
                            </p>
                            <p>
                                3. 用户不应将其帐号、密码转让、出售或出借予他人使用，若用户授权他人使用帐户，应对被授权人在该帐户下发生所有行为负全部责任。由于帐号关联用户使用信息，仅当依法律法规、司法裁定或经联创优学同意，并符合联创优学规定的用户帐号转让流程的情况下，方可进行帐号的转让。
                            </p>
                            <p>
                                4. 因您个人原因导致的帐号信息遗失，如需找回联创优学帐号信息，请按照联创优学帐号找回要求提供相应的信息，并确保提供的信息合法真实有效，若提供的信息不符合要求，无法通过联创优学安全验证，联创优学有权拒绝提供帐号找回服务；若帐号的唯一凭证不再有效，联创优学有权拒绝支持帐号找回。例如手机号二次出售，联创优学可拒绝支持帮助找回原手机号绑定的帐号。
                            </p>
                            <p>
                                5. 联创优学统一制定联创人的奖励机制和服务流程，为用户提供项目培训、工作指导和相应的工作支持，协助用户开展工作，对于联创优学内部信息、资料、意向学员的个人信息等，用户要严格保密，不可外泄；否则，联创优学有权终止该协议，并要求用户赔偿相关损失且联创优学保留诉诸法律的权利。
                            </p>
                            <p>
                                6. 用户应遵守联创优学制定的奖励机制和管理流程，用户有权利在本协议规定范围内使用联创优学品牌，进行招生宣传工作；用户有义务保存好联创优学提供的项目宣传招生物料等，丢失者须承担相应赔偿责任。用户若要离开联创优学的校园联创人团队，须提前一周通知联创优学，并将有关联创优学的一切资料全部交接给指定交接人，不得以任何形式外泄或带离联创优学；否则，联创优学将追究用户法律责任，并要求用户赔偿联创优学相应损失。
                            </p>
                            <p>
                                7. 联创优学网络服务的具体内容由联创优学根据实际情况提供。除非本服务协议另有其它明示规定，联创优学所推出的新产品、新功能、新服务，均受到本服务协议之规范。
                            </p>
                        </section>
                        <section>
                            <h3>免责声明</h3>
                            <p>
                                因以下情况造成网络服务在合理时间内的中断，联创优学无需为此承担任何责任。
                            </p>
                            <p>
                                1. 联创优学需要定期或不定期地对提供网络服务的平台或相关的设备进行检修或者维护，联创优学保留不经事先通知为维修保养、升级或其它目的暂停本服务任何部分的权利。
                            </p>
                            <p>
                                2. 因台风、地震、洪水、雷电或恐怖袭击等不可抗力原因；
                            </p>
                            <p>
                                3. 用户的电脑软硬件和通信线路、供电线路出现故障的；
                            </p>
                            <p>
                                4. 因病毒、木马、恶意程序攻击、网络拥堵、系统不稳定、系统或设备故障、通讯故障、电力故障、银行原因、第三方服务瑕疵或政府行为等原因。
                                联创优学将采取合理行动积极促使服务恢复正常。
                            </p>
                        </section>
                        <h3>使用联创优学前必读</h3>
                </article>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<?php include_once ROOT_PATH."/footer.php"?>
<script type="text/javascript" src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
