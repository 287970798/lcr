<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/4/5 0005
 * Time: 下午 3:46
 */
class ConsultantAction extends Action {
    public function __construct(){
        parent::__construct(new ConsultantModel);
    }
    //check to login panel
    public function loginCheck(){
        if (Validate::checkNull(trim($_POST['name']))) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull(trim($_POST['phone']))) Tool::alertBack('手机号不得为空！');
        $this->model->name = trim($_POST['name']);
        $this->model->phone = trim($_POST['phone']);
        $consultant = $this->model->getOneFromNameAndPhone();
        if (!$consultant) {
            Tool::alertBack('您无法登录，请确认姓名手机号是否输入正确！');
        }else{
            $_SESSION['consultant'] = $consultant;
            header('location:index.php');
        }

    }
    //add
    public function add($url='.'){


        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机不得为空！');

        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->wechat = $_POST['wechat'];

        //通过手机号检测该优学顾问是否为联创人
        $applyM = new ApplyModel();
        $applyM->phone = $_POST['phone'];
        $apply = $applyM->getOneApplyFromPhone();
        if (!$apply) Tool::alertBack('该人员不是联创人！');
        //通过手机号检测该优学顾问是否已存在
        $consultant = $this->model->getOneFromPhone();
        if ($consultant) Tool::alertBack('系统已存在该优学顾问！');

        if (isset($_POST['pid'])) $this->model->pid = $_POST['pid'];



        $this->model->add() ? Tool::alertLocation('成功！', $url) : Tool::alertBack('失败！');
    }
    //获取所有下级优学顾问服务的联创人录入的学员
    public function getSubApplysStudents($pid){
        $this->model->pid = $pid;
        $students = $this->model->getSubConsultantApplyStudent();
        return $students;
    }
    //获取所胡下级优学顾问服务的联创人
    public function getSubApplys($pid){
        $this->model->pid = $pid;
        $applys = $this->model->getSubConsultantApply();
        return $applys;
    }
    //获取所有下级优学顾问服务的联创人录入的学员总数
    public function getSubApplysStudentsCount($pid){
        $this->model->pid = $pid;
        $students = $this->model->getSubConsultantApplyStudentCount();
        return $students;
    }
    //获取所胡下级优学顾问服务的联创人总数
    public function getSubApplysCount($pid){
        $this->model->pid = $pid;
        $applys = $this->model->getSubConsultantApplyCount();
        return $applys;
    }
    //获取所有下级优学顾问（代理商员工）
    public function getStaffs($pid){
        $this->model->pid = $pid;
        $staffs = $this->model->getAllSubConsultants();
        return $staffs;
    }
    //获取全部
    public function getAll(){
        $consultants = $this->model->getAll();
        return $consultants;
    }
    //获取单一
    public function getOne(){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $this->model->id = $_GET['id'];
            $consultant = $this->model->getOne();
            return empty($consultant) ? Tool::alertBack('顾问不存在！') : $consultant;
        } else {
            Tool::alertBack('请选择顾问！');
        }
    }
    //通过id获取单一
    public function getOneFromId($id){
        $this->model->id = $id;
        $consultant = $this->model->getOne();
        return $consultant;
    }
    //修改
    public function update($url='./detail.php'){

        $this->model->id = $_POST['id'];

        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机不得为空！');

        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->wechat = $_POST['wechat'];

        $this->model->update() ? Tool::alertLocation('成功！', $url.'?id='.$this->model->id) : Tool::alertBack('失败！');
    }
    //删除
    public function delete(){
        if (isset($_GET['id']) && !empty($_GET['id'])){
            $this->model->id = $_GET['id'];
            echo $this->model->delete() ? '1' : '0';
        }
    }
}