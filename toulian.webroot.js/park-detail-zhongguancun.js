/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {

//    鼠标滑过红旗改变字体颜色红旗颜色
    $('.small1 li').hover(function () {
        $('.small1 li').removeClass('active');
        $(this).addClass('active');
        $('.small1 li').find('img').attr('src', '../images/park/hongqi1.png');
        $(this).find('img').attr('src', '../images/park/hongqi.png');
    });
    $('.small2 li').hover(function () {
        $('.small2 li').removeClass('active1');
        $(this).addClass('active1');
        $('.small2 li').find('img').attr('src', '../images/park/hongqi1.png');
        $(this).find('img').attr('src', '../images/park/hongqi2.png');
    });
//    推荐资源部分
    $('.ziyuan li').hover(function () {
        $(this).find('span').css({"display": "inline-block"});
        $(this).find('span').stop().animate({height: '30px'}, 500);
    }, function () {
        $(this).find('span').stop().animate({height: '0px'}, 500, function () {
            $(this).find('span').css("display", "none");
        });
    });
//   轮播图
    /*demo4  这种效果只是测试，没有集成到插件中*/
    $content = $('#demo_4 .content');
    $('#demo_4 .tab li.normal').mouseover(function () {
        var self = this;
        var top = $(this).index() * ($(this).height() + 5);
        var current = $(this).index();
        $('#demo_4 .tab .on').removeClass('on');
        $(self).addClass('on');
        $content.find('li.on').removeClass('on');
        var e2 = $content;
        height = e2.find('li').height();//若给img外面的li设上了高，则可以删去此行
        e2.stop().animate({top: -current * (height)}, {duration: "slow"});
    });
    $('.environment li').mouseenter(function () {
        var i=$('.environment li').index(this);
        $('.con_1 .dl').removeClass('show');
        $('.con_1 .dl').eq(i).addClass('show');
        var Plft = $(this).position().left;
        var Plft1 = $(this).position().left + 50;
        $('.environment li').removeClass('current');
        $(this).addClass('current');
        $('.curBg1').stop(true).animate({"left": Plft}, 300);
        $('.curBg').stop(true).animate({"left": Plft1}, 300);
         $('.curBg').text($(this).index() + 1);
    });
//    图片等比列缩放
//    $('#demo_4 .content').autoIMG();
//    var w = $('#demo_4 .content').width();
//    console.log(w);
//    $('#demo_4 .content img').each(function () {
//        var img_w = $(this).width();//图片宽度
//        var img_h = $(this).height();//图片高度
//        console.log(img_w)
//        console.log(img_h)
//        if(img_w>w){
//             var height = (w*img_h)/img_w; //高度等比缩放
//             $(this).css({"width":w,"height":height});
//        }
//    });
});

