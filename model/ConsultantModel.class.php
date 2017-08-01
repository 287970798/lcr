<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/4/5 0005
 * Time: 下午 3:31
 */
class ConsultantModel extends Model {
    private $id;        //id
    private $name;      //姓名
    private $phone;     //手机号
    private $wechat;    //微信号
    private $isAgent;   //是否为代理商
    private $pid;       //  上级优学顾问ID

    //拦截器(__set)
    public function __set($key,$value){
        $this->$key = Tool::mysqlString($value);
    }
    //拦截器(__get)
    public function __get($key){
        return $this->$key;
    }
    //通过传入字段查询单一
    public function getOneCounsultant($field='id'){
        $sql = "SELECT
                        id,
                        name,
                        phone,
                        wechat,
                        ctime
                  FROM
                        lcr_consultants
                 WHERE
                        $field = '{$this->$field}'";
        return parent::one($sql);
    }
    //获取本人及下级所有优学顾问服务的联创人
    //getSubConsultantApply
    public function getSubConsultantApply(){
        $sql = "SELECT
                        a.*,
                        IF(b.name<>'',b.name,'系统添加') AS parentName
                  FROM
                        (
                            SELECT
                                    *
                              FROM
                                    lcr_apply
                             WHERE
                                    consultantId 
                                IN 
                                    (
                                      SELECT
                                                id
                                        FROM
                                                lcr_consultants
                                       WHERE
                                                pid = '$this->pid'
                                          OR
                                                id = '$this->pid'
                                    )
                               AND
                                    status = 1
                        ) a
             LEFT JOIN
                        lcr_apply b
                    ON 
                        a.parent_id = b.id
              ORDER BY
                        id DESC
                        ";
        return parent::all($sql);
    }
    //获取本人及下级优学顾问服务的联创人录入的学员
    public function getSubConsultantApplyStudent(){
        $sql = "SELECT 
                            *
                      FROM
                            lcr_students
                     WHERE
                            owner_id
                        IN 
                            (
                                SELECT
                                        id
                                  FROM
                                        lcr_apply
                                 WHERE
                                        consultantId 
                                    IN 
                                        (
                                          SELECT
                                                    id
                                            FROM
                                                    lcr_consultants
                                           WHERE
                                                    pid = '$this->pid'
                                              OR
                                                    id = '$this->pid'
                                        )
                                   AND
                                        status = 1
                            )
                  ORDER BY
                            id DESC ";
        return parent::all($sql);
    }
    //获取本人及下级所有优学顾问服务的联创人总数
    //getSubConsultantApply
    public function getSubConsultantApplyCount(){
        $sql = "SELECT
                        a.id,
                        count(a.id) as c
                  FROM
                        (
                            SELECT
                                    *
                              FROM
                                    lcr_apply
                             WHERE
                                    consultantId 
                                IN 
                                    (
                                      SELECT
                                                id
                                        FROM
                                                lcr_consultants
                                       WHERE
                                                pid = '$this->pid'
                                          OR
                                                id = '$this->pid'
                                    )
                               AND
                                    status = 1
                        ) a
             LEFT JOIN
                        lcr_apply b
                    ON 
                        a.parent_id = b.id
              ORDER BY
                        id DESC
                        ";
        return parent::one($sql);
    }
    //获取本人及下级优学顾问服务的联创人录入的学员总数
    public function getSubConsultantApplyStudentCount(){
        $sql = "SELECT 
                            COUNT(id) as c
                      FROM
                            lcr_students
                     WHERE
                            owner_id
                        IN 
                            (
                                SELECT
                                        id
                                  FROM
                                        lcr_apply
                                 WHERE
                                        consultantId 
                                    IN 
                                        (
                                          SELECT
                                                    id
                                            FROM
                                                    lcr_consultants
                                           WHERE
                                                    pid = '$this->pid'
                                              OR
                                                    id = '$this->pid'
                                        )
                                   AND
                                        status = 1
                            )
                  ORDER BY
                            id DESC ";
        return parent::one($sql);
    }
    //获取下级优学顾问
    public function getAllSubConsultants(){
        $sql = "SELECT
                        id,
                        name,
                        phone,
                        wechat,
                        ctime
                  FROM
                        lcr_consultants
                 WHERE
                        pid = '$this->pid'";
        return parent::all($sql);

    }
    //获取通过id优学顾问openid
    public function getConsultantOpenIdFromId(){
        $sql = "SELECT
                              a.name,
                              a.wx_nickname,
                              a.openId
                       FROM
                              (select phone from lcr_consultants WHERE id = '$this->id') b
                  LEFT JOIN
                              lcr_apply a
                         ON
                              a.phone = b.phone
                      LIMIT
                              1";
        return parent::one($sql);
    }
    //getOneFromNameAndPhone
    public  function getOneFromNameAndPhone(){
        $sql = "SELECT 
                        * 
                  FROM 
                        lcr_consultants 
                 WHERE 
                        name = '$this->name' 
                   AND 
                        phone = '$this->phone'
                 LIMIT
                        1";
        return parent::one($sql);
    }
    //getOneFromPhone
    public  function getOneFromPhone(){
        $sql = "SELECT 
                        * 
                  FROM 
                        lcr_consultants 
                 WHERE  
                        phone = '$this->phone'
                 LIMIT
                        1";
        return parent::one($sql);
    }
    //
    public function getAll(){
        $sql = "SELECT
                        id,
                        name,
                        phone,
                        wechat,
                        ctime
                  FROM
                        lcr_consultants";
        return parent::all($sql);
    }
    public function getOne(){
        $sql = "SELECT
                        id,
                        name,
                        phone,
                        wechat,
                        ctime
                  FROM
                        lcr_consultants
                 WHERE
                        id = '$this->id'";
        return parent::one($sql);
    }
    public function add(){
        $sql = "INSERT INTO
                              lcr_consultants 
                                              (
                                                name,
                                                phone,
                                                wechat,
                                                ctime,
                                                pid
                                              )
                     VALUES
                                              (
                                                '$this->name',
                                                '$this->phone',
                                                '$this->wechat',
                                                NOW(),
                                                '$this->pid'
                                              )";
        return parent::aud($sql);
    }

    public function update(){
        $sql = "UPDATE
                        lcr_consultants
                   SET
                        name = '$this->name',
                        phone = '$this->phone',
                        wechat = '$this->wechat'
                 WHERE
                        id = '$this->id'
                 LIMIT
                        1";
        return parent::aud($sql);
    }

    public function delete(){
        $sql = "DELETE FROM
                                lcr_consultants
                      WHERE
                                id = '$this->id'
                      LIMIT
                                1";
        return parent::aud($sql);
    }

}