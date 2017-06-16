<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10 0010
 * Time: 下午 4:22
 */
class AdminAction extends Action {
    //构造方法初始化
    public function __construct()
    {
        parent::__construct(new AdminModel);
    }

    //login
    public function login(){
        if (isset($_POST['submit'])){
            $this->getPost();
            return $this->model->getOneAdmin();
        }
    }

    //getPost
    private function getPost(){
        //验证
        if (Validate::checkNull($_POST['user'])) Tool::alertBack('用户名不得为空！');
        if (Validate::checkNull($_POST['password'])) Tool::alertBack('密码不得为空！');
        //接收post
        $this->model->user = $_POST['user'];
        $this->model->password = sha1($_POST['password']);
    }

}