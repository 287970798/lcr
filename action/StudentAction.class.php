<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/24 0024
 * Time: 下午 3:08
 */
class StudentAction extends Action {

    public function __construct() {
        parent::__construct(new StudentModel);
    }

    //所有学员
    public function allStudents(){
        $objects = $this->model->getAllStudentsFull();
        Tool::objDate($objects, 'ctime');
        return $objects;
    }
    //单个学员
    public function oneStudent(){
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            Tool::alertBack('非法操作！');
        } else {
            $this->model->id = $_GET['id'];
            $object = $this->model->getOneStudent();
            if (empty($object)) Tool::alertBack('学员不存在！');
            $object->ctime = date('Y-m-d', strtotime($object->ctime));
        }
        return $object;
    }

    //自建学员
    public function ownStudents(){
        if (isset($_SESSION['apply_id']) && !empty($_SESSION['apply_id']) && is_numeric($_SESSION['apply_id'])){
            $this->model->owner_id = $_SESSION['apply_id'];
            $students = $this->model->getOwnStudents();
            Tool::objDate($students, 'ctime');
            return $students;
        } else {
            Tool::alertBack('非法操作！');
        }
    }

    //下级学员
    public function subOwnStudents(){}

    //新增学员
    public function addStudent(){
        if (isset($_POST['send'])){
            $this->getPost();
            $this->model->addStudent() ? Tool::alertLocation('新增成功！', '.') : Tool::alertBack('新增失败！');
        }
    }

    //新增学员(同时新增积分的事务处理)
    public function addStudent_t(){
        if (isset($_POST['send'])){
            $this->getPost();
            //实例化联创人，用于获取所属联创人及上级联创人信息
            $applyM = new ApplyModel();
            $applyM->id = $this->model->owner_id;
            $apply = $applyM->getOneApplyFull();
            //积分
            $pointModel = new PointModel();
            $pointModel->sid = $this->model->nextId('lcr_students');
            $pointModel->point = $_POST['point'];
            $pointModel->type = '学员积分';
            $pointModel->status = 0;
            $sql2 = $pointModel->addPointSql();
//            echo $sql2; exit;
            //积分流水
            $streamM = new PointStreamModel();
            $streamM->changeType = 11;
            $streamM->studentId = $this->model->id;
            $streamM->studentName = $this->model->name;
            $streamM->applyId = $apply->id;
            $streamM->applyName = $apply->name;
            $streamM->refereeId = $apply->referee_id;
            $streamM->refereeName = $apply->referee_name;
            $streamM->description = "联创人 $streamM->applyName 新增学员 {$streamM->studentName}, 不可用积分 +{$_POST['point']}";

            $streamM->availablePoint = 0;
            $streamM->unavailablePoint = "+{$_POST['point']}";
            $streamM->briefDesc = "不可用+{$_POST['point']}";

            $studentStreamSql = $streamM->addStreamSql();

            $this->model->addStudent_t($sql2, $studentStreamSql) ? Tool::alertLocation('新增成功！', '.') : Tool::alertBack('新增失败！');
        }
    }

    //修改学员
    public function updateStudent(){
        if (isset($_POST['send'])){
            if (!isset($_POST['id']) || empty($_POST['id'])) Tool::alertBack('非法操作！');
            $this->getPost();
            $this->model->updateStudent() ? Tool::alert('修改成功！'): Tool::alertBack('修改失败！');
        }
    }
    //修改学员(同时修改积分的事务处理)
    public function updateStudent_t(){
        if (isset($_POST['send'])){
            if (!isset($_POST['id']) || empty($_POST['id'])) Tool::alertBack('非法操作！');
            $this->getPost();

            //实例化联创人，用于获取所属联创人及上级联创人信息
            $applyM = new ApplyModel();
            $applyM->id = $this->model->owner_id;
            $apply = $applyM->getOneApplyFull();

            /**积分操作 begin**/
            /*
             * 操作：首单联创人积分begin
             * 学员赢单，积分状态变为可用
             * 查询该学员的所属联创人，是否存在赢单学员
             * 如果不存在，则该学员为所属联创人的首单
             * 上级联创人产生的积分变为可用
             * */
            $applySql = '';
            if ($this->model->owner_id != 0){       //所属联创人ID=0，是系统添加，没有所属联创人
                $applySql = '';
                $applyStreamSql = '';

                //获取所属联创人的赢单学员
                $studentByOwner = $this->model->getOwnWinStudents();

                //1、没有赢单学员记录，则该单为首单
                //2、或者 有赢单记录，并且只有一单，并且就是当前操作的学员
                if (empty($studentByOwner) || (count($studentByOwner) == 1 && $studentByOwner[0]->id == $_POST['id'])){
                    //积分对象用于操作联创人产生的积分
                    $applyPointM = new PointModel();
                    $applyPointM->bid = $this->model->owner_id;
                    //检测该学员的所属联创人产生的积分记录
                    $applyPoint = $applyPointM->oneApplyPoint();
                    //如果所属联创人存在积分记录，则对该记录操作。如果所属联创人不存在积分记录则不做任何操作。
                    if (!empty($applyPoint)){
                        //学员状态发生变化，则进行积分操作
                        if ($_POST['status'] != $_POST['oldStatus']){
                            $applyPointM->point = $applyPoint->point;
                            //产生积分流水
                            if ($_POST['status'] == 1 || $_POST['oldStatus'] == 1){
                                //??实例化流水对象//
                                $streamM = new PointStreamModel();
                                //??流水对象赋值//
                                $streamM->studentId = $this->model->id;
                                $streamM->studentName = $this->model->name;
                                $streamM->applyId = $apply->id;
                                $streamM->applyName = $apply->name;
                                $streamM->refereeId = $apply->referee_id;
                                $streamM->refereeName = $apply->referee_name;
                                //赢单
                                if ($_POST['status'] == 1) {    //您推荐的联创人 XXX 录入的学员 XXX 状态变为赢单，联创人 XXX 不可用积分 -50， 可用积分 +50
                                    $applyPointM->status = 1;
                                    $applySql = $applyPointM->updatePointSql();
                                    $streamM->description = "您推荐的联创人 $streamM->applyName 录入的学员 $streamM->studentName 状态变为赢单，联创人 $streamM->refereeName 的不可用积分 -{$applyPointM->point}， 可用积分 +{$applyPointM->point}";
                                    $streamM->changeType = 3;

                                    $streamM->availablePoint = "+{$applyPointM->point}";
                                    $streamM->unavailablePoint = "-{$applyPointM->point}";
                                    $streamM->briefDesc = "可用+{$applyPointM->point}，不可用-{$applyPointM->point}";
                                }
                                //取消赢单
                                if ($_POST['oldStatus'] == 1) {    //您推荐的联创人 XXX 录入的学员 XXX 取消赢单状态，联创人 XXX 不可用积分 -50， 可用积分 +50
                                    $applyPointM->status = 0;
                                    $applySql = $applyPointM->updatePointSql();
                                    $streamM->description = "您推荐的联创人 $streamM->applyName 录入的学员 $streamM->studentName 状态取消赢单，联创人 $streamM->refereeName 的不可用积分 +{$applyPointM->point}， 可用积分 -{$applyPointM->point}";
                                    $streamM->changeType = 4;

                                    $streamM->availablePoint = "-{$applyPointM->point}";
                                    $streamM->unavailablePoint = "+{$applyPointM->point}";
                                    $streamM->briefDesc = "可用-{$applyPointM->point}，不可用+{$applyPointM->point}";
                                }
                                $applyStreamSql = $streamM->addStreamSql();
                            }
                        }
                    }
                }
            }
            /*首单联创人积分 end*/

            /*学员积分操作begin*/
            $studentSql = '';
            $studentStreamSql = '';
            //实例化积分对象,用于操作学员积分
            $pointModel = new PointModel();
            $pointModel->sid = $_POST['id'];          //学员ID
            $pointModel->point = $_POST['point'];     //学员积分
            $pointModel->status = $_POST['status'];   //积分状态
            //检测该学员是否产生过积分
            $point = $pointModel->oneStudentPoint();
            if (!empty($point)){

                //如果学员状态发生变化
                if ($_POST['status'] != $_POST['oldStatus']){

                    //??实例化流水对象//
                    $streamM2 = new PointStreamModel();
                    //??流水对象赋值//
                    $streamM2->studentId = $this->model->id;
                    $streamM2->studentName = $this->model->name;
                    $streamM2->applyId = $apply->id;
                    $streamM2->applyName = $apply->name;
                    $streamM2->refereeId = $apply->referee_id;
                    $streamM2->refereeName = $apply->referee_name;

                    //如果原状态为营销中
                    if ($_POST['oldStatus'] == 0){
                        //变为赢单
                        if ($_POST['status'] == 1){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 营销中 改为 赢单，联创人 {$streamM2->applyName} 您的不可用积分 -{$point->point}，可用积分 +{$point->point}";
                            $streamM2->changeType = 5;

                            $streamM2->availablePoint = "+{$point->point}";
                            $streamM2->unavailablePoint = "-{$point->point}";
                            $streamM2->briefDesc = "可用+{$point->point}，不可用-{$point->point}";
                        }
                        //变为输单
                        if ($_POST['status'] == 2){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 营销中 改为 输单，联创人 {$streamM2->applyName} 您的不可用积分 -{$point->point}";
                            $streamM2->changeType = 6;

                            $streamM2->availablePoint = 0;
                            $streamM2->unavailablePoint = "-{$point->point}";
                            $streamM2->briefDesc = "不可用-{$point->point}";
                        }
                    }
                    //如果原状态为赢单
                    if ($_POST['oldStatus'] == 1){
                        //变为营销
                        if ($_POST['status'] == 0){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 赢单 改为 营销中，联创人 {$streamM2->applyName} 您的不可用积分 +{$point->point}，可用积分 -{$point->point}";
                            $streamM2->changeType = 7;

                            $streamM2->availablePoint = "-{$point->point}";
                            $streamM2->unavailablePoint = "+{$point->point}";
                            $streamM2->briefDesc = "可用-{$point->point}，不可用+{$point->point}";
                        }
                        //变为输单
                        if ($_POST['status'] == 2){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 赢单 改为 输单，联创人 {$streamM2->applyName} 您的不可用积分 -{$point->point}";
                            $streamM2->changeType = 8;

                            $streamM2->availablePoint = "0";
                            $streamM2->unavailablePoint = "-{$point->point}";
                            $streamM2->briefDesc = "不可用-{$point->point}";
                        }
                    }
                    //如果原状态为输单
                    if ($_POST['oldStatus'] == 2){
                        //变为营销
                        if ($_POST['status'] == 0){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 输单 改为 营销中，联创人 {$streamM2->applyName} 您的不可用积分 +{$point->point}";
                            $streamM2->changeType = 9;

                            $streamM2->availablePoint = "0";
                            $streamM2->unavailablePoint = "+{$point->point}";
                            $streamM2->briefDesc = "不可用+{$point->point}";
                        }
                        //变为赢单
                        if ($_POST['status'] == 1){
                            $streamM2->description = "学员 {$streamM2->studentName} 状态由 输单 改为 赢单，联创人 {$streamM2->applyName} 您的可用积分 +{$point->point}";
                            $streamM2->changeType = 10;

                            $streamM2->availablePoint = "+{$point->point}";
                            $streamM2->unavailablePoint = "0";
                            $streamM2->briefDesc = "可用+{$point->point}";
                        }
                    }

                    //获取修改积分的sql语句
                    $studentSql = $pointModel->updatePointSql();
                    //获取修改修改学员积分流水的sql
                    $studentStreamSql = $streamM2->addStreamSql();
                }
            }
            /*学员积分操作end*/

            /**积分操作 end**/
            //执行事务
            $this->model->updateStudent_t($studentSql, $applySql, $studentStreamSql, $applyStreamSql) ? Tool::alert('修改成功！'): Tool::alertBack('修改失败！updateStudent_t');
        }
    }
    //学员getPost
    private function getPost(){
        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机号不得为空！');
        if (Validate::checkNull($_POST['sex'])) Tool::alertBack('请选择性别！');
        if (Validate::checkNull($_POST['project'])) Tool::alertBack('请选择意向项目！');
        if (Validate::checkNull($_POST['hedu'])) Tool::alertBack('请选择最高学历！');
        if (isset($_POST['id'])) $this->model->id = $_POST['id'];
        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->sex = $_POST['sex'];
        $this->model->project_id = $_POST['project'];
        $this->model->hedu = $_POST['hedu'];
        $this->model->note = $_POST['note'];
        if (isset($_POST['status'])) $this->model->status = $_POST['status'];
        if (isset($_POST['owner_id'])) $this->model->owner_id = $_POST['owner_id'];
    }
}