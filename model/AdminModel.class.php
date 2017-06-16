<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/10 0010
 * Time: 下午 4:13
 */
class AdminModel extends Model {
    private $id;
    private $user;
    private $password;
    private $rank;
    private $createtime;

    //拦截器(__set)
    public function __set($key,$value){
        $this->$key = Tool::mysqlString($value);
    }
    //拦截器(__get)
    public function __get($key){
        return $this->$key;
    }

    //查询单个管理员
    public function getOneAdmin(){
        $sql = "SELECT 
                        *
                  FROM
                        lcr_admin
                 WHERE
                        user = '$this->user'
                   AND
                        password = '$this->password'
                 LIMIT
                        1";
        return parent::one($sql);
    }
}