jQuery(function ($) {
    new WOW().init();
    if ($('#carousel-example-generic .carousel-indicators li').length < 5) {
        $('#carousel-example-generic .carousel-indicators').css({"left": '47%'});
    }
//    window.setTimeout(function () {
//        $('.carousel').carousel({
//            interval: 5000
//        });
//        $('.carousel-indicators').show();
//    }, 5000);
    //小图轮播
    var imgW = $('.con a').width();
    var x = 1;
    var anm = true;
    var n = 0;
    var timer1 = null;

    $('#out').scrollLeft(imgW);//初始位置

    //第五步：复制插入节点
    var fir = $('.con a:first').clone();
    var las = $('.con a:last').clone();
    $('.con').append(fir);
    $('.con').prepend(las);

    //第一步：点击左
    $('.news1 .left').click(function () {
        clearInterval(timer1);
        if (anm) {
            anm = false;
            x--;
            if (x < 0) {
                x = $('.con a').length - 3;
                $('#out').scrollLeft(imgW * (x + 1));
            }
            ;
            n--;
            if (n < 0) {
                n = $('.nav li').length - 1;
            }
            ;
            move();
        }
        ;
        autoMove();
    });

    //第二步：点击右
    $(' .news1  .right').click(function () {
        clearInterval(timer1);
        if (anm) {
            anm = false;
            x++;
            if (x >= $('.con a').length) {
                x = 2;
                $('#out').scrollLeft(imgW);
            }
            ;
            n++;
            if (n >= $('.nav li').length) {
                n = 0;
            }
            ;
            move();
        }
        ;
        autoMove();
    });

    //第三步：点击数字
    $('.nav li').click(function () {
        clearInterval(timer1);
        n = $('.nav li').index(this);
        x = n + 1;
        move();
        autoMove();
    });

    //第四步：自动走
    function autoMove() {
        timer1 = setInterval(function () {
            x++;
            if (x >= $('.con a').length) {
                x = 2;
                $('#out').scrollLeft(imgW);
            }
            ;
            n++;
            if (n >= $('.nav li').length) {
                n = 0;
            }
            ;
            move();
        }, 5000)
    }

    autoMove();//进入页面执行

    //第六步：提取公用部分
    function move() {
        $('.nav li').eq(n).addClass('select').siblings().removeClass('select');
        $('.btm a').eq(n).addClass('current').siblings().removeClass('current');
        $('#out').stop().animate({scrollLeft: imgW * x}, function () {
            anm = true;
        });
    }
//    轮播图删除最后一个
//    $('.carousel-indicators li:last').remove();
//    $('.carousel-inner .item:last').remove();
    $('#search .c_daohang a').click(function () {
        $(this).addClass('sch_nva').parent('li').siblings('li').children('a').removeClass('sch_nva');
        var lefts = ['46px', '150px', '254px', '350px', '430px'];
        $('#content .ipt_jian').animate({left: lefts[$(this).parent('li').index()]}, 300);
    });
    $('#search .search').click(function () {
        var resCategory = $('#search .c_daohang a.sch_nva').attr('data-rescategory');
        var keyword = $('#search .keyword').val();
        if (resCategory === 'all') {
            location.href = 'http://search.toulianwang.com/cse/search?s=12412628924461048038&q=' + keyword;
            return;
        }
        location.href = T.baseUrl + '/resource/supply.html?resCategory=' + resCategory + '&keyword=' + keyword;
    });
    $('#property .pc_0').hover(function () {
        var i = $('#property .pc_0').index(this);
        $('#property .pc_0').eq(i).addClass('show show1').siblings().removeClass('show show1');
        $('#property .m0').removeClass('morecolor');
        $('#property .m0').eq(i).addClass('morecolor');
//        $('#property .pc_0').eq(i).animate({left:'20px',top:"20"},1000);
    });

    $('.bj1').hover(function () {
        var i = $('.bj1').index(this);
        $('.bj1').eq(i).css({'background': '#ccc'});
        $('.bj').eq(i).show();
    },
            function () {
                var i = $('.bj1').index(this);
                $('.bj1').eq(i).css({'background': ''});
                $('.bj').eq(i).hide();
            }
    );
//    var arr = [T.imageUrl + '/one/tt3.png', T.imageUrl + '/one/tt4.png', T.imageUrl + '/one/tt6.png', T.imageUrl + '/one/tt5.png', T.imageUrl + '/one/tt8.png', T.imageUrl + '/one/tt7.png', T.imageUrl + '/one/tt2.png'];
//    var arr1 = [T.imageUrl + '/one/t3.png', T.imageUrl + '/one/t4.png', T.imageUrl + '/one/t6.png', T.imageUrl + '/one/t5.png', T.imageUrl + '/one/t8.png', T.imageUrl + '/one/t7.png', T.imageUrl + '/one/t2.png', ]
//    var arr2 = [T.imageUrl + '/one/t1.png'];
//    var arr3 = [T.imageUrl + '/one/tt1.png'];
//    $('#service .s_nav li:gt(0)').hover(function () {
//        var i = $('#service .s_nav li:gt(0)').index(this);
//        $('#service .s_nav li img:gt(0)').eq(i).attr('src', arr[i]);
//        $('#service .s_nav li img').eq(0).attr('src', arr2[0]);
//    },
//            function () {
//                var i = $('#service .s_nav li:gt(0)').index(this);
//                $('#service .s_nav li img:gt(0)').eq(i).attr('src', arr1[i]);
//                $('#service .s_nav li img').eq(0).attr('src', arr3[0]);
//
//            }
//    );

//    $('#service .s_nav li:gt(0)').hover(function () {
//        var i = $('#service .s_nav li:gt(0)').index(this);
//        $('#service .s_nav li p a:gt(0)').eq(i).addClass('tlf').siblings().removeClass('tlf');
//        $('#service .s_nav li p a').eq(0).removeClass('tlf');
//    },
//            function () {
//                var i = $('#service .s_nav li:gt(0)').index(this);
//                $('#service .s_nav li p a:gt(0)').eq(i).removeClass('tlf');
//                $('#service .s_nav li p a').eq(0).addClass('tlf');
//            }
//    );
    $('#service .s_nav li').hover(function () {
        $(this).find('p a').css({"color": "#0EA8E3"});
    }, function () {
        $(this).find('p a').css({"color": ""});
    });
    var timer = null;

    // 回到顶部
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 400 && screen && screen.width > 1024) {
            $('.mup').show();
        } else {
            $('.mup').hide();
        }
    });
    $('.mup').click(function () {
        timer = setInterval(function () {
            var stop = document.documentElement.scrollTop || document.body.scrollTop;
            var speed = Math.floor(-stop / 3);
            document.documentElement.scrollTop = document.body.scrollTop = stop + speed;
            otstop = true;
            if (stop == 0) {
                clearInterval(timer);
            }
        }, 50);
    });
    // 添加部分鼠标移动效果
    $('#add .new_rong li').hover(function () {
        $(this).addClass('bgcl1').siblings().removeClass('bgcl1');
    }, function () {
        $(this).removeClass('bgcl1');
    });
    $('#add .ner_rong1 li').hover(function () {
        $(this).addClass('bgcl2').siblings().removeClass('bgcl2');
    }, function () {
        $(this).removeClass('bgcl2');
    });
//    滚轮滚动更随效果
//    window.onscroll = function () {
//        var val = document.documentElement.scrollTop || window.pageYOffset;
//        document.getElementById('side').style.top = val + 300 + 'px';
//    };
//    右侧漂浮点击关闭
    var Top = ($(window).height() - $('#side').height()) / 2;
    if (screen && screen.width > 1024) {
        $('#side').show();
        $('#side').css({"top": Top});
        $('#side .degree i').click(function () {
            $(this).parent().parent().hide();
            $(this).parent().parent().next().hide();
        });
    }
    // li改变图片
    $('.hot_nei .fir li:gt(0),.hot_nei .fir2 li:gt(0)').css({"padding-left": "20px"});
    $('.hot_nei .fir li:first,.hot_nei .fir li:last,.hot_nei .fir2 li:first,.hot_nei .fir2 li:last').css({"width": "130px"});
    $('.hot_nei .fir li:last,.hot_nei .fir2 li:last').css({"border-right": "none"});
    $('.hot_nei .fir2 ').css({"border-top": "none"});
    // 鼠标以上图片向左移动
    $('.hot_nei ul li').hover(function () {
        $(this).find('img').stop().animate({top: '-5px'}, 300);
        $(this).find('a').css({"color": "#F7621F"});
    },
            function () {
                $(this).find('img').stop().animate({top: '0px'}, 300);
                $(this).find('a').css({"color": ""});
            }
    );
    // 地图部分
//    var main1 = echarts.init(document.getElementById('main'));
//    option = {
//        tooltip: {
//            trigger: 'item',
//            formatter: '{b}，点击切换'
//        },
//        series: [
//            {
//                name: '中国',
//                type: 'map',
//                mapType: 'china',
//                zoom: 1.5,
//                label: {
//                    normal: {
//                        show: true
//                    },
//                    emphasis: {
//                        show: true
//                    }
//                },
//                itemStyle: {
//                    normal: {
//                        areaColor: '#eee'
//                    },
//                    emphasis: {
//                        areaColor: '#0EA8E3'
//                    }
//                },
//                data: [
//                    {name: '北京', value: '110000', selected: true},
//                    {name: '上海', value: '310000', selected: true}
//                ]
//            }
//        ]
//    };
//    main1.setOption(option);
//    main1.on('click', function (params) {
//        if (!params.data.value) {
//            layer.alert(params.data.name + '数据正在建设中，如有商务合作请拨打电话：010-61820546（座机），13911600017（手机）', {
//                icon: 5,
//                skin: 'layui-layer-demo', //样式类名
//            });
//            return;
//        }
//        $.cookie('areaCode', params.data.value, {expires: null, path: '/'});
//        location.href = T.homeUrl;
//    });
    // 轮播图
    var swiper = new Swiper('.swiper-container1', {
        autoplay: 3000, //可选选项，自动滑动
        loop: true,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });
//    var swiper = new Swiper('.swiper-container2', {
//        autoplay: 3000, //可选选项，自动滑动
//        loop: true,
//        pagination: '.swiper-pagination',
//        paginationClickable: true,
//        direction: 'vertical'
//    });
    var swiper = new Swiper('.swiper-container4', {
        autoplay: 3000, //可选选项，自动滑动
        loop: true,
        direction: 'vertical',
        speed: 3000
    });
    $(".swiper-container4").mouseenter(function () {//滑过悬停
        swiper.stopAutoplay();//mySwiper 为上面你swiper实例化的名称
    }).mouseleave(function () {//离开开启
        swiper.startAutoplay();
    });
//    政府招商部分查看更多
    $(".zh_more").hover(function () {
        $(this).stop().animate({"text-indent": "20px"});
    }, function () {
        $(this).stop().animate({"text-indent": "34px"});
    });
//点击招商秘书台
    $("#main").click(function () {
        layer.open({
            type: 1,
            closeBtn: 1,
            title: false,
            shift: 1,
            time: 3000,
            area: ['540px', '450px'],
            skin: 'layui-layer-nobg', //没有背景色
//            shade: 0, //不显示遮罩
            shadeClose: true,
            content: '<img src = "' + T.imageUrl + '/one/building.png' + '" alt=""/> '
        });
    });

});