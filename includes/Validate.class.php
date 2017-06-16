<?php
//验证类
class Validate{
	//是否为空
	static public function checkNull($data){
		if (trim($data) == '') return true;
		return false;
	}
	//数据是否为数字
	static public function checkNum($data){
		if (!is_numeric($data)) return true;
		return false;
	}
	//长度是否合法
	static public function checkLength($data,$length,$flag){
		if ($flag == 'min') {
			if (mb_strlen(trim($data),'utf-8') < $length) return true;
			return false;
		}
		if ($flag == 'max') {
			if (mb_strlen(trim($data),'utf-8') > $length) return true;
			return false;
		}
		if ($flag == 'equals') {
			if (mb_strlen(trim($data),'utf-8') != $length) return true;
			return false;
		}
		Tool::alertBack('ERROR:参数错误，必须为min,max！');
	}
	//数据是否一致
	static public function checkEquals($data,$otherData){
		if(trim($data) != trim($otherData)) return true;
		return false;
	}
	//验证电子邮件
	static function checkEmail($data){
		if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $data)) return true;
		return false;
	}
	//session验证
	static public function checkSession($name = 'admin', $url = ''){
        if (empty($url)) $url = WEB_PATH."/admin/login.php";
		if (!isset($_SESSION[$name])) Tool::alertLocation('', $url);
	}
	//权限
	static public function checkPermission($data, $info){
		if(!in_array($data, explode(',', $_SESSION['admin']['permission']))) Tool::alertBack($info);
	}
}