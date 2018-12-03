/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    //    页面出现效果加载
    new WOW().init();
//    点击向上部分
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 400) {
            $('.top').show();
            $('.renovate').show();
        } else {
            $('.top').hide();
            $('.renovate').hide();
        }
    });
    $('.top').click(function () {
        timer = setInterval(function () {
            var stop = document.documentElement.scrollTop || document.body.scrollTop;
            var speed = Math.floor(-stop / 3);
            document.documentElement.scrollTop = document.body.scrollTop = stop + speed;
            otstop = true;
            if (stop == 0) {
                clearInterval(timer);
            }
        }, 50);
    });

    var swiper3 = new Swiper('.swiper-container3', {
        pagination: '.swiper-pagination',
        autoplay: 3000,
        loop: true
    });
    var swiper1 = new Swiper('.swiper-container1', {
        pagination: '.swiper-pagination',
        autoplay: 3000,
        loop: true
    });
    var swiper2 = new Swiper('.swiper-container2', {
        pagination: '.swiper-pagination',
        loop: true
    });
//点击刷新页面
    $('.renovate').click(function () {
        window.location.reload(true);
    });
});

