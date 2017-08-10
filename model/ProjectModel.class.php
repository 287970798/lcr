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
    private $category;  //类别
    private $list_order;    //排序

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __get($name)
    {
        return $this->$name;
    }

    //查询所有项目
    public function allProjects2(){
        $sql = "SELECT
                        id,
                        brief_name,
                        point,
                        name,
                        note,
                        catalogLink,
                        category
                  FROM
                        lcr_projects
              ORDER BY
                        category ASC,
                        list_order ASC,
                        point DESC";
        return parent::all($sql);
    }
    //查询所有项目
    public function allProjects(){
        $sql = "SELECT
                        a.id,
                        a.brief_name,
                        a.point,
                        a.name,
                        a.note,
                        a.catalogLink,
                        a.category,
                        a.list_order,
                        b.list_order as b_list_order,
                        b.name as category_name
                  FROM
                        lcr_projects AS a
             LEFT JOIN
                        lcr_project_categorys AS b
                    ON 
                        a.category = b.id
              ORDER BY
                        b.list_order ASC ,
                        a.category ASC,
                        a.list_order ASC,
                        a.point DESC";
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
                        note,
                        category,
                        list_order
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
											note,
											category,
											list_order
										)
								VALUES
										(
											'$this->brief_name',
											'$this->name',
											'$this->point',
											'$this->catalogLink',
											'$this->note',
											'$this->category',
											'$this->list_order'
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
				   		note = '$this->note',
                        category = '$this->category',
                        list_order = '$this->list_order'
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