jQuery(function($) {
    var navHeight = $("#heng").offset().top;
    var navFix = $("#heng");
    $(window).scroll(function() {
        if ($(this).scrollTop() > navHeight) {
            navFix.addClass("fix");
        } else {
            navFix.removeClass("fix");
        }
    });
    $('#heng').navScroll({
        mobileDropdown: true,
        mobileBreakpoint: 768,
        scrollSpy: true
    });
    var to = $('.lankuai p').text().length;
    if (to === 2) {
        $('.lankuai p').css({"paddingTop": "32px"});
    }
    // 轮播图
    $('#demo1').banqh({
        box: "#demo1", //总框架
        pic: "#ban_pic1", //大图框架
        pnum: "#ban_num1", //小图框架
        prev_btn: "#prev_btn1", //小图左箭头jq
        next_btn: "#next_btn1", //小图右箭头
        pop_prev: "#prev2", //弹出框左箭头
        pop_next: "#next2", //弹出框右箭头
        prev: "#prev1", //大图左箭头
        next: "#next1", //大图右箭头
        pop_div: "#demo2", //弹出框框架
        pop_pic: "#ban_pic2", //弹出框图片框架
        pop_xx: ".pop_up_xx", //关闭弹出框按钮
        mhc: ".mhc", //朦灰层
        autoplay: true, //是否自动播放
        interTime: 5000, //图片自动切换间隔
        delayTime: 400, //切换一张图片时间
        pop_delayTime: 400, //弹出框切换一张图片时间
        order: 0, //当前显示的图片（从0开始）
        picdire: true, //大图滚动方向（true为水平方向滚动）
        mindire: true, //小图滚动方向（true为水平方向滚动）
        min_picnum: 3, //小图显示数量
        pop_up: true//大图是否有弹出框
    });
    $(".xuand img").zoomImgRollover();
    // 未审核资源提醒
    if (parseInt(T.resource.ReleaseStatus) !== 3) {
        layer.confirm('您所查看的资源未被审核通过，请选择其他资源或查看审核该资源！', {
            icon: 3, title: '温馨提示', closeBtn: 0, btn: ['其他资源', '审核资源'], area: '450px'
        }, function(index) {
            location.href = T.baseUrl + '/resource/supply.html';
            layer.close(index);
        }, function(index) {
            layer.close(index);
        });
    }
    // 查看联系方式
    $(".tel a").click(function() {
        // 未登录时弹出登录框
        if (T.user.isGuest) {
            layer.open({
                type: 1,
                area: '360px',
                title: ['请先登录！', 'background-color:#09C1FF; color:#fff; border:none;'],
                closeBtn: 2,
                shift: 1,
                skin: 'layui-layer-demo', //样式类名
                content: '<div style="padding-bottom:20px;">\
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
        // 经纪公司角色ID：22733acf-ea59-4019-945b-46e97ef8b613
        // 经纪人/招商顾问角色ID：cf92e44a-28f8-46db-a268-fa8d940746fa
        // 登录者角色为经纪公司或经纪人/招商顾问时
        if (T.user.roleId === '22733acf-ea59-4019-945b-46e97ef8b613' || T.user.roleId === 'cf92e44a-28f8-46db-a268-fa8d940746fa') {
            var apply = T.user.roleId === '22733acf-ea59-4019-945b-46e97ef8b613' ? T.user.deptName : T.user.userName;
            var owner = T.resource.Owner;
            if (T.resource.Dept && T.resource.Dept.DeptType === 'agency') {// 所访问的资源为物业经纪资源
                // 经纪公司访问经纪公司的资源时是交易
                if (T.user.roleId === '22733acf-ea59-4019-945b-46e97ef8b613' && T.resource.User.RoleID !== '22733acf-ea59-4019-945b-46e97ef8b613') {
                    if (!mobileIsValid()) {
                        return;
                    }
                    layer.confirm('您确认申请与对方交易吗？', {
                        btn: ['确认', '取消']
                    }, function(index) {
                        trade();
                        layer.close(index);
                    }, function(index) {
                        layer.close(index);
                    });
                } else {// 经纪公司访问经纪人的资源，经纪人访问经纪公司或者经纪人的资源都是经纪合作
                    if (!mobileIsValid()) {
                        return;
                    }
                    layer.confirm('您申请的经济合作已提交，' + owner + '正在审核中...', {
                        btn: ['确认']
                    }, function(index) {
                        cooperation();
                        layer.close(index);
                    });
                }
            } else {// 所访问的资源为非物业经纪资源
                if (!mobileIsValid()) {
                    return;
                }
                layer.open({
                    type: 1,
                    title: ['信息获取确认单'],
                    content: '<div><ul>\
                                <li><span>申请资源信息获取方：</span><label>' + apply + '</label></li>\
                                <li><span>资源提供方：</span><label>' + owner + '</label></li>\
                                <li><span>资源获取时间：</span><label>' + (new Date()).toLocaleString() + '</label></li>\
                                </ul></div>',
                    closeBtn: 2,
                    shift: 1,
                    btn: ['代理', '交易'],
                    btn1: function() {
                        agency();
                    }, btn2: function() {
                        trade();
                    }
                });
            }
            return;
        } else {
            if (!mobileIsValid()) {
                return;
            }
            layer.confirm('您确认申请与对方交易吗？', {
                btn: ['确认', '取消']
            }, function(index) {
                trade();
                layer.close(index);
            }, function(index) {
                layer.close(index);
            });
        }
    });
});
function SmscodeCounter(seconds) {
    if (seconds === 0) {
        $('#btn-smsCode').css('background-color', '#808CA4');
        $('#btn-smsCode').text('获取验证码');
        return;
    }
    $('#btn-smsCode').css('background-color', 'gray');
    $('#btn-smsCode').text(seconds + '秒后重发');
    seconds--;
    window.setTimeout(function() {
        SmscodeCounter(seconds);
    }, 1000);
}
function mobileIsValid() {
    if (T.user.mobileIsValid) {
        return true;
    }
    window.setTimeout(function() {
        layer.open({
            type: 1,
            title: ['请先验证手机号！', 'background-color:#09C1FF; color:#fff; border:none;'],
            closeBtn: 2,
            shift: 1,
            content: '<div class="tlwlogon" id="mobileValidForm">\
                         <p><input type="text" placeholder="手机号码" name="mobile" value="' + T.user.mobile + '" /></p>\
                         <p><input type="text" placeholder="请输入验证码" name="smsCode" style="width: 140px;" /><a class="tlw-z-but" href="javascript:;" id="btn-smsCode">获取验证码</a></p>\
                         <p class="tlw-z-yesbut"><a href="javascript:;" id="btn-confirm" >确定</a></p>\
                    </div>'
        });
        $('#btn-smsCode').click(function() {
            var self = this;
            if ($(self).attr('data-clicked')) {
                return;
            }
            $(self).attr('data-clicked', '1');
            if ($(this).text() !== '获取验证码') {
                $(self).removeAttr('clicked');
                return;
            }
            var url = T.baseUrl + '/studio/security/mobile';
            var type = 'new-code';
            var mobile = $('#mobileValidForm input[name=mobile]').val();
            $.post(url, {type: type, mobile: mobile}, function(ret) {
                if (ret.code === 0) {
                    layer.msg(ret.msg, {
                        icon: 1,
                        time: 1500,
                        end: function() {
                            SmscodeCounter(60);
                        }
                    });
                } else {
                    layer.msg(ret.msg, {icon: 0});
                }
                $(self).removeAttr('data-clicked');
            }, 'json');
        });
        $('#btn-confirm').click(function() {
            var self = this;
            if ($(self).attr('data-clicked')) {
                return;
            }
            $(self).attr('data-clicked', '1');
            var url = T.baseUrl + '/studio/security/mobile';
            var type = 'new';
            var mobile = $('#mobileValidForm input[name=mobile]').val();
            var smsCode = $('#mobileValidForm input[name=smsCode]').val();
            $.post(url, {type: type, mobile: mobile, smsCode: smsCode}, function(ret) {
                if (ret.code === 0) {
                    layer.msg(ret.msg, {
                        icon: 1,
                        time: 1500,
                        end: function() {
                            location.href = T.url;
                        }
                    });
                } else {
                    layer.msg(ret.msg, {icon: 0});
                }
                $(self).removeAttr('data-clicked');
            }, 'json');
        });
    }, 500);
    return false;
}
// 代理资源
function agency() {
    var url = T.baseUrl + '/resource/trade.html';
    $.post(url, {resId: T.resource.ID, status: 0}, function(ret) {
        if (ret.code === 0) {
            layer.msg('申请代理成功', {
                icon: 1,
                time: 1500,
                end: function() {
                    getContact();
                }});
        } else {
            layer.msg(ret.msg, {icon: 0});
        }
    }, 'json');
}
// 经纪合作
function cooperation() {
    var url = T.baseUrl + '/resource/trade.html';
    $.post(url, {resId: T.resource.ID, status: 8, responseId: T.resource.UserID}, function(ret) {
        if (ret.code === 0) {
            layer.msg('提交申请经纪合作成功,请等待对方回应', {
                icon: 1,
                time: 1500,
                end: function() {
                    getContact();
                }});
        } else {
            layer.msg(ret.msg, {icon: 0});
        }
    }, 'json');
}
// 资源交易
function trade() {
    var url = T.baseUrl + '/resource/trade.html';
    $.post(url, {resId: T.resource.ID, status: 8}, function(ret) {
        if (ret.code === 0) {
            layer.msg('申请交易成功', {
                icon: 1,
                time: 1500,
                end: function() {
                    getContact();
                }});
        } else {
            layer.msg(ret.msg, {icon: 0});
        }
    }, 'json');
}
// 获取资源联系电话，并发送到用户绑定手机
function getContact() {
    var url = T.baseUrl + '/resource/contact.html';
    $.post(url, {resId: T.resource.ID}, function(ret) {
        if (ret.code === 0) {
            $('.tel').html('<span>' + ret.data + '</span>');
            if (ret.msg) {
                layer.msg(ret.msg, {icon: 1});
            }
        } else {
            layer.msg(ret.msg, {icon: 0});
        }
    }, 'json');
}
