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
    public function add(){


        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机不得为空！');

        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->wechat = $_POST['wechat'];
        $this->model->add() ? Tool::alertLocation('成功！', '.') : Tool::alertBack('失败！');
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
    //修改
    public function update(){

        $this->model->id = $_POST['id'];

        if (Validate::checkNull($_POST['name'])) Tool::alertBack('姓名不得为空！');
        if (Validate::checkNull($_POST['phone'])) Tool::alertBack('手机不得为空！');

        $this->model->name = $_POST['name'];
        $this->model->phone = $_POST['phone'];
        $this->model->wechat = $_POST['wechat'];

        $this->model->update() ? Tool::alertLocation('成功！', './detail.php?id='.$this->model->id) : Tool::alertBack('失败！');
    }
    //删除
    public function delete(){
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $this->model->id = $_POST['id'];
            echo $this->model->delete() ? '1' : '0';
        }
    }
}