/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $('#content .c_daohang a').click(function () {
        $(this).addClass('sch_nva').parent('li').siblings('li').children('a').removeClass('sch_nva');
        var lefts = ['48px', '151px', '248px', '330px'];
        $('#content .ipt_jian').animate({left: lefts[$(this).parent('li').index()]}, 300);
    });
    $('#content .search').click(function () {
        var resCategory = $('#content .c_daohang a.sch_nva').attr('data-rescategory');
        var keyword = $('#content .keyword').val();
        location.href = T.baseUrl + '/resource/supply.html?resCategory=' + resCategory + '&keyword=' + keyword;
    });

    $('.xiangqing li').hover(function () {
        $(this).addClass('hvrbg').siblings().removeClass('hvrbg');
    });

    $('.neirong .up').click(function () {
        var slt = $(this).parent().siblings('.slt');
        if (slt.is(':hidden')) {
            $(this).attr('src', T.imageUrl + '/biaodantudi/down.png');
            slt.show();
        } else {
            $(this).attr('src', T.imageUrl + '/biaodantudi/up.png');
            slt.hide();
        }
    });
});

