function loginInit() {
    $('#verifyCodeRefresh').click(function() {
        $(this).children('img').attr('src', T.baseUrl + '/user/verifyCode.html?refresh=' + Math.random());
    });
    $('#confirmlogin').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var username = $.trim($('#username').val());
        var password = $.trim($('#password').val());
        var verifyCode = $.trim($('#verifyCode').val());
        var autoLogin = false;
        if ($.trim(username) === '') {
            layer.open({content: '登录账户不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return false;
        }
        if ($.trim(password) === '') {
            layer.open({content: '登录密码不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return false;
        }
        if ($.trim(verifyCode) === '') {
            layer.open({content: '验证码不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return false;
        }
        $(self).val('登录中');
        $.post(T.baseUrl + '/user/login.html', {
            username: username,
            password: md5(md5(password) + T.time),
            passwordTime: T.time,
            verifyCode: verifyCode,
            rememberMe: (autoLogin ? 1 : 0)
        }, function(ret) {
            if (ret.code === 0) {
                $(self).val('跳转中...');
                layer.open({
                    content: '登录成功',
                    time: 2,
                    end: function() {
                        location.href = ret.data.returnUrl;
                    }
                });
            } else {
                $(self).val('立即登录');
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            $(self).val('立即登录');
            layer.open({content: '登录失败，请刷新页面重试！', time: 2});
            $(self).removeAttr('data-clicked');
        });
    });
}