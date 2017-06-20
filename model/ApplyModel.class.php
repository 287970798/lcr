<?php

class ApplyModel extends Model {
    private $id;
    private $parent_id;
    private $name;
    private $phone;
    private $wechat;
    private $status;
    private $note;
    private $openid;
    private $wx_nickname;
    private $wx_sex;
    private $wx_headimgurl;
    private $wx_province;
    private $wx_city;
    private $wx_country;
    private $apply_time;

    private $serviceName;
    private $servicePhone;
    private $consultantId;

    private $region;
    private $ext_phone;

    //拦截器(__set)
    public function __set($key,$value){
        $this->$key = Tool::mysqlString($value);
    }
    //拦截器(__get)
    public function __get($key){
        return $this->$key;
    }
    //getApplyFromConsultant
    public function getApplyFromConsultant(){
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
                                    consultantId = '$this->consultantId'
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

    //获取有赢单的下级总数
    public function getWinSubCount(){
        $sql = "SELECT
                            COUNT(id) AS winCount
                      FROM
                            lcr_apply
                      WHERE
                            id IN (SELECT owner_id FROM lcr_students WHERE status = 1)
                        AND
                            parent_id = '$this->parent_id'";
        return parent::one($sql);
    }

    //获取下级总数
    public function getSubCount(){
        $sql = "SELECT 
                        COUNT(id) as applyCount
                  FROM
                        lcr_apply
                 WHERE
                        parent_id = '$this->parent_id'";
        return parent::one($sql);
    }

    //新增申请
    public function addApply(){
       $sql = "INSERT INTO lcr_apply 
                                      (
                                          parent_id,
                                          name,
                                          phone,
                                          wechat,
                                          status,
                                          note,
                                          apply_time,
                                          serviceName,
                                          servicePhone
                                      )
                               VALUES
                                      (
                                          '$this->parent_id',
                                          '$this->name',
                                          '$this->phone',
                                          '$this->wechat',
                                          '$this->status',
                                          '$this->note',
                                          NOW(),
                                          '$this->serviceName',
                                          '$this->servicePhone'
                                      )";
        return parent::aud($sql);
    }

//    //获取所有申请人
//    public function getApply(){
//        $sql = "SELECT
//						id,
//						name,
//						phone,
//						status,
//						apply_time
//				  FROM
//				  		lcr_apply
//			  ORDER BY
//			  			status ASC,
//			  			id DESC";
//        return parent::all($sql);
//    }

    //获取所有申请人
    public function getApply(){
        $sql = "SELECT
						a.id,
						a.name,
						a.phone,
						a.status,
						a.apply_time,
						a.consultantId,
						a.note,
						IF(a.parent_id=0,'顶级联创人',b.name) AS parent_name
				  FROM
				  		lcr_apply a LEFT JOIN lcr_apply b
				  	ON 
				  	    a.parent_id = b.id
			  ORDER BY
			  			a.id DESC";
        return parent::all($sql);
    }


    //查找单个申请人
    public function  getOneApply(){
        $sql = "SELECT
						*
				  FROM
				  		lcr_apply
				 WHERE
				 		id = '$this->id'
				 LIMIT
				 		1";
        return parent::one($sql);
    }

    //查找单个申请人带推荐人信息
    public function  getOneApplyFull(){
        $sql = "SELECT
						a.id,
						a.parent_id,
						a.name,
						a.phone,
						a.wechat,
						a.apply_time,
						a.status,
						a.note,
						a.consultantId,
						b.name AS referee_name,
						b.phone AS referee_phone,
						b.id AS referee_id
				  FROM
				  		(SELECT * FROM lcr_apply WHERE id = '$this->id') a LEFT JOIN lcr_apply b
				    ON
				 		 a.parent_id = b.id
				 LIMIT
				 		1";
        return parent::one($sql);
    }


    //通过手机号查找申请人
    public function getOneApplyFromPhone(){
        $sql = "SELECT
						id,
						name,
						phone,
						wechat,
						apply_time,
						status,
						openid,
						wx_nickname
				  FROM
				  		lcr_apply
				  WHERE 
				        phone = '$this->phone'
				 LIMIT
				 		1";
        return parent::one($sql);
    }

    //通过openid查询单个申请人
    public function getOneApplyFromOpenid(){
        $sql = "SELECT
						id,
						name,
						phone,
						wechat,
						apply_time,
						status,
						ext_phone,
						consultantId
				  FROM
				  		lcr_apply
				  WHERE 
				        openid = '$this->openid'
				 LIMIT
				 		1";
        return parent::one($sql);
    }

    //写入通过手机号写入单个申请人的微信用户信息
    public function updateOpenidFromPhone(){
        $sql = "UPDATE
						lcr_apply
				   SET
				   		openid = '$this->openid',
				   		wx_nickname = '$this->wx_nickname',
				   		wx_sex = '$this->wx_sex',
				   		wx_province = '$this->wx_province',
				   		wx_city = '$this->wx_city',
				   		wx_country = '$this->wx_country',
				   		wx_headimgurl = '$this->wx_headimgurl'
				 WHERE
				 		phone = '$this->phone'
				 LIMIT  1";
        return parent::aud($sql);
    }

    //查找下级申请人
    public function getSubApply(){
//        $sql = "SELECT
//						id,
//						name,
//						phone,
//						wechat,
//						apply_time,
//						status,
//						serviceName,
//						consultantId
//				  FROM
//				  		lcr_apply
//				  WHERE
//				        parent_id = '$this->id'
//			  ORDER BY
//			  			status ASC,
//			  			id DESC";
        $sql = "SELECT
                        a.id,
                        a.name,
                        a.phone,
                        a.wechat,
                        a.apply_time,
                        a.status,
                        a.serviceName,
                        a.consultantId,
                        b.name as cName,
                        b.phone as cPhone
                  FROM
                           (
                               SELECT
                                        *
                                  FROM
                                        lcr_apply
                                  WHERE 
                                        parent_id = '$this->id'
                           ) a
            LEFT JOIN 
                          lcr_consultants b
                   ON 
                          a.consultantId = b.id
				        
			  ORDER BY
			  			a.status ASC,
			  			a.id DESC";
        return parent::all($sql);
    }

    //修改申请人
    public function updateApply(){
        $sql = "UPDATE
						lcr_apply
				   SET
				   		name = '$this->name',
				   		phone = '$this->phone',
				   		wechat = '$this->wechat',
				   		status = '$this->status',
				   		note = '$this->note'
				 WHERE
				 		id = '$this->id'
				 LIMIT  1";
        return parent::aud($sql);
    }
    //修改申请人(同时新增或删除积分记录)
    public function updateApply_t(){
        $args = func_get_args();
        $sql = "UPDATE
						lcr_apply
				   SET
				   		name = '$this->name',
				   		phone = '$this->phone',
				   		wechat = '$this->wechat',
				   		status = '$this->status',
				   		note = '$this->note',
				   		ext_phone = '$this->ext_phone',
				   		consultantId = '$this->consultantId',
				   		region = '$this->region'
				 WHERE
				 		id = '$this->id'
				 LIMIT  1";
        array_unshift($args, $sql);
        return parent::aud_t($args);
    }
}