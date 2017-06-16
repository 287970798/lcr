<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/23 0023
 * Time: 下午 4:26
 */


class LogAction extends Action {

    public function __construct(){
        parent::__construct(new LogModel());
    }

    public function __invoke($lcrId,$lcrName,$detail)
    {
        $this->model->lcrId = $lcrId;
        $this->model->lcrName = $lcrName;
        $this->model->detail = $detail;

        $this->model->add();
    }

    public function pickPage(){
        $this->model->pages = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].($_SERVER['QUERY_STRING'] == '' ? '' : '?'.$_SERVER['QUERY_STRING']);
        $this->model->updatePages();
    }

}