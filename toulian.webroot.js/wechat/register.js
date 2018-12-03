function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('.obtain.smsCode').css({'color': '#0EA8E3', 'font-size': '16px'});
        $('.obtain.smsCode').text('点击获取');
        return;
    }
    $('.obtain.smsCode').css({'color': 'gray', 'font-size': '13px'});
    $('.obtain.smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function() {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function($) {
    $('.register a').click(function() {
        $(this).addClass('current').siblings().removeClass('current');
        var plft = $(this).position().left;
        $('.arrow').animate({"left": plft}, 300);
        var usercategory = $(this).attr('data-usercategory');
        $('.container input[name=usercategory]').val(usercategory);
        $(".container .opt").hide();
        $(".container .opt." + usercategory).show();
    });
    $('#areaCode').pcasDict('areaCode');
    $('.obtain.smsCode').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        if ($(this).text() !== '点击获取') {
            $(self).removeAttr('data-clicked');
            return;
        }
        var mobile = $('#register input[name=mobile]').val();
        if ($.trim(mobile) === '') {
            $('div.error.mobile').text('手机号码不能为空');
            $('#register input[name=mobile]').focus();
            $(self).removeAttr('data-clicked');
            return;
        }
        /* 容联要求发送手机验证码前需先验证图片验证码 */
        var verifyCode = $('#register input[name=verifyCode]').val();
        if ($.trim(verifyCode) === '') {
            $('div.error.verifyCode').text('图片验证码不能为空');
            $('img.bgright.verifyCode').hide();
            $('#register input[name=verifyCode]').focus();
            $(self).removeAttr('data-clicked');
            return;
        } else if ($.trim($('div.error.verifyCode').text()) !== '') {
            $('div.error.verifyCode').text('图片验证码填写不正确');
            $('img.bgright.verifyCode').hide();
            $('#register input[name=verifyCode]').focus();
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile, usage: 'register'}, function(ret) {
            if (ret.code === 0) {
                layer.open({
                    content: ret.msg,
                    time: 2,
                    end: function() {
                        SmscodeCounter(60);
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json');
    });
    $('#verifyCodeRefresh').click(function() {
        $(this).children('img').attr('src', T.baseUrl + '/user/verifyCode.html?refresh=' + Math.random());
    });

    $('#register .btn_register').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var usercategory = $('#register input[name=usercategory]').val();
        var username = $('#register input[name=username]').val();
        var enterpriseName = $('#register input[name=enterpriseName]').val();
        var leader = $('#register input[name=leader]').val();
        var realName = $('#register input[name=realName]').val();
        var gender = $('#register input[name=gender]:checked').val();
        var areaCode = $('#register input[name=areaCode]').val();
        var password = $('#register input[name=password]').val();
        var password2 = $('#register input[name=password2]').val();
        var mobile = $('#register input[name=mobile]').val();
        var smsCode = $('#register input[name=smsCode]').val();
        var verifyCode = $('#register input[name=verifyCode]').val();
        var agree = $('#register input[name=agree]').is(":checked");
        $(self).val('提交中');
        $.post(T.baseUrl + '/user/register.html', {
            usercategory: usercategory,
            username: username,
            enterpriseName: enterpriseName,
            leader: leader,
            realName: realName,
            gender: gender,
            areaCode: areaCode,
            password: password,
            password2: password2,
            mobile: mobile,
            smsCode: smsCode,
            verifyCode: verifyCode,
            agree: (agree ? 1 : 0)
        }, function(ret) {
            if (ret.code === 0) {
                $(self).val('跳转中...');
                layer.open({
                    content: '注册成功',
                    time: 2,
                    end: function() {
                        location.href = T.baseUrl + '/wechatService/user/login.html';
                    }
                });
            } else {
                $(self).val('确认注册');
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            $(self).val('确认注册');
            layer.open({content: '注册失败，请重试！', time: 2});
            $(self).removeAttr('data-clicked');
        });
    });
    $('#register input[name=username]').blur(function() {
        var username = $(this).val();
        if ($.trim(username) === '') {
            $('div.error.username').text('登录账户不能为空');
            $('img.bgright.username').hide();
            return;
        } else if ($.trim(username).length < 6 || $.trim(username).length > 20) {
            $('div.error.username').text('登录账户长度为6-20个字符');
            $('img.bgright.username').hide();
            return;
        } else if (!(/^[a-zA-Z]+\w+$/).test(username)) {
            $('div.error.username').text('登录账户只能使用字母、数字、下划线，需以字母开头');
            $('img.bgright.username').hide();
            return;
        }
        $.post(T.baseUrl + '/user/registerCheckUserName.html', {username: username}, function(ret) {
            if (ret.code === 0) {
                $('div.error.username').text('');
                $('img.bgright.username').show();
            } else {
                $('div.error.username').text(ret.msg);
                $('img.bgright.username').hide();
            }
        }, 'json');
    });

    $('#register input[name=password]').blur(function() {
        var password = $(this).val();
        if ($.trim(password) === '') {
            $('div.error.password').text('登录密码不能为空');
            $('img.bgright.password').hide();
        } else if ($.trim(password).length < 6 || $.trim(password).length > 20) {
            $('div.error.password').text('登录密码长度为6-20个字符');
            $('img.bgright.password').hide();
        } else if ($.trim(password).indexOf(' ') !== -1) {
            $('div.error.password').text('登录密码不能包含空格');
            $('img.bgright.password').hide();
        } else {
            $('div.error.password').text('');
            $('img.bgright.password').show();
        }
    });

    $('#register input[name=password2]').blur(function() {
        var password = $('#register input[name=password]').val();
        if ($.trim(password) === '') {
            $('#register input[name=password]').blur();
            return;
        }
        var password2 = $(this).val();
        if ($.trim(password) === $.trim(password2)) {
            $('div.error.password2').text('');
            $('img.bgright.password2').show();
        } else {
            $('div.error.password2').text('两次密码不一致');
            $('img.bgright.password2').hide();
        }
    });

    $('#register input[name=mobile]').blur(function() {
        var mobile = $(this).val();
        if ($.trim(mobile) === '') {
            $('div.error.mobile').text('手机号码不能为空');
            $('img.bgright.mobile').hide();
            return;
        } else if (!(/^1[3578][0-9]{9}$/).test(mobile)) {
            $('div.error.mobile').text('手机号码格式错误');
            $('img.bgright.mobile').hide();
            return;
        }
        $.post(T.baseUrl + '/user/registerCheckMobile.html', {mobile: mobile}, function(ret) {
            if (ret.code === 0) {
                $('div.error.mobile').text('');
                $('img.bgright.mobile').show();
            } else {
                $('div.error.mobile').text(ret.msg);
                $('img.bgright.mobile').hide();
            }
        }, 'json');
    });

    $('#register input[name=smsCode]').blur(function() {
        var mobile = $('#register input[name=mobile]').val();
        if ($.trim(mobile) === '') {
            $('#register input[name=mobile]').blur();
            return;
        }
        var smsCode = $(this).val();
        $.post(T.baseUrl + '/user/registerCheckSmsCode.html', {mobile: mobile, smsCode: smsCode}, function(ret) {
            if (ret.code === 0) {
                $('div.error.smsCode').text('');
                $('img.bgright.smsCode').show();
            } else {
                for (var fm in ret.data) {
                    $('div.error.' + fm).text(ret.data[fm]);
                    $('img.bgright.' + fm).hide();
                }
            }
        }, 'json');
    });

    $('#register input[name=verifyCode]').blur(function() {
        var verifyCode = $(this).val();
        if ($.trim(verifyCode) === '') {
            $('div.error.verifyCode').text('图片验证码不能为空');
            $('img.bgright.verifyCode').hide();
            return;
        }
        $.post(T.baseUrl + '/user/registerCheckVerifyCode.html', {verifyCode: verifyCode}, function(ret) {
            if (ret.code === 0) {
                $('div.error.verifyCode').text('');
                $('img.bgright.verifyCode').show();
            } else {
                $('div.error.verifyCode').text(ret.msg);
                $('img.bgright.verifyCode').hide();
            }
        }, 'json');
    });
});