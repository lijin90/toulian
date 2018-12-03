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
        var autoLogin = $('#autologin').is(":checked");
        if ($.trim(username) === '') {
            layer.msg('登录账户不能为空', {icon: 0});
            $(self).removeAttr('data-clicked');
            return false;
        }
        if ($.trim(password) === '') {
            layer.msg('登录密码不能为空', {icon: 0});
            $(self).removeAttr('data-clicked');
            return false;
        }
        if ($.trim(verifyCode) === '') {
            layer.msg('验证码不能为空', {icon: 0});
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
                layer.msg('登录成功', {
                    icon: 1,
                    time: 1500,
                    end: function() {
                        if (location.pathname === '/login.html' || location.pathname === '/user/login.html') {
                            location.href = ret.data.returnUrl;
                        } else {
                            window.location.reload();
                        }
                    }
                });
            } else {
                $(self).val('立即登录');
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            $(self).val('立即登录');
            layer.msg('登录失败，请刷新页面重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });
}
