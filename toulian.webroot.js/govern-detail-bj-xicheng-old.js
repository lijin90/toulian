/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    jQuery(".slideBox").slide({mainCell: ".bd ul", autoPlay: true});
    var swiper = new Swiper('.swiper-container', {
        autoplay: 3000, //可选选项，自动滑动
        direction: 'vertical',
        loop: true,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        paginationBulletRender: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        }
    });
    function check(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    $('.swiper-pagination-bullet').each(function () {
        var h = $(this).html();
//        console.log(h);
        $(this).html(check(h));
    });
//    划过切换
    $('.htp1 .center .c_fl1 li').hover(function () {
        var i = $('.htp1 .center .c_fl1 li').index(this);
        $('.tihuan .tihuan1').removeClass('show');
        $('.tihuan .tihuan1').eq(i).addClass('show');
    });
    $('.htp1 .center .con:eq(2)').css({'border': "none"});
//    15个街道样式、
    $('.jiedao a:nth-child(8n)').css({"border-right": "none"});
    $('.jiedao a:gt(7)').css({"border-bottom": "none"});
});

