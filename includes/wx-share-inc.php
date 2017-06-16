<?php
	session_start();
	$appId = 'wx196c2f6fac038737';
	//获取票据
	$jsApiTicket = getJsApiTicket();
	$timestamp = time();
	$nonceStr = getRandCode();
	$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	//获取signature
	$signature = "jsapi_ticket=".$jsApiTicket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
	$signature = sha1($signature);
	
	//获取jsapi_ticket全局票据
	function getJsApiTicket(){
		if (isset($_SESSION['jsApiTicket_expire_time']) && $_SESSION['jsApiTicket_expire_time'] > time() && $_SESSION['jsApiTicket']) {
			$jsApiTicket = $_SESSION['jsApiTicket'];
		} else {
			$access_token = getWxAccessToken(); //??
			$url = 	"https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
			$res = http_curl($url); //??
			$jsApiTicket = $res['ticket'];
			$_SESSION['jsApiTicket'] = $jsApiTicket;
			$_SESSION['jsApiTicket_expire_time'] = time() + 7000;
		}
		return $jsApiTicket;
	}
	//获取随机码
	function getRandCode($length = 16){
		$array = array(
			'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
			'1','2','3','4','5','6','7','8','9'
		);
		$tmpStr = '';
		$max = count($array);
		for($i = 1; $i <= $length; $i++){
			$key = rand(0, $max - 1);
			$tmpStr .= $array[$key];
		}
		return $tmpStr;
	}
	function getWxAccessToken(){
		//1.请求URL地址
		$appId = 'wx196c2f6fac038737';
		$appSecret = '88961531e80a670eee500aeaa7a78a5a';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
		$arr = http_curl($url);
		return $arr['access_token'];
	}
	function http_curl($url){
		//1.初始化
		$ch = curl_init();
		// 2.设置参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		// 4.调用接口
		$res = curl_exec($ch);
		if (curl_errno($ch)) {
			var_dump(curl_error($ch));
		}
		// 5.关闭curl
		curl_close($ch);
		$arr = json_decode($res, true);
		return $arr;
	}
?>