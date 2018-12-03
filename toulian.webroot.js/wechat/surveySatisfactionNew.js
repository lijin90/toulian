function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('.obtain.smsCode').text('点击获取');
        return;
    }
    $('.obtain.smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function () {
        SmscodeCounter(seconds);
    }, 1000);
}
jQuery(function ($) {
    if (T.submitAlert) {
        $('#surveyEnd').modal({backdrop: 'static'});
    }
    $(".module_2,.add_replace,.module_2_1,.module_2_2,.module_3,.module_4").hide();
    $(".replace .radio").click(function () {
        $(this).find("input").prop("checked", true).parent().siblings().find("input").prop("checked", false);
    });
    $(".module_1 .begin").click(function () {
        $(this).parents(".module_1").hide();
        $(".module_2,.module_2_1").show();
    });
    $(".select").click(function () {
        $('input[name=serviceObject]').val($(this).find('p.serviceObject').text());
        var data = $(this).attr("data-type");
        wenzi = $(this).find('p.serviceObject').text();
        $(".select").removeClass("active");
        $(this).addClass("active");
        $(".personal,.enterprise,.invest,.sell").hide().removeClass('swiper-slide');
        $("." + data).show().addClass('swiper-slide');
        if ($(".select.active p.serviceObject").text()) {
            var common = T.surveyStatistics[$(".select.active p.serviceObject").text()];
            if (common.all == common.current) {
                layer.open({content: common.all + '份问卷已答完，感谢您的参与！', time: 2});
                return;
            }
            if ($(".select.active").index() == 1) {
                $(".add_replace").addClass("bg0");
            } else if ($(".select.active").index() == 2) {
                $(".add_replace").addClass("bg1");
            } else if ($(".select.active").index() == 3) {
                $(".add_replace").addClass("bg2");
            } else if ($(".select.active").index() == 4) {
                $(".add_replace").addClass("bg3");
            }
            $(".main strong.common").text(common.all);
            $(".main strong.already").text(common.current);
            $(".main strong.surplus").text(common.all - common.current);
            $(".add_replace p em").text($(".select.active p.serviceObject").text());
            $(".img_select").attr("src", T.imageUrl + "/wechat/survey/ti0" + $(".select.active").index() + ".png");
            $(this).parents(".bg_top").hide();
            $(".add_replace").show();
            $('.title_select').hide();
            $('.title_select2').removeClass("hide");
        }
    });
    // 继续（您属于哪种类型的投联网服务对象？）
    $(".main .module_2_1_continue").click(function () {
        if ($(".select.active p.serviceObject").text()) {
            var common = T.surveyStatistics[$(".select.active p.serviceObject").text()];
            if (common.all == common.current) {
                layer.open({content: common.all + '份问卷已答完，感谢您的参与！', time: 2});
                return;
            }
            if ($(".select.active").index() == 1) {
                $(".add_replace").addClass("bg0");
            } else if ($(".select.active").index() == 2) {
                $(".add_replace").addClass("bg1");
            } else if ($(".select.active").index() == 3) {
                $(".add_replace").addClass("bg2");
            } else if ($(".select.active").index() == 4) {
                $(".add_replace").addClass("bg3");
            }
            $(".main strong.common").text(common.all);
            $(".main strong.already").text(common.current);
            $(".main strong.surplus").text(common.all - common.current);
            $(".add_replace p em").text($(".select.active p.serviceObject").text());
            $(".img_select").attr("src", T.imageUrl + "/wechat/survey/ti0" + $(".select.active").index() + ".png");
            $(this).parents(".bg_top").hide();
            $(".add_replace").show();
            $('.title_select').hide();
            $('.title_select2').removeClass("hide");
        } else {
            layer.open({content: '您属于哪种类型的投联网服务对象？', time: 2});
        }
    });
    // 重新选择（您属于哪种类型的投联网服务对象？）
    $(".back_select,span.glyphicon").click(function () {
        $(".select").removeClass("active");
        $(".add_replace").removeClass("bg0 bg1 bg2 bg3");
        $(".add_replace").hide();
        $(".bg_top").show();
        $('.title_select').show();
        $('.title_select2').addClass("hide");
    });
    // 继续（您属于哪种类型的投联网服务对象？）
    $(".main .add_continue").click(function () {
        $(this).parents(".add_replace").hide();
        $('.title_select').show();
        $('.title_select2').addClass("hide");
        $(".module_2_1").hide();
        $(".bg_top,.main .module_2_2").show();
        $(".main .module_2_2").find("p.add_p").text("您的身份是" + wenzi);
        mySwiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationType: 'fraction',
            nextButton: '.continue',
            loop: false,
            onSlideChangeEnd: function (swiper) {
                if (swiper.activeIndex === swiper.slides.length - 1) {
                    // 滑到最后一个问题时
                    $('.continue').addClass('hide');
                    $('.continue_next').removeClass('hide');
                } else {
                    $('.continue').removeClass('hide');
                    $('.continue_next').addClass('hide');
                }
            },
            onSlideNextEnd: function (swiper) {
                var questionRadio = $(".swiper-slide").eq(swiper.previousIndex).find("input[type=radio]").length > 0 && $(".swiper-slide").eq(swiper.previousIndex).find("input:checked").length == 0;
                var questionTextarea = $(".swiper-slide").eq(swiper.previousIndex).find("textarea").length > 0 && $(".swiper-slide").eq(swiper.previousIndex).find("textarea").val() === '';
                if (questionRadio || questionTextarea) {
                    layer.open({
                        content: "请选择或填写",
                        time: 1,
                        end: function () {
                            mySwiper.slideTo(mySwiper.previousIndex, 1000, true);
                        }
                    })
                }
            }
        });
        $('.continue_next').click(function () {
            $(".module_2_2").hide();
            $(".module_3").show();
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
        var mobile = $('input[name=mobile]').val();
        if ($.trim(mobile) === '') {
            $('div.error.mobile').text('手机号码不能为空');
            $('input[name=mobile]').focus();
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
    // 继续（手机号码）
    $(".skip_complete").click(function () {
        // AJAX 提交
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var data = {};
        $.each(T.questionTypes.text, function (i, item) {
            data[item] = $('textarea[name=' + item + ']').val();
        });
        $.each(T.questionTypes.radio, function (i, item) {
            if ($('input[name=' + item + ']:checked').val() === '其它' && $('input[name=' + item + '].other').val()) {
                data[item] = '其它：' + $('input[name=' + item + '].other').val();
            } else {
                data[item] = $('input[name=' + item + ']:checked').val();
            }
        });
        $.each(T.questionTypes.checkbox, function (i, item) {
            data[item] = [];
            $('input[name=' + item + ']').each(function () {
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
        $.each(T.questionTypes.rate, function (i, item) {
            data[item] = [];
            $.each(T.questionOptions[item].answers, function (answerKey, answer) {
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
        data.mobile = $('input[name=mobile]').val();
        data.smsCode = $('input[name=smsCode]').val();
        $.ajax({
            url: T.url,
            type: "post",
            dataType: "json",
            data: data,
            success: function (ret) {
                if (ret.code === 0) {
                    $(".module_3").hide();
                    $(".module_4").show();
                    T.surveyId = ret.data;
                } else if (ret.code === 2) {
                    $('#surveyEnd').modal({backdrop: 'static'});
                } else {
                    layer.open({content: ret.msg, time: 2, end: function () {
                            var qnum = ret.msg.substring(0, 1);
//                            var qnum = ret.msg.substring(0, 2).replace(/[^0-9]/ig, "");
//                            var qnum = ret.msg.replace(/[^0-9]/ig, "");
//                            console.log(qnum);
                            if (!isNaN(qnum)) {
                                $(".module_3").hide();
                                $(".module_2_2").show();
                                mySwiper.init();
                                mySwiper.slideTo(qnum - 1, 1000, true);
                            }
                        }
                    });
                }
                $(self).removeAttr('data-clicked');
            },
            error: function (xhr, textStatus, errorThrown) {
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
    // 完成
    $(".module_4 .complete").click(function (e) {
        $('#surveyShare').modal();
    });
});
function shareSuccess() {
    $('#surveyShare').modal('hide');
    if (!T.surveyId) {
        layer.open({content: '分享成功！', time: 2});
        return;
    }
    layer.open({content: '分享成功！正在领取红包...', time: 2});
    $.ajax({
        url: T.baseUrl + '/wechatService/surveySatisfactionNew/sendRedEnvelope.html',
        type: "post",
        dataType: "json",
        data: {surveyId: T.surveyId},
        success: function (ret) {
            if (ret.code === 0) {
                layer.open({
                    content: '领取成功，敬请查收！',
                    time: 2,
                    end: function () {
                        wx.closeWindow();
                    }
                });
            } else {
                layer.open({content: '领取失败', time: 2});
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
    });
}
function shareCancel() {

}
wx.ready(function () {
    // 在这里调用 API
    var title = '填写调查问卷 分享惠赠微信红包';
    var desc = '投联网为提升服务特推出满意度调查表，希冀您提出宝贵建议，填写分享惠赠微信红包。';
    var link = T.baseAbsoluteUrl + '/wechatService/surveySatisfactionNew.html';
    var imgUrl = T.baseAbsoluteUrl + '/images/qrcodelogo.png';
    wx.onMenuShareTimeline({
        title: title, // 分享标题
        link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: imgUrl, // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            shareSuccess();
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            shareCancel();
        }
    });
    wx.onMenuShareAppMessage({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        imgUrl: imgUrl, // 分享图标
        type: 'link', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () {
            // 用户确认分享后执行的回调函数
            shareSuccess();
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            shareCancel();
        }
    });
    wx.onMenuShareQZone({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            shareSuccess();
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            shareCancel();
        }
    });
    wx.onMenuShareQQ({
        title: title, // 分享标题
        desc: desc, // 分享描述
        link: link, // 分享链接
        imgUrl: imgUrl, // 分享图标
        success: function () {
            // 用户确认分享后执行的回调函数
            shareSuccess();
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
            shareCancel();
        }
    });
});