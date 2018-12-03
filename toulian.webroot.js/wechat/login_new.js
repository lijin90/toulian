// 手机登录-验证码倒计时
function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('a.login_mobile_code_send').text('发送验证码');
        return;
    }
    $('a.login_mobile_code_send').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function () {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function ($) {
    // 登录方式切换
    $(".login_mixed_way li").click(function () {
        var $self = $(this);
        $(this).addClass("current").siblings().removeClass("current");
        $(".login_mixed_method_con .login_mixed_method").eq($self.index()).addClass("show_login").siblings().removeClass("show_login");
    });
//    手机的登录
    $('a.login_mobile_code_send').click(function () {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        if ($(this).text() !== '发送验证码') {
            $(self).removeAttr('data-clicked');
            return;
        }
        var mobile = $('input[name=login_mobile]').val();
        if ($.trim(mobile) === '') {
            layer.open({content: '手机号码不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile, usage: 'login'}, function (ret) {
            if (ret.code === 0) {
                layer.open({
                    content: ret.msg,
                    time: 2,
                    end: function () {
                        SmscodeCounter(60);
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json');
    });
    $('#login_mobile_confirm').click(function () {
        var mobile = $.trim($('input[name=login_mobile]').val());
        var smsCode = $.trim($('input[name=login_mobile_code]').val());
        var autoLogin = $('input[name=login_mobile_autologin]').is(":checked");
        if ($.trim(mobile) === '') {
            layer.open({content: '手机号码不能为空', time: 2});
            return false;
        }
        if ($.trim(smsCode) === '') {
            layer.open({content: '验证码不能为空', time: 2});
            return false;
        }
        $.post(T.baseUrl + '/user/loginMobileCode.html', {
            mobile: mobile,
            smsCode: smsCode,
            rememberMe: (autoLogin ? 1 : 0)
        }, function (ret) {
            if (ret.code === 0) {
                layer.open({
                    content: '登录成功',
                    time: 2,
                    end: function () {
                        location.href = ret.data.returnUrl;
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
        }, 'json').error(function (xhr, textStatus, errorThrown) {
            layer.msg('登录失败，请刷新页面重试！', {icon: 0});
        });
    });
//    账户登录
    $('#login_confirm').click(function () {
        var username = $.trim($('input[name=login_username]').val());
        var password = $.trim($('input[name=login_password]').val());
        var autoLogin = $('input[name=login_autologin]').is(":checked");
        if ($.trim(username) === '') {
            layer.open({content: '账户名不能为空', time: 2});
            return false;
        }
        if ($.trim(password) === '') {
            layer.open({content: '密码不能为空', time: 2});
            return false;
        }
        $.post(T.baseUrl + '/user/login.html', {
            mobile: username,
            smsCode: password,
            rememberMe: (autoLogin ? 1 : 0)
        }, function (ret) {
            if (ret.code === 0) {
                layer.open({
                    content: '登录成功',
                    time: 2,
                    end: function () {
                        location.href = ret.data.returnUrl;
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
        }, 'json').error(function (xhr, textStatus, errorThrown) {
            layer.msg('登录失败，请刷新页面重试！', {icon: 0});
        });
    });
});

