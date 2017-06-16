<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/24 0024
 * Time: 下午 2:37
 */
class StudentModel extends Model {

    private $id;
    private $owner_id;
    private $name;
    private $sex;
    private $project_id;
    private $phone;
    private $hedu;
    private $note;
    private $status;

    public function __set($name, $value)
    {
        $this->$name = Tool::mysqlString($value);
    }
    public function __get($name)
    {
        return $this->$name;
    }

    //获取某个人的学员总数
    public function getOwnerStudentCount(){
        $sql = "SELECT
                        COUNT(id) as studentCount
                  FROM
                        lcr_students
                 WHERE
                        owner_id = '$this->owner_id'";
        return parent::one($sql);
    }

    //查询所有学员
    public function getAllStudents(){
        $sql = "SELECT 
                        s.id,
                        s.name,
                        p.name as project,
                        p.brief_name as brief_project,
                        s.phone,
                        s.ctime
                  FROM
                          lcr_students s,
                          lcr_projects p
                 WHERE
                        s.project_id = p.id
              ORDER BY
                        id DESC";
        return parent::all($sql);
    }

    //查询所有学员(联接申请表与项目表，调出录入人与项目)
    public function getAllStudentsFull(){
        $sql = "SELECT 
                        s.id,
                        s.owner_id,
                        s.name,
                        p.name AS project,
                        p.brief_name AS brief_project,
                        s.phone,
                        s.ctime,
                        IF(s.owner_id=0,'内部添加',a.name) AS owner_name
                  FROM
                          lcr_students s
             LEFT JOIN
                        lcr_projects p
                    ON
                        s.project_id = p.id
             LEFT JOIN
                        lcr_apply a
                    ON
                        s.owner_id = a.id
                        
              ORDER BY
                        id DESC";
        return parent::all($sql);
    }

    //查询自建学员
    public function getOwnStudents(){
        $sql = "SELECT 
                        s.id,
                        s.name,
                        p.name as project,
                        p.brief_name as brief_project,
                        s.phone,
                        s.status,
                        s.ctime
                  FROM
                          lcr_students s,
                          lcr_projects p
                 WHERE
                        s.project_id = p.id
                   AND
                        s.owner_id = '$this->owner_id'
              ORDER BY
                        id DESC";
        return parent::all($sql);
    }
    //查询自建赢单学员
    public function getOwnWinStudents(){
        $sql = "SELECT 
                        s.id,
                        s.name,
                        p.name as project,
                        p.brief_name as brief_project,
                        s.phone,
                        s.ctime
                  FROM
                          lcr_students s,
                          lcr_projects p
                 WHERE
                        s.project_id = p.id
                   AND
                        s.owner_id = '$this->owner_id'
                   AND
                        s.status = 1
              ORDER BY
                        id DESC";
        return parent::all($sql);
    }

    //查询下级学员
    public function getSubOwnStudents(){}

    //查询单个学员
    public function getOneStudent(){
        $sql = "SELECT 
                        a.id,
                        a.owner_id,
                        a.name,
                        a.sex,
                        a.project_id,
                        a.phone,
                        a.hedu,
                        a.note,
                        a.status,
                        a.ctime,
                        b.point
                  FROM
                        (SELECT * FROM lcr_students WHERE id = '$this->id') a
             LEFT JOIN 
                        lcr_points b
                    ON 
                        a.id = b.sid";
        return parent::one($sql);
    }

    //新增学员
    public function addStudent(){
        $sql = "INSERT INTO 
							lcr_students
									   (
									        owner_id,
											name,
											phone,
											sex,
											project_id,
											hedu,
											note,
											ctime
										)
								VALUES
										(
											'$this->owner_id',
											'$this->name',
											'$this->phone',
											'$this->sex',
											'$this->project_id',
											'$this->hedu',
											'$this->note',
											NOW()
										)";
        return parent::aud($sql);
    }
    //新增学员
    public function addStudent_t(){
        $args = func_get_args();
        $sql = "INSERT INTO 
							lcr_students
									   (
									        owner_id,
											name,
											phone,
											sex,
											project_id,
											hedu,
											note,
											ctime
										)
								VALUES
										(
											'$this->owner_id',
											'$this->name',
											'$this->phone',
											'$this->sex',
											'$this->project_id',
											'$this->hedu',
											'$this->note',
											NOW()
										)";
        array_unshift($args, $sql);
        return parent::aud_t($args);
    }

    //修改学员
    public function updateStudent(){
        $sql = "UPDATE
						lcr_students
				   SET
				   		owner_id = '$this->owner_id',
				   		name = '$this->name',
				   		sex = '$this->sex',
				   		project_id = '$this->project_id',
				   		phone = '$this->phone',
				   		hedu = '$this->hedu',
				   		note = '$this->note',
				   		status = '$this->status'
				 WHERE
				 		id = '$this->id'
				 LIMIT  1";
        return parent::aud($sql);
    }
    //修改学员(同时修改积分)
    public function updateStudent_t(){
        $args = func_get_args();
        $sql = "UPDATE
						lcr_students
				   SET
				   		owner_id = '$this->owner_id',
				   		name = '$this->name',
				   		sex = '$this->sex',
				   		project_id = '$this->project_id',
				   		phone = '$this->phone',
				   		hedu = '$this->hedu',
				   		note = '$this->note',
				   		status = '$this->status'
				 WHERE
				 		id = '$this->id'
				 LIMIT  1";
        array_unshift($args, $sql);
        return parent::aud_t($args);
    }


    //删除学员
    public function deleteStudent(){}

    //搜索学员
    public function searchStudents(){}

}