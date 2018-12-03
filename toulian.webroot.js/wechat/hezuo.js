/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    var mySwiper = new Swiper('.swiper-container1', {
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 55
    });
    var mySwiper = new Swiper('.swiper-container2', {
        autoplay: 3000,
        loop: true,
//        slidesPerView: 3,
        spaceBetween: 10
    });
});
