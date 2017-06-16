<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/2/24 0024
 * Time: 下午 2:17
 */
class ProjectModel extends Model {
    private $id;
    private $name;
    private $brief_name;
    private $point;
    private $catalogLink;
    private $note;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __get($name)
    {
        return $this->$name;
    }

    //查询所有项目
    public function allProjects(){
        $sql = "SELECT
                        id,
                        brief_name,
                        point,
                        name,
                        note,
                        catalogLink
                  FROM
                        lcr_projects
              ORDER BY
                        point ASC";
        return parent::all($sql);
    }

    //查询单个项目
    public function oneProject(){
        $sql = "SELECT
                        id,
                        brief_name,
                        name,
                        point,
                        catalogLink,
                        note
                  FROM
                        lcr_projects
                 WHERE
                        id = '$this->id'";
        return parent::one($sql);
    }

    //新增项目
    public function add(){
        $sql = "INSERT INTO 
							lcr_projects
									   (
											brief_name,
											name,
											point,
											catalogLink,
											note
										)
								VALUES
										(
											'$this->brief_name',
											'$this->name',
											'$this->point',
											'$this->catalogLink',
											'$this->note'
										)";
        return parent::aud($sql);
    }

    //修改项目
    public function update(){
        $sql = "UPDATE
						lcr_projects
				   SET
				   		brief_name = '$this->brief_name',
				   		name = '$this->name',
				   		point = '$this->point',
				   		catalogLink = '$this->catalogLink',
				   		note = '$this->note'
				 WHERE
				 		id = '$this->id' 
				 LIMIT 
				 		1";
        return parent::aud($sql);
    }
    //删除项目
    public function delete(){
        $sql = "DELETE FROM
							lcr_projects
					  WHERE
					  		id = '$this->id'
					  LIMIT
					  		1";
        return parent::aud($sql);
    }

}