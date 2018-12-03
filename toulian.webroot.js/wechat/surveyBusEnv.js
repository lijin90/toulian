function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('.obtain.smsCode').text('点击获取');
        return;
    }
    $('.obtain.smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function() {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function($) {
    if (T.submitAlert) {
        $('#surveyEnd').modal({backdrop: 'static'});
    }
    $(".yeshu").createPage({
        pageCount: 3,
        current: 1,
        backFn: function(p) {
            $(".container").find(".con").addClass('hide');
            $("#content" + p).removeClass('hide');
            var speed = 500;//滑动的速度
            $('body,html').animate({scrollTop: 0}, speed);
            if ($('.yeshu .current').text() == 3) {
                $('.submit').removeClass('hide');
            } else {
                $('.submit').addClass('hide');
            }
        }
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
        var mobile = $('input[name=mobile]').val();
        if ($.trim(mobile) === '') {
            $('div.error.mobile').text('手机号码不能为空');
            $('input[name=mobile]').focus();
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
    // 点击提交按钮
    $(".submit .btn").click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var data = {};
        $.each(T.questionTypes.text, function(i, item) {
            data[item] = $('input[name=' + item + ']').val();
        });
        $.each(T.questionTypes.radio, function(i, item) {
            if ($('input[name=' + item + ']:checked').val() === '其它' && $('input[name=' + item + '].other').val()) {
                data[item] = '其它：' + $('input[name=' + item + '].other').val();
            } else {
                data[item] = $('input[name=' + item + ']:checked').val();
            }
        });
        $.each(T.questionTypes.checkbox, function(i, item) {
            data[item] = [];
            $('input[name=' + item + ']').each(function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() === '其它' && $('input[name=' + item + '].other').val()) {
                        data[item].push('其它：' + $('input[name=' + item + '].other').val());
                    } else {
                        data[item].push($(this).val());
                    }
                }
            });
            data[item] = data[item].join('|');
        });
        $.each(T.questionTypes.rate, function(i, item) {
            data[item] = [];
            $.each(T.questionOptions[item].answers, function(answerKey, answer) {
                if ($('input[name=' + item + (answerKey + 1) + ']:checked').length === 0) {
                    return;
                }
                if ($('input[name=' + item + (answerKey + 1) + ']:checked').attr('data-answer') === '其它' && $('input[name=' + item + '].other').val()) {
                    data[item].push('其它：' + $('input[name=' + item + '].other').val() + '|' + $('input[name=' + item + (answerKey + 1) + ']:checked').val());
                } else if ($('input[name=' + item + (answerKey + 1) + ']:checked').attr('data-answer') === '其它') {

                } else {
                    data[item].push($('input[name=' + item + (answerKey + 1) + ']:checked').attr('data-answer') + '|' + $('input[name=' + item + (answerKey + 1) + ']:checked').val());
                }
            });
            data[item] = data[item].join('||');
        });
        data.smsCode = $('input[name=smsCode]').val();
        $.ajax({
            url: T.url,
            type: "post",
            dataType: "json",
            data: data,
            success: function(ret) {
                if (ret.code === 0) {
                    $('#submitSuccess').on('hidden.bs.modal', function(e) {
                        location.href = T.url + (T.url.indexOf('?') !== -1 ? '&' : '?') + 't=' + (new Date().getTime());
                    });
                    $('#submitSuccess').modal({backdrop: 'static'});
                } else if (ret.code === 2) {
                    $('#surveyEnd').modal({backdrop: 'static'});
                } else {
                    layer.open({content: ret.msg, time: 2});
                    if (ret.msg.indexOf('基本情况') === 0) {
                        $(".yeshu").jumpPage(1);
                    } else if (ret.msg.indexOf('主要问题') === 0) {
                        $(".yeshu").jumpPage(2);
                    } else if (ret.msg.indexOf('对策建议') === 0) {
                        $(".yeshu").jumpPage(3);
                    }
                }
                $(self).removeAttr('data-clicked');
            },
            error: function(xhr, textStatus, errorThrown) {
                if (xhr.responseJSON) {
                    alert(xhr.responseJSON.msg);
                } else if (xhr.responseText) {
                    alert(xhr.responseText);
                } else {
                    alert('请求出错！\n响应状态：' + xhr.statusText + '（' + xhr.status + '）\n错误信息：' + textStatus);
                }
                $(self).removeAttr('data-clicked');
            }
        });
    });
});

