/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.onload = function () {
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
        mousewheelControl: true
    });
    $('.swiper-container').mouseover(function () {
        mySwiper.stopAutoplay();      
    });
    $('.swiper-container').mouseout(function () {
        mySwiper.startAutoplay();
    });
};
