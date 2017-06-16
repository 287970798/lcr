window.onload = function () {
    //查询二维码表单验证
    var qrcodeForm = document.getElementById('qrcodeForm');
    qrcodeForm.phone.onblur = function () {
        this.value = this.value.replace(' ', '');
        placeholderColor(this, '必须输入手机号');
    }
    qrcodeForm.onsubmit = function () {
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
        return true;
    }

}