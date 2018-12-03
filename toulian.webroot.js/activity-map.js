jQuery(function($) {
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
    // 添加带有定位的导航控件
    var navigationControl = new BMap.NavigationControl({
        // 靠左上角位置
        anchor: BMAP_ANCHOR_TOP_LEFT,
        // LARGE类型
        type: BMAP_NAVIGATION_CONTROL_LARGE,
        // 启用显示定位
        enableGeolocation: true
    });
    map.addControl(navigationControl);
    // 添加定位控件
    var geolocationControl = new BMap.GeolocationControl();
    geolocationControl.addEventListener("locationSuccess", function(e) {
        // 定位成功事件
        var address = '';
        address += e.addressComponent.province;
        address += e.addressComponent.city;
        address += e.addressComponent.district;
        address += e.addressComponent.street;
        address += e.addressComponent.streetNumber;
        layer.msg("当前定位地址为：" + address, {icon: 1});
    });
    geolocationControl.addEventListener("locationError", function(e) {
        // 定位失败事件
        layer.msg(e.message, {icon: 0});
    });
    map.addControl(geolocationControl);
    var mapLocation = $("#mapLocation").val();
    var mapCoordinates = $("#mapCoordinates").val();
    if (mapCoordinates) {
        var point = new BMap.Point(mapCoordinates.split(",")[0], mapCoordinates.split(",")[1]);
        map.centerAndZoom(point, 16);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
    } else if (mapLocation) {
        var local = new BMap.LocalSearch(map, {
            renderOptions: {map: map}
        });
        local.search($("#mapLocation").val());
    }
    /*
     var routePolicy = [BMAP_TRANSIT_POLICY_LEAST_TIME, BMAP_TRANSIT_POLICY_LEAST_TRANSFER, BMAP_TRANSIT_POLICY_LEAST_WALKING, BMAP_TRANSIT_POLICY_AVOID_SUBWAYS];
     var transit = new BMap.TransitRoute(map, {
     renderOptions: {map: map},
     policy: 0
     });
     $("#result").click(function() {
     map.clearOverlays();
     var i = $("#driving_way select").val();
     search(address, local, routePolicy[i]);
     function search(address, local, route) {
     transit.setPolicy(route);
     transit.search(address, local);
     }
     });
     */
});