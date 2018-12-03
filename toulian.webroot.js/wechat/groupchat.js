// XMPP服务器BOSH地址
var bosh_service = 'http://host:7070/http-bind/';
// 当前登录的JID
var jid = "";
// XMPP连接
var connection = null;
// 当前状态是否连接
var connected = false;

// xmlInput方法用来接收服务器发送来的XMPP节
function onXmlInput(elem) {
    //console.log("onXmlInput");
    //console.log(elem);
}

// xmlOutput是客户端发送的XMPP节
function onXmlOutput(elem) {
    //console.log("onXmlOutput");
    //console.log(elem);
}

// 连接状态改变的事件
function onConnect(status) {
    //console.log("onConnect");
    //console.log(status);
    if (status == Strophe.Status.CONNFAIL) {
        connected = false;
        layer.open({
            content: '<div class="text-center">连接失败！</div>',
            btn: ['重新连接'],
            end: function() {
                location.href = T.url + (T.url.indexOf('?') !== -1 ? '&' : '?') + 't=' + (new Date().getTime());
            }
        });
    } else if (status == Strophe.Status.AUTHFAIL) {
        connected = false;
        layer.open({
            content: '<div class="text-center">登录失败！</div>',
            btn: ['重新登录'],
            end: function() {
                location.href = T.url + (T.url.indexOf('?') !== -1 ? '&' : '?') + 't=' + (new Date().getTime());
            }
        });
    } else if (status == Strophe.Status.DISCONNECTED) {
        connected = false;
        layer.open({
            content: '<div class="text-center">连接断开！</div>',
            btn: ['重新连接'],
            end: function() {
                location.href = T.url + (T.url.indexOf('?') !== -1 ? '&' : '?') + 't=' + (new Date().getTime());
            }
        });
    } else if (status == Strophe.Status.CONNECTED) {
        layer.open({
            type: 2,
            content: '正在进入聊天室',
            time: 1
        });
        connected = true;
        // 当接收到<message>节，调用onMessage回调函数
        connection.addHandler(onMessage, null, 'message', null, null, null);
        // 首先要发送一个<presence>给服务器（initial presence）
        connection.send($pres().tree());
        var toJid = T.im.roomjid;
        // 发送<presence>元素进入房间（若房间已存在，则直接进入房间；若房间不存在，则创建后进入房间）
        connection.send($pres({
            from: jid,
            to: toJid + "/" + Strophe.getResourceFromJid(jid)
        }).c('x', {xmlns: 'http://jabber.org/protocol/muc'}).tree());
    }
}

// 接收到<message>
function onMessage(msg) {
    //console.log("onMessage");
    //console.log(msg);
    // 解析出<message>的from、type属性，以及body子元素
    var from = msg.getAttribute('from');
    var type = msg.getAttribute('type');
    var elems = msg.getElementsByTagName('body');
    if (type == "groupchat" && elems.length > 0) {
        var body = elems[0];
        body = Strophe.getText(body);
        //表情符号替换为表情图片
        body = body.replace(/\[em_qq_([0-9]+)\]/g, '<img src="' + T.imageUrl + '/emoji/qq/$1.gif" alt="" />');
        body = body.replace(/\[em_tieba_([0-9]+)\]/g, '<img src="' + T.imageUrl + '/emoji/tieba/$1.jpg" alt="" />');
        body = body.replace(/\[em_symbol_([0-9]+)\]/g, '<img src="' + T.imageUrl + '/emoji/symbol/$1.png" alt="" />');
        //图片符号替换为图片
        var regexp = /\[file_image_(\/[0-9]{8}\/[0-9]{8}_[0-9]{5}\.[a-z]+)\]/g;
        var image_thumb = T.baseUrl + '/file/resizeImage.html?path=' + '$1&type=im&width=' + $(window).width() * 0.54 + '&redirect=1';
        body = body.replace(regexp, '<img onclick="realImage(this)" class="img-thumbnail" src="' + image_thumb + '" data-path="$1" alt="" />');
        if (Strophe.getResourceFromJid(from) == T.im.nickname) {
            var avatar = $('<div></div>')
                    .addClass("col-xs-2 text-center")
                    .append($('<img />').attr("src", T.imageUrl + "/wechat/missing_face_me.png"));
            var title = $('<div></div>')
                    .addClass("no-padding text-right")
                    .append($('<div></div>').addClass("text-muted title").text(Strophe.getResourceFromJid(from)));
            var cont = $('<div></div>')
                    .addClass("col-xs-8 col-xs-offset-4 no-padding")
                    .append($('<div></div>').addClass("text-info cont cont-right").html(body));
            var row = $('<div></div>')
                    .addClass("row")
                    .append(title)
                    .append($('<div></div>').addClass("col-xs-10 no-padding").append(title).append(cont))
                    .append(avatar);
            $('.message-list').append(row);
        } else {
            var avatar = $('<div></div>')
                    .addClass("col-xs-2 text-center")
                    .append($('<img />').attr("src", T.imageUrl + "/wechat/missing_face.png"));
            var title = $('<div></div>')
                    .addClass("no-padding")
                    .append($('<div></div>').addClass("text-muted title").text(Strophe.getResourceFromJid(from)));
            var cont = $('<div></div>')
                    .addClass("col-xs-8 no-padding")
                    .append($('<div></div>').addClass("text-info cont cont-left").html(body));
            var row = $('<div></div>')
                    .addClass("row")
                    .append(avatar)
                    .append(title)
                    .append($('<div></div>').addClass("col-xs-10 no-padding").append(title).append(cont));
            $('.message-list').append(row);
        }
        var ht1 = $('.message-list')[0].scrollHeight;
        var ht2 = $('.message-list').scrollTop() + $('.message-list').height() + $('.message-list .row:last').height() + 10;
        if (ht1 - ht2 < 20) {
            $('.message-list').scrollTop($('.message-list')[0].scrollHeight);
        }
    }
    return true;
}
function realImage(obj) {
    if (!$(obj).attr('data-path')) {
        return;
    }
    $('#imagePreview').on('shown.bs.modal', function(e) {
        var image_thumb = T.baseUrl + '/file/resizeImage.html?path=' + $(obj).attr('data-path') + '&type=im&width=' + $('#imagePreview .modal-body').width() + '&redirect=1';
        $('#imagePreview .modal-body').html($('<img />').attr("src", image_thumb).attr('alt', ''));
        $('#imagePreview .modal-footer .btn-primary').removeClass('hide').click(function() {
            $('#imagePreview .modal-body').html($('<img />').attr("src", T.uploadUrl + '/im' + $(obj).attr('data-path')).attr('alt', ''));
            $(this).addClass('hide');
        });
        if ($(obj).attr('data-filesize')) {
            $('#imagePreview .modal-footer .btn-primary').text('查看原图（' + $(obj).attr('data-filesize') + '）');
        } else {
            $.post(T.baseUrl + '/file/info.html', {path: $(obj).attr('data-path'), type: 'im'}, function(ret) {
                if (ret.code === 0) {
                    $(obj).attr('data-filesize', ret.data.file_size_format);
                    $('#imagePreview .modal-footer .btn-primary').text('查看原图（' + ret.data.file_size_format + '）');
                }
            }, 'json');
        }
    });
    $('#imagePreview').modal();
}
$(document).ready(function() {
    $('.message-list').height($(window).height() - $('.navbar-top').height() - $('.navbar-bottom').height());
    $('.message-list').css('overflow-y', 'auto');
    // 通过BOSH连接XMPP服务器
    if (!connected) {
        bosh_service = T.im.boshservice;
        jid = T.im.jid;
        var password = T.im.password;
        connection = new Strophe.Connection(bosh_service);
        connection.xmlInput = onXmlInput;
        connection.xmlOutput = onXmlOutput;
        connection.connect(jid, password, onConnect);
    }
    // 返回
    $(".row .back").click(function() {
        if (connected) {
            // 离开房间
            var toJid = T.im.roomjid;
            connection.send($pres({
                from: jid,
                to: toJid + "/" + Strophe.getResourceFromJid(jid),
                type: 'unavailable'
            }).tree());
            // 断开连接
            connection.disconnect();
        }
        location.href = T.im.backUrl;
    });
    // 成员列表
    $(".row .members").click(function() {
        var url = T.baseUrl + '/wechatService/activity/applyGroupChatMembers.html';
        $.get(url, {activityApplyId: T.activityApply.ID}, function(ret) {
            if (ret.code === 0) {
                var tp = $('.navbar-top').height();
                var ht = $(window).height() - tp;
                var list = $('<div></div>');
                for (var i = 0; i < ret.data.length; i++) {
                    var src = T.imageUrl + "/wechat/missing_face.png";
                    if (Strophe.getResourceFromJid(ret.data[i].jid) == T.im.nickname) {
                        src = T.imageUrl + "/wechat/missing_face_me.png";
                    }
                    var avatar = $('<div></div>').addClass('text-center').append($('<img />').attr("src", src));
                    var title = $('<div></div>').addClass('text-center').append(Strophe.getResourceFromJid(ret.data[i].jid));
                    list.append($('<div></div>').addClass('col-xs-3').css({'padding-top': '10px', 'padding-bottom': '10px'}).append(avatar).append(title));
                }
                layer.open({
                    type: 1,
                    title: '在线成员（' + ret.data.length + '）',
                    content: list.html(),
                    anim: 'scale',
                    style: 'position: fixed;top: ' + tp + 'px;left: 0;width: 100%; height: ' + ht + 'px;padding: 10px 0;border: none;',
                    success: function(elem) {
                        $(elem).find('.layermcont').css('height', (ht - 90) + 'px');
                        $(elem).find('.layermcont').css('overflow-y', 'auto');
                    }
                });
            } else {
                layer.open({content: ret.msg, time: 2});
            }
        }, 'json').error(function(xhr, textStatus, errorThrown) {
            layer.open({content: '成员列表获取失败，请重试！', time: 2});
        });
    });
    // 发送消息
    $(".row .send").click(function() {
        if (connected) {
            var toJid = T.im.roomjid;
            var message = $('.message').val();
            if ($.trim(message) === '') {
                layer.open({
                    content: '请输入你要说的',
                    time: 1,
                    end: function() {
                        $('.message').focus();
                    }
                });
                return;
            }
            // 创建一个<message>元素并发送
            var msg = $msg({
                to: toJid,
                from: jid,
                type: 'groupchat'
            }).c("body", null, message);
            connection.send(msg.tree());
            $('.message').val('');
        } else {
            layer.open({
                content: '<div class="text-center">连接断开！</div>',
                btn: ['重新连接'],
                end: function() {
                    location.href = T.url + (T.url.indexOf('?') !== -1 ? '&' : '?') + 't=' + (new Date().getTime());
                }
            });
        }
    });
    // 表情
    $('.emoji').click(function() {
        var tp = $('.navbar-top').height();
        var bm = $('.navbar-bottom').height();
        var ht = $(window).height() - tp - bm;
        var html = $('<div></div>');
        var tabs = $('<ul></ul>').attr('role', 'tablist').addClass('nav nav-tabs');
        tabs.append($('<li></li>').attr('role', 'presentation').addClass('active').append($('<a></a>').attr('role', 'tab').attr('data-toggle', 'tab').attr('href', '#qq').text('QQ表情')));
        tabs.append($('<li></li>').attr('role', 'presentation').append($('<a></a>').attr('role', 'tab').attr('data-toggle', 'tab').attr('href', '#tieba').text('贴吧表情')));
        tabs.append($('<li></li>').attr('role', 'presentation').append($('<a></a>').attr('role', 'tab').attr('data-toggle', 'tab').attr('href', '#symbol').text('符号表情')));
        html.append(tabs);
        var content = $('<div></div>').addClass('tab-content');
        var qq = $('<div></div>').addClass('tab-pane active').attr('role', 'tabpanel').attr('id', 'qq');
        for (var i = 1; i <= 91; i++) {
            var src = T.imageUrl + "/emoji/qq/" + i + ".gif";
            var alias = '[em_qq_' + i + ']';
            var emoji = $('<a></a>').attr('href', 'javascript:;').attr('data-alias', alias).append($('<img />').attr("src", src));
            qq.append($('<div></div>').addClass('col-xs-2 text-center').css({'padding-top': '10px', 'padding-bottom': '10px'}).append(emoji));
        }
        content.append(qq);
        var tieba = $('<div></div>').addClass('tab-pane').attr('role', 'tabpanel').attr('id', 'tieba');
        for (var i = 1; i <= 50; i++) {
            var src = T.imageUrl + "/emoji/tieba/" + i + ".jpg";
            var alias = '[em_tieba_' + i + ']';
            var emoji = $('<a></a>').attr('href', 'javascript:;').attr('data-alias', alias).append($('<img />').attr("src", src));
            tieba.append($('<div></div>').addClass('col-xs-2 text-center').css({'padding-top': '10px', 'padding-bottom': '10px'}).append(emoji));
        }
        content.append(tieba);
        var symbol = $('<div></div>').addClass('tab-pane').attr('role', 'tabpanel').attr('id', 'symbol');
        for (var i = 0; i <= 58; i++) {
            var src = T.imageUrl + "/emoji/symbol/" + i + ".png";
            var alias = '[em_symbol_' + i + ']';
            var emoji = $('<a></a>').attr('href', 'javascript:;').attr('data-alias', alias).append($('<img />').attr("src", src));
            symbol.append($('<div></div>').addClass('col-xs-2 text-center').css({'padding-top': '10px', 'padding-bottom': '10px'}).append(emoji));
        }
        content.append(symbol);
        html.append(content);
        var emojiIndex = layer.open({
            type: 1,
            content: html.html(),
            anim: 'scale',
            style: 'position: fixed;bottom: ' + bm + 'px;left: 0;width: 100%; height: ' + ht + 'px;padding: 10px 0;border: none;',
            success: function(elem) {
                $(elem).find('.layermcont').css('height', (ht - 20) + 'px');
                $(elem).find('.layermcont').css('overflow-y', 'auto');
                $(elem).find('.layermcont .tab-content a').click(function() {
                    var msg = $('.message').val();
                    $('.message').val(msg + $(this).attr('data-alias'));
                    layer.close(emojiIndex);
                });
            }
        });
    });
    // 图片上传
    $('.imageupload').fileupload({
        url: T.baseUrl + '/file/uploadImage.html',
        type: 'POST',
        dataType: 'json',
        paramName: 'file',
        formData: {type: 'im'},
        start: function(e) {
            window.imageUploading = layer.open({type: 2, shadeClose: false, content: '上传中'});
        },
        done: function(e, data) {
            var data = data.result;
            if (data.code === 0) {
                var alias = '[file_image_' + data.data.path + ']';
                $('.message').val(alias);
                $(".row .send").click();
            } else {
                layer.open({content: data.msg, time: 2});
            }
            layer.close(window.imageUploading);
        },
        fail: function(e, data) {
            layer.close(window.imageUploading);
            layer.open({content: '上传失败，请重试！', time: 2});
        }
    });
    $('.sendimage').click(function() {
        $('.imageupload').click();
    });
});