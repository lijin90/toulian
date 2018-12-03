$(function() {
    $('#search .ipt_r a').click(function() {
        var i = $('#search .ipt_r a').index(this);
        $('#search .ipt_r a').removeClass('slow');
        $('#search .ipt_r a').eq(i).addClass('slow');
    });
    $('#search .ipt .ipt1 a').click(function() {
        var keyword = $(this).siblings('.keyword').val();
        location.href = T.searchUrl + '&keyword=' + keyword;
    });

    flag = true;
    $('.city img').click(function() {
        if (flag) {
            $('.city .ct_switch').slideDown({
                duration: 500,
                easing: 'easeInQuad',
            });
            flag = false;
        } else {
            $('.city .ct_switch').slideUp({
                duration: 500,
                easing: 'easeInQuad',
            });
            flag = true;
        }
    });

    $('.ct_switch li a').click(function() {
        $(this).parent('li').css('background', '#EEEEEE').siblings().css('background', '');
        $('.city_select span').text($(this).text());
        $('.city_select span').attr('data-code', $(this).attr('data-code'));
        $('.city .ct_switch').hide();
        flag = true;
        $('#areaCode .pcas_tree_province a[data-address="' + $(this).attr('data-code') + '"]').click();
    });

    $(".lmaqiao1 img").lazyload({
        placeholder: T.imageUrl + '/shang/default.png',
        effect: "fadeIn",
        appear: function() {
        },
        load: function() {
            //$(this).zoomImgRollover();
            $(this).parent().zoom();
        }
    });
});