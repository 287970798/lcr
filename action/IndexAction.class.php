<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/15 0015
 * Time: 下午 4:49
 */
class IndexAction extends Action {
    public function __construct(){
    }

    public function getCount(){
        if (isset($_SESSION['apply_id'])){
            //学员总数
            $studentM = new StudentModel();
            $studentM->owner_id = $_SESSION['apply_id'];
            $studentCount = $studentM->getOwnerStudentCount();

            //下级联创人总数
            $applyM = new ApplyModel();
            $applyM->parent_id = $_SESSION['apply_id'];
            $applyCount = $applyM->getSubCount();

            //积分总数
            $pointM = new PointModel();
            $pointM->owner_id = $_SESSION['apply_id'];
            $pointCount = $pointM->getPoint();

            $countO = new stdClass();
            $countO->student = $studentCount->studentCount;
            $countO->apply = $applyCount->applyCount;
            $countO->point = ($pointCount->availablePoint?:0) + ($pointCount->unavailablePoint?:0);
            $countO->availablePoint = $pointCount->availablePoint?:0;
            $countO->unavailablePoint = $pointCount->unavailablePoint?:0;

            return $countO;
        }
    }
}