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
        var url = T.baseUrl + '/enterprise/index';
        $.post(url, {page: page}, function(ret) {
            var data = ret.data;
            if (page >= data.pagination.pageCount) {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
                return;
            }
            if (data.datas) {
                var ul1 = $('<ul></ul>').addClass('fli hd').css('clear', 'both');
                var ul2 = $('<ul></ul>').addClass('fli').css('clear', 'both');
                var ul3 = $('<ul></ul>').addClass('fli').css('clear', 'both');
                var ul4 = $('<ul></ul>').addClass('fli').css('clear', 'both');
                var liDom = '';
                for (var i = 0; i < data.datas.length; i++) {
                    if (i === 0) {
                        liDom = $('<li></li>').addClass('bg fl pr').append(
                                $('<span></span>').addClass('pa wz').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul1.append(liDom);
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul1.append(liDom);
                    } else if (i === 1) {
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul1.append(liDom);
                        liDom = $('<li></li>').addClass('bg fl pr').append(
                                $('<span></span>').addClass('pa wz1').text('◆')
                                ).append(
                                $('<p></p>').addClass('f18 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul1.append(liDom);
                    } else if (i === 2) {
                        liDom = $('<li></li>').addClass('bg fl pr rbg').append(
                                $('<span></span>').addClass('pa wz2').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul2.append(liDom);
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul2.append(liDom);
                    } else if (i === 3) {
                        liDom = $('<li></li>').addClass('bg fl pr').append(
                                $('<span></span>').addClass('pa wz').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul2.append(liDom);
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul2.append(liDom);
                    } else if (i === 4) {
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul1.append(liDom);
                        liDom = $('<li></li>').addClass('gbg fl pr').append(
                                $('<span></span>').addClass('pa wz3').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul2.append(liDom);
                    } else if (i === 5) {
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul3.append(liDom);
                        liDom = $('<li></li>').addClass('hbg fl pr').append(
                                $('<span></span>').addClass('pa wz4').text('◆')
                                ).append(
                                $('<p></p>').addClass('f18 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul3.append(liDom);
                    } else if (i === 6) {
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul3.append(liDom);
                        liDom = $('<li></li>').addClass('rbg fl pr').append(
                                $('<span></span>').addClass('pa wz5').text('◆')
                                ).append(
                                $('<p></p>').addClass('f18 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul3.append(liDom);
                    } else if (i === 7) {
                        liDom = $('<li></li>').addClass('gbg fl pr').append(
                                $('<span></span>').addClass('pa wz6').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );

                        ul4.append(liDom);
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul4.append(liDom);
                    } else if (i === 8) {
                        liDom = $('<li></li>').addClass('fl pr ubg').append(
                                $('<span></span>').addClass('pa wz7').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul4.append(liDom);
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul4.append(liDom);
                    } else if (i === 9) {
                        liDom = $('<li></li>').addClass('bg1 fl').append(
                                $('<a></a>').attr('href', data.datas[i].Link).append($('<img />').addClass('tp').attr('alt', '').attr('src', data.datas[i].Logo))
                                );
                        ul3.append(liDom);
                        liDom = $('<li></li>').addClass('bg fl pr').append(
                                $('<span></span>').addClass('pa wz8').text('◆')
                                ).append(
                                $('<p></p>').addClass('f20 plh tc').text(data.datas[i].DeptName)
                                ).append(
                                $('<p></p>').addClass('f15 plh1').html(data.datas[i].Introduction ? data.datas[i].Introduction : '')
                                );
                        ul4.append(liDom);
                    }
                }
                $('#core .inner .elist').append(ul1).append(ul2).append(ul3).append(ul4);
                $("#loadMore").attr('data-page', parseInt(page) + 1);
                layer.close(pIndex);
            } else {
                layer.close(pIndex);
                layer.alert('没有更多数据', {icon: 0});
            }
        }, 'json');
    }).click();
});