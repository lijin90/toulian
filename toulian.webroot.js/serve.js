/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    var arr = [T.imageUrl + '/serve/t1.png', T.imageUrl + '/serve/t3.png', T.imageUrl + '/serve/t4.png', T.imageUrl + '/serve/t6.png',
        T.imageUrl + '/serve/t5.png', T.imageUrl + '/serve/t8.png', T.imageUrl + '/serve/t7.png', T.imageUrl + '/serve/t2.png'];
    var arr1 = [T.imageUrl + '/serve/tt1.png', T.imageUrl + '/serve/tt3.png', T.imageUrl + '/serve/tt4.png', T.imageUrl + '/serve/tt6.png',
        T.imageUrl + '/serve/tt5.png', T.imageUrl + '/serve/tt8.png',T.imageUrl + '/serve/tt7.png',T.imageUrl + '/serve/tt2.png'];
    $('#service .tp_nva li').click(function () {
        for (i = 0; i < arr1.length; i++) {
            $('#service .tp_nva li a img').eq(i).attr('src', arr[i]);
            $('#service .tp_nva li a').eq(i).removeClass('current');
        }
        var i = $('#service .tp_nva li').index(this);
        $('#service .tp_nva li a img').eq(i).attr('src', arr1[i]);
        $('#service .tp_nva li a').eq(i).addClass('current').siblings().removeClass('current');
    });



//    $('#service .tp_nva li').hover(function () {
//        for (i = 0; i < arr1.length; i++) {
//            $('#service .tp_nva li img').eq(i).attr('src', arr[i]);
//        }
//        var i = $('#service .tp_nva li').index(this);
//        $('#service .tp_nva li img').eq(i).attr('src', arr1[i]);
//    }
//    ,
//            function () {
//                var i = $('#service .tp_nva li').index(this);
//                $('#service .tp_nva li img').eq(i).attr('src', arr1[i]);
//            }
//
//    );  
//    $('#service .tp_nva li').hover(function () {
//        for (i = 0; i < arr1.length; i++) {
//            $('#service .tp_nva li p a').eq(i).removeClass('current');
//        }
//        var i = $('#service .tp_nva li').index(this);
//        $('#service .tp_nva li p a').eq(i).addClass('current').siblings().removeClass('current');  
//    });

//    图片内容切换
    $('#service .tp_nva li').click(function () {
        var i = $('#service .tp_nva li').index(this);
        $('.con .con1').eq(i).addClass('show').siblings().removeClass('show');
    });
//    内容部分滑过切换颜色效果
        $('.con .con2 li').hover(function () {
            var i = $('.con .con2 li').index(this);
            $('.con .con2 li').eq(i).find('span').addClass('present');
            $('.con .con2 li').eq(i).find('a').addClass('current');
            $(this).siblings('li').find('span').removeClass('present');
            $(this).siblings('li').find('a').removeClass('current');
        },
                function () {
                    var i = $('.con .con2 li').index(this);
                    $('.con .con2 li').eq(i).find('span').removeClass('present');
                    $('.con .con2 li').eq(i).find('a').removeClass('current');
                }
        );
//        去掉最右边线
    
});
