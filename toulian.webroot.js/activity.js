/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $('#xiang .fen li').hover(function () {
        var i = $('#xiang .fen li').index(this);
        $('#xiang .fen li').eq(i).addClass('select').siblings().removeClass('select');
    });
});


