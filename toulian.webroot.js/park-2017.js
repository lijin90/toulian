jQuery(function($) {
//    new Swiper('.swiper-container', {
//        //autoplay: 5,
//        pagination: '.swiper-pagination',
//        paginationClickable: true,
//        loop: true
//    });  
    // 园区加载
    $(".boot .more a").click(function() {
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
                    var html = '<li><a href="' + data.datas[i].Link + '"><img src="' + data.datas[i].Logo + '" alt=""></a><div class="nei"><h2>' + data.datas[i].DeptName + '</h2><p>' + (data.datas[i].Introduction ? data.datas[i].Introduction : '') + '</p></div></li>';
                    $(".boot .shang_tp ul").append(html);
                }
                $(".boot .more a").attr('data-page', parseInt(page) + 1);
                layer.close(pIndex);
                if (parseInt(page) === 0) {
                    $(".boot .more a").click();
                }
            } else {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
            }
        }, 'json');
    }).click();    
});