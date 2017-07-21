<?php
final class Tool{
    //alert
    static  public function alert($info){
        echo "<script type='text/javascript'>alert('$info');</script>";
    }
	//弹窗跳转
	static public function alertLocation($info, $url){
		if (empty($info)) {
			header("location:$url");
		} else {
			echo "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
		}
		exit;
	}
    //弹窗返回
    static public function alertBack($info){
        echo "<script type='text/javascript'>alert('$info');history.back();</script>";
        exit;
    }
    //返回
    static public function back(){
        echo "<script type='text/javascript'>history.back();</script>";
        exit;
    }
	//弹窗关闭
	static public function alertClose($info){
		echo "<script type='text/javascript'>alert('$info');close();</script>";
		exit;
	}
	//弹窗赋值关闭（上传专用）
	static public function alertOpenerClose($info,$path){
		echo "<script type='text/javascript'>alert('$info');</script>";
		echo "<script type='text/javascript'>opener.document.content.thumbnail.value = '$path';</script>";
		echo "<script type='text/javascript'>opener.document.content.pic.src = '$path';opener.document.content.pic.style.display = 'block';</script>";
		echo "<script type='text/javascript'>window.close();</script>";
		exit;
	}
	//将当前文件转换成tpl文件名
	static public function tplName(){
		$str = explode('/', $_SERVER["SCRIPT_NAME"]);
		$str = explode('.', $str[count($str)-1]);
		return $str[0];
	}
	//将html字符串转换成HTML标签
	static public function unHtml($str){
		return htmlspecialchars_decode($str);
	}
	//日期转换
	static public function objDate(&$object, $field='date'){
		if ($object) {
			foreach ($object as $key => $value) {
				$value->$field = date('y-m-d',strtotime($value->$field));
			}
		}
	}
	//将对象数组转换成字符串，并去掉最后的逗号
	static public function objArrToStr($object,$field){
			$html = '';
			if($object){
				foreach ($object as $value) {
					$html .= $value->$field.",";
				}
			}
			return substr($html,0,-1);
	}
	//字符串截取
	static public function subStr($object,$field,$length,$encoding='utf-8'){
		if ($object) {
			if (is_array($object)) {
				foreach ($object as $value) {
					if (mb_strlen($value->$field,$encoding) > $length) $value->$field = mb_substr($value->$field, 0, $length, $encoding)."...";
				}
			} else {
				if (mb_strlen($object,$encoding) > $length){
					return mb_substr($object, 0, $length,$encoding)."...";
				} else {
					return $object;
				}
				
			}
		}
	}
	//显示过滤
	static public function htmlString($data=''){
		$string = '';
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$string[$key] = Tool::htmlString($value);
			}
		} elseif(is_object($data)){
			$string = new stdClass;
			foreach ($data as $key => $value) {
				$string->$key = Tool::htmlString($value);
			}
		} else {
			$string = htmlspecialchars($data);
		}
		return $string;
	}
	//数据库输入过滤
	static public function mysqlString($data){
		$string = '';
		if (GPC) {
			$string = $data;
		} else {
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$string[$key] = Tool::mysqlString($value);
				}
			} elseif(is_object($data)){
				$string = new stdClass;
				foreach ($data as $key => $value) {
					$string->$key = Tool::mysqlString($value);
				}
			} else {
				$string = mysql_escape_string($data);
//                $string = $data;
			}
		}
		return $string;	
	}
	//清理session
	static function unSession(){
		if (session_start()) {
			session_destroy();
		}
	}
	//curl
    function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    /*
     * $url 接口url   string
     * $type 请求类型   string
     * $res 返回数据类型  string
     * $arr 请求参数    string
     * */
    function httpCurl($url, $type = 'get', $res = '', $arr=''){
        //初始化curl
        $ch = curl_init();
        //设置参数
        curl_setopt($ch, CURLOPT_URL, $url);            //url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //设置返回采集到的数据
        if ($type == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);          //定义POST方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //采集
        $output = curl_exec($ch);
        //关闭
        if (curl_errno($ch)) return curl_errno($ch);
        curl_close($ch);
        if ($res == 'json'){
            return json_decode($output, true);
        }
        return $output;
    }
}