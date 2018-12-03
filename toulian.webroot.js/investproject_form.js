jQuery(function($) {
    $('.project_form .submit input').click(function() {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var ID = $('.project_form input[name=ID]').val();
        var Type = $('.project_form input[name=Type]').val();
        var Year = $('.project_form input[name=Year]').val();
        var Name = $('.project_form input[name=Name]').val();
        var Industry = $('.project_form input[name=Industry]').val();
        var Content = $('.project_form textarea[name=Content]').val();
        var Money = $('.project_form input[name=Money]').val();
        var Region = $('.project_form input[name=Region]').val();
        var TotalArea = $('.project_form input[name=TotalArea]').val();
        var InvestArea = $('.project_form input[name=InvestArea]').val();
        var InvestRequire = $('.project_form textarea[name=InvestRequire]').val();
        var Prospect = $('.project_form textarea[name=Prospect]').val();
        var Supplement = $('.project_form textarea[name=Supplement]').val();
        var InvestorName = $('.project_form input[name=InvestorName]').val();
        var InvestorBackground = $('.project_form input[name=InvestorBackground]').val();
        var InvestorContact = $('.project_form input[name=InvestorContact]').val();
        var InvestorPhone = $('.project_form input[name=InvestorPhone]').val();
        var InvestorMail = $('.project_form input[name=InvestorMail]').val();
        $.post(T.baseUrl + '/investproject/save.html', {
            ID: ID,
            Type: Type,
            Year: Year,
            Name: Name,
            Industry: Industry,
            Content: Content,
            Money: Money,
            Region: Region,
            TotalArea: TotalArea,
            InvestArea: InvestArea,
            InvestRequire: InvestRequire,
            Prospect: Prospect,
            Supplement: Supplement,
            InvestorName: InvestorName,
            InvestorBackground: InvestorBackground,
            InvestorContact: InvestorContact,
            InvestorPhone: InvestorPhone,
            InvestorMail: InvestorMail
        }, function(ret) {
            if (ret.code === 0) {
                layer.alert(ret.msg, {
                    icon: 1,
                    end: function() {
                        location.href = ret.data ? ret.data : T.url;
                    }
                });
            } else {
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            if (xhr.responseText) {
                layer.msg(xhr.responseText, {icon: 0});
            } else {
                layer.msg('提交失败，请重试！', {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        });
    });
});