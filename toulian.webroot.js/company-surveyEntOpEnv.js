jQuery(function($) {
    T.needLogin = false;
    $('#surveyEnd').on('hidden.bs.modal', function(e) {
        location.href = T.baseUrl + '/company/surveyEntOpEnv.html?type=index';
    });
    $('#surveyEnd').modal({backdrop: 'static'});
    if (T.needLogin) {
        $('#loginDialog .btn-login').click(function() {
            var userName = $("#loginDialog input[name=userName]").val();
            var password = $("#loginDialog input[name=password]").val();
            if (!userName) {
                $("#loginDialog input[name=userName]").focus();
                return;
            } else if (!password) {
                $("#loginDialog input[name=password]").focus();
                return;
            }
            location.href = T.baseUrl + '/company/surveyEntOpEnv.html?type=form&area=' + T.questionArea + '&userName=' + userName + '&password=' + password;
        });
        $('#loginDialog').on('hidden.bs.modal', function(e) {
            location.href = T.baseUrl + '/company/surveyEntOpEnv.html?type=index';
        });
        $('#loginDialog').modal();
    }
    $(".yeshu").createPage({
        pageCount: 8,
        current: 1,
        backFn: function(p) {
            $(".survey_con .switch").addClass('hide');
            $(".survey_con .switch.switch_" + p).removeClass('hide')
            if ($('.yeshu .current').text() == 8) {
                $('.submit_btn').removeClass('hide');
            } else {
                $('.submit_btn').addClass('hide');
            }
        }
    });
    $('select[name=industry]').change(function() {
        $('select[name=industry_scale]').empty();
        $('.industry_scale_unit').text('');
        //$('.industry_scale_unit').parent('.input-group-addon').addClass('hide');
        if ($(this).val() && T.industry.answers[$(this).val()]) {
            $('select[name=industry_scale]').append($('<option></option>').attr('value', '').text('请选择企业规模（' + T.industry.answers[$(this).val()].note + '）'));
            $.each(T.industry.answers[$(this).val()].list, function(i, item) {
                $('select[name=industry_scale]').append($('<option></option>').attr('value', item).text(item));
            });
            $('.industry_scale_unit').text(T.industry.answers[$(this).val()].note);
            //$('.industry_scale_unit').parent('.input-group-addon').removeClass('hide');
        } else {
            $('select[name=industry_scale]').append($('<option></option>').attr('value', '').text('请选择企业规模'));
        }
    }).change();
    $('.ipt.other').siblings('input').change(function() {
        if ($(this).is(':checked')) {
            $(this).siblings('.ipt.other').removeAttr('readonly');
            $(this).siblings('.ipt.other').focus();
        } else {
            $(this).siblings('.ipt.other').attr('readonly', 'readonly');
            $(this).siblings('.ipt.other').val('');
        }
    });
    $.each(T.questionOptions, function(key, option) {
        if (!option.answersJumps) {
            return;
        }
        $('input[name=' + key + ']').change(function() {
            $.each(option.answersJumps, function(answer, jumpKeys) {
                jumpKeys = jumpKeys.split(',');
                $.each(jumpKeys, function(i, jumpKey) {
                    $('input[name=' + jumpKey + ']').removeAttr("disabled");
                    $('.question_' + jumpKey).removeClass('jump');
                });
            });
            $.each(option.answersJumps, function(answer, jumpKeys) {
                jumpKeys = jumpKeys.split(',');
                $.each(jumpKeys, function(i, jumpKey) {
                    if (option.type === 'radio' && $('input[name=' + key + ']:checked').val() === answer) {
                        $('input[name=' + jumpKey + ']').attr("disabled", "disabled");
                        $('.question_' + jumpKey).addClass('jump');
                    } else if (option.type === 'checkbox' && $('input[name=' + key + ']:checked').val().indexOf(answer) !== -1) {
                        $('input[name=' + jumpKey + ']').attr("disabled", "disabled");
                        $('.question_' + jumpKey).addClass('jump');
                    }
                });
            });
            if (key === 'policysupport' && $('input[name=policysupport]:checked').val() === '是') {
                $('input[name=policysupport_benefit]').change();
            } else if (key === 'feedback') {
                $('input[name=feedback_effect]').change();
            }
        }).change();
    });
    $(".submit_btn .btn").click(function() {
        if (T.needLogin) {
            return;
        }
        var data = {};
        data.industry = $('select[name=industry]').val();
        data.industry_scale = $('select[name=industry_scale]').val();
        data.industry_scale_unit = $('.industry_scale_unit').text();
        $.each(T.questionTypes.radio, function(i, item) {
            if ($('input[name=' + item + ']:checked').val() === '其他' && $('input[name=' + item + '].other').val()) {
                data[item] = '其他：' + $('input[name=' + item + '].other').val();
            } else {
                data[item] = $('input[name=' + item + ']:checked').val();
            }
        });
        $.each(T.questionTypes.checkbox, function(i, item) {
            data[item] = [];
            $('input[name=' + item + ']').each(function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() === '其他' && $('input[name=' + item + '].other').val()) {
                        data[item].push('其他：' + $('input[name=' + item + '].other').val());
                    } else {
                        data[item].push($(this).val());
                    }
                }
            });
            data[item] = data[item].join('|');
        });
        $.ajax({
            url: T.url,
            type: "post",
            dataType: "json",
            data: data,
            success: function(ret) {
                if (ret.code === 0) {
                    layer.msg('提交成功', {
                        icon: 1,
                        time: 1500,
                        end: function() {
                            location.href = T.baseUrl + '/company/surveyEntOpEnv.html?type=success';
                        }
                    });
                } else {
                    layer.msg(ret.msg, {icon: 0});
                    var patt = /^\d+/g;
                    var result = patt.exec(ret.msg);
                    if (result) {
                        var page = Math.ceil(result[0] / 6);
                        $(".yeshu").jumpPage(page);
                    }
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                if (xhr.responseJSON) {
                    alert(xhr.responseJSON.msg);
                } else if (xhr.responseText) {
                    alert(xhr.responseText);
                } else {
                    alert('请求出错！\n响应状态：' + xhr.statusText + '（' + xhr.status + '）\n错误信息：' + textStatus);
                }
            }
        });
    });
});