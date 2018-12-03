jQuery(function($) {
    // 点击头部导航城市切换按钮
    $('.navbar .city').click(function() {
        var flag = $(this).attr("data-flag");
        var h = $(document.body).outerHeight(true);
        $('.mask').height(h);
        if ($('.navbar-collapse.in')) {
            $('.navbar-collapse').removeClass('in');
        }
        if (flag == 1) {
            $('.mask').attr('data-flag', 1);
            $('.mask').show();
            $(this).css({"background": "url(" + T.imageUrl + "/wechat/homepage/icon_top.png) 92% center no-repeat", "background-size": "22%"});
            $('.navbar .city_list').stop().slideDown();
            $(this).attr("data-flag", 0);
        } else {
            $('.mask').hide();
            $(this).css({"background": "url(" + T.imageUrl + "/wechat/homepage/icon_down.png) 92% center no-repeat", "background-size": "22%"});
            $('.navbar .city_list').stop().slideUp();
            $(this).attr("data-flag", 1);
        }
    });
    $('.navbar .city_list a').click(function() {
        var code = $(this).attr('data-code');
        if (!T.areaCodes.hasOwnProperty(code)) {
            layer.open({
                content: $(this).text() + '数据正在建设中，如有商务合作请拨打电话：010-61820546（座机），13911600017（手机）',
                style: 'background-color: #5cb85c;color: #fff;',
                time: 2
            });
            return;
        }
        $('.navbar .city').text($(this).text());
        $('.navbar .city').attr('data-code', code);
        $('.navbar .city_list a').removeClass('current');
        $(this).addClass('current');
        $.cookie('areaCode', code, {expires: null, path: '/'});
        window.location.reload(true);
    });
    $(".navbar-toggle").click(function() {
        var h = $(document.body).outerHeight(true);
        $('.mask').height(h);
        var flag = $('.mask').attr("data-flag");
        if (flag == 1) {
            $('.mask').stop().show();
            $('.mask').attr("data-flag", 0);
        } else {
            $('.mask').stop().hide();
            $('.mask').attr("data-flag", 1);
        }
        if ($('.navbar .city').attr("data-flag", 1)) {
            $('.navbar .city').css({"background": "url(" + T.imageUrl + "/wechat/homepage/icon_down.png) 92% center no-repeat", "background-size": "22%"});
            $('.navbar .city_list').stop().slideUp();
        }
    });
});
function imageResizeLoad() {
    $('img.resizeLoad').each(function() {
        var self = this;
        $(self).removeClass('resizeLoad');
        var path = $(self).attr('data-src');
        if (!path) {
            return;
        }
        var width = $(self).width();
        var height = $(self).height();
        $.post(T.baseUrl + '/file/resizeImage.html', {path: path, width: width, height: height}, function(url) {
            if (url) {
                $(self).attr('src', url);
            }
        }, 'text');
    });
}