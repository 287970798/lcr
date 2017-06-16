<?php
/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/3/23 0023
 * Time: 下午 4:17
 */


class LogModel extends Model {
    private $id;
    private $lcrId;
    private $lcrName;
    private $detail;
    private $logTime;
    private $pages;

    public function __set($key, $value){
        $this->$key = $value;
    }
    public function __get($key){
        return $this->$key;
    }
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    /*新增日志*/
    public function add(){
        $sql = "INSERT INTO lcr_log (
                                        lcrId,
                                        lcrName,
                                        detail,
                                        logTime
                                    )
                             VALUES (
                                        '$this->lcrId',
                                        '$this->lcrName',
                                        '$this->detail',
                                        NOW()
                                    )";
        return parent::aud($sql);
    }

    /*修改浏览页面记录*/
    public function updatePages(){
        $sql = "UPDATE
                        lcr_log
                   SET
                        pages = CONCAT_WS('|',pages,'$this->pages')
              ORDER BY
                        logTime DESC 
                 LIMIT
                        1";
        return parent::aud($sql);
    }
}