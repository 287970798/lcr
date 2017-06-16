window.onload = function () {
    //apply表单验证
    var applyForm = document.getElementById('applyForm');
    applyForm.name.onblur = function () {
        this.value = this.value.replace(' ', ''); //失焦时删除空格
        placeholderColor(this, '必须输入姓名');
    }
    applyForm.phone.onblur = function () {
        this.value = this.value.replace(' ', '');
        placeholderColor(this, '必须输入手机号');
    }
    applyForm.vcode.onblur = function () {
        this.value = this.value.replace(' ', '');
        placeholderColor(this, '必须输入验证码');
    }
    applyForm.onsubmit = function(){
        if (this.phone.value.length == 0){
            placeholderColor(this.phone, '必须输入手机号');
            this.phone.focus();
            return false;
        }
        if (isNaN(this.phone.value)){
            alert('手机号必须为数字！');
            this.phone.focus();
            return false;
        }
        if (this.phone.value.length != 11){
            alert('手机号必须为11位！');
            this.phone.focus();
            return false;
        }
        if (this.vcode.value.length == 0){
            placeholderColor(this.vcode, '必须输入验证码');
            this.vcode.focus();
            return false;
        }
        if (this.vcode.value != getCookie('code') || this.phone.value != getCookie('phone')){
            placeholderColor(this.vcode, '验证码不正确');
            alert('验证码不正确！');
            this.vcode.focus();
            return false;
        }
        if (this.name.value.length == 0){
            placeholderColor(this.name, '必须输入姓名');
            this.name.focus();
            return false;
        }
        ///////////
        var ck = this.i1;
        for (var i=0; i<ck.length;i++){
            if(ck[i].checked==false){
                alert('请勾选所有列表项');
                ck[i].focus();
                return false;
            }
        }
        /////////


        return true;
    }

    checkAgreement();
    applyForm.agreement.onchange = checkAgreement;
    function checkAgreement() {
        applyForm.submit.disabled = !applyForm.agreement.checked;
    }
    //发送验证码
    var getVcode = applyForm.getVcode;
    getVcode.onclick = function () {
        //验证手机号
        if (applyForm.phone.value.length == 0){
            placeholderColor(applyForm.phone, '必须输入手机号');
            applyForm.phone.focus();
            return false;
        }
        if (isNaN(applyForm.phone.value)){
            alert('手机号必须为数字！');
            applyForm.phone.focus();
            return false;
        }
        if (applyForm.phone.value.length != 11){
            alert('手机号必须为11位！');
            applyForm.phone.focus();
            return false;
        }

        //发送按钮禁用
        this.disabled = true;
        //请求发送验证码
        ajax({
            method : 'post',
            url : 'index.php',
            data : {
                'phone' : applyForm.phone.value,
                'type' : 'check'
            },
            success : function(text){
                console.log(text);
                //如果手机号未注册，则发送验证码
                if(text=='t'){
                    ajax({
                        method : 'post',
                        url : 'test.php',
                        data : {
                            'phone' : applyForm.phone.value
                        },
                        success : function(result){
                            console.log(result);
                            var result = JSON.parse(result);
                            setCookie('code',result.code,setCookieExpires(10*60));
                            setCookie('phone',result.phone,setCookieExpires(10*60));

                            //设置1分钟读秒
                            var second = 60;
                            this.innerHTML = second + 'S';
                            var timer = setInterval(vTimeFunc,1000);
                            function vTimeFunc() {
                                if (second > 0){
                                    second--;
                                    getVcode.innerHTML = second + 'S';
                                }else{
                                    clearInterval(timer);
                                    getVcode.disabled = false;
                                    getVcode.innerHTML = '重新获取';
                                }

                            }
                        },
                        async : true

                    });
                }else{
                    alert('您已提交过注册，请不要重复提交！');
                    getVcode.disabled = false;
                    getVcode.innerHTML = '重新获取';
                    return false;
                }
            },
            async : true
        });
    }

}

