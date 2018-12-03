jQuery(function ($) {
    laydate({
        elem: '#Birthday',
        format: 'YYYY-MM-DD',
        //min: laydate.now(), //设定最小日期为当前日期
        //max: '2099-06-16 23:59:59', //最大日期
        istime: false,
        istoday: false,
        choose: function (dates) { //选择好日期的回调
            $("input[name=Birthday]").blur();
        }
    });
    $(".basic input[type=text]").blur(function () {
        var name = $(this).attr('name');
        var val = $.trim($(this).val());
        var pl = $(this).attr('placeholder');
        if (name === 'CareerIntention') {
            return;
        }
        if (val === '') {
            $(".error ." + name).text(pl);
        } else if (name === 'Telephone' && !(/^1[3578][0-9]{9}$/).test(val)) {
            $(".error ." + name).text('手机号码格式错误');
        } else if (name === 'Email' && !(/^[\w\.\-]{1,26}@([\w\-]{1,20}\.){1,2}[a-z]{2,10}(\.[a-z]{2,10})?$/i).test(val)) {
            $(".error ." + name).text('邮箱格式码格式错误');
        } else {
            $(".error ." + name).text("");
        }
    });
    // 性别
    $(".basic .Gender").click(function () {
        $(".basic .Gender").removeClass("current");
        $(this).addClass("current");
        $(this).find("img:eq(1)").addClass("active").siblings("img").removeClass("active");
        $(this).siblings().find("img:eq(0)").addClass("active").siblings("img").removeClass("active");
    });
    // 最高学历
    $(".basic select[name=HighestEducation]").change(function () {
        if ($(this).val() === '') {
            $(".error .HighestEducation").text('最高学历必须选择');
        } else {
            $(".error .HighestEducation").text('');
        }
    });
    // 头像上传
    $('.resume .AvatarUpload').fileupload({
        url: T.baseUrl + '/file/uploadImage.html',
        type: 'POST',
        dataType: 'json',
        paramName: 'file',
        formData: {type: 'images'},
        start: function (e) {
            window.avatarUploading = layer.msg('上传中', {icon: 16, shadeClose: false});
        },
        done: function (e, data) {
            var data = data.result;
            if (data.code === 0) {
                $('.resume input[name="AvatarPath"]').val(data.data.path);
                $('.resume input[name="AvatarUrl"]').val(data.data.url);
                $('.resume .AvatarUpload').siblings('.cover').find('img').attr('src', data.data.url);
                $('.resume .AvatarUpload').siblings('.cover').find('img').addClass("active_img");
                $(".resume .cover p,.resume .cover span").hide();
            } else {
                layer.alert(data.msg, {icon: 0});
            }
            layer.close(window.avatarUploading);
        },
        fail: function (e, data) {
            layer.close(window.avatarUploading);
            layer.alert('上传失败，请重试！', {icon: 0});
        }
    });
    // 简历附件上传
    $('.resume .AttachUpload').fileupload({
        url: T.baseUrl + '/file/uploadImage.html',
        type: 'POST',
        dataType: 'json',
        paramName: 'file',
        formData: {type: 'resumes'},
        start: function (e) {
            window.attachUploading = layer.msg('上传中', {icon: 16, shadeClose: false});
        },
        done: function (e, data) {
            var data = data.result;
            if (data.code === 0) {
                $('.resume input[name="AttachPath"]').val(data.data.path);
                $('.resume input[name="AttachUrl"]').val(data.data.url);
                $('.resume .AttachUpload').siblings('.file_box').find('img').attr('src', data.data.url);
            } else {
                layer.alert(data.msg, {icon: 0});
            }
            layer.close(window.attachUploading);
        },
        fail: function (e, data) {
            layer.close(window.attachUploading);
            layer.alert('上传失败，请重试！', {icon: 0});
        }
    });
    // Ajax请求
    $(".resume_fill .submit button").click(function () {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var hasError = false;
        $(".basic input[type=text]").each(function () {
            var name = $(this).attr('name');
            var val = $.trim($(this).val());
            var pl = $(this).attr('placeholder');
            if (name === 'CareerIntention') {
                return;
            }
            if (val === '') {
                $(".error ." + name).text(pl);
                hasError = true;
            } else if (name === 'Telephone' && !(/^1[3578][0-9]{9}$/).test(val)) {
                $(".error ." + name).text('手机号码格式错误');
                hasError = true;
            } else if (name === 'Email' && !(/^[\w\.\-]{1,26}@([\w\-]{1,20}\.){1,2}[a-z]{2,10}(\.[a-z]{2,10})?$/i).test(val)) {
                $(".error ." + name).text('邮箱格式码格式错误');
                hasError = true;
            } else {
                $(".error ." + name).text("");
            }
        });
        if ($(".basic select[name=HighestEducation]").val() === '') {
            $(".error .HighestEducation").text('最高学历必须选择');
            hasError = true;
        } else {
            $(".error .HighestEducation").text('');
        }
        if (hasError) {
            $(self).removeAttr('data-clicked');
            return false;
        }
        var data = {
            RealName: $("input[name=RealName]").val(),
            Gender: $(".Gender.current span").attr('data-id'),
            Nation: $("input[name=Nation]").val(),
            Marital: $("input[name=Marital]").val(),
            Birthday: $("input[name=Birthday]").val(),
            Native: $("input[name=Native]").val(),
            Telephone: $("input[name=Telephone]").val(),
            Email: $("input[name=Email]").val(),
            SchoolTag: $("input[name=SchoolTag]").val(),
            HighestEducation: $("select[name=HighestEducation]").val(),
            MajorName: $("input[name=MajorName]").val(),
            LanguageCompetence: $("textarea[name=LanguageCompetence]").val(),
            WorkExperience: $("textarea[name=WorkExperience]").val(),
            PersonalSkill: $("textarea[name=PersonalSkill]").val(),
            SelfEvaluation: $("textarea[name=SelfEvaluation]").val(),
            CareerIntention: $("input[name=CareerIntention]").val(),
            Avatar: $('.resume input[name="AvatarPath"]').val(),
            Attach: $('.resume input[name="AttachPath"]').val()
        }
        $.post('', data, function (ret) {
            if (ret.code === 0) {
                layer.open({
                    type: 1,
                    title: false,
                    shadeClose:true,
                    time: 3000, //20s后自动关闭
                    area: ['304px', '236px'], //宽高
                    closeBtn: 0,
                    content: '<img src="' + T.imageUrl + '/resume/tip_success.png' + '" alt=""/>',
                    end: function () {
                        location.href = T.url;
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

