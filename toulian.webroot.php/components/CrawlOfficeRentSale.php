<?php

/**
 * 抓取写字楼租售信息
 * @author Changfeng Ji <jichf@qq.com>
 */
class CrawlOfficeRentSale {

    /**
     * 获取地址的所属区域
     * @param string $address 地址
     * @param string $defaultArea 默认区域
     * @return string 区域。若匹配不到则返回默认区域。
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getAreaFromAddress($address, $defaultArea = '北京') {
        if (!$address) {
            return $defaultArea;
        }
        $areas = array('东城', '崇文', '西城', '宣武', '朝阳', '丰台', '石景山', '海淀', '门头沟', '房山', '通州', '顺义', '昌平', '大兴', '怀柔', '平谷', '密云', '延庆', '燕郊', '近郊', '周边');
        foreach ($areas as $area) {
            if (mb_strpos($address, $area) !== false) {
                return $area;
            }
        }
        return $defaultArea;
    }

    /**
     * 过滤重复的URL
     * @param array $urls
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function filterUrls($urls) {
        foreach ($urls as $key => $url) {
            $existUrl = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('sourceUrl')
                    ->from('t_office_rent_sale')
                    ->where('sourceUrl = :sourceUrl', array(':sourceUrl' => $url))
                    ->queryScalar();
            if ($existUrl) {
                unset($urls[$key]);
            }
        }
        return array_values($urls);
    }

    /**
     * 输出日志
     * @param int $successCount 成功数量
     * @param int $startTime 开始时间
     * @param int $endTime 结束时间
     * @param string $remark 备注
     * @param string $detailedLog 详细日志
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function dumpLog($successCount, $startTime, $endTime, $remark, $detailedLog) {
        Yii::app()->getDb()->createCommand()->insert('t_office_rent_sale_log', array(
            'successCount' => $successCount,
            'startTime' => date('Y-m-d H:i:s', $startTime),
            'endTime' => date('Y-m-d H:i:s', $endTime),
            'timeSpan' => $endTime - $startTime,
            'remark' => $remark,
            'detailedLog' => $detailedLog
        ));
    }

    /**
     * 获取URL数据
     * @param string $url
     * @param string $referer
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function requestUrl($url, $referer = '') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (stripos($url, "https://") !== false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $userAgents = array(
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36 QIHU 360SE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36 QIHU 360EE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2107.204 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2716.5 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgents[rand(0, count($userAgents) - 1)]);
        $cookieDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'crawl-cookie';
        if (!is_dir($cookieDir)) {
            mkdir($cookieDir);
        }
        $cookieFile = tempnam($cookieDir, 'cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: max-age=0'
        ));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = false;
        $body = false;
        if (is_numeric($headerSize)) {
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
        }
        $info = array(
            'httpCode' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'contentType' => curl_getinfo($curl, CURLINFO_CONTENT_TYPE),
            'contentTypeDownload' => curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
            'sizeDownload' => curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD),
            'errno' => curl_errno($curl),
            'error' => curl_error($curl),
            'proxy' => false
        );
        curl_close($curl);
        if ($info['httpCode'] == 200 && $info['sizeDownload'] < 300 && mb_strpos($body, 'Unauthorized') !== false) {
            $info['httpCode'] = -1;
            $info['error'] = $info['error'] ? $info['error'] . ' - Unauthorized' : 'Unauthorized';
        }
        return array('header' => $header, 'body' => $body, 'info' => $info);
    }

    /**
     * 使用阿布云专业代理获取URL数据
     * @param string $url
     * @param string $referer
     * @return array
     * @link https://www.abuyun.com
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function requestUrlByAbuyun($url, $referer = '') {
        //设置时区（使用中国时间，以免时区不同导致认证错误）
        date_default_timezone_set("Asia/Shanghai");
        $proxyIp = 'http-pro.abuyun.com';
        $proxyPort = '9010';
        // 隧道身份信息
        $proxyUser = "HBSWV822HJ1H964P";
        $proxyPass = "0C5359E163AA3CFB";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (stripos($url, "https://") !== false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $userAgents = array(
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36 QIHU 360SE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36 QIHU 360EE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2107.204 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2716.5 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgents[rand(0, count($userAgents) - 1)]);
        $cookieDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'crawl-cookie';
        if (!is_dir($cookieDir)) {
            mkdir($cookieDir);
        }
        $cookieFile = tempnam($cookieDir, 'cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
        curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
        curl_setopt($curl, CURLOPT_PROXY, $proxyIp); //代理服务器地址
        curl_setopt($curl, CURLOPT_PROXYPORT, $proxyPort); //代理服务器端口
        // 设置隧道验证信息
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, "{$proxyUser}:{$proxyPass}");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: max-age=0'
        ));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = false;
        $body = false;
        if (is_numeric($headerSize)) {
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
        }
        $info = array(
            'httpCode' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'contentType' => curl_getinfo($curl, CURLINFO_CONTENT_TYPE),
            'contentTypeDownload' => curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
            'sizeDownload' => curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD),
            'errno' => curl_errno($curl),
            'error' => curl_error($curl),
            'proxy' => $proxyIp . ':' . $proxyPort
        );
        curl_close($curl);
        if ($info['httpCode'] == 200 && $info['sizeDownload'] < 300 && mb_strpos($body, 'Unauthorized') !== false) {
            $info['httpCode'] = -1;
            $info['error'] = $info['error'] ? $info['error'] . ' - Unauthorized' : 'Unauthorized';
        }
        return array('header' => $header, 'body' => $body, 'info' => $info);
    }

    /**
     * 使用蚂蚁动态代理获取URL数据
     * @param string $url
     * @param string $referer
     * @return array
     * @link http://www.mayidaili.com
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function requestUrlByMayiProxy($url, $referer = '') {
        //设置时区（使用中国时间，以免时区不同导致认证错误）
        date_default_timezone_set("Asia/Shanghai");
        $proxyIp = 's4.proxy.mayidaili.com';
        $proxyPort = '8123';
        //AppKey 信息，请替换
        $appKey = '219475397';
        //AppSecret 信息，请替换
        $secret = '149259373890d18fce9dcb3cf3dca6db';
        //示例请求参数
        $paramMap = array(
            'app_key' => $appKey,
            'timestamp' => date('Y-m-d H:i:s')
        );
        //按照参数名排序
        ksort($paramMap);
        //连接待加密的字符串
        $codes = $secret;
        //请求的URL参数
        $auth = 'MYH-AUTH-MD5 ';
        foreach ($paramMap as $key => $val) {
            $codes .= $key . $val;
            $auth .= $key . '=' . $val . '&';
        }
        $codes .= $secret;
        //签名计算
        $auth .= 'sign=' . strtoupper(md5($codes));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (stripos($url, "https://") !== false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $userAgents = array(
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36 QIHU 360SE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36 QIHU 360EE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2107.204 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2716.5 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgents[rand(0, count($userAgents) - 1)]);
        $cookieDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'crawl-cookie';
        if (!is_dir($cookieDir)) {
            mkdir($cookieDir);
        }
        $cookieFile = tempnam($cookieDir, 'cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
        curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
        curl_setopt($curl, CURLOPT_PROXY, $proxyIp); //代理服务器地址
        curl_setopt($curl, CURLOPT_PROXYPORT, $proxyPort); //代理服务器端口
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: max-age=0',
            "Proxy-Authorization: {$auth}"
        ));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = false;
        $body = false;
        if (is_numeric($headerSize)) {
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
        }
        $info = array(
            'httpCode' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'contentType' => curl_getinfo($curl, CURLINFO_CONTENT_TYPE),
            'contentTypeDownload' => curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
            'sizeDownload' => curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD),
            'errno' => curl_errno($curl),
            'error' => curl_error($curl),
            'proxy' => $proxyIp . ':' . $proxyPort
        );
        curl_close($curl);
        if ($info['httpCode'] == 200 && $info['sizeDownload'] < 300 && mb_strpos($body, 'Unauthorized') !== false) {
            $info['httpCode'] = -1;
            $info['error'] = $info['error'] ? $info['error'] . ' - Unauthorized' : 'Unauthorized';
        }
        return array('header' => $header, 'body' => $body, 'info' => $info);
    }

    /**
     * 使用芝麻代理获取URL数据
     * @param string $url
     * @param string $referer
     * @return array
     * @link http://http.zhimaruanjian.com
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function requestUrlByZhimaProxy($url, $referer = '') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (stripos($url, "https://") !== false) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            //curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if ($referer) {
            curl_setopt($curl, CURLOPT_REFERER, $referer);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $userAgents = array(
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0",
            "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36 QIHU 360SE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36 QIHU 360EE",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2107.204 Safari/537.36",
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 UBrowser/6.1.2716.5 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgents[rand(0, count($userAgents) - 1)]);
        $cookieDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'crawl-cookie';
        if (!is_dir($cookieDir)) {
            mkdir($cookieDir);
        }
        $cookieFile = tempnam($cookieDir, 'cookie');
        curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
        $proxy = self::getZhimaProxy();
        if (isset($proxy['ip'])) {
            curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
            curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
            curl_setopt($curl, CURLOPT_PROXY, $proxy['ip']); //代理服务器地址
            curl_setopt($curl, CURLOPT_PROXYPORT, $proxy['port']); //代理服务器端口
            //curl_setopt($ch, CURLOPT_PROXYUSERPWD, ":"); //http代理认证帐号，username:password 的格式
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: max-age=0'
        ));
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        $response = curl_exec($curl);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = false;
        $body = false;
        if (is_numeric($headerSize)) {
            $header = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
        }
        $info = array(
            'httpCode' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'contentType' => curl_getinfo($curl, CURLINFO_CONTENT_TYPE),
            'contentTypeDownload' => curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD),
            'sizeDownload' => curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD),
            'errno' => curl_errno($curl),
            'error' => curl_error($curl),
            'proxy' => isset($proxy['ip']) ? $proxy['ip'] . ':' . $proxy['port'] : false
        );
        curl_close($curl);
        if ($info['httpCode'] == 200 && $info['sizeDownload'] < 300 && mb_strpos($body, 'Unauthorized') !== false) {
            $info['httpCode'] = -1;
            $info['error'] = $info['error'] ? $info['error'] . ' - Unauthorized' : 'Unauthorized';
        }
        return array('header' => $header, 'body' => $body, 'info' => $info);
    }

    /**
     * 获取代理，从第一个开始逐个获取，获取不到时返回 false
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getZhimaProxy() {
        $lockpath = Yii::getPathOfAlias('application') . '/runtime/phplock/';
        if (!is_dir($lockpath)) {
            mkdir($lockpath, 0777, true);
        }
        $lock = new PHPLock($lockpath, __CLASS__ . '_' . __FUNCTION__);
        $lock->startLock();
        $status = $lock->Lock();
        if (!$status) {
            //exit("lock error");
            return false;
        }
        $cacheProxyList = __CLASS__ . '_' . __FUNCTION__ . '_ZhimaProxyList';
        $proxyList = Yii::app()->getCache()->get($cacheProxyList);
        if ($proxyList) {
            // 移除已过期的代理IP
            foreach ($proxyList as $key => $value) {
                if ($value['expire_time'] < time()) {
                    unset($proxyList[$key]);
                }
            }
            $proxyList = array_values($proxyList);
        }
        $max = 20;
        $num = 0;
        if (!$proxyList) {
            $num = $max;
            $proxyList = array();
        }if (count($proxyList) < $max) {
            $num = $max - count($proxyList);
        }
        if ($num > 0) {
            // 按次提取
            //$url = 'http://http-webapi.zhimaruanjian.com/getip?num=' . $num . '&type=2&pro=&city=0&yys=0&port=11&time=1&ts=1&ys=1&cs=1&lb=1&sb=0&pb=4&mr=1';
            // 按月购买-25分钟版(17-08-31 11:22~17-10-01 11:22)
            $url = 'http://http-webapi.zhimaruanjian.com/getip?num=' . $num . '&type=2&pro=&city=0&yys=0&port=11&pack=585&ts=1&ys=1&cs=1&lb=1&sb=0&pb=4&mr=1';
            $ret = CrawlOfficeRentSale::requestUrl($url);
            if ($ret['info']['httpCode'] == 200) {
                $info = (array) json_decode($ret['body']);
                if (isset($info['code']) && $info['code'] == 0) {
                    foreach ($info['data'] as $value) {
                        $value->time_span = Unit::timespanFormat(isset($value->expire_time) ? strtotime($value->expire_time) - time() : 0);
                        file_put_contents(Yii::getPathOfAlias('application') . '/runtime/zhimaproxy.log', json_encode($value, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
                        $proxyList[] = array(
                            'ip' => $value->ip,
                            'port' => $value->port,
                            'expire_time' => isset($value->expire_time) ? strtotime($value->expire_time) : 0,
                            'city' => isset($value->city) ? $value->city : '',
                            'isp' => isset($value->isp) ? $value->isp : ''
                        );
                    }
                }
            }
        }
        Yii::app()->getCache()->set($cacheProxyList, $proxyList, 0); //永不过期
        $cacheProxyIndex = __CLASS__ . '_' . __FUNCTION__ . '_ZhimaProxyIndex';
        $proxyIndex = Yii::app()->getCache()->get($cacheProxyIndex);
        if (is_numeric($proxyIndex)) {
            $proxyIndex++;
            if (!isset($proxyList[$proxyIndex])) {
                $proxyIndex = 0;
            }
        } else {
            $proxyIndex = 0;
        }
        Yii::app()->getCache()->set($cacheProxyIndex, $proxyIndex, 0); //永不过期
        $lock->unlock();
        $lock->endLock();
        return isset($proxyList[$proxyIndex]) ? $proxyList[$proxyIndex] : false;
    }

}
