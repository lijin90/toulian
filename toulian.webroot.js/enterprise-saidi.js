/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {
    $('#demo1').banqh({
        box: "#demo1", //总框架
        pic: "#ban_pic1", //大图框架
        pnum: "#ban_num1", //小图框架
        prev_btn: "#prev_btn1", //小图左箭头
        next_btn: "#next_btn1", //小图右箭头
        pop_prev: "#prev2", //弹出框左箭头
        pop_next: "#next2", //弹出框右箭头
        prev: "#prev1", //大图左箭头
        next: "#next1", //大图右箭头
        pop_div: "#demo2", //弹出框框架
        pop_pic: "#ban_pic2", //弹出框图片框架
        pop_xx: ".pop_up_xx", //关闭弹出框按钮
        mhc: ".mhc", //朦灰层
        autoplay: true, //是否自动播放
        interTime: 5000, //图片自动切换间隔
        delayTime: 400, //切换一张图片时间
        pop_delayTime: 400, //弹出框切换一张图片时间
        order: 0, //当前显示的图片（从0开始）
        picdire: true, //大图滚动方向（true为水平方向滚动）
        mindire: true, //小图滚动方向（true为水平方向滚动）
        min_picnum: 3, //小图显示数量
        pop_up: true//大图是否有弹出框
    })
});
