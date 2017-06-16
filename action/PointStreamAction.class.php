<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/10 0010
 * Time: 下午 3:24
 */
class PointStreamAction extends Action {

    public function __construct(){
        parent::__construct(new PointStreamModel);
    }

    //getOwnStream
    public function getOwnStreams(){
        if (isset($_SESSION['apply_id'])){
            $this->model->owner_id = $_SESSION['apply_id'];
            $streams = $this->model->getOwnStreams();
            Tool::objDate($streams,'ctime');
            return $streams;
        }
    }
}