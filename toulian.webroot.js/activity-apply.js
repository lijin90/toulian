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
    $(".personal li:eq(1)").click(function() {
        layer.msg('正在开发建设中...', {time: 2000});
    });
    // 个人报名、团购报名切换
    /* $(".personal li").click(function () {
     $(this).addClass("current").siblings().removeClass("current");
     $(this).find("img").attr("src", $(this).find("img").attr("data-click"));
     $(this).siblings().find("img").attr("src", $(this).siblings().find("img").attr("data-src"));
     }); */
    // 活动报名、报名缴费切换
    $(".apply_title li").click(function() {
        if ($(this).hasClass('tofee') && !T.activity.activityApply) {
            layer.msg('请先填写报名信息', {icon: 0});
            $(".apply_title li.toapply").click();
            return;
        }
        $(this).addClass("active").siblings().removeClass("active");
        $(".apply_con .icon_con").eq($(this).index()).addClass("show").siblings().removeClass("show");
    });
    if (parseInt(T.activity.toApply)) {
        $(".apply_title li.toapply").click();
    }
    if (parseInt(T.activity.toFee)) {
        $(".apply_title li.tofee").click();
    }
    $('.apply_btn').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var reset = $(".baoming input[name=reset]").val();
        var AID = $(".baoming input[name=AID]").val();
        var Company = $(".baoming input[name=Company]").val();
        var Name = $(".baoming input[name=Name]").val();
        var EnterprisePosition = $(".baoming input[name=EnterprisePosition]").val();
        var Phone = $(".baoming input[name=Phone]").val();
        var smsCode = $('.baoming input[name=smsCode]').val();
        var Email = $(".baoming input[name=Email]").val();
        var Wechat = $(".baoming input[name=Wechat]").val();
        var ExtendField1 = $(".baoming input[name=ExtendField1]").val();
        var ExtendField2 = $(".baoming input[name=ExtendField2]").val();
        var ExtendField3 = $(".baoming input[name=ExtendField3]").val();
        $.post(T.baseUrl + '/activity/applySubmit.html', {
            reset: reset,
            AID: AID,
            Company: Company,
            Name: Name,
            EnterprisePosition: EnterprisePosition,
            Phone: Phone,
            smsCode: smsCode,
            Email: Email,
            Wechat: Wechat,
            ExtendField1: ExtendField1,
            ExtendField2: ExtendField2,
            ExtendField3: ExtendField3
        }, function(ret) {
            if (ret.code === 0) {
                layer.msg(ret.msg, {
                    icon: 1,
                    time: 1500,
                    end: function() {
                        location.href = T.baseUrl + '/activity/apply.html?fee=1&acId=' + AID;
                    }
                });
            } else {
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            layer.msg('报名失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
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
        var mobile = $(".baoming input[name=Phone]").val();
        if ($.trim(mobile) === '') {
            layer.msg('请输入手机号码', {icon: 0});
            $(".baoming input[name=Phone]").focus();
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile}, function(ret) {
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
    // 返回修改
    $('.bill a.back').click(function() {
        if (!T.activity.activityApply) {
            return;
        }
        $(".baoming input[name=reset]").val(1);
        $(".baoming input[name=Company]").val(T.activity.activityApply.Company);
        $(".baoming input[name=Name]").val(T.activity.activityApply.Name);
        $(".baoming input[name=EnterprisePosition]").val(T.activity.activityApply.EnterprisePosition);
        $(".baoming input[name=Phone]").val(T.activity.activityApply.Phone);
        $(".baoming input[name=Email]").val(T.activity.activityApply.Email);
        $(".baoming input[name=Wechat]").val(T.activity.activityApply.Wechat);
        $(".apply_title li.toapply").click();
    });
    // 立即支付
    $('.bill a.payment').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var url = T.baseUrl + '/order/create.html';
        $.post(url, {type: 'activity_apply', typeId: T.activity.activityApply.ID}, function(ret) {
            if (ret.code === 0) {
                location.href = T.baseUrl + '/order/cashier.html?orderId=' + ret.data.ID;
            } else {
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            layer.msg('提交失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });
});

