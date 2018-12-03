jQuery(function ($) {
    if (T.submitAlert) {
        layer.msg(T.submitAlert, {
            time: 0,
            icon: 2,
            shift: 1,
            btn: ['确定', '回到首页'],
            yes: function (index) {
                layer.close(index);
                location.href = T.url;
            },
            cancel: function (index) {
                location.href = T.homeUrl;
            }
        });
    }
    // 个人和企业切换
    $('input[name=CustomerType]').change(function () {
        if ($('input[name=CustomerType]:checked').val() === 'individual') {
            $(".enterprise").addClass("hide");
        } else {
            $(".enterprise").removeClass("hide");
        }
    });
    // 增值税普通发票和增值税专用发票切换
    $('input[name=TaxpayerType]').change(function () {
        if ($('input[name=TaxpayerType]:checked').val() === 'general') {
            $(".common_invoice i,.hint_blue").addClass("hide");
            $(".hint_red").removeClass("hide");
        } else {
            $(".common_invoice i,.hint_blue").removeClass("hide");
            $(".hint_red").addClass("hide");
        }
    });
    $('img.tips').mouseover(function () {
        layer.tips($(this).attr('data-title'), $(this), {tips: [3, '#BA6165'], maxWidth: 400, time: 3000});
    });
    $('img.tips2').click(function () {
        layer.tips($(this).attr('data-title'), $(this), {tips: [2, '#BA6165'], maxWidth:130, time: 2000});
    });
// 地区选择
    $('#areaCode').pcasDict('AreaCode');
// 点击提交按钮
    $('.invoice .submit input').click(function () {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var data = {};
        data.InvoiceType = $('.InvoiceType.current').attr('data-invoicetype');
        data.CustomerType = $('input[name=CustomerType]:checked').val();
        data.InvoiceTitle = $('input[name=InvoiceTitle]').val();
        data.TaxpayerType = $('input[name=TaxpayerType]:checked').val();
        data.RegisterNo = $('input[name=RegisterNo]').val();
        data.Bank = $('input[name=Bank]').val();
        data.BankNo = $('input[name=BankNo]').val();
        data.OperatingLicenseAddress = $('input[name=OperatingLicenseAddress]').val();
        data.OperatingLicensePhone = $('input[name=OperatingLicensePhone]').val();
        data.Addressee = $('input[name=Addressee]').val();
        data.AreaCode = $('input[name=AreaCode]').val();
        data.Street = $('input[name=Street]').val();
        data.PostalCode = $('input[name=PostalCode]').val();
        data.Phone = $('input[name=Phone]').val();
        $.post(T.url, data, function (ret) {
            if (ret.code === 0) {
                layer.msg('提交成功', {
                    icon: 1,
                    time: 3000,
                    end: function () {
                        location.href = T.successToUrl ? T.successToUrl : T.homeUrl;
                    }
                });
            } else {
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function (xhr, textStatus, errorThrown) {
            layer.alert('提交失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });
});

