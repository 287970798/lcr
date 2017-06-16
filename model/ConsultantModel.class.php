<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/4/5 0005
 * Time: 下午 3:31
 */
class ConsultantModel extends Model {
    private $id;
    private $name;
    private $phone;
    private $wechat;

    //拦截器(__set)
    public function __set($key,$value){
        $this->$key = Tool::mysqlString($value);
    }
    //拦截器(__get)
    public function __get($key){
        return $this->$key;
    }
    //
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
                                                ctime
                                              )
                     VALUES
                                              (
                                                '$this->name',
                                                '$this->phone',
                                                '$this->wechat',
                                                NOW()
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
        $sql = "DELETE FORM
                                lcr_consultants
                      WHERE
                                id = '$this->id'
                      LIMIT
                                1";
        return parent::aud($sql);
    }

}