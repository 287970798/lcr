<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/28 0028
 * Time: 上午 10:36
 */
class ProjectAction extends Action {
    public function __construct(){
        parent::__construct(new ProjectModel);
    }

    //全部项目
    public function show(){
        $projects = $this->model->allProjects();
        return $projects;
    }
    //单个项目
    public function showOne(){
        if (isset($_GET['id'])){
            $this->model->id = $_GET['id'];
            $project = $this->model->oneProject();
            return $project;
        } else {
            Tool::alertBack('非法操作！');
        }
    }
    //新增
    public function add(){
        if (isset($_POST['send'])){
            if (Validate::checkNull($_POST['name'])) Tool::alertBack('项目名不得为空！');
            if (Validate::checkNull($_POST['brief_name'])) Tool::alertBack('项目简称不得为空！');
            $this->model->name = $_POST['name'];
            $this->model->brief_name = $_POST['brief_name'];
            $this->model->point = $_POST['point'];
            $this->model->catalogLink = $_POST['catalogLink'];
            $this->model->note = $_POST['note'];
            $this->model->add() ? Tool::alertLocation('新增成功！', '.') : Tool::alertBack('新增失败！');
        }
    }
    //修改
    public function update(){
        if (isset($_POST['send'])){
            if (Validate::checkNull($_POST['name'])) Tool::alertBack('项目名称不得为空！');
            if (Validate::checkNull($_POST['brief_name'])) Tool::alertBack('项目简称不得为空！');
            $this->model->id = $_POST['id'];
            $this->model->name = $_POST['name'];
            $this->model->brief_name = $_POST['brief_name'];
            $this->model->point = $_POST['point'];
            $this->model->catalogLink = $_POST['catalogLink'];
            $this->model->note = $_POST['note'];
            $this->model->update() ? Tool::alert('修改成功！', '.') : Tool::alert('修改失败！');
        }
    }
}