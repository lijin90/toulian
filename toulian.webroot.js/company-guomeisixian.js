/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $('.yeji_wid li:even').css({"background": "#ACB7C1"});
    $('.yeji_wid li:odd').css({"background": "#969FA8"});
    $('.yeji_wid li:last').css({"marginBottom": "0"});
    $('.bgtp1 li:last').css({"paddingRight": "0"});
//    固定钉部分
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 300) {
            $('.fixed').removeClass('hide');
        } else {
            $('.fixed').addClass('hide');
        }
    });
    $('.fixed').onePageNav({
        filter: ':not(.external)',
        scrollThreshold: 0.25
    });
//    鼠标滑过图片移动
    $('.icon .bg').mouseenter(function () {
        $(this).find('img').animate({"top": "-80px", "opacity": "0"}, 300,function(){
            $(this).css({"top": "80px"});
            $(this).animate({"top": "40px", "opacity": "1"},600);
        });
    });
});

