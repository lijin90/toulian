<?php

/**
 * 地图帮助类
 * 
 * 地图坐标系说明:
 *  - 1. WGS84 原始坐标系，一般用国际GPS纪录仪记录下来的经纬度，通过GPS定位拿到的原始经纬度，
 *    Google和高德地图定位的的经纬度（国外）都是基于WGS84坐标系的；
 *    但是在国内是不允许直接用WGS84坐标系标注的，必须经过加密后才能使用；
 *  - 2. GCJ02 坐标系，又名“火星坐标系”，是我国国测局独创的坐标体系，由WGS－84加密而成，
 *    在国内，必须至少使用GCJ02坐标系，或者使用在GCJ02加密后再进行加密的坐标系，如百度坐标系。
 *    高德和Google在国内都是使用GCJ02坐标系，可以说，GCJ02是国内最广泛使用的坐标系；
 *  - 3. BD09 为百度坐标系，百度坐标系是在GCJ02坐标系的基础上再次加密偏移后形成的坐标系，只适用于百度地图。
 * @author Changfeng Ji <jichf@qq.com>
 */
class MapHelper {

    /**
     * 非百度坐标转换成百度坐标（baidu）
     * 
     * 百度地图坐标转换API是一套以HTTP形式提供的坐标转换接口，
     * 用于将常用的非百度坐标（目前支持GPS设备获取的坐标、google地图坐标、soso地图坐标、amap地图坐标、mapbar地图坐标）转换成百度地图中使用的坐标，
     * 并可将转化后的坐标在百度地图JavaScript API、车联网API、静态图API、web服务API等产品中使用。
     * 
     * 坐标系说明:
     *  - WGS84：为一种大地坐标系，也是目前广泛使用的GPS全球卫星定位系统使用的坐标系。
     *  - GCJ02：是由中国国家测绘局制订的地理信息系统的坐标系统。由WGS84坐标系经加密后的坐标系。
     *  - BD09：为百度坐标系，在GCJ02坐标系基础上再次加密。其中bd09ll表示百度经纬度坐标，bd09mc表示百度墨卡托米制坐标。
     * 
     * 百度地图开放平台提供的各类Web API服务，默认输入输出坐标类型为百度坐标（BD09），同时可通过参数（如："coord_type","ret_coordtype"。具体参数以各服务参数介绍为准）控制输入输出坐标类型。
     * 输入坐标支持以上三种坐标系，输出坐标支持-国测局坐标（GCJ02）和百度坐标（BD09）。
     * @param string $coords 源坐标:
     *  - 格式：经度,纬度;经度,纬度…
     *  - 限制：最多支持100个
     *  - 格式举例：114.21892734521,29.575429778924;114.21892734521,29.575429778924
     * @param int $from 源坐标类型，取值为如下:
     *  - 1：GPS设备获取的角度坐标，wgs84坐标;
     *  - 2：GPS获取的米制坐标、sogou地图所用坐标;
     *  - 3：google地图、soso地图、aliyun地图、mapabc地图和amap地图所用坐标，国测局坐标;
     *  - 4：3中列表地图坐标对应的米制坐标;
     *  - 5：百度地图采用的经纬度坐标;
     *  - 6：百度地图采用的米制坐标;
     *  - 7：mapbar地图坐标;
     *  - 8：51地图坐标
     * @param int $to 目的坐标类型，取值为如下:
     *  - 5：bd09ll(百度经纬度坐标),
     *  - 6：bd09mc(百度米制经纬度坐标);
     * @return array 返回值说明，参数包括 :
     *  - status: 状态码，正常0，异常非0，详细见状态码说明
     *  - result: 转换结果，与输入顺序一致，其中 x 为横坐标，y 为纵坐标
     * @link http://lbsyun.baidu.com/index.php?title=webapi/guide/changeposition
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function coordinateConvertToBaidu($coords, $from, $to) {
        if (!$coords || !$from || !$to) {
            return array('status' => -1);
        }
        $url = 'http://api.map.baidu.com/geoconv/v1/';
        $params = array(
            'ak' => '7f2bfc6f4602138bc556be07949ef1ee',
            'coords' => $coords,
            'from' => $from,
            'to' => $to,
            'output' => 'json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $strRes = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($strRes, true);
        if (isset($arrResponse['status'])) {
            return $arrResponse;
        }
        return array('status' => -1);
    }

    /**
     * 非高德坐标转换成高德坐标（amap）
     * 
     * 坐标转换是一类简单的HTTP接口，能够将用户输入的非高德坐标（GPS坐标、mapbar坐标、baidu坐标）转换成高德坐标。
     * @param string $locations 坐标点:
     *  - 经度和纬度用","分割，经度在前，纬度在后，经纬度小数点后不得超过6位。
     *  - 多个坐标对之间用”|”进行分隔最多支持40对坐标。
     * @param string $coordsys 原坐标系:
     *  - gps 全球定位系统
     *  - mapbar 图吧
     *  - baidu 百度
     *  - autonavi(不进行转换)
     * @return array 返回生成的坐标信息，参数包括 :
     *  - status: 返回状态，值为0或1，1：成功；0：失败
     *  - info: 返回的状态信息，status为0时，info返回错误原；否则返回“OK”。
     *  - locations: 转换之后的坐标。若有多个坐标，则用 “;”进行区分和间隔
     * @link http://lbs.amap.com/api/webservice/guide/api/convert
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function coordinateConvertToGaode($locations, $coordsys) {
        if (!$locations || !$coordsys) {
            return array('status' => 0, 'info' => '缺少参数');
        }
        $url = 'http://restapi.amap.com/v3/assistant/coordinate/convert';
        $params = array(
            'key' => 'fe2c082c663455cddb267e2c1e8ee840',
            'locations' => $locations,
            'coordsys' => $coordsys,
            'output' => 'JSON'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $strRes = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($strRes, true);
        if (isset($arrResponse['status'])) {
            return $arrResponse;
        }
        return array('status' => 0, 'info' => '执行失败');
    }

}
