jQuery(function($) {
    // 查看联系方式
    $(".tel a").click(function() {
        // 未登录时弹出登录框
        if (T.user.isGuest) {
            layer.open({
                type: 1,
                title: ['请先登录！', 'background-color:#09C1FF; color:#fff; border:none;'],
                closeBtn: 2,
                shift: 1,
                content: '<div>\
                        <li><input type="text" id="username" name="username" placeholder="登录账户"/></li>\
                        <li><input type="password" id="password" name="password" placeholder="登录密码"/></li>\
                        <li><input type="text" id="verifyCode" name="verifyCode" placeholder="请输入图片验证码" />\
                        <a id="verifyCodeRefresh" href="javascript:;"><img title="若不清晰，请点击更换！" src="' + T.baseUrl + '/user/verifyCode"/></a></li>\
                        <a id="confirmlogin" href="javascript:;">登录</a><a id="register" href="' + T.baseUrl + '/user/register">注册</a>\
                        </div>',
                success: function(layero, index) {
                    loginInit();
                }
            });
            return;
        }
    });
});