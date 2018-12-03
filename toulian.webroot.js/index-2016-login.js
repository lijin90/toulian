jQuery(function($) {
    // 登录方式切换
    $(".login_mixed_way li").click(function() {
        var $self = $(this);
        $(this).addClass("active").siblings().removeClass("active");
        $(".login_mixed_method_con .login_mixed_method").eq($self.index()).addClass("show_login").siblings().removeClass("show_login");
        if ($(".login_mixed_method_con .login_mixed_method").eq($self.index()).hasClass('wechat_qrcode')) {
            window.wechatScanSwitch = true;
            wechatScanChecking();
        } else {
            window.wechatScanSwitch = false;
        }
    });
    // 手机用户名点击切换
//    $(".login_new .cut_tab").click(function() {
//        $(".cut").removeClass("active");
//        $(this).parents(".cut").siblings(".cut").addClass("active");
//    });
//    $(".login_new img.pc_wechat").click(function() {
//        var flag = $(this).attr("data-flag");
//        if (flag == 1) {
//            $(this).attr("src", T.imageUrl + "/one/pc.png");
//            $('.pc_tab').css({"display": "none"});
//            $('.wechat_tab').css({"display": "block"});
//            $(this).attr("data-flag", 0);
//            layer.tips('密码登录', this, {
//                tips: [4, '#5bc0de'],
//                time: 180000
//            });
//            window.wechatScanSwitch = true;
//            wechatScanChecking();
//        } else {
//            $(this).attr("src", T.imageUrl + "/one/erweima.png");
//            $('.pc_tab').css({"display": "block"});
//            $('.wechat_tab').css({"display": "none"});
//            $(this).attr("data-flag", 1);
//            layer.tips('扫码登录', this, {
//                tips: [4, '#5bc0de'],
//                time: 180000
//            });
//            window.wechatScanSwitch = false;
//        }
//    });
    if (T.url === T.homeUrl && T.user.isGuest) {
        $('.login_mixed_frame').css('display', 'block');
    }
});