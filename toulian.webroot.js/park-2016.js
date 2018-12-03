jQuery(function($) {
    function getMinUl() {//每次获取最短的ul,将图片放到其后
        var $arrUl = $("#container .col");
        var $minUl = $arrUl.eq(0);
        $arrUl.each(function(index, elem) {
            if ($(elem).height() < $minUl.height()) {
                $minUl = $(elem);
            }
        });
        return $minUl;
    }
    //无限加载
    /*
     $(window).on("scroll", function () {
     $minUl = getMinUl();
     if ($minUl.height() <= $(window).scrollTop() + $(window).height()) {
     //当最短的ul的高度比窗口滚出去的高度+浏览器高度大时加载新图片
     //loadMeinv();//加载新图片
     }
     });
     */

    //点击更多加载
    $("#loadMeinvMOre").click(function() {
        if (window.deptFilterLoading) {
            return;
        }
        window.deptFilterLoading = true;
        var pIndex = layer.load(0, {
            end: function(layero, index) {
                window.deptFilterLoading = false;
            }
        });
        var page = $(this).attr('data-page');
        var url = T.baseUrl + '/park/index';
        $.post(url, {page: page}, function(ret) {
            var data = ret.data;
            if (page >= data.pagination.pageCount) {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
                return;
            }
            if (data.datas) {
                for (var i = 0; i < data.datas.length; i++) {
                    $minUl = getMinUl();
                    var html = '<li><div class="water_pic"><a href="' + data.datas[i].Link + '"><img src="' + data.datas[i].Logo + '"></a></div><div class="water_user f14">' + data.datas[i].DeptName + '</div><div class="water_option">' + (data.datas[i].Introduction ? data.datas[i].Introduction : '') + '</div></li>';
                    $minUl.append(html);
                }
                $("#loadMeinvMOre").attr('data-page', parseInt(page) + 1);
                layer.close(pIndex);
                if (parseInt(page) === 0) {
                    $("#loadMeinvMOre").click();
                }
            } else {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
            }
        }, 'json');
    }).click();

});