jQuery(function($) {
    $("#loadMore").click(function() {
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
        var url = T.baseUrl + '/association/index';
        $.post(url, {page: page}, function(ret) {
            var data = ret.data;
            if (page >= data.pagination.pageCount) {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
                return;
            }
            if (data.html) {
                $('#xiehui .inner').append(data.html);
                $("#loadMore").attr('data-page', parseInt(page) + 1);
                layer.close(pIndex);
                if(parseInt(page) === 0){
                    $("#loadMore").click();
                }
            } else {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
            }
        }, 'json');
    }).click();
});

