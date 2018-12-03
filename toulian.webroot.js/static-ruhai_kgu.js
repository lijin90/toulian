      /* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: 3000,
        autoplayDisableOnInteraction: false,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
        mousewheelControl: true
    });
    $('.ruhai_kgu .tc .arrow').click(function () {
        var flag = $(this).attr("data-flag");
        if (flag == 1) {
            $(this).attr("src", '../images/ruhai_kgu/up.png');
            $(this).parent().siblings('.hide').slideDown(1000);
            $(this).attr('data-flag', 0);
        } else {
            $(this).attr("src", '../images/ruhai_kgu/down.png');
            $(this).parent().siblings('.hide').slideUp(1000);
            $(this).attr('data-flag', 1);
        }
    });
//    楼层判断
    var oNav = $('#elevator');//导航壳
    var aNav = oNav.find('li');//导航
    var aDiv = $('#content .company');//楼层
    var Top=($(window).height()-$("#elevator").height())/2;
    //回到顶部
    $(window).scroll(function () {
        var winH = $(window).height();//可视窗口高度
        var iTop = $(window).scrollTop();//鼠标滚动的距离
        if (iTop >= $('#head').height()) {
            oNav.fadeIn();
            $("#elevator").css({"top":Top});
        } else {
            oNav.fadeOut();
        }
    });
    //点击top回到顶部
    $('#elevator .top').click(function () {
        $('body,html').animate({"scrollTop": 0}, 500);
    });
    //点击回到当前楼层
//    aNav.click(function () {
//        var t = aDiv.eq($(this).index()).offset().top;
//        $('body,html').animate({"scrollTop": t}, 500);
//        $(this).addClass('active').siblings().removeClass('current');
//    });
    $('#elevator').onePageNav({
        currentClass: 'current',
        changeHash: false,
        scrollSpeed: 750,
        scrollThreshold: 0.5,
        filter: '',
        easing: 'swing'
    });
    ;
});
