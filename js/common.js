/*
 * 知识点
 * js
 * -------------------------------------------
 * 获取父节点 node.parentNode
 * 获取节点属性 node.getAttribute(attr)
 * 设置节点属性 node.setAttribute(attr, value)
 *
 * css
 * --------------------------------------------
 * 设置placeholder颜色
 .placeholderColor{}
 .placeholderColor::-webkit-input-placeholder {
 color: red;
 }
 .placeholderColor:-moz-placeholder {
 color: red;
 }
 .placeholderColor::-moz-placeholder{
 color: red;
 }
 .placeholderColor:-ms-input-placeholder {
 color: red;
 }
 *
 *
 *
 */

//封装ajax
function ajax(obj) {
    var xhr = new XMLHttpRequest();
    obj.url += "?rand="+Math.random();
    obj.data = params(obj.data);
    if (obj.method == 'get') obj.url += (obj.url.indexOf('?') == -1 ? '?' : '&') + obj.data;
    if (obj.async) {
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    obj.success(xhr.responseText); //回调传递参数
                } else {
                    return "读取数据错误，错误代码：" + xhr.status + "错误信息： " + xhr.statusText;
                }
            }
        }
    }
    xhr.open(obj.method, obj.url, obj.async);
    if (obj.method == 'post'){
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(obj.data);
    }else{
        xhr.send();
    }
    if(!obj.async){
        if (xhr.status == 200) {
            obj.success(xhr.responseText); //回调传递参数
        } else {
            return "读取数据错误，错误代码：" + xhr.status + "错误信息： " + xhr.statusText;
        }
    }
}

//名值对转换
function params(data) {
    var arr = [];
    for(i in data){
        arr.push(encodeURIComponent(i) + '=' + encodeURIComponent(data[i]));
    }
    return arr.join('&');
}

//设置placeholder字体颜色，仅用于bootstrap
var placeholderColor = function (node, str) {
    node.parentNode.className = node.parentNode.className.replace(/has-error|has-success/, '');
    if (node.value.length == 0){
        node.parentNode.className += ' has-error';
        node.setAttribute('placeholder', str);
        node.className += ' placeholderColor';
    } else {
        node.parentNode.className += ' has-success';
    }
}

//获取url参数
Request = {
    QueryString : function(item){
        var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
        return svalue ? svalue[1] : svalue;
    }
}

/*以下为cookie*/

//设置cookie 封装
function setCookie(name, value, expires, path, domain, secure) {
    var cookieText = encodeURIComponent(name) + '=' + encodeURIComponent(value);
    if (expires instanceof Date){
        cookieText += ';expires=' + expires;
    }
    if (path){
        cookieText += ';path=' + path;
    }
    if(domain){
        cookieText += ';domain=' + domain;
    }
    if (secure){
        cookieText += ';secure';
    }
    document.cookie = cookieText;
}

//获取cookie 封装
function getCookie(name) {
    var cookieName =encodeURIComponent(name) + '=';
    var cookieStart = document.cookie.indexOf(cookieName);
    var cookieValue = null;
    if (cookieStart > -1){
        var cookieEnd = document.cookie.indexOf(';',cookieStart);
        if (cookieEnd == -1){
            cookieEnd = document.cookie.length;
        }
        cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
    }
    return cookieValue;
}

//过期时间
function setCookieExpires(second) {  //传递一个秒数
    var Expires = null;
    if (typeof second == 'number' && second > 0){
        Expires = new Date();
        Expires.setTime(Expires.getTime() + second*1000);
    }else{
        throw new Error('您传递的时间不合法！必须是数字且大于0。');
    }
    return Expires;
}
