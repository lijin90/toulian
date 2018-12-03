/**
 * 部门筛选封装类
 * 
 * 需要 jQuery、layer 的支持
 * 示例 - 部门筛选：
 *     $.deptFilter(function(deptId, deptName){
 *         alert(deptId + ' | ' + deptName);
 *     });
 * 示例 - 资源筛选：
 *     $.resourceFilter(function(resId, resName){
 *         alert(resId + ' | ' + resName);
 *     });
 * 提示：当 $ 不等于 jQuery 时，请使用 jQuery.
 * 
 * @param {object} callback 回调函数，包含参数 id 和 name
 * @returns {void}
 * @author Changfeng Ji <jichf@qq.com>
 */
(function($) {
    $.extend({
        deptFilter: function(callback) {
            var filterTypes = {
                'org': '政府招商',
                'office': '下属处室',
                'park': '园区招商',
                'association': '商会/协会/俱乐部',
                'enterprise': '企业招商',
                'agency': '经纪公司',
                'vendor': '交易服务商',
                'incubator': '孵化器',
                'enterpriseworld': '企业天地',
                'investorlibrary': '投资人库'
            };
            var menu = $('<div></div>').addClass('filtermenu');
            for (var dt in filterTypes) {
                menu.append($('<a></a>').attr('href', 'javascript:;').attr('data-page', 0).attr('data-filtertype', dt).text(filterTypes[dt]));
            }
            var keyword = $('<div></div>').addClass('filterkeyword');
            keyword.append($('<input />').addClass('keyword-text').attr('type', 'text').attr('name', 'keyword').attr('placeholder', '请输入名称关键字').val(''));
            keyword.append($('<a></a>').addClass('keyword-btn').attr('href', 'javascript:;').attr('title', '点击查询').append($('<img />').attr('alt', '').attr('src', T.imageUrl + '/one/04.png')));
            var list = $('<div></div>').addClass('filterlist');
            var more = $('<div></div>').addClass('filtermore');
            more.append($('<a></a>').attr('href', 'javascript:;').text('查看更多'));
            var filterIndex = null;
            filterIndex = layer.open({
                type: 1,
                title: '部门筛选',
                closeBtn: 0,
                shadeClose: true,
                scrollbar: false,
                content: $('<div></div>').append(menu).append(keyword).append(list).append(more).html(),
                success: function(layero, index) {
                    $('.filtermenu a').click(function() {
                        $(this).addClass('current').siblings().removeClass('current');
                        $('.filterkeyword .keyword-text').attr('placeholder', '请输入' + $(this).text() + '名称关键字');
                        $('.filtermore a').attr('data-page', 0);
                        $('.filtermore a').attr('data-filtertype', $(this).attr('data-filtertype'));
                        $('.filterlist').empty();
                        $('.filtermore a').click();
                    });
                    $('.filterkeyword .keyword-btn').click(function() {
                        $('.filtermore a').attr('data-page', 0);
                        $('.filterlist').empty();
                        $('.filtermore a').click();
                    });
                    $('.filterkeyword .keyword-text').keypress(function(event) {
                        if (event.keyCode === 13) {
                            $('.filterkeyword .keyword-btn').click();
                        }
                    });
                    $('.filtermore a').click(function() {
                        if (window.filterLoading) {
                            return;
                        }
                        window.filterLoading = true;
                        var pIndex = layer.load(0, {
                            end: function(layero, index) {
                                window.filterLoading = false;
                            }
                        });
                        var page = $(this).attr('data-page');
                        var deptType = $(this).attr('data-filtertype');
                        var keyword = $('.filterkeyword .keyword-text').val();
                        var url = T.baseUrl + '/department/filter';
                        $.post(url, {page: page, deptType: deptType, keyword: keyword}, function(ret) {
                            var data = ret.data;
                            if (data.scope === 'self') {
                                $('.filtermenu a').each(function() {
                                    if ($(this).attr('data-filtertype') !== 'org' && $(this).attr('data-filtertype') !== 'park' && $(this).attr('data-filtertype') !== 'enterprise') {
                                        $(this).hide();
                                    }
                                });
                            }
                            if (page >= data.pagination.pageCount) {
                                if ($('.filterlist .row').length === 0) {
                                    $('.filterlist').html('<div style="text-align: center;margin: 5px 0;height: 30px;line-height: 30px;">暂无数据</div>');
                                    layer.close(pIndex);
                                } else {
                                    layer.close(pIndex);
                                    layer.alert('没有更多数据', {icon: 0});
                                }
                                return;
                            }
                            if (data.datas) {
                                for (var i = 0; i < data.datas.length; i++) {
                                    var row = $('<div></div>').addClass('row');
                                    row.append($('<a></a>').attr('href', 'javascript:;').attr('data-id', data.datas[i].ID).text(data.datas[i].DeptName).click(function() {
                                        callback($(this).attr('data-id'), $(this).text());
                                        layer.close(filterIndex);
                                    }));
                                    $('.filterlist').append(row);
                                }
                                $('.filtermore a').attr('data-page', parseInt(page) + 1);
                                layer.close(pIndex);
                            } else {
                                if ($('.filterlist .row').length === 0) {
                                    $('.filterlist').html('<div style="text-align: center;height: 30px;line-height: 30px;">暂无数据</div>');
                                    layer.close(pIndex);
                                } else {
                                    layer.close(pIndex);
                                    layer.alert('没有更多数据', {icon: 0});
                                }
                            }
                        }, 'json');
                    });
                    $('.filtermenu a').eq(0).click();
                    $('.filtermore a').click();
                }
            });
        },
        resourceFilter: function(callback) {
            var filterTypes = {
                'land': '土地',
                'factory': '厂房',
                'officebuilding': '写字楼',
                'shop': '商铺'
            };
            var menu = $('<div></div>').addClass('filtermenu');
            for (var dt in filterTypes) {
                menu.append($('<a></a>').attr('href', 'javascript:;').attr('data-page', 0).attr('data-filtertype', dt).text(filterTypes[dt]));
            }
            var keyword = $('<div></div>').addClass('filterkeyword');
            keyword.append($('<input />').addClass('keyword-text').attr('type', 'text').attr('name', 'keyword').attr('placeholder', '请输入名称关键字').val(''));
            keyword.append($('<a></a>').addClass('keyword-btn').attr('href', 'javascript:;').attr('title', '点击查询').append($('<img />').attr('alt', '').attr('src', T.imageUrl + '/one/04.png')));
            var list = $('<div></div>').addClass('filterlist');
            var more = $('<div></div>').addClass('filtermore');
            more.append($('<a></a>').attr('href', 'javascript:;').text('查看更多'));
            var filterIndex = null;
            filterIndex = layer.open({
                type: 1,
                title: '资源筛选',
                closeBtn: 0,
                shadeClose: true,
                scrollbar: false,
                content: $('<div></div>').append(menu).append(keyword).append(list).append(more).html(),
                success: function(layero, index) {
                    $('.filtermenu a').click(function() {
                        $(this).addClass('current').siblings().removeClass('current');
                        $('.filterkeyword .keyword-text').attr('placeholder', '请输入' + $(this).text() + '名称关键字');
                        $('.filtermore a').attr('data-page', 0);
                        $('.filtermore a').attr('data-filtertype', $(this).attr('data-filtertype'));
                        $('.filterlist').empty();
                        $('.filtermore a').click();
                    });
                    $('.filterkeyword .keyword-btn').click(function() {
                        $('.filtermore a').attr('data-page', 0);
                        $('.filterlist').empty();
                        $('.filtermore a').click();
                    });
                    $('.filterkeyword .keyword-text').keypress(function(event) {
                        if (event.keyCode === 13) {
                            $('.filterkeyword .keyword-btn').click();
                        }
                    });
                    $('.filtermore a').click(function() {
                        if (window.filterLoading) {
                            return;
                        }
                        window.filterLoading = true;
                        var pIndex = layer.load(0, {
                            end: function(layero, index) {
                                window.filterLoading = false;
                            }
                        });
                        var page = $(this).attr('data-page');
                        var resCategory = $(this).attr('data-filtertype');
                        var keyword = $('.filterkeyword .keyword-text').val();
                        var url = T.baseUrl + '/resource/filter';
                        $.post(url, {page: page, resCategory: resCategory, keyword: keyword}, function(ret) {
                            var data = ret.data;
                            if (page >= data.pagination.pageCount) {
                                if ($('.filterlist .row').length === 0) {
                                    $('.filterlist').html('<div style="text-align: center;margin: 5px 0;height: 30px;line-height: 30px;">暂无数据</div>');
                                    layer.close(pIndex);
                                } else {
                                    layer.close(pIndex);
                                    layer.alert('没有更多数据', {icon: 0});
                                }
                                return;
                            }
                            if (data.datas) {
                                for (var i = 0; i < data.datas.length; i++) {
                                    var row = $('<div></div>').addClass('row');
                                    row.append($('<a></a>').attr('href', 'javascript:;').attr('data-id', data.datas[i].ID).text(data.datas[i].Title).click(function() {
                                        callback($(this).attr('data-id'), $(this).text());
                                        layer.close(filterIndex);
                                    }));
                                    $('.filterlist').append(row);
                                }
                                $('.filtermore a').attr('data-page', parseInt(page) + 1);
                                layer.close(pIndex);
                            } else {
                                if ($('.filterlist .row').length === 0) {
                                    $('.filterlist').html('<div style="text-align: center;height: 30px;line-height: 30px;">暂无数据</div>');
                                    layer.close(pIndex);
                                } else {
                                    layer.close(pIndex);
                                    layer.alert('没有更多数据', {icon: 0});
                                }
                            }
                        }, 'json');
                    });
                    $('.filtermenu a').eq(0).click();
                    $('.filtermore a').click();
                }
            });
        }
    });
})(jQuery);