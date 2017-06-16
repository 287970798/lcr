window.onload = function () {
    var loginForm = document.getElementById('loginForm');
    loginForm.user.onblur = function () {
        this.value = this.value.replace(/\s/g, '');
        placeholderColor(this, '必须填写用户名');
    }
    loginForm.password.onblur = function () {
        placeholderColor(this, '必须填写密码');
    }
    loginForm.onsubmit = function () {
        if (this.user.value.length == 0){
            placeholderColor(this.user, '必须填写用户名');
            this.user.focus();
            return false;
        }
        if (this.password.value.length == 0){
            placeholderColor(this.password, '必须填写密码');
            this.password.focus();
            return false;
        }
        return true;
    }
}