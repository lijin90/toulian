// 手机登录-验证码倒计时
function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('a.login_mobile_code_send').text('发送验证码');
        return;
    }
    $('a.login_mobile_code_send').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function() {
        SmscodeCounter(seconds);
    }, 1000);
}
// 账户登录-提交
function loginSubmit(captchaObj) {
    $('.error.login_username').text('');
    $('.error.login_password').text('');
    var username = $.trim($('input[name=login_username]').val());
    var password = $.trim($('input[name=login_password]').val());
    var validate = captchaObj.getValidate();
    var autoLogin = $('input[name=login_autologin]').is(":checked");
    if ($.trim(username) === '') {
        $('.error.login_username').text('登录账户不能为空');
        $('input[name=login_username]').focus();
        return false;
    }
    if ($.trim(password) === '') {
        $('.error.login_password').text('登录密码不能为空');
        $('input[name=login_password]').focus();
        return false;
    }
    if (!validate) {
        layer.msg('请先完成滑块拼图验证', {icon: 0});
        return false;
    }
    $.post(T.baseUrl + '/user/login.html', {
        scenario: 'geetest',
        geetest_challenge: validate.geetest_challenge,
        geetest_validate: validate.geetest_validate,
        geetest_seccode: validate.geetest_seccode,
        username: username,
        password: md5(md5(password) + T.time),
        passwordTime: T.time,
        rememberMe: (autoLogin ? 1 : 0)
    }, function(ret) {
        if (ret.code === 0) {
            layer.msg('登录成功', {
                icon: 1,
                time: 1500,
                end: function() {
                    location.href = ret.data.returnUrl;
                }
            });
        } else {
            layer.msg(ret.msg, {
                icon: 0,
                end: function() {
                    captchaObj.refresh();
                }
            });
        }
    }, 'json').error(function(xhr, textStatus, errorThrown) {
        layer.msg('登录失败，请刷新页面重试！', {
            icon: 0,
            end: function() {
                captchaObj.refresh();
            }
        });
    });
}
// 扫码登录-检测
function wechatScanChecking() {
    if (!window.wechatScanSwitch) {
        return;
    }
    var guid = $('#login_wechat_qrcode').attr('data-guid');
    $.get(T.baseUrl + '/user/loginWechatScan.html', {guid: guid}, function(ret) {
        if (ret.code === 0) {
            layer.msg(ret.msg, {
                icon: 1,
                time: 1500,
                end: function() {
                    location.href = ret.data.returnUrl;
                }
            });
        } else if (ret.code === 2) {
            $('#login_wechat_qrcode').siblings('.login_wechat_qrcode_scanned').show();
            window.setTimeout(function() {
                wechatScanChecking();
            }, 2000);
        } else {
            $('#login_wechat_qrcode').siblings('.login_wechat_qrcode_scanned').hide();
            //layer.msg(ret.msg, {icon: 0});
            window.setTimeout(function() {
                wechatScanChecking();
            }, 2000);
        }
    }, 'json').error(function(xhr, textStatus, errorThrown) {
        window.setTimeout(function() {
            wechatScanChecking();
        }, 2000);
    });
}
jQuery(function($) {
    if (T.user.isGuest) {
        // 手机登录
        $('a.login_mobile_code_send').click(function() {
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
                $('.error.login_mobile').text('手机号码不能为空');
                $('input[name=login_mobile]').focus();
                $(self).removeAttr('data-clicked');
                return;
            }
            $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile, usage: 'login'}, function(ret) {
                if (ret.code === 0) {
                    layer.msg(ret.msg, {
                        icon: 1,
                        time: 1500,
                        end: function() {
                            SmscodeCounter(60);
                        }
                    });
                } else {
                    layer.msg(ret.msg);
                }
                $(self).removeAttr('data-clicked');
            }, 'json');
        });
        $('#login_mobile_confirm').click(function() {
            $('.error.login_mobile').text('');
            $('.error.login_mobile_code').text('');
            var mobile = $.trim($('input[name=login_mobile]').val());
            var smsCode = $.trim($('input[name=login_mobile_code]').val());
            var autoLogin = $('input[name=login_mobile_autologin]').is(":checked");
            if ($.trim(mobile) === '') {
                $('.error.login_mobile').text('手机号码不能为空');
                $('input[name=login_mobile]').focus();
                return false;
            }
            if ($.trim(smsCode) === '') {
                $('.error.login_mobile_code').text('验证码不能为空');
                $('input[name=login_mobile_code]').focus();
                return false;
            }
            $.post(T.baseUrl + '/user/loginMobileCode.html', {
                mobile: mobile,
                smsCode: smsCode,
                rememberMe: (autoLogin ? 1 : 0)
            }, function(ret) {
                if (ret.code === 0) {
                    layer.msg('登录成功', {
                        icon: 1,
                        time: 1500,
                        end: function() {
                            location.href = ret.data.returnUrl;
                        }
                    });
                } else {
                    layer.msg(ret.msg, {icon: 0});
                }
            }, 'json').error(function(xhr, textStatus, errorThrown) {
                layer.msg('登录失败，请刷新页面重试！', {icon: 0});
            });
        });
        // 账户登录
        var handlerGeetest = function(captchaObj) {
            // 弹出式需要绑定触发验证码弹出按钮
            captchaObj.bindOn("#login_confirm");
            // 将验证码加到id为captcha的元素里
            captchaObj.appendTo("#popup-captcha");
            // 验证成功时调用callback函数。
            captchaObj.onSuccess(function() {
                loginSubmit(captchaObj);
            });
            // 当验证出现网络错误时调用callback函数。
            captchaObj.onError(function() {
                //location.href = T.baseUrl + '/user/login.html?mode=general';
            });
            if (captchaObj.d.product !== 'popup') {
                $("#login_confirm").click(function() {
                    loginSubmit(captchaObj);
                });
            }
            // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
        };
        $.ajax({
            // 获取id，challenge，success（是否启用failback）
            url: T.baseUrl + "/user/StartCaptchaServlet.html?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                // 使用initGeetest接口
                // 参数1：配置参数
                // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    product: T.url === T.homeUrl ? "popup" : 'float', // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                    offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                }, handlerGeetest);
            }
        });
    }
});