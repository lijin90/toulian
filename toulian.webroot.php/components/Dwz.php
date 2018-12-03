<?php

/**
 * 短网址
 * @author Changfeng Ji <jichf@qq.com>
 */
class Dwz {

    /**
     * 生成短网址（百度）
     * @param string $url 长网址
     * @param string $alias 自定义网址，可为字母、数字、破折号
     * @return array 返回生成的短网址信息，参数包括 :
     *  - status: 状态码，值为 0 时表示执行成功，其它值则为错误状态码
     *  - err_msg: 错误信息
     *  - longurl: 原网址（长网址）
     *  - tinyurl: 生成的短网址
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function create($url, $alias = '') {
        if (!$url) {
            return array('status' => -1, 'err_msg' => '愿网址为空');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dwz.cn/create.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = array('url' => $url);
        if ($alias) {
            $data['alias'] = $alias;
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $strRes = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($strRes, true);
        if (isset($arrResponse['status'])) {
            return $arrResponse;
        }
        return array('status' => -1, 'err_msg' => '执行失败');
    }

    /**
     * 显示原网址（百度）
     * @param string $tinyurl 查询的短地址
     * @return array 返回原网址信息，参数包括 :
     *  - status: 状态码，值为 0 时表示执行成功，其它值则为错误状态码
     *  - err_msg: 错误信息
     *  - longurl: 原网址（长网址）
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function query($tinyurl) {
        if (!$tinyurl) {
            return array('status' => -1, 'err_msg' => '查询的短地址为空');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://dwz.cn/query.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = array('tinyurl' => $tinyurl);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $strRes = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($strRes, true);
        if (isset($arrResponse['status'])) {
            return $arrResponse;
        }
        return array('status' => -1, 'err_msg' => '执行失败');
    }

}
