<?php

/**
 * Created by PhpStorm.
 * User: Ren    wecat: yyloon
 * Date: 2017/4/7 0007
 * Time: 上午 10:01
 * 发送微信模板消息
 */
class WXTemplateMsg{
    private $postArr;

    public function __construct($postArr){
        if (!isset($_SESSION)) session_start();
        $this->postArr = $postArr;
        if (is_array($postArr) && !empty($postArr)) $this->send();
    }

    //返回access_token
    public function getWxAccessToken(){
        //将access_token存在session/cookie中
        if (isset($_SESSION['access_token']) && $_SESSION['expire_time'] > time()){
            //如果$_SESSION['access_token']存在，并且没有过期
            return $_SESSION['access_token'];
        }else {
            //请求URL地址
            $appId = 'wx196c2f6fac038737';
            $appSecret = '88961531e80a670eee500aeaa7a78a5a';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
            $res = Tool::httpCurl($url);
            $arr = json_decode($res, true);
            $_SESSION['access_token'] = $arr['access_token'];
            $_SESSION['expire_time'] = time() + 7000; //7200-200
            return $arr['access_token'];
        }
    }

    /*模板消息*/
    public function send(){
        //获取access_token
        $accessToken = $this->getWxAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$accessToken;
        //数组转成json
        $postJson = json_encode($this->postArr);
        //调用curl函数
        $res = Tool::httpCurl($url,'post', 'json', $postJson);
    }


}