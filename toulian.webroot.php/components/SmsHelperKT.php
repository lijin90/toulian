<?php

/**
 * 彩短信接口
 * @author Changfeng Ji <jichf@qq.com>
 */
class SmsHelperKT {

    /**
     * 状态码说明
     * @var array
     * @author Changfeng Ji <jichf@qq.com>
     */
    private static $statuses = array(
        '0' => '提交成功',
        '0000' => '提交成功',
        '1001' => '彩信xml格式有误',
        '1002' => '彩信资源文件过大(视频类不能超过100K,其它不能超过80K)',
        '1003' => '读取彩信资源文件有误',
        '1004' => '彩信标题有误(不能超过30字且不能为空)',
        '1005' => '定时时间格式有误',
        '1006' => '账户余额不足',
        '1007' => '插入发送列表异常',
        '1008' => '生成资源文件有误',
        '1009' => '没有可发送的手机号码',
        '1010' => '电话号码过大(最多可一次提交500,000个手机号码)',
        '1011' => '含有敏感词',
        '1012' => '短信内容为空',
        '1013' => '绑定IP有误',
        '1014' => '提交时段错误',
        '1015' => '提交密码有误',
        '1016' => '提交账号有误',
        '1017' => '短信签名有误',
        '9999' => '其它错误'
    );

    /**
     * 用户帐号
     * @var string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static $account = 'csdfyx';

    /**
     * 用户密码
     * @var string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static $password = 'csdftoulian9026';

    /**
     * 最后一次发送短信或彩信的发送响应结果
     * @var array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static $sendResult = array();

    /**
     * 发送短信
     * 
     * 注：短信内容末尾必须带有中文签名，而且必须以包括在【2-15字的中英文签名】中，并确保短信内容最后一个字符为“】”，例如：短信内容【测试】
     * @param string|array $phonelist 单个手机号码，或手机号码列表
     * @param string $subject 短信内容(不能为空且不能超过二百八十个字)
     * @param string $regulartime 定时发送时间，格式为：Y-m-d H:i:s，如果不定时则为空
     * @return boolean 是否发送成功
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function sendSMS($phonelist, $subject, $regulartime = '') {
        if (!$phonelist || !$subject) {
            return false;
        }
        $balanceOld = self::queryBalance('短信余额');
        $server = 'http://service.caixinbao.cn/sendSMS';
        $params = array(
            'account' => self::$account,
            'password' => self::$password
        );
        if (is_array($phonelist)) {
            $params['phonelist'] = implode(',', $phonelist);
        } else if (is_string($phonelist)) {
            $params['phonelist'] = $phonelist;
        }
        $params['subject'] = $subject;
        $params['regulartime'] = $regulartime;
        $params = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $sendResult = curl_exec($ch);
        curl_close($ch);
        if (!$sendResult) {
            return false;
        }
        $datas = (array) simplexml_load_string(trim($sendResult, " \t\n\r"));
        if (isset($datas['submitstatus']) && isset(self::$statuses[$datas['submitstatus']])) {
            $datas['submitmsg'] = self::$statuses[$datas['submitstatus']];
        }
        $balanceNew = self::queryBalance('短信余额');
        if (is_array($datas)) {
            $datas['之前短信余额'] = $balanceOld ? $balanceOld . '条' : '获取失败';
            $datas['当前短信余额'] = $balanceNew ? $balanceNew . '条' : '获取失败';
            $datas['当前短信消费'] = ($balanceOld && $balanceNew) ? ($balanceOld - $balanceNew) . '条' : '获取失败';
        }
        self::$sendResult = $datas;
        if (isset($datas['submitstatus']) && $datas['submitstatus'] == 0) {
            return true;
        }
        return false;
    }

    /**
     * 发送彩信
     * @param string|array $phonelist 单个手机号码，或手机号码列表
     * @param string $subject 彩信标题(不能为空且不能超过三十个字)
     * @param array $pages 页面列表，其每个子项为单页 $page，格式为 array($page, $page, $page, ...)。
     *  $page 仍为一个数组，其格式为 array('text' => '文本节点内容', 'image' => '图片节点路径')。
     * @param string $regulartime 定时发送时间，格式为：Y-m-d H:i:s，如果不定时则为空
     * @return boolean 是否发送成功
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function sendMMS($phonelist, $subject, $pages, $regulartime = '') {
        if (!$phonelist || !$subject || !$pages) {
            return false;
        }
        $balanceOld = self::queryBalance('彩信余额');
        $server = 'http://service.caixinbao.cn/sendMMS';
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<Body>';
        $xml .= '<account>' . self::$account . '</account>';
        $xml .= '<password>' . self::$password . '</password>';
        $xml .= '<mms>';
        $xml .= '<phonelist>' . (is_array($phonelist) ? implode(',', $phonelist) : $phonelist) . '</phonelist>';
        $xml .= '<subject>' . base64_encode($subject) . '</subject>';
        $xml .= '<regulartime>' . $regulartime . '</regulartime>';
        $xml .= '<pages>';
        foreach ($pages as $key => $page) {
            $xml .= '<page dur="100" order="' . ($key + 1) . '">';
            foreach ($page as $type => $value) {
                if ($type == 'image' && file_exists($value)) {
                    $ext = FileHelper::getExtension($value);
                    if ($ext == 'gif' || $ext == 'jpg') {
                        $xml .= '<img type="' . $ext . '">' . base64_encode(file_get_contents($value)) . '</img>';
                    }
                } else if ($type == 'text') {
                    $xml .= '<text type="txt">' . base64_encode(iconv('UTF-8', 'GBK//IGNORE', $value)) . '</text>';
                }
            }
            $xml .= '</page>';
        }
        $xml .= '</pages>';
        $xml .= '</mms>';
        $xml .= '</Body>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $server);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: text/xml"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $sendResult = curl_exec($ch);
        curl_close($ch);
        if (!$sendResult) {
            return false;
        }
        $datas = (array) simplexml_load_string(trim($sendResult, " \t\n\r"));
        if (isset($datas['submitstatus']) && isset(self::$statuses[$datas['submitstatus']])) {
            $datas['submitmsg'] = self::$statuses[$datas['submitstatus']];
        }
        $balanceNew = self::queryBalance('彩信余额');
        if (is_array($datas)) {
            $datas['之前彩信余额'] = $balanceOld ? $balanceOld . '条' : '获取失败';
            $datas['当前彩信余额'] = $balanceNew ? $balanceNew . '条' : '获取失败';
            $datas['当前彩信消费'] = ($balanceOld && $balanceNew) ? ($balanceOld - $balanceNew) . '条' : '获取失败';
        }
        self::$sendResult = $datas;
        if (isset($datas['submitstatus']) && $datas['submitstatus'] == 0) {
            return true;
        }
        return false;
    }

    /**
     * 查询余额
     * 
     * 若指定 $key 则返回指定的信息，否则返回全部信息。
     * @param string $key 截止时间|彩信余额|短信余额
     * @return array|boolean
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function queryBalance($key = false) {
        $server = 'http://service.caixinbao.cn/queryBalance';
        $params = array(
            'account' => self::$account,
            'password' => self::$password
        );
        $url = $server . '?' . http_build_query($params);
        $rt = file_get_contents($url);
        if (!$rt) {
            return false;
        }
        $rts = array('原始数据' => $rt);
        preg_match_all('/截止时间:(.*?)<br/i', $rt, $return);
        if (isset($return[1][0])) {
            $rts['截止时间'] = $return[1][0];
        }
        preg_match_all('/彩信余额:(\d+)/i', $rt, $return);
        if (isset($return[1][0])) {
            $rts['彩信余额'] = $return[1][0];
        }
        preg_match_all('/短信余额:(\d+)/i', $rt, $return);
        if (isset($return[1][0])) {
            $rts['短信余额'] = $return[1][0];
        }
        if ($key) {
            return isset($rts[$key]) ? $rts[$key] : false;
        }
        return $rts;
    }

}
