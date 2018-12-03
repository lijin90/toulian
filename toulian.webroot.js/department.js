/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    //    商业协会增加左边图片
    if ($('#content .swiper-slide').length === 0) {
        $('.lun_logo').removeClass('ml30').addClass('fl');
        $('.lun0').css('width', '100%');
        $('.lun_logo1').css({"float": "left", "height": "auto"});
        $('.lun_logo1 li').css({'float': 'left', "width": "400px", "overflow": "hidden", "white-space": "nowrap", "text-overflow": "ellipsis"});
        $('.lun_logo1 ul').css({'width': "800px", "height": "150px"});
    }
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next'
    });

//    划过时改变背景颜色。。。。。。。。。。。。。。。。。。。。。。。

    $('#more .more1 a').click(function () {
        $('#more .hide').show();
        $('#more .more1').hide();
    });
    $('#more .shouqi a').click(function () {
        $('#more .hide').hide();
        $('#more .more1').show();
    });
//    导航位置fixexd,背景改变
    if ($('.tab_nva').length === 1) {
        $('.tab_nva a').click(function () {
            if ($('.tab_nva a').hasClass('tab_sc1')) {
                $('.tab_nva a').removeClass("tab_sc1");
            }
            $(this).addClass("tab_sc1");
        });
        var sections = $(".tab_1");
        sections.waypoint({
            handler: function (event, direction) {
                var active_section;
                active_section = $(this);
                if (direction === "up")
                    active_section = active_section.prev();
                var active_link = $('.tab_nva a.' + $(active_section[0].element).attr("id"));
                active_link.addClass("tab_sc1").siblings().removeClass("tab_sc1");
                if ($(active_section[0].element).attr("id") === null) {
                    $('.tab_nva a[id="#specification0"]').addClass("tab_sc1");
                }
            },
            offset: '25%'
        });
        $('.tab_nva').posfixed({
            distance: 0,
            pos: 'top',
            type: 'while',
            hide: false
        });
    } else {
        return false;
    }
//    判断lvshi的长度为1时去掉查看更多
    if ($('.lvshi').length === 1) {
        $('.lvshi .more1').hide();
    }

    if ($('#div1 img').length > 4) {
        var oOut = document.getElementById("out");
        var oDiv1 = document.getElementById("div1");
        var oDiv2 = document.getElementById("div2");
        var aImg = oOut.getElementsByTagName("img");
        var timer = null;

        oDiv2.innerHTML = oDiv1.innerHTML; // 复制div1内容赋值给div2

        function clear() { // 清除所有计时器
            clearInterval(timer);
        }

        function moveleft() { // 图片向左滚动函数
            oOut.scrollLeft++;
            // 判断整个循环临界值及处理方式
            if (oOut.scrollLeft >= oDiv1.offsetWidth) {
                oOut.scrollLeft = 0;
            }
            //判断单张图片临界值及处理方式
            if (oOut.scrollLeft % (aImg[0].offsetWidth + 34) == 0) {
                clearInterval(timer);
                timer2 = setTimeout(function () {
                    timer = setInterval(moveleft, 20);
                }, 1000);
            }
            ;
        }
        timer = setInterval(moveleft, 20);//进入页面执行
        //以下为添加鼠标事件
        oOut.onmouseover = function () {
            clear();
        };
        oOut.onmouseout = function () {
            timer = setInterval(moveleft, 20);
        };
    }
});



