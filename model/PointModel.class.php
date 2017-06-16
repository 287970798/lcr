<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/7 0007
 * Time: 下午 2:50
 */
class PointModel extends Model {

    private $id;
    private $sid;       //产生积分的学员ID
    private $bid;       //产生积分的联创人ID
    private $point;     //产生的积分数
    private $status;    //积分状态：unavailable / available
    private $type;      //积分类型：学员积分 / 联创人积分
    private $ctime;     //积分产生时间
    private $mtime;     //积分变动时间

    private $owner_id;

//    public $addSql = "INSERT INTO lcr_points (sid,bid,point,status,type,ctime)VALUES('$this->sid','$this->bid','$this->point','$this->status','$this->type',NOW())";

    public function __set($key, $value){
        $this->$key = $value;
    }
    public function __get($key){
        return $this->$key;
    }

    //新增积分
    public function addPoint(){
        $sql = "INSERT INTO lcr_points 
                                        (
                                          sid,
                                          bid,
                                          point,
                                          status,
                                          type,
                                          ctime
                                        )
                                VALUES
                                        (
                                          '$this->sid',
                                          {$this->bid},
                                          '$this->point',
                                          '$this->status',
                                          '$this->type',
                                          NOW()
                                        )";
        return parent::aud($sql);
    }
    //新增积分sql
    public function addPointSql(){
        $sql = "INSERT INTO lcr_points 
                                        (
                                          sid,
                                          bid,
                                          point,
                                          status,
                                          type,
                                          ctime
                                        )
                                VALUES
                                        (
                                          '$this->sid',
                                          '$this->bid',
                                          '$this->point',
                                          '$this->status',
                                          '$this->type',
                                          NOW()
                                        )";
        return $sql;
    }

    //修改积分sql
    public function updatePointSql(){
        $sql = "UPDATE
                        lcr_points
                   SET
                        point = '$this->point',
                        status = '$this->status',
                        mtime = NOW()
                 WHERE
                        (sid = '$this->sid' AND sid <> '')
                    OR
                        (bid = '$this->bid' AND bid <> '')
                 LIMIT
                        1";
        return $sql;
    }

    //删除积分sql
    public function deletePointSql(){
        $sql = "DELETE FROM
                            lcr_points
                      WHERE
                            bid = '$this->bid'
                        AND 
                            bid <> ''
                      LIMIT
                            1";
        return $sql;
    }

    //查询单一积分
    public function oneStudentPoint(){
        $sql = "SELECT 
                        id,
                        point
                  FROM
                        lcr_points
                 WHERE
                        sid = '$this->sid'
                 LIMIT
                        1";
        return parent::one($sql);
    }
    //查询单一积分
    public function oneApplyPoint(){
        $sql = "SELECT 
                        id,
                        point
                  FROM
                        lcr_points
                 WHERE
                        bid = '$this->bid'
                 LIMIT
                        1";
        return parent::one($sql);
    }

    //查询积分
    public function getPoint(){
        $sql = "SELECT
                        SUM(IF(status = 0,point,0)) as unavailablePoint,
                        SUM(IF(status = 1,point,0)) as availablePoint
                  FROM
                        lcr_points
                 WHERE
                        sid
                    IN
                        (
                          SELECT
                                  id
                            FROM
                                  lcr_students
                           WHERE
                                  owner_id = '$this->owner_id'
                        )
                    OR
                        bid
                    IN
                        (
                          SELECT
                                  id
                            FROM
                                  lcr_apply
                           WHERE
                                  parent_id = '$this->owner_id'
                        )";
        return parent::one($sql);
    }


}