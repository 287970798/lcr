<?php


class DeductPointModel extends Model
{
    private $id;
    private $point;

    public function __set($key, $value){
        $this->$key = $value;
    }
    public function __get($key){
        return $this->$key;
    }

    //消耗积分
    public function deduct()
    {
        $sql = "INSERT INTO lcr_deduct_point 
                                        (
                                          id,
                                          point,
                                          create_time
                                        )
                                VALUES
                                        (
                                          '$this->id',
                                          '$this->point',
                                          NOW()
                                        )";
        return parent::aud($sql);
    }
}