/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {
//    页面出现效果加载
    new WOW().init();
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
        pagination: '.swiper-pagination',
        paginationClickable: true,
        mousewheelControl: true
    });
    //鼠标划过图片出现蒙版层
    $('.module_img').sliphover({
        backgroundColor: 'rgba(243,125,42,0.8)'
    });
//    写字楼部分切换效果
    $('.module_title li').click(function () {
        var i = $('.module_title li').index(this);
        $('.module_title li').removeClass('module_current');
        $(this).addClass('module_current');
        $('.module_img .switch').eq(i).addClass('show').siblings('.switch').removeClass('show');
    });
//        投资服务项目
    $('.right_bottom_con a').mouseenter(function () {
        $(this).find('img').stop(true).animate({"top": "-40px", "opacity": "0"}, 300, function () {
            $(this).css({"top": "40px"});
            $(this).stop(true).animate({"top": "0px", "opacity": "1"}, 300);
        });
    });
//    政府招商
    $('.bus_center li a img').hover(function () {
        $(this).stop(true).animate({"marginRight": "35px"}, 300);
    }, function () {
        $(this).stop(true).animate({"marginRight": "0px"}, 300);
    }
    );
    $('.company_team a').bumpyText();
//    企业园区招商切换
    $('.bus_left .btm a').click(function () {
        var i = $('.bus_left .btm a').index(this);
        $('.bus_left .btm a').removeClass('current');
        $(this).addClass('current');
        $('.bus_left ul').eq(i).addClass('show').siblings('ul').removeClass('show');
    });
//    帮我选址部分
    $('input[name="submit"]').click(function () {
        var data = {};

        data.select = $('select option:checked').val();
        data.phone = $('input[name="phone"]').val();
        var reg = /(1[3-9]\d{9}$)/;
        if (!reg.test(data.phone)) {
            alert("手机号码不正确");
            return;
        }
        console.log(data);
        $.ajax({
            url: T.url,
            type: "post",
            dataType: "json",
            data: data,
            success: function (ret) {
                if (ret.code === 0) {
                    layer.msg('提交成功', {
                        icon: 1,
                        time: 1500,
                        end: function () {
                            location.href = T.baseUrl + '/site/new.html';
                        }
                    });
                } else {
                    layer.msg(ret.msg, {icon: 0});
                }
            }
        });
    });

});

