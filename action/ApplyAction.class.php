<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10 0010
 * Time: 下午 1:46
 */
class ApplyAction extends Action
{
    //构造方法初始化
    public function __construct()
    {
        parent::__construct(new ApplyModel);
    }

    //查找单个联创人
    public function getOne($field = 'id',$value){
        if ($field === null) $field = 'id';
        $this->model->$field = $value;
        $one = $this->model->getOneApply($field);
        return $one;
    }

    //getApplyFromConsultant
    public function getApplyFromConsultant($consultantId){
        $this->model->consultantId = $consultantId;
        $applys = $this->model->getApplyFromConsultant();
        return $applys;
    }
    //getSubWin
    public function getWinSubCount(){
        if (isset($_SESSION['apply_id'])){
            $this->model->parent_id = $_SESSION['apply_id'];
            $count = $this->model->getWinSubCount();
            return $count;
        }
    }

    //show
    public function show(){
        if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) Tool::alertBack('警告：请选择一个要查看或修改的申请人！');
        $this->model->id = $_GET['id'];
        $object = $this->model->getOneApply();
        if (empty($object)) Tool::alertBack('查询的联创人不存在！');
        $object->selectHtml ='';
        $selectArr = array('未审核', '通过', '拒绝');
        foreach ($selectArr as $key=>$value){
            $selected = '';
            if ($object->status == $key) $selected = ' selected';
            $object->selectHtml .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }
        return $object;
    }

    //查询下级申请人
    public function getSub(){
        if (isset($_GET['id'])){
            $this->model->id = $_GET['id'];
            $objects = $this->model->getSubApply();
            return $objects;
        }
    }

    //通过openid检查申请人状态
    public function checkOpenid($url){
        if (isset($_SESSION['wx']['openid'])){
            $this->model->openid = $_SESSION['wx']['openid'];
            $object = $this->model->getOneApplyFromOpenid();
            //可以查询到申请人时，检查该申请人状态
            if (!empty($object)){
                switch ($object->status){
                    case 0:
                        Tool::alertBack('您的联创人申请信息尚未审核，请稍后再试！');
                        break;
                    case 1:
                        $_SESSION['apply_id'] = $object->id;
                        $logStr = "操作者：{$object->name} 动作：登入联创人系统";
                        $logA = new LogAction();
                        $logA($object->id,$object->name,$logStr);
                        header('Location:'.$url.'?id=' . $object->id);
                        break;
                    case 2:
                        Tool::alertBack('您的联创人申请已被拒绝，无权查看此页面！');
                        break;
                }
            } else {
//                Tool::alert('第一次查询请输入申请时登记的手机号绑定微信！');
//                Tool::back();
                header('location:../lcr/login.php?flag=back');
            }
        }
    }

    //通过openid获取联创人信息
    public function getOneFromOpenid(){
        if (isset($_SESSION['wx']['openid'])){
            $this->model->openid=$_SESSION['wx']['openid'];
            $object=$this->model->getOneApplyFromOpenid();
            return $object;
        }
        exit('openid不存在');
    }

    //通过手机号检查申请人状态。状态为审核通过时则写入openid跳转到下级列表页
    public function checkPhone($url){
        if (isset($_POST['send'])){
            if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机号不得为空！');
            $this->model->phone = $_POST['phone'];
            $object = $this->model->getOneApplyFromPhone();
            //可以查询到申请人时，检查该申请人状态
            if (!empty($object)){
                if (!empty($object->openid) && $object->openid != $_SESSION['wx']['openid']) {
                    Tool::alert('该手机号已与另一微信绑定，微信昵称为"'.$object->wx_nickname.'"，不可重复绑定！');
                    return; //跳出函数
                }
                switch ($object->status){
                    case 0:
                        Tool::alert('您的联创人申请信息正在审核中，请稍后再试！');
                        break;
                    case 1:
                        $this->model->openid = $_SESSION['wx']['openid'];
                        $this->model->wx_nickname = $_SESSION['wx']['nickname'];
                        $this->model->wx_sex = $_SESSION['wx']['sex'];
                        $this->model->wx_headimgurl = $_SESSION['wx']['headimgurl'];
                        $this->model->wx_province = $_SESSION['wx']['province'];
                        $this->model->wx_city = $_SESSION['wx']['city'];
                        $this->model->wx_country = $_SESSION['wx']['country'];
                        $this->model->updateOpenidFromPhone();
                        $_SESSION['apply_id'] = $object->id;

                        $logStr = "操作者：{$object->name} 动作：绑定微信并登入联创人系统";
                        $logA = new LogAction();
                        $logA($object->id,$object->name,$logStr);

                        header('Location:'.$url.'?id=' . $object->id);
                        break;
                    case 2:
                        Tool::alert('您的联创人申请已被拒绝，无权查看此页面！');
                        break;
                }
            }else{
                Tool::alert('手机号尚未登记，请确认您是否申请联创人，或者确认手机号是否正确！');
            }
        }
    }

    //update
    public function update(){
        if (isset($_POST['send'])){
            $this->model->id = $_GET['id'];
            $this->getPost();
            $apply = $this->model->getOneApplyFull();

            if($this->model->status ==1 && $apply->status <> 1) {
                //获取优学顾问信息
                $consultantM = new ConsultantModel();
                $consultantM->id = $this->model->consultantId;
                $consultant = $consultantM->getConsultantOpenIdFromId();
                //模板消息
                if (!empty($consultant) && !empty($consultant->openId)) {
                    $postArr = array(
                        'touser' => $consultant->openId,
                        'template_id' => '0CuP5RZIY7pDGQUxSerb_BqccfvJqDupgPFKOKCClPE',
                        'data' => array(
                            'first' => array(
                                'value' => '联创人通过审核', 'color' => '#173177'
                            ),
                            'keyword1' => array(
                                'value' => $apply->name, 'color' => '#173177'
                            ),
                            'keyword2' => array(
                                'value' => date('Y-m-d h:i:s'), 'color' => '#173177'
                            ),
                            'keyword3' => array(
                                'value' => '通过审核', 'color' => '#173177'
                            )
                        )
                    );
                    new WXTemplateMsg($postArr);
                }
            }

            /*积分模块begin*/
            $sql2 = '';
            $streamSql = '';
            /*
             * 取消联创人积分
             * */
//            if ($apply->parent_id != 0) {               //判断是否有上级，无上级不记录积分及积分流水
//                $pointM = new PointModel();             //积分对象
//                $pointM->bid = $this->model->id;        //产生积分的联创人ID
//                $point = $pointM->oneApplyPoint();           //检测该联创人是否已产生过积分记录
//                //如果联创人状态为通过，并且不存在该联创人的积分记录，则新增一条积分记录
//                if ($this->model->status == 1 && empty($point)) {
//                    $pointM->point = 300;                    //通过审核后产生的积分数，可以后台设置
//                    $pointM->status = 0;
//                    $pointM->type = '联创人积分';
//                    $sql2 = $pointM->addPointSql();
//                    //流水说明及流水类型
//                    $streamDescription = "联创人 $apply->name 通过审核，上级联创人 $apply->referee_name 不可用积分 +".$pointM->point;
//                    $streamChangeType = 1;
//
//                    $streamAvailablePoint = 0;
//                    $streamUnavailablePoint = "+".$pointM->point;
//                    $streamBriefDesc = "不可用+".$pointM->point;
//                }
//                //如果联创人状态为未审核或拒绝，并且该联创人存在积分记录，则删除该积分记录
//                if ($this->model->status != 1 && !empty($point)) {
//                    $sql2 = $pointM->deletePointSql();
//                    //流水说明及流水类型
//                    $streamDescription = "联创人 $apply->name 被取消审核状态，上级联创人 $apply->referee_name 不可用积分 -".$point->point;
//                    $streamChangeType = 2;
//
//                    $streamAvailablePoint = 0;
//                    $streamUnavailablePoint = "-".$point->point;
//                    $streamBriefDesc = "不可用-".$point->point;
//                }
//                /*积分模块end*/
//
//
//                /*积分流水begin*/
//                if ($sql2 != '') {
//                    $streamM = new PointStreamModel();
//                    $streamM->applyId = $this->model->id;
//                    $streamM->applyName = $this->model->name;
//                    $streamM->refereeId = $apply->referee_id;
//                    $streamM->refereeName = $apply->referee_name;
//                    $streamM->description = $streamDescription;
//                    $streamM->changeType = $streamChangeType;
//
//                    $streamM->availablePoint = $streamAvailablePoint;
//                    $streamM->unavailablePoint = $streamUnavailablePoint;
//                    $streamM->briefDesc = $streamBriefDesc;
//
//                    $streamSql = $streamM->addStreamSql();
//                } else {
//                    $streamSql = '';
//                }
//                /*积分流水end*/
//            }


            $this->model->updateApply_t($sql2, $streamSql) ? Tool::alertLocation('修改成功！', PREV_URL) : Tool::alertBack('修改失败！');
        }
    }

    //getPost
    private function getPost(){
        //验证
        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机号不得为空！');
        if (Validate::checkNum($_POST['phone'])) Tool::alertBack('手机号必须为数字！');
        if (Validate::checkLength($_POST['phone'], 11, 'equals')) Tool::alertBack('手机号必须为11位！');
        //接收post
        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->wechat = $_POST['wechat'];
        $this->model->status = $_POST['status'];
        $this->model->consultantId = $_POST['consultantId'];
        $this->model->region = $_POST['region'];
        $this->model->note = $_POST['note'];
        $this->model->ext_phone = $_POST['ext_phone'];
    }
}
