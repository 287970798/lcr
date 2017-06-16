<?php
//模型基类
class Model{

	//执行多条SQL语句
	public function multi($sql){
		$mysqli = DB::getDB();
		$mysqli->multi_query($sql);
		DB::unDB($mysqli);
		return true;	
	}

	//获取下一个增值ID模型
	public function nextid($table){
		$sql = "SHOW TABLE STATUS LIKE '$table'";
		return $this->one($sql)->Auto_increment;
	}

	//查找总记录模型
	protected function total($sql){
		$mysqli = DB::getDB();
		$result = $mysqli->query($sql);
		$total = $result->fetch_row();
		DB::unDB($myslqi,$result);
		return $total[0];
	}

	//查找单个数据模型
	protected function one($sql){
		$mysqli = DB::getDB();
		$result = $mysqli->query($sql);
		$row = $result->fetch_object();
		DB::unDB($mysqli,$result);
		return Tool::htmlString($row);
	}

	//查找多个模型
	protected function all($sql){
		$mysqli = DB::getDB();
		$result = $mysqli->query($sql);
		$html = array();
		while($row = $result->fetch_object()){
			$html[] = $row;
		}
		DB::unDB($mysqli,$result);
		return Tool::htmlString($html);		
	}

    //增删改模型
    protected function aud($sql){
        $mysqli = DB::getDB();
        $mysqli->query($sql);
        $affected_rows = $mysqli->affected_rows;
        DB::unDB($mysqli); //
        return $affected_rows;
    }
    //增删改模型-事务处理
    protected function aud_t2($sql1, $sql2){
        $success = false;
        $sql = $sql1.';'.$sql2;
        $mysqli = DB::getDB();
        $mysqli->autocommit(false);
        if ($result = $mysqli->multi_query($sql)){
            $success = $mysqli->affected_rows == 1 ? true : false;
            $mysqli->next_result();
            $success = $mysqli->affected_rows == 1 ? true : false;
        }
        $mysqli->autocommit(true);
        DB::unDB($mysqli); //
        return $success;
    }
    //增删改模型-事务处理
    protected function aud_t(){
        $success = false;

        $tempArgs = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();        //获取参数数组,如果第一个参数为数组，则使用第一个参数，否则使用全部参数
        //删除为空的参数
        foreach ($tempArgs as $v){
            $v != '' ? $args[] = $v : 1;
        }
//        print_r($args);exit;
        $argsNum = count($args);     //获取参数个数
        $sql = '';
        for ($i = 0; $i < $argsNum; $i++){
           $sql .= $args[$i];
           if ($i < $argsNum - 1) $sql .= ';';      //拼装sql
        }
//        exit($sql);
        $mysqli = DB::getDB();
        $mysqli->autocommit(false);
        //循环执行事务
        if ($result = $mysqli->multi_query($sql)){
            for ($i = 0; $i < $argsNum; $i++){
                $success = $mysqli->affected_rows == 1 ? true : false;
                if ($i < $argsNum - 1) $mysqli->next_result();
            }
        }
        $mysqli->autocommit(true);
        DB::unDB($mysqli); //
        return $success;
    }
}