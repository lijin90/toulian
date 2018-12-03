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
    $(".border_col:eq(1)").click(function() {
        layer.open({content: '正在开发建设中...', time: 2});
    });
    $(".apply_btn").click(function() {
        if ($(this).hasClass('tofee') && !T.activity.activityApply) {
            layer.open({content: '请先填写报名信息', time: 2});
            $(".apply_btn.toapply").click();
            return;
        }
        $(this).addClass("current").siblings().removeClass("current");
        $(".apply_fill").eq($(this).index()).addClass("show").siblings().removeClass("show");
        $(".submit").eq($(this).index()).addClass("show").siblings().removeClass("show");
    });
    if (parseInt(T.activity.toApply)) {
        $(".apply_btn.toapply").click();
    }
    if (parseInt(T.activity.toFee)) {
        $(".apply_btn.tofee").click();
    }
    $('.baoming_btn').click(function() {
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
        $.post(T.baseUrl + '/wechatService/activity/applySubmit.html', {
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
                layer.open({
                    content: ret.msg,
                    time: 2,
                    end: function() {
                        location.href = T.baseUrl + '/wechatService/activity/apply.html?fee=1&acId=' + AID;
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            layer.open({content: '报名失败，请重试！', time: 2});
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
            layer.open({content: '请输入手机号码', time: 2});
            $(".baoming input[name=Phone]").focus();
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile}, function(ret) {
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
        $(".apply_btn.toapply").click();
    });
    // 立即支付
    $('.bill a.payment').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var url = T.baseUrl + '/wechatService/order/create.html';
        $.post(url, {type: 'activity_apply', typeId: T.activity.activityApply.ID}, function(ret) {
            if (ret.code === 0) {
                location.href = T.baseUrl + '/wechatService/order/cashier/' + ret.data.ID + '.html';
            } else {
                layer.open({content: ret.msg, time: 2});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            layer.open({content: '提交失败，请重试！', time: 2});
            $(self).removeAttr('data-clicked');
        });
    });
});