jQuery(function($) {
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
        if (!mobileIsValid()) {
            return;
        }
        var apply = T.user.roleId === '22733acf-ea59-4019-945b-46e97ef8b613' ? T.user.deptName : T.user.userName;
        var owner = T.resource.Owner;
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
            btn: ['代理', '取消'],
            btn1: function() {
                agency();
            }, btn2: function() {

            }
        });
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