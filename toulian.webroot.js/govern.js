/**
 * Created by Administrator on 2016/1/18.
 */
$(function () {
//    图片滑过出现边框、、、、、、、、、、、、、、、、
    $('.core2_tp li').hover(function () {
        var i = $('.core2_tp li').index(this);
        $('.core2_tp li').eq(i).addClass('bor').siblings().removeClass('bor');
    });
//    下方字体鼠标滑过效果
    $('.core2_js li a').hover(function () {
        $('.core2_js li a').removeClass('current');
        $(this).addClass('current');
    });

//        tab切换部分、、、、、、、、、、、、、、
    $('.core2_con ul li').click(function () {
        var i = $('.core2_con ul li').index(this);
        $('#core2 .core2_con li').eq(i).addClass('show').siblings().removeClass('show');
        $('.core2_tp ul').eq(i).addClass('show1').siblings().removeClass('show1');
        $('.core2_js div.di').eq(i).addClass('show2').siblings().removeClass('show2');
    });
//    鼠标上去图片变化大小
    $(".core2_tp img").zoomImgRollover();
//      li左侧与下边的边框去掉
//    $('.core2_js ul li').css({"border-left": "1px solid #ccc", "border-top": "1px solid #ccc"});
//    $('.core2_js ul:eq(0) li:eq(3),.core2_js ul li:eq(7),.core2_js ul li:eq(11),.core2_js ul li:eq(15),.core2_js ul li:eq(16)').css({"border-right": "1px solid #ccc"});
//    $('.core2_js ul:eq(0) li:gt(12)').css({"border-bottom": "1px solid #ccc"});
//    $('.core2_js ul:eq(1) li:eq(3),.core2_js ul:eq(1) li:eq(7),.core2_js ul:eq(1) li:eq(11),.core2_js ul:eq(1) li:eq(15),.core2_js ul:eq(1) li:eq(19),.core2_js ul:eq(1) li:eq(23)').css({"border-right": "1px solid #ccc"});
//    $('.core2_js ul:eq(1) li:gt(19)').css({"border-bottom": "1px solid #ccc"});
//    $('.core2_js ul:eq(2) li:eq(3),.core2_js ul:eq(2) li:eq(7),.core2_js ul:eq(2) li:eq(10)').css({"border-right": "1px solid #ccc"});
//    $('.core2_js ul:eq(2) li:gt(6)').css({"border-bottom": "1px solid #ccc"});
//          判断浏览器使用css样式部分
//    if (window.navigator.userAgent.indexOf("MSIE") >= 1)
//    {
////如果浏览器为IE
//        setActiveStyleSheet("zhengfu1.css");
//    }
//    if (window.navigator.userAgent.indexOf("Chrome") >= 1) {
//        //如果浏览器为谷歌
//        setActiveStyleSheet("zhengfu.css");
//    } else {
//        if (window.navigator.userAgent.indexOf("Firefox") >= 1)
//        {
////如果浏览器为Firefox
//            setActiveStyleSheet("zhengfu.css");
//        } else {
////如果浏览器为其他
//            setActiveStyleSheet("zhengfu1.css");
//        }
//    }
//
//    function setActiveStyleSheet(title) {
//        document.getElementsByTagName("link")[2].href = "../css/" + title;
//    }
//点击其他时中间图片图没有
    $('.core2_con .qita').click(function(){
           $('.core2_tp ul:last').hide();
    });
});

