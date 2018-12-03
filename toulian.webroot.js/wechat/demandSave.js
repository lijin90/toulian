jQuery(function($) {
    $('.select_area').click(function() {
        var flag = $(this).attr('data-flag');
        var h = $(document.body).outerHeight(true);
        $('.mask').height(h);
        if (flag == 1) {
            $('.mask').stop().show();
            $(this).find('span').html('&#8744;');
            $(this).attr('data-flag', 0);
            $('.city_select').slideDown();
        } else {
            $('.mask').stop().hide();
            $(this).find('span').html('&#62;');
            $(this).attr('data-flag', 1);
            $('.city_select').slideUp();
        }
    });
    $('.city_select .city_close').click(function() {
        $('.select_area').click();
    });
    $('.diqu a').click(function() {
        $(this).parent('li').addClass('current').siblings().removeClass('current');
        var ind = $(this).parent('li').index();
        if (ind > 0) {
            $('.diqu_detail').eq(ind - 1).addClass('show').siblings().removeClass('show');
        }
    });
    $('.diqu_detail a').click(function() {
        var code = $(this).attr('data-address');
        $('input[name=AreaCode]').val(code);
        $('span.AreaName').text($.pcasAddress(code));
        $('.select_area').click();
    });
});