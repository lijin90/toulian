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
    // 企业个人注册切换
    $(".personal li").click(function() {
        var usercategory = $(this).attr('data-usercategory');
        $('#register input[name=usercategory]').val(usercategory);
        $(".register_con  .regster_input .common").hide();
        $(".register_con  .regster_input .common." + usercategory).show();
        $(this).addClass("current").siblings().removeClass("current");
        $(this).find("img").attr("src", $(this).find("img").attr("data-click"));
        $(this).siblings().find("img").attr("src", $(this).siblings().find("img").attr("data-src"));
    });
    // 图片验证码
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
        var realName = $('#register input[name=realName]').val();
        var enterpriseName = $('#register input[name=enterpriseName]').val();
        var mobile = $('#register input[name=mobile]').val();
        var smsCode = $('#register input[name=smsCode]').val();
        var verifyCode = $('#register input[name=verifyCode]').val();
        var agree = $('#register input[name=agree]').is(":checked");
        $(self).val('提交中');
        $.post(T.baseUrl + '/user/registerSimple.html', {
            usercategory: usercategory,
            realName: realName,
            enterpriseName: enterpriseName,
            mobile: mobile,
            smsCode: smsCode,
            verifyCode: verifyCode,
            agree: (agree ? 1 : 0)
        }, function(ret) {
            if (ret.code === 0) {
                $(self).val('跳转中...');
                layer.msg('注册成功', {
                    icon: 1,
                    time: 1500,
                    end: function() {
                        location.href = T.baseUrl + '/login.html';
                    }
                });
            } else {
                $(self).val('确认注册');
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            $(self).val('确认注册');
            layer.msg('注册失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });
    $('#register input[name=mobile]').blur(function() {
        var mobile = $(this).val();
        if ($.trim(mobile) === '') {
            $('div.error.mobile').text('手机号码不能为空');
            return;
        } else if (!(/^1[3578][0-9]{9}$/).test(mobile)) {
            $('div.error.mobile').text('手机号码格式错误');
            return;
        }
        $.post(T.baseUrl + '/user/registerCheckMobile.html', {mobile: mobile}, function(ret) {
            if (ret.code === 0) {
                $('div.error.mobile').text('');
            } else {
                $('div.error.mobile').text(ret.msg);
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
            } else {
                for (var fm in ret.data) {
                    $('div.error.' + fm).text(ret.data[fm]);
                }
            }
        }, 'json');
    });
    $('#register input[name=verifyCode]').blur(function() {
        var verifyCode = $(this).val();
        if ($.trim(verifyCode) === '') {
            $('div.error.verifyCode').text('图片验证码不能为空');
            return;
        }
        $.post(T.baseUrl + '/user/registerCheckVerifyCode.html', {verifyCode: verifyCode}, function(ret) {
            if (ret.code === 0) {
                $('div.error.verifyCode').text('');
            } else {
                $('div.error.verifyCode').text(ret.msg);
            }
        }, 'json');
    });
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
            $('#register input[name=verifyCode]').focus();
            $(self).removeAttr('data-clicked');
            return;
        } else if ($.trim($('div.error.verifyCode').text()) !== '') {
            $('div.error.verifyCode').text('图片验证码填写不正确');
            $('#register input[name=verifyCode]').focus();
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile, usage: 'register'}, function(ret) {
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
});

