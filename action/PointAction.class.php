<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/10 0010
 * Time: 下午 1:46
 */
class PointAction extends Action {

    public function __construct(){
        parent::__construct(new PointModel);
    }

    //获取积分
    public function getPoint(){
        if(isset($_SESSION['apply_id'])){
            $this->model->owner_id = $_SESSION['apply_id'];
            $point = $this->model->getPoint();
            return $point;
        }
    }

}