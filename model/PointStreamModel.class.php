<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/9 0009
 * Time: 下午 2:15
 */
class PointStreamModel extends Model {
    private $id;
    private $studentName;
    private $studentId;
    private $applyId;
    private $applyName;
    private $refereeId;
    private $refereeName;
    private $changeType;
    private $description;
    private $ctime;
    private $owner_id;

    private $availablePoint;
    private $unavailablePoint;
    private $briefDesc;

    public function __set($key, $value){
        $this->$key = $value;
    }
    public function __get($key){
        return $this->$key;
    }

    public function addStreamSql(){
        $sql = "INSERT INTO lcr_pointStream
                                            (
                                                studentName,
                                                studentId,
                                                applyId,
                                                applyName,
                                                refereeId,
                                                refereeName,
                                                changeType,
                                                description,
                                                availablePoint,
                                                unavailablePoint,
                                                briefDesc,
                                                ctime
                                            )
                                     VALUES
                                            (
                                                '$this->studentName',
                                                '$this->studentId',
                                                '$this->applyId',
                                                '$this->applyName',
                                                '$this->refereeId',
                                                '$this->refereeName',
                                                '$this->changeType',
                                                '$this->description',
                                                '$this->availablePoint',
                                                '$this->unavailablePoint',
                                                '$this->briefDesc',
                                                NOW()
                                            )";
        return $sql;
    }

    public function getOwnStreams(){
        $sql = "SELECT
                        description,
                        availablePoint,
                        unavailablePoint,
                        briefDesc,
                        ctime
                  FROM
                        lcr_pointStream
                 WHERE
                        (changeType IN (1,2,3,4) AND refereeId = '$this->owner_id')
                    OR
                        (changeType IN (5,6,7,8,9,10,11) AND applyId = '$this->owner_id')
              ORDER BY
                        id DESC";
        return parent::all($sql);
    }

}