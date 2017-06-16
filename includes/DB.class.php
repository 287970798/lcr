<?php
//数据库连接类
class DB{
	//获取对象句柄
	static function getDB(){
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME,DB_PORT);
		if(mysqli_connect_errno()){
			exit("数据库连接错误".mysqli_connect_error());
		}
		$mysqli->set_charset('utf8');
		return $mysqli;	
	}

	//清理
	static function unDB(&$mysqli,&$result = null){
		if(is_object($result)){
			$result->free();
			$result = null;
		}
		if (is_object($mysqli)) {
			if ($mysqli->errno) {
			    exit("数据库操作出错！".$mysqli->error);
			}
			$mysqli->close();
			$mysqli = null;
		}
	}
}