jQuery(function($) {
    // 点击条件选项切换
    $('.select .bg1').click(function() {
        var flag = $(this).attr('data-flag');
        var i = $('.select .bg1').index(this);
        $('.select .bg1').find('img').attr('src', $('.select .bg1').find('img').attr('data-src'));
        $('.select .slide').eq(i).slideToggle().siblings('.slide').slideUp();
        var h = $(document.body).outerHeight(true);
        $('.mask').height(h);
        if (flag == 1) {
            $('.mask').stop().show();
            $(this).css({"color": "#0EA7E3"}).siblings().css({"color": ""});
            $(this).find('img').attr('src', $(this).find('img').attr('data-click'));
            $('.select .bg1').attr('data-flag', 1);
            $(this).attr('data-flag', 0);
            if ($('.select .bg1').index(this) === 0) { //所在区域
                $('.diqu li.current a').click();
            }
        } else {
            $('.mask').stop().hide();
            $('.select .bg1').css({"color": ""});
            $(this).find('img').attr('src', $(this).find('img').attr('data-src'));
            $(this).attr('data-flag', 1);
        }
    });
    // 城市切换
    $('.diqu a').click(function() {
        $(this).parent('li').addClass('current').siblings().removeClass('current');
        var ind = $(this).parent('li').index();
        if (ind > 0) {
            $('.diqu_detail').eq(ind - 1).addClass('show').siblings().removeClass('show');
        }
    });

//    $('.more .btn').click(function() {
//        if (window.dataLoading) {
//            return;
//        }
//        window.dataLoading = true;
//        var pIndex = layer.open({
//            type: 2,
//            shade: false,
//            end: function(layero, index) {
//                window.dataLoading = false;
//            }
//        });
//        var url = T.url;
//        window.dataPage = window.dataPage >= 0 ? window.dataPage + 1 : 0;
//        $.post(url, {page: window.dataPage}, function(ret) {
//            var data = ret.data;
//            if (window.dataPage >= data.pagination.pageCount) {
//                window.dataPage--;
//                if ($('.container .load').length === 0) {
//                    layer.close(pIndex);
//                    layer.open({content: '暂无信息', style: 'background-color:#d9534f; color:#fff; border:none;', time: 2});
//                } else {
//                    layer.close(pIndex);
//                    layer.open({content: '没有更多数据', style: 'background-color:#d9534f; color:#fff; border:none;', time: 2});
//                }
//                return;
//            }
//            if (data.html) {
//                $('.load').append(data.html);
//                layer.close(pIndex);
//            } else {
//                layer.close(pIndex);
//                layer.open({content: '没有更多数据', style: 'background-color:#d9534f; color:#fff; border:none;', time: 2});
//            }
//        }, 'json');
//    });
});

