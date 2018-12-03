function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('.obtain.smsCode').text('获取');
        return;
    }
    $('.obtain.smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function () {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function ($) {
//    点击获取发送手机验证码
    $('.obtain.smsCode').click(function () {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        if ($(this).text() !== '获取') {
            $(self).removeAttr('data-clicked');
            return;
        }
        var mobile = $('input[name=mobile]').val();
        if ($.trim(mobile) === '') {
            layer.open({
                content: "手机号码不能为空",
                time: 2,
                end: function () {
                    $('input[name=mobile]').focus();
                }
            })
            $(self).removeAttr('data-clicked');
            return;
        }
        $.get(T.baseUrl + '/sms/sendCode.html', {mobile: mobile}, function (ret) {
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

//    点击提交按钮
    $('.btn-submit').click(function () {
        var data = {};
        data.mobile = $('input[name=mobile]').val();
        data.smsCode = $('input[name=smsCode]').val();
        $.ajax({
            url: T.url,
            type: "post",
            dataType: "json",
            data: data,
            success: function (ret) {
                if (ret.code === 0) {
                    //提交成功
                    location.href = T.baseUrl + '/wechatService/wechatRedenvelope/share.html?wrId=' + T.wechatRedenvelope.id + '&wrlId=' + ret.data;
                } else if (ret.code === 2) {
                    //活动结束
                    location.href = T.baseUrl + '/wechatService/wechatRedenvelope/over.html?wrId=' + T.wechatRedenvelope.id;
                } else {
                    //提交失败
                    layer.open({content: ret.msg, time: 2});
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                if (xhr.responseJSON) {
                    alert(xhr.responseJSON.msg);
                } else if (xhr.responseText) {
                    alert(xhr.responseText);
                } else {
                    alert('请求出错！\n响应状态：' + xhr.statusText + '（' + xhr.status + '）\n错误信息：' + textStatus);
                }
            }
        })

    });
});