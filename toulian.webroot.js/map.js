jQuery(function ($) {
    $('a.areaCode').click(function () {
        var code = $(this).attr('data-code');
        if (!T.areaCodes.hasOwnProperty(code)) {
            layer.alert($(this).attr('data-name') + '数据正在建设中，如有商务合作请拨打电话：010-61820546（座机），13911600017（手机）', {icon: 0});
            return;
        }
        $.cookie('areaCode', code, {expires: null, path: '/'});
        location.href = T.homeUrl;
    });
//    var main1 = echarts.init(document.getElementById('main'));
//    var data = [
//        {name: '北京市', code: 110000, value: 279},
//        {name: '上海市', code: 310000, value: 229},
//        {name: '深圳市', code: 440300, value: 273},
//        {name: '天津市', code: 120000, value: 194}
//    ];
//    var geoCoordMap = {
//        '北京市': [116.46, 39.92],
//        '上海市': [121.48, 31.22],
//        '深圳市': [114.07, 22.62],
//        '天津市': [117.2, 39.13]
//    };
//
//    var convertData = function (data) {
//        var res = [];
//        for (var i = 0; i < data.length; i++) {
//            var geoCoord = geoCoordMap[data[i].name];
//            if (geoCoord) {
//                res.push({
//                    name: data[i].name,
//                    code: data[i].code,
//                    value: geoCoord.concat(data[i].value)
//                });
//            }
//        }
//        return res;
//    };
//
//    option = {
//        tooltip: {
//            trigger: 'item'
//        },
//        legend: {
//            orient: 'vertical',
//            y: 'bottom',
//            x: 'right',
//            textStyle: {
//                color: '#fff'
//            }
//        },
//        geo: {
//            map: 'china',
//            label: {
//                emphasis: {
//                    show: false
//                }
//            },
//            roam: true,
//            itemStyle: {
//                normal: {
//                    areaColor: '#9DBBD5',
//                    borderColor: '#EEF4F7'
//                },
//                emphasis: {
//                    areaColor: '#78A3C6'
//                }
//            }
//        },
//        series: [
//            {
//                type: 'scatter',
//                coordinateSystem: 'geo',
//                data: convertData(data),
//                selectedMode: 'multiple',
//                symbolSize: function (val) {
//                    return val[2] / 10;
//                },
//                label: {
//                    normal: {
//                        formatter: '{b}',
//                        position: 'right',
//                        show: false
//                    },
//                    emphasis: {
//                        show: true
//                    }
//                },
//                itemStyle: {
//                    normal: {
//                        color: '#ddb926'
//                    }
//                }
//            },
//            {
//                name: '地区选择',
//                type: 'effectScatter',
//                coordinateSystem: 'geo',
//                data: convertData(data.sort(function (a, b) {
//                    return b.value - a.value;
//                })),
//                symbolSize: function (val) {
//                    return val[2] / 10;
//                },
//                showEffectOn: 'render',
//                rippleEffect: {
//                    brushType: 'stroke'
//                },
//                hoverAnimation: true,
//                label: {
//                    normal: {
//                        formatter: '{b}',
//                        position: 'right',
//                        show: true
//                    }
//                },
//                itemStyle: {
//                    normal: {
//                        color: '#f4e925',
//                        shadowBlur: 10,
//                        shadowColor: '#333'
//                    }
//                },
//                zlevel: 1
//            }
//        ]
//    };
//    main1.setOption(option);
//    main1.on('click', function (params) {
//        var code = params.data.code;
//        if (!T.areaCodes.hasOwnProperty(code)) {
//            layer.alert(params.data.name + '数据正在建设中，如有商务合作请拨打电话：010-61820546（座机），13911600017（手机）', {icon: 0});
//            return;
//        }
//        $.cookie('areaCode', code, {expires: null, path: '/'});
//        location.href = T.homeUrl;
//    });
//    
// 地图部分
    var main1 = echarts.init(document.getElementById('main'));
    option = {
        tooltip: {
            trigger: 'item',
            formatter: '{b}，点击切换'
        },
        series: [
            {
                name: '中国',
                type: 'map',
                mapType: 'china',
                zoom: 1.2,
                label: {
                    normal: {
                        show: true
                    },
                    emphasis: {
                        show: true
                    },
                },
                itemStyle: {
                    normal: {
                        areaColor: '#eee'
                    },
                    emphasis: {
                        areaColor: '#0EA8E3'
                    }
                },
                data: [
                    {name: '北京', value: '110000', selected: true},
                    {name: '上海', value: '310000', selected: true},
                    {name: '天津', value: '120000', selected: true},
                    {name: '深圳', value: '440300', selected: true}
                ]
            }
        ]
    };
    main1.setOption(option);
    main1.on('click', function (params) {
        var code = params.data.code;
        if (!T.areaCodes.hasOwnProperty(code)) {
            layer.alert(params.data.name + '数据正在建设中，如有商务合作请拨打电话：010-61820546（座机），13911600017（手机）', {icon: 0});
            return;
        }
        $.cookie('areaCode', code, {expires: null, path: '/'});
        location.href = T.homeUrl;
    });
});