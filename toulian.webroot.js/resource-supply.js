jQuery(function ($) {
    $("img.reslogo").lazyload({
        placeholder: T.imageUrl + '/shang/default.png',
        effect: "fadeIn",
        appear: function () {
        },
        load: function () {
            //$(this).zoomImgRollover();
            //$(this).parent().zoom();
        }
    });
    $('.search .submit').click(function () {
        var keyword = $(this).siblings('.shuru').val();
        location.href = T.searchUrl + '&keyword=' + keyword;
    });
    $('.mapFind-sort').click(function () {
        var flag = $('.mapFind-sort').attr('data-flag');
        if (flag == 1) {
            $('.mapFind-sort .hide1').slideDown();
            $('.mapFind-sort').attr('data-flag', 0);
        } else {
            $('.mapFind-sort .hide1').slideUp(300);
            $('.mapFind-sort').attr('data-flag', 1);
        }
    });
    $('.mapFind-sort .hide1 a').click(function () {
        $('.mapFind-sort .moren').text($(this).text());
        $(this).addClass('current1').siblings().removeClass('current1');
    });
});

