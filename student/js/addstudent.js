/**
 * Created by Administrator on 2017/2/28 0028.
 */
window.onload = function () {
    var studentForm = document.getElementById('studentForm');
    var validateData = {
        name : '必须填写姓名',
        phone : '必须填写手机号',
        sex : '请选择性别',
        project : '请选择意向项目',
        hedu : '请选择学历'
    }
    //失焦
    for (var i in validateData){
        studentForm[i].onblur = function (i) {
            return function () {
                this.value = this.value.replace(/\s/g, '');
                placeholderColor(this,validateData[i]);
            }
        }(i);
    }

    //提交
    studentForm.onsubmit = function () {
        for (var i in validateData){
            if (this[i].value.length == 0){
                placeholderColor(this[i],validateData[i]);
                this[i].focus();
                return false;
            }
        }
    }
    studentForm.project.onchange = function () {
        var pid = this.value;
        if (pid != ''){
        studentForm.send.disabled = true;
            ajax({
                method : 'get',
                url : 'add.php',
                data : {
                    'js' : '',
                    'id' : pid
                },
                success : function (text) {
                    studentForm.point.value = text;
                    studentForm.send.disabled = false;
                },
                async : false
            });
        }
    }
}
