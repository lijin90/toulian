jQuery(function ($) {
//// 老板需求飘进来
// new WOW().init();
// 修改咨询
    $(".zixun").parents('.train_tab_con').css("padding", "0px 35px");
    $(".zixun").siblings("h1").css("text-indent", "3rem");
    // 培训内容-保持高度与左边菜单一致
    $('.train .train_con').height($('.train .train_tab').height() + 30 - 4 - 80);
    $(".nano").height($('.train .train_con').height());
    $(".nano").nanoScroller();
    // 培训内容切换
    $(".train_tab li").click(function () {
        $(".train_tab li").removeClass("current");
        $(this).addClass("current");
        $(".train .train_tab_con").eq($(this).index()).addClass("show").siblings().removeClass("show");
        // 培训内容-刷新滚动条
        $(".nano").nanoScroller();
        if ($(this).find('a').text() === '培训位置' || $(this).find('a').text() === '时间地点') {
            // 渲染位置地图
            if ($('#allmap').length === 1 && $("#mapRendered").val() === 'no') {
                var map = new BMap.Map("allmap");
                var point = new BMap.Point(116.404, 39.915);
                map.centerAndZoom(point, 11);
                map.setCurrentCity("北京");
                map.setDefaultCursor("default");
                map.addControl(new BMap.MapTypeControl());
                map.addControl(new BMap.NavigationControl());
                map.enableDragging();
                map.enableInertialDragging();
                map.enableScrollWheelZoom();
                map.disableKeyboard();
                var mapLocation = $("#mapLocation").val();
                var mapCoordinates = $("#mapCoordinates").val();
                if (mapCoordinates) {
                    var point = new BMap.Point(mapCoordinates.split(",")[0], mapCoordinates.split(",")[1]);
                    map.centerAndZoom(point, 16);
                    var marker = new BMap.Marker(point);
                    map.addOverlay(marker);
                } else if (mapLocation) {
                    var local = new BMap.LocalSearch(map, {
                        renderOptions: {map: map}
                    });
                    local.search($("#mapLocation").val());
                }
                $("#mapRendered").val('yes');
            }
        }
    });
    // 培训内容分页
    $(".train_tab_con .content-page-box").each(function () {
        if ($(this).siblings('.content-page').length === 0) {
            return;
        }
        $(this).siblings('.content-page').hide().eq(0).show();
        $(this).attr('data-page-max', $(this).siblings('.content-page').length - 1);
        $(this).attr('data-page-current', 0);
        $(this).children('.content-page-prev').css("pointer-events", "none");
        $(this).children('.content-page-prev').find("img").attr("src", "../../images/peixun_new/btn_left_none.png");
        $(this).children('.content-page-prev').click(function () {
            var pageBox = $(this).parent('.content-page-box');
            var pageCurrent = parseInt(pageBox.attr('data-page-current'));
            var pageMax = parseInt(pageBox.attr('data-page-max'));
            pageCurrent--;
            if (pageCurrent > 0) {
                $(this).css("pointer-events", "");
                $(this).find("img").attr("src", "../../images/peixun_new/btn_left.png");
            } else {
                $(this).css("pointer-events", "none");
                $(this).find("img").attr("src", "../../images/peixun_new/btn_left_none.png");
            }
            if (pageCurrent < pageMax) {
                $(this).siblings('.content-page-next').css("pointer-events", "");
                $(this).siblings('.content-page-next').find("img").attr("src", "../../images/peixun_new/btn_right.png");
            } else {
                $(this).siblings('.content-page-next').css("pointer-events", "none");
                $(this).siblings('.content-page-next').find("img").attr("src", "../../images/peixun_new/btn_right_none.png");
            }
            pageBox.attr('data-page-current', pageCurrent);
            pageBox.siblings('.content-page').hide().eq(pageCurrent).show();
        });
        $(this).children('.content-page-next').click(function () {
            var pageBox = $(this).parent('.content-page-box');
            var pageCurrent = parseInt(pageBox.attr('data-page-current'));
            var pageMax = parseInt(pageBox.attr('data-page-max'));
            pageCurrent++;
            if (pageCurrent > 0) {
                $(this).siblings('.content-page-prev').css("pointer-events", "");
                $(this).siblings('.content-page-prev').find("img").attr("src", "../../images/peixun_new/btn_left.png");
            } else {
                $(this).siblings('.content-page-prev').css("pointer-events", "none");
                $(this).siblings('.content-page-prev').find("img").attr("src", "../../images/peixun_new/btn_left_none.png");
            }
            if (pageCurrent < pageMax) {
                $(this).css("pointer-events", "");
                $(this).find("img").attr("src", "../../images/peixun_new/btn_right.png");
            } else {
                $(this).css("pointer-events", "none");
                $(this).find("img").attr("src", "../../images/peixun_new/btn_right_none.png");
            }
            pageBox.attr('data-page-current', pageCurrent);
            pageBox.siblings('.content-page').hide().eq(pageCurrent).show();
        });
    });
    // 培训内容-创建滚动条
    $(".nano").nanoScroller();
    // 培训咨询
    $(".message_ask textarea").blur(function () {
        if ($.trim($(this).val()) === '') {
            $(".message_ask .error.question").text("请输入您要咨询的问题");
        } else {
            $(".message_ask .error.question").text("");
        }
    });
    $(".message_ask input[name=mobile]").blur(function () {
        var mobile = $.trim($(this).val());
        if (mobile === "") {
            $(".message_ask .error.mobile").text("请输入您的手机号码");
        } else if (!(/^1[3578][0-9]{9}$/).test(mobile)) {
            $('.message_ask .error.mobile').text('手机号码格式错误');
        } else {
            $(".message_ask .error.mobile").text("");
        }
    });
    // 发表咨询
    $(".message_ask .submit input").click(function () {
        var self = this;
        if ($(self).attr('data-clicked')) {
            return;
        }
        $(self).attr('data-clicked', '1');
        var RealName = '';
        var Mobile = $(".message_ask input[name=mobile]").val();
        var Content = $(".message_ask textarea").val();
        $.post(T.baseUrl + '/activity/consultSubmit.html', {AID: T.training.ID, RealName: RealName, Mobile: Mobile, Content: Content}, function (ret) {
            if (ret.code === 0) {
                layer.alert('咨询已提交，稍后会有专人联系您！', {
                    icon: 1,
                    end: function () {
                        $(".message_ask input[name=mobile]").val('');
                        $(".message_ask textarea").val('');
                    }
                });
            } else {
                layer.msg(ret.msg, {icon: 0});
            }
            $(self).removeAttr('data-clicked');
        }, 'json').error(function (xhr, textStatus, errorThrown) {
            layer.msg('提交失败，请重试！', {icon: 0});
            $(self).removeAttr('data-clicked');
        });
    });

    // 发表评论
    /* $('.comment_submit').click(function() {
     var self = this;
     if ($(self).attr('data-clicked')) {
     return;
     }
     $(self).attr('data-clicked', '1');
     var Content = $(".textarea textarea[name=comment]").val();
     $.post(T.baseUrl + '/activity/commentSubmit.html', {AID: T.training.ID, Content: Content}, function(ret) {
     if (ret.code === 0) {
     layer.msg('评论已提交', {
     icon: 1,
     end: function() {
     $(".textarea textarea[name=comment]").val('');
     }
     });
     } else {
     layer.msg(ret.msg, {icon: 0});
     }
     $(self).removeAttr('data-clicked');
     }, 'json').error(function(xhr, textStatus, errorThrown) {
     layer.msg('提交失败，请重试！', {icon: 0});
     $(self).removeAttr('data-clicked');
     });
     }); */
});


