function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('.obtain.smsCode').css({'color': '#0EA8E3', 'font-size': '16px'});
        $('.obtain.smsCode').text('点击获取');
        return;
    }
    $('.obtain.smsCode').css({'color': 'gray', 'font-size': '13px'});
    $('.obtain.smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function () {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function ($) {
//  个人企业注册
    $(".personal li").click(function () {
        var usercategory = $(this).attr('data-usercategory');
        $('.container input[name=usercategory]').val(usercategory);
        $(".container  .row .common").hide();
        $(".container  .row .common." + usercategory).show();
        $(this).addClass("current").siblings().removeClass("current");
        $(this).find("img").attr("src", $(this).find("img").attr("data-click"));
        $(this).siblings().find("img").attr("src", $(this).siblings().find("img").attr("data-src"));
    })
    // 图片验证码
    $('#verifyCodeRefresh').click(function () {
        $(this).children('img').attr('src', T.baseUrl + '/user/verifyCode.html?refresh=' + Math.random());
    });
    $('#register .btn_register').click(function () {
//        alert(12);
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
        }, function (ret) {
            if (ret.code === 0) {
                $(self).val('跳转中...');
                layer.open({
                    content: ret.msg,
                    time: 2,
                    end: function () {
                        location.href = T.baseUrl + '/login.html';
                    }
                });
            } else {
                $(self).val('确认注册');
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function (xhr, textStatus, errorThrown) {
            $(self).val('确认注册');
            layer.msg('注册失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });
    $('.obtain.smsCode').click(function () {
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
            layer.open({content: '手机号码不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return;
        }
        /* 容联要求发送手机验证码前需先验证图片验证码 */
        var verifyCode = $('#register input[name=verifyCode]').val();
        if ($.trim(verifyCode) === '') {
            layer.open({content: '图片验证码不能为空', time: 2});
            $(self).removeAttr('data-clicked');
            return;
        } else if ($.trim($('div.error.verifyCode').text()) !== '') {
            layer.open({content: '图片验证码填写不正确', time: 2});
            $(self).removeAttr('data-clicked');
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile, usage: 'register'}, function (ret) {
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
});

