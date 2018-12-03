<?php

/**
 * 公用函数类库
 * @author Changfeng Ji <jichf@qq.com>
 */
class Unit {

    /**
     * 封装数据为用于 AJAX 输出的 JSON 格式字符串
     * @param int $code 状态码，值为 0 时表示执行成功，其它值则为错误状态码。默认为 0
     * @param string $msg 状态信息
     * @param mixed $data 数据
     * @param boolean $captureOutput 是否捕获输出，若为 true 则返回输出结果，否则直接输出并退出程序。默认为 false
     * @return string JSON 格式字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function ajaxJson($code = 0, $msg = '', $data = '', $captureOutput = false) {
        $value = array('code' => $code, 'msg' => $msg, 'data' => $data);
        if ($captureOutput) {
            return $value;
        } else {
            exit(CJSON::encode($value));
        }
    }

    /**
     * JSON 数据格式化
     * @param array $data 数据
     * @param string $indent 缩进字符，默认4个空格
     * @return string 格式化后的 JSON 数据字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsonFormat($data, $indent = null) {
        if (!is_array($data)) {
            return false;
        }
        // 对数组中每个元素递归进行urlencode操作，保护中文字符
        array_walk_recursive($data, create_function('&$val,$key', 'if ($val !== true && $val !== false && $val !== null) { $val = urlencode($val); }'));
        // json encode
        $data = json_encode($data);
        // 将urlencode的内容进行urldecode
        $data = urldecode($data);
        // 缩进处理
        $ret = '';
        $pos = 0;
        $length = strlen($data);
        $indent = isset($indent) ? $indent : '    ';
        $newline = "\n";
        $prevchar = '';
        $outofquotes = true;
        for ($i = 0; $i <= $length; $i++) {
            $char = substr($data, $i, 1);
            if ($char == '"' && $prevchar != '\\') {
                $outofquotes = !$outofquotes;
            } elseif (($char == '}' || $char == ']') && $outofquotes) {
                $ret .= $newline;
                $pos --;
                for ($j = 0; $j < $pos; $j++) {
                    $ret .= $indent;
                }
            }
            $ret .= $char;
            if (($char == ',' || $char == '{' || $char == '[') && $outofquotes) {
                $ret .= $newline;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }
                for ($j = 0; $j < $pos; $j++) {
                    $ret .= $indent;
                }
            }
            $prevchar = $char;
        }
        return $ret;
    }

    /**
     * 时间间隔格式化，把秒数转化为容易识别的时间间隔字符串
     * @param int $seconds 秒数
     * @param array $units 输出时间间隔字符串的单位，默认为：day:天、hour:时、minute:分、second:秒
     * @return string 格式化后的时间间隔字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function timespanFormat($seconds, $units = array()) {
        if (!$seconds) {
            return 0;
        }
        $defaultUnits = array('day' => '天', 'hour' => '时', 'minute' => '分', 'second' => '秒');
        $units = array_merge($defaultUnits, $units);
        $days = floor($seconds / 86400);
        $seconds = $seconds % 86400;
        $hours = floor($seconds / 3600);
        $seconds = $seconds % 3600;
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        $result = array(
            $days ? $days . $units['day'] : '',
            $hours ? $hours . $units['hour'] : '',
            $minutes ? $minutes . $units['minute'] : '',
            $seconds ? $seconds . $units['second'] : '',
        );
        return implode('', $result);
    }

    /**
     * 数字转化为中文表示
     * @param int $num 数字
     * @param int $mode 0 = 简体中文（Simplified Chinese）; 1 = 繁体中文（Traditional Chinese）; 2 = 人民币大写
     * @return string 数字的中文表示
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function numberToChinese($num, $mode = 0) {
        if (!in_array($mode, array(0, 1, 2))) {
            $mode = 0;
        }
        switch ($mode) {
            case 0:
                $CNum = array(
                    array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九'),
                    array('', '十', '百', '千'),
                    array('', '万', '亿', '万亿')
                );
                break;
            case 1:
                $CNum = array(
                    array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'),
                    array('', '拾', '佰', '仟'),
                    array('', '萬', '億', '萬億')
                );
            case 2:
                $CNum = array(
                    array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'),
                    array('', '拾', '佰', '仟'),
                    array('', '万', '亿', '万亿')
                );
                break;
        }
        if (is_integer($num)) {
            $int = (string) $num;
        } else if (is_numeric($num)) {
            $num = explode('.', (string) floatval($num));
            $int = $num[0];
            $fl = isset($num[1]) ? $num[1] : FALSE;
        }
        $len = strlen($int); // 长度
        $chinese = array(); // 中文

        $str = strrev($int); // 反转的数字
        for ($i = 0; $i < $len; $i += 4) {
            $s = array(0 => isset($str[$i]) ? $str[$i] : '',
                1 => isset($str[$i + 1]) ? $str[$i + 1] : '',
                2 => isset($str[$i + 2]) ? $str[$i + 2] : '',
                3 => isset($str[$i + 3]) ? $str[$i + 3] : ''
            );
            $j = '';
            /* 千位 */
            if ($s[3] !== '') {
                $s[3] = (int) $s[3];
                if ($s[3] !== 0) {
                    $j .= $CNum[0][$s[3]] . $CNum[1][3];
                } else {
                    if ($s[2] != 0 || $s[1] != 0 || $s[0] != 0) {
                        $j .= $CNum[0][0];
                    }
                }
            }
            /* 百位 */
            if ($s[2] !== '') {
                $s[2] = (int) $s[2];
                if ($s[2] !== 0) {
                    $j .= $CNum[0][$s[2]] . $CNum[1][2];
                } else {
                    if ($s[3] != 0 && ($s[1] != 0 || $s[0] != 0)) {
                        $j .= $CNum[0][0];
                    }
                }
            }
            /* 十位 */
            if ($s[1] !== '') {
                $s[1] = (int) $s[1];
                if ($s[1] !== 0) {
                    $j .= $CNum[0][$s[1]] . $CNum[1][1];
                } else {
                    if ($s[0] != 0 && $s[2] != 0) {
                        $j .= $CNum[0][$s[1]];
                    }
                }
            }
            /* 个位 */
            if ($s[0] !== '') {
                $s[0] = (int) $s[0];
                if ($s[0] !== 0) {
                    $j .= $CNum[0][$s[0]] . $CNum[1][0];
                } else {
                    // do nothing
                }
            }
            $j .= $CNum[2][$i / 4];
            array_unshift($chinese, $j);
        }
        $chs = implode('', $chinese);
        if ($fl) {
            $chs .= '点';
            for ($i = 0, $j = strlen($fl); $i < $j; $i++) {
                $t = (int) $fl[$i];
                $chs .= $CNum[0][$t];
            }
        }
        return $chs;
    }

    /**
     * 返回数组中指定的一列。
     * 
     * 返回input数组中键值为column_key的列， 如果指定了可选参数index_key，那么input数组中的这一列的值将作为返回数组中对应值的键。 
     * @param array $input 需要取出数组列的多维数组（或结果集） 
     * @param mixed $column_key 需要返回值的列，它可以是索引数组的列索引，或者是关联数组的列的键。 也可以是 NULL ，此时将返回整个数组（配合index_key参数来重置数组键的时候，非常管用） 
     * @param mixed $index_key 作为返回数组的索引/键的列，它可以是该列的整数索引，或者字符串键值。
     * @return array 从多维数组中返回单列数组
     * @author Changfeng Ji <jichf@qq.com>
     * @see array_column() - 返回数组中指定的一列（PHP 5 >= 5.5.0）。
     */
    public static function arrayColumn($input, $column_key = null, $index_key = null) {
        if (!is_array($input)) {
            return array();
        }
        if (function_exists('array_column')) {
            return array_column($input, $column_key, $index_key);
        } else {
            return array_reduce($input, create_function('$v,$w', '$v[' . ($index_key ? '$w["' . $index_key . '"]' : '') . '] = ' . ($column_key ? '$w["' . $column_key . '"]' : '$w') . ';return $v;'));
        }
    }

    /**
     * 排序数组。
     * 
     * 按照input数组中键值column_key进行排序，返回排序后的数组。 
     * @param array $input 需要排序的多维数组（或结果集）。
     * @param mixed $column_key 需要排序的列，它可以是索引数组的列索引，或者是关联数组的列的键。
     * @param int $order 可选，规定排列顺序。可能的值: 
     *  - SORT_ASC - 默认。按升序排列 (A-Z)。
     *  - SORT_DESC - 按降序排列 (Z-A)。
     * @param int $type 可选，规定排序类型。可能的值: 
     *  - SORT_REGULAR - 默认。把每一项按常规顺序排列（Standard ASCII，不改变类型）。
     *  - SORT_NUMERIC - 把每一项作为数字来处理。
     *  - SORT_STRING - 把每一项作为字符串来处理。
     * @return array 返回排序后的数组
     * @see sort() 函数用于对数组单元从低到高进行排序。
     * @see rsort() 函数用于对数组单元从高到低进行排序。
     * @see asort() 函数用于对数组单元从低到高进行排序并保持索引关系。
     * @see arsort() 函数用于对数组单元从高到低进行排序并保持索引关系。
     * @see ksort() 函数用于对数组单元按照键名从低到高进行排序。
     * @see krsort() 函数用于对数组单元按照键名从高到低进行排序。
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function arraySort($input, $column_key, $order = SORT_ASC, $type = SORT_REGULAR) {
        if (!is_array($input) || empty($input)) {
            return array();
        } else if (empty($column_key)) {
            return array();
        } else if (!in_array($order, array(SORT_ASC, SORT_DESC))) {
            return array();
        } else if (!in_array($type, array(SORT_REGULAR, SORT_NUMERIC, SORT_STRING))) {
            return array();
        }
        $arrSort = array();
        foreach ($input as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$column_key], $order, $type, $input);
        return $input;
    }

    /**
     * 数组不重复排列集合
     * 
     * 测试示例：
     *     $arr = array(array('a', 'b', 'c'), array('A', 'B', 'C'), array('1', '2', '3', '4'));
     *     $set = Unit::arrayUniqueSet($arr);
     *     echo json_encode($set);
     * 
     * 测试结果（输出36种组合的结果(3*3*4=36)）：
     *     [
     *         ["a","A","1"],["a","A","2"],["a","A","3"],["a","A","4"],
     *         ["a","B","1"],["a","B","2"],["a","B","3"],["a","B","4"],
     *         ["a","C","1"],["a","C","2"],["a","C","3"],["a","C","4"],
     *         ["b","A","1"],["b","A","2"],["b","A","3"],["b","A","4"],
     *         ["b","B","1"],["b","B","2"],["b","B","3"],["b","B","4"],
     *         ["b","C","1"],["b","C","2"],["b","C","3"],["b","C","4"],
     *         ["c","A","1"],["c","A","2"],["c","A","3"],["c","A","4"],
     *         ["c","B","1"],["c","B","2"],["c","B","3"],["c","B","4"],
     *         ["c","C","1"],["c","C","2"],["c","C","3"],["c","C","4"]
     *     ]
     * 
     * @staticvar array $_total_arr 总数组
     * @staticvar int $_total_arr_index 总数组下标计数
     * @staticvar int $_total_count 输入的数组长度
     * @staticvar array $_temp_arr 临时拼凑数组
     * @param array $arrs 二维数组，格式：array(array(),...)
     * @param int $_current_index 二维数组当前索引，此为辅助参数，勿传值。
     * @return array 返回数组不重复排列集合
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function arrayUniqueSet($arrs, $_current_index = -1) {
        //总数组
        static $_total_arr;
        //总数组下标计数
        static $_total_arr_index;
        //输入的数组长度
        static $_total_count;
        //临时拼凑数组
        static $_temp_arr;
        //进入输入数组的第一层，清空静态数组，并初始化输入数组长度
        if ($_current_index < 0) {
            $_total_arr = array();
            $_total_arr_index = 0;
            $_temp_arr = array();
            $_total_count = count($arrs) - 1;
            self::arrayUniqueSet($arrs, 0);
        } else {
            //循环第$_current_index层数组
            foreach ($arrs[$_current_index] as $v) {
                //如果当前的循环的数组少于输入数组长度
                if ($_current_index < $_total_count) {
                    //将当前数组循环出的值放入临时数组
                    $_temp_arr[$_current_index] = $v;
                    //继续循环下一个数组
                    self::arrayUniqueSet($arrs, $_current_index + 1);
                }
                //如果当前的循环的数组等于输入数组长度(这个数组就是最后的数组)
                else if ($_current_index == $_total_count) {
                    //将当前数组循环出的值放入临时数组
                    $_temp_arr[$_current_index] = $v;
                    //将临时数组加入总数组
                    $_total_arr[$_total_arr_index] = $_temp_arr;
                    //总数组下标计数+1
                    $_total_arr_index++;
                }
            }
        }
        return $_total_arr;
    }

    /**
     * 截取字符串
     * @param string $str 字符串
     * @param int $length 截取长度
     * @param string $suffix 截取后的字符串后缀，默认为“...”
     * @param string $encoding 字符编码，默认为 utf-8
     * @return string 截取后的字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function stringCut($str, $length, $suffix = '...', $encoding = 'utf-8') {
        return mb_strlen($str, $encoding) > $length ? mb_substr($str, 0, $length, $encoding) . $suffix : $str;
    }

    /**
     * 获取随机字符串
     * @param int $length 字符串长度
     * @param string $chars 字符库
     * @return string 返回随机字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function stringRandom($length, $chars = 'ABCDEFGHKLMNPRSTUVWYZabcdefghkmnprstuvwyz23456789') {
        $hashes = array();
        $max = mb_strlen($chars) - 1;
        while (count($hashes) < $length) {
            $hashes[] = mt_rand(0, $max);
            $hashes = array_unique($hashes);
        }
        $string = "";
        foreach ($hashes as $hash) {
            $string .= mb_substr($chars, $hash, 1);
        }
        return $string;
    }

    /**
     * 获取一个唯一的ID
     * @param boolean $hyphens 是否包含连字号（-），默认为 FALSE，既不包含连字号（-）。
     * @return string 返回一个唯一的ID，长度包括如下两种 : 
     *  - 参数 $hyphens 为 TRUE 时，返回包含连字号（-）的36位ID（8-4-4-4-12）
     *  - 参数 $hyphens 为 FALSE 时（默认），返回移除连字号（-）的32位ID
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function stringGuid($hyphens = false) {
        $uuid = '';
        if (function_exists('com_create_guid')) {
            $uuid = com_create_guid();
        } else {
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
        }
        if (!$hyphens) {
            $uuid = strtr($uuid, array('-' => ''));
        }
        return trim($uuid, '{}');
    }

    /**
     * 打乱一个字符串（使用相同密钥，一次执行为打乱字符串，再一次执行即为恢复字符串）
     * 
     * 例如:
     *  - $str = 'abcdefghijklmn'; //声明一个字符串
     *  - $key = Unit::shuffleString($str); //获取 $str 字符串的密钥（随机生成）
     *  - echo $key; //输出 9,11,6,8,3,4,0,2,10,13,12,5,1,7
     *  - $a = Unit::shuffleString($str, $key); //打乱 $str 字符串为 $a 字符串
     *  - echo $a; //输出 cbaedmihglnjfk
     *  - $b = Unit::shuffleString($a, $key); //打乱 $a 字符串为 $b 字符串
     *  - echo $b; //输出 abcdefghijklmn
     * @param string $string 字符串
     * @param string $key 字符串的密钥，当为空时表示获取 $string 字符串的密钥（随机生成）
     * @return string 打乱后的字符串，执行失败则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function stringShuffle($string, $key = null) {
        if (empty($string)) {
            return false;
        }
        if (empty($key)) {
            $keys = array_keys(str_split($string));
            shuffle($keys);
            $key = implode(',', $keys);
            return $key;
        }
        $strings = str_split($string);
        $keys = explode(',', $key);
        while (count($keys) > 2) {
            $two = array_splice($keys, 0, 2);
            $tmp = $strings[$two[0]];
            $strings[$two[0]] = $strings[$two[1]];
            $strings[$two[1]] = $tmp;
        }
        $string = implode('', $strings);
        return $string;
    }

    /**
     * utf8 转 unicode
     * 
     * UCS-2 编码的潜规则:
     *  - 对于 UCS-2，Windows 下默认是 UCS-2LE。
     *  - 对于 UCS-2，Linux 下默认是 UCS-2BE。
     * @param string $name
     * @return string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function utf8_unicode($name) {
        if (strtoupper(substr(PHP_OS, 0, 5)) == "LINUX") {
            $name = iconv('UTF-8', 'UCS-2BE', $name);
        } else {
            $name = iconv('UTF-8', 'UCS-2', $name);
        }
        $len = strlen($name);
        $str = '';
        for ($i = 0; $i < $len - 1; $i = $i + 2) {
            $c = $name[$i];
            $c2 = $name[$i + 1];
            if (ord($c) > 0) {    // 两个字节的文字  
                $str .= '\u' . base_convert(ord($c), 10, 16) . str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
            } else {
                $str .= '\u' . str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
            }
        }
        return $str;
    }

    /**
     * unicode 转 utf8
     * 
     * UCS-2 编码的潜规则:
     *  - 对于 UCS-2，Windows 下默认是 UCS-2LE。
     *  - 对于 UCS-2，Linux 下默认是 UCS-2BE。
     * @param string $name
     * @return string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function unicode_utf8($name) {
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches)) {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++) {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0) {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code) . chr($code2);
                    if (strtoupper(substr(PHP_OS, 0, 5)) == "LINUX") {
                        $c = iconv('UCS-2BE', 'UTF-8', $c);
                    } else {
                        $c = iconv('UCS-2', 'UTF-8', $c);
                    }
                    $name .= $c;
                } else {
                    $name .= $str;
                }
            }
        }
        return $name;
    }

    /**
     * 哈希加密密码
     * @param string $password 明文密码
     * @param int $length 哈希加密长度，包括 32、64、128 三种，默认为 64
     * @return string 返回哈希密码，失败则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function hashEncrypt($password, $length = 64) {
        if ($length == 32) {
            $salt = self::stringRandom(6);
            $algo = 'md5';
        } else if ($length == 64) {
            $salt = self::stringRandom(12);
            $algo = 'sha256';
        } else if ($length == 128) {
            $salt = self::stringRandom(24);
            $algo = 'sha512';
        } else {
            return false;
        }
        $len = strlen($salt);
        $hash = hash($algo, $salt . $password);
        $output = $salt . substr($hash, 0, $length - $len);
        return $output;
    }

    /**
     * 检查明文密码是否匹配哈希密码
     * @param string $password 明文密码
     * @param string $stored_hash 哈希密码
     * @return boolean 匹配则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function hashCheck($password, $stored_hash) {
        $length = strlen($stored_hash);
        if ($length == 32) {
            $salt = substr($stored_hash, 0, 6);
            $algo = 'md5';
        } else if ($length == 64) {
            $salt = substr($stored_hash, 0, 12);
            $algo = 'sha256';
        } else if ($length == 128) {
            $salt = substr($stored_hash, 0, 24);
            $algo = 'sha512';
        } else {
            return false;
        }
        $len = strlen($salt);
        $hash = hash($algo, $salt . $password);
        $output = $salt . substr($hash, 0, $length - $len);
        return ($output && $stored_hash == $output);
    }

    /**
     * The encryption of symmetric encryption algorithm.
     * @access public
     * @static
     * @param string $string The unencrypted string(raw string).
     * @param string $key The encryption key.
     * @return mixed The encrypted string or <b>FALSE</b> on failure.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function encrypt($string, $key = '') {
        if (!is_string($string)) {
            return false;
        }
        $key = md5($key);
        $key_length = strlen($key);
        $string = substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $randomKeys = $box = array();
        $result = '';
        for ($i = 0; $i < 256; $i++) {
            $randomKeys[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $randomKeys[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        $a = $j = 0;
        for ($i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        return base64_encode($result);
    }

    /**
     * The decryption of symmetric encryption algorithm.
     * @access public
     * @static
     * @param string $string The encrypted string.
     * @param string $key The decryption key.
     * @return mixed The decrypted string(raw string) or <b>FALSE</b> on failure.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function decrypt($string, $key = '') {
        if (!is_string($string)) {
            return false;
        }
        $key = md5($key);
        $key_length = strlen($key);
        $string = base64_decode($string);
        $string_length = strlen($string);
        $randomKeys = $box = array();
        $result = '';
        for ($i = 0; $i < 256; $i++) {
            $randomKeys[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        $j = 0;
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $randomKeys[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        $a = $j = 0;
        for ($i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
            return substr($result, 8);
        } else {
            return false;
        }
    }

    /**
     * 安全加密字符串
     * @param string $data 未加密的数据
     * @param string $encryptionKey 用于加密/解密数据的密钥，默认为 NULL
     * @return string 返回加密后的字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function securityEncrypt($data, $encryptionKey = null) {
        $securityManager = Yii::app()->getSecurityManager();
        if ($encryptionKey) {
            $securityManager->setEncryptionKey($encryptionKey);
        }
        return base64_encode($securityManager->encrypt($data));
    }

    /**
     * 安全解密字符串
     * @param string $data 已加密的数据
     * @param string $encryptionKey 用于加密/解密数据的密钥，默认为 NULL
     * @return string 返回解密后的字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function securityDecrypt($data, $encryptionKey = null) {
        $securityManager = Yii::app()->getSecurityManager();
        if ($encryptionKey) {
            $securityManager->setEncryptionKey($encryptionKey);
        }
        return $securityManager->decrypt(base64_decode($data));
    }

    /**
     * Escapes characters that work as wildcard characters in a LIKE pattern.
     * 
     * The wildcard characters "%" and "_" as well as backslash are prefixed with
     * a backslash. Use this to do a search for a verbatim string without any
     * wildcard behavior.
     * 
     * Backslash is defined as escape character for LIKE patterns in database condition.
     * 
     * For example, the following does a case-insensitive query for all rows whose
     * name starts with $prefix:
     *  - $datas = Yii::app()->getDb()->createCommand()->select('*')->from('person')->where(array('like', 'name', Unit::escapeLike($prefix) . '%'))->queryAll();
     * 
     * @param string $string The string to escape.
     * @return string The escaped string.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function escapeLike($string) {
        return addcslashes($string, '\%_');
    }

    /**
     * 对 HTML 进行编码
     * @param string $html 未编码的 HTML
     * @return string 返回编码后的字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function htmlEncode($html) {
        return get_magic_quotes_gpc() ? htmlspecialchars($html) : htmlspecialchars(addslashes($html));
    }

    /**
     * 对 HTML 进行解码
     * @param string $data 已编码的 HTML
     * @return string 返回解码后的字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function htmlDecode($data) {
        return get_magic_quotes_gpc() ? htmlspecialchars_decode($data) : stripslashes(htmlspecialchars_decode($data));
    }

    /**
     * 设置 Cookie
     * @param string $name 名称
     * @param string $value 值
     * @param array $options 配置数组键值对，默认为空数组。配置项包括：
     *  - domain: 域名
     *  - expire: 过期时间，是一个时间戳（默认是 0，关闭浏览器就结束）
     *  - path: 路径（默认是 / ）
     *  - secure: 是否通过安全连接发送（默认是 false ）
     *  - httpOnly: 是否只通过http协议访问（默认是 false ）
     * @example Unit::cookieSet('demo', 'test', array('expire' => time() + 60 * 60 * 24 * 30));//有效期30天
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function cookieSet($name, $value, $options = array()) {
        $cookie = new CHttpCookie($name, $value, $options);
        Yii::app()->getRequest()->getCookies()->add($name, $cookie);
    }

    /**
     * 读取 Cookie
     * @param string $name 名称
     * @return CHttpCookie Cookie 对象
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function cookieGet($name) {
        return Yii::app()->getRequest()->getCookies()->itemAt($name);
    }

    /**
     * 删除 Cookie
     * @param string $name 名称
     * @param array $options 配置数组键值对，默认为空数组。
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function cookieDelete($name, $options = array()) {
        Yii::app()->getRequest()->getCookies()->remove($name, $options);
    }

    /**
     * 加载 CSS 文件(相对路径，参与自动化合并压缩):
     *  - Unit::cssFile('css/demo.css');
     *  - Unit::cssFile('css/demo.css','lte IE 6');
     * 
     * 加载 CSS 文件(绝对路径，不参与自动化合并压缩):
     *  - Unit::cssFile(Yii::app()->getBaseUrl(true) . '/css/demo.css');
     *  - Unit::cssFile('http://www.example.com/css/demo.css');
     * @param string $url 相对路径或绝对路径。注：相对路径的文件后缀(.css)可以省略。
     * @param string $media
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function cssFile($url, $media = '') {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        if (strtolower($ext) != 'css' && strpos($url, '://') === false) {
            $url .= '.css';
        }
        if (substr($url, 0, 1) !== '/' && strpos($url, '://') === false) {
            $url = Yii::app()->getBaseUrl() . '/' . $url;
        }
        Yii::app()->getClientScript()->registerCssFile($url, $media);
    }

    /**
     * 加载 JavaScript 文件(相对路径，参与自动化合并压缩):
     *  - Unit::jsFile('js/demo.js');
     *  - Unit::jsFile('js/demo.js', CClientScript::POS_HEAD, array('media' => 'lt IE 9'));
     * 
     * 加载 JavaScript 文件(绝对路径，不参与自动化合并压缩):
     *  - Unit::jsFile(Yii::app()->getBaseUrl(true) . '/js/demo.js');
     *  - Unit::jsFile('http://www.example.com/js/demo.js');
     * @param string $url 相对路径或绝对路径。注：相对路径的文件后缀(.js)可以省略。
     * @param int $position
     * @param array $htmlOptions
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsFile($url, $position = CClientScript::POS_HEAD, $htmlOptions = array()) {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        if (strtolower($ext) != 'js' && strpos($url, '://') === false) {
            $url .= '.js';
        }
        if (substr($url, 0, 1) !== '/' && strpos($url, '://') === false) {
            $url = Yii::app()->getBaseUrl() . '/' . $url;
        }
        Yii::app()->getClientScript()->registerScriptFile($url, $position, $htmlOptions);
    }

    /**
     * 加载全局 JavaScript 变量
     * @param string $key
     * @param mixed $value
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsVariable($key, $value = null) {
        static $variable;
        if (!isset($variable)) {
            $variable = array();
        }
        if (is_null($key)) {
            return $variable;
        }
        $keys = explode('.', $key);
        if (!isset($keys[1]) && is_null($value)) {
            return isset($variable[$key]) ? $variable[$key] : null;
        } else if (!isset($keys[1])) {
            $variable[$key] = $value;
            return;
        }
        if (!isset($variable[$keys[0]])) {
            $variable[$keys[0]] = array();
        }
        if (is_null($value)) {
            return isset($variable[$keys[0]][$keys[1]]) ? $variable[$keys[0]][$keys[1]] : null;
        } else {
            $variable[$keys[0]][$keys[1]] = $value;
        }
    }

    /**
     * 获取全局 JavaScript 变量脚本
     * @param string $variable 全局 JavaScript 变量名称，默认为 Yii.
     * @return string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsVariableScript($variable = 'Yii') {
        $text = CJSON::encode(self::jsVariable(null));
        return CHtml::script($variable . ' = ' . $text . ';');
    }

    /**
     * 压缩混淆加密 JavaScript 脚本
     * 
     * Notes : need PHP 5 . Tested with PHP 5.1.2, 5.1.3, 5.1.4, 5.2.3
     * @param string $script the JavaScript to pack.
     * @param string $encoding level of encoding, int or string :
     *  0,10,62,95 or 'None', 'Numeric', 'Normal', 'High ASCII'.
     *  default: 62.
     * @param boolean $fastDecode include the fast decoder in the packed result. default : true.
     * @param boolean $specialChars if you are flagged your private and local variables in the script. default: false.
     * @return string the compressed JavasScript. Empty string is returned if the dependent class has not been defined.
     * @depends class JavaScriptPacker
     * @see http://dean.edwards.name/packer/usage/
     * @link http://dean.edwards.name/packer/
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsPack($script, $encoding = 62, $fastDecode = true, $specialChars = false) {
        if (!class_exists('JavaScriptPacker')) {
            return '';
        }
        $packer = new JavaScriptPacker($script, $encoding, $fastDecode, $specialChars);
        $packed = $packer->pack();
        return $packed;
    }

    /**
     * 压缩混淆加密 JavaScript 脚本文件
     * 
     * 若 $outputFile 脚本文件已存在，则只有当 $fromFile 脚本文件已修改或 $reset 参数为 TRUE 时才会重新生成 $outputFile 脚本文件
     * @param string $fromFile 输入 JavaScript 脚本文件的路径
     * @param string $outputFile 输出 JavaScript 脚本文件的路径
     * @param string $reset 若输出 JavaScript 脚本文件已存在，是否重新生成，默认为 FALSE
     * @return boolean 执行成功则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsPackFile($fromFile, $outputFile, $reset = false) {
        if (empty($fromFile) || empty($outputFile)) {
            return false;
        } else if (!is_file($fromFile)) {
            return false;
        }
        if (!$reset && is_file($outputFile) && filemtime($outputFile) >= filemtime($fromFile)) {
            return true;
        }
        $script = file_get_contents($fromFile);
        if (!$script) {
            return false;
        }
        $packed = self::jsPack($script);
        if (!$packed) {
            return false;
        }
        $dir = pathinfo($outputFile, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        if (file_put_contents($outputFile, $packed)) {
            return true;
        }
        return false;
    }

    /**
     * 获取面包屑HTML
     * @param array $crumbs 面包屑数组，不传则默认 $controller 控制器下的 breadcrumbs。格式示例：array(array('name' => '首页', 'url' => Yii::app()->getHomeUrl()), array('name' => '登录页'))
     * @param string $delimiter 面包屑项分隔符，默认为“ -> ”
     * @param CController $controller 默认为当前控制器
     * @return string 面包屑HTML
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getBreadCrumbHTML($crumbs = array(), $delimiter = ' -> ', $controller = null) {
        if (is_null($controller)) {
            $controller = Yii::app()->getController();
        }
        if (empty($crumbs)) {
            $crumbs = $controller->breadcrumbs;
        }
        $properties = array(
            'crumbs' => $crumbs,
            'delimiter' => $delimiter
        );
        return $controller->widget('application.widgets.BreadCrumb', $properties, true);
    }

    /**
     * 获取分页HTML
     * @param CPagination $pages 分页对象
     * @param CController $controller 默认为当前控制器
     * @return string 分页HTML
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getPageHTML($pages, $controller = null) {
        if (is_null($controller)) {
            $controller = Yii::app()->getController();
        }
        $appendParams = Yii::app()->getUrlManager()->appendParams;
        Yii::app()->getUrlManager()->appendParams = false;
        $properties = array(
            'pages' => $pages,
            'firstPageLabel' => '首页',
            'lastPageLabel' => '末页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'header' => '',
            'footer' => ''
        );
        $result = $controller->widget('CLinkPager', $properties, true);
        Yii::app()->getUrlManager()->appendParams = $appendParams;
        return $result;
    }

    /**
     * 获取浏览器信息，包括浏览器名称和版本。格式示例为 array('browser' => 'ie', 'version' => 7.0)
     * @return array/boolean 返回浏览器名称和版本，若获取失败则返回 false。支持如下浏览器:
     *  - ie: Internet Explorer 浏览器
     *  - edge: Edge 浏览器
     *  - firefox: FireFox 浏览器
     *  - chrome: Chrome 浏览器
     *  - opera: Opera 浏览器
     *  - safari: Safari 浏览器
     *  - unknown: 未识别浏览器
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getBrowser() {
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        if (is_null($agent)) {
            return false;
        }
        $browser = false;
        $version = false;
        $regs = false;
        if (strpos($agent, 'rv:11.0')) {//ie11判断
            $browser = 'ie';
            $version = '11';
        } else if (strpos($agent, 'MSIE') !== false) {
            $browser = 'ie';
            preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else if (strpos($agent, 'Edge') !== false) {
            $browser = 'edge';
            preg_match('/Edge\/(\d+)\..*/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else if (strpos($agent, 'Firefox') !== false) {
            $browser = 'firefox';
            preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else if (strpos($agent, 'Chrome') !== false) {
            $browser = 'chrome';
            preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else if (strpos($agent, 'Opera') !== false) {
            $browser = 'opera';
            preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else if (strpos($agent, 'Chrome') == false && strpos($agent, 'Safari') !== false) {
            $browser = 'safari';
            preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs);
            $version = isset($regs[1]) ? $regs[1] : false;
        } else {
            $browser = 'unknown';
            $version = false;
        }
        return array('browser' => $browser, 'version' => $version, 'http_user_agent' => $agent);
    }

    /**
     * 获取当前IP地址
     * @return string 返回当前IP地址，失败则返回 unknown
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getIp() {
        $realip = '';
        $unknown = 'unknown';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
            } else if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = $unknown;
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
                $realip = getenv("REMOTE_ADDR");
            } else {
                $realip = $unknown;
            }
        }
        $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
        return $realip;
    }

    /**
     * 根据提供的IP地址，快速查询出该IP地址所在的地理信息和地理相关的信息，包括国家、省、市和运营商。
     * 
     * 返回数据格式示例：
     *   array(2) (
     *     [code] => (int) 0
     *     [data] => array(13) (
     *       [country] => (string) 中国
     *       [country_id] => (string) CN
     *       [area] => (string) 华北
     *       [area_id] => (string) 100000
     *       [region] => (string) 北京市
     *       [region_id] => (string) 110000
     *       [city] => (string) 北京市
     *       [city_id] => (string) 110100
     *       [county] => (string)
     *       [county_id] => (string) -1
     *       [isp] => (string) 阿里云
     *       [isp_id] => (string) 1000323
     *       [ip] => (string) 123.56.188.183
     *     )
     *   )
     * 其中code的值的含义为，0：成功，1：失败。
     * @param string $ip IP地址，默认为当前IP地址
     * @param string $cacheID 缓存应用组件的标识ID，默认为“cache”（主缓存应用组件）
     * @return array 返回该IP地址所在的地理信息和地理相关的信息。
     * @see http://ip.taobao.com/instructions.php
     * @link http://ip.taobao.com
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getIpInfo($ip = '', $cacheID = 'cache') {
        if (empty($ip)) {
            $ip = self::getIp();
        }
        $cached = Yii::app()->getComponent($cacheID)->get('getIpInfo_' . $ip);
        if ($cached) {
            return $cached;
        }
        $data = null;
        try {
            $data = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
        } catch (Exception $exc) {
            return array('code' => 1, 'data' => 'unknown error.');
        }
        if (empty($data)) {
            return array('code' => 1, 'data' => 'unknown error.');
        }
        $json = json_decode($data, true);
        Yii::app()->getCache()->set('getIpInfo_' . $ip, $json, 3600 * 24 * 1); // 1 days
        return $json;
    }

    /**
     * 获取当前登录用户的ID
     */
    public static function getLoggedUserId() {
        return Yii::app()->getUser()->getId();
    }

    /**
     * 获取当前登录的部门ID
     */
    public static function getLoggedDeptId() {
        return Yii::app()->getUser()->getState('deptId', '');
    }

    /**
     * 获取当前登录的角色ID
     */
    public static function getLoggedRoleId() {
        return Yii::app()->getUser()->getState('roleId', '');
    }

    /**
     * 获取开放的区域编码
     * @return array 开放的区域编码列表
     */
    public static function getAreaCodes() {
        $opens = array(
            '110000' => '北京市'
        );
        return $opens;
    }

    /**
     * 获取当前区域编码
     * @return int 区域编码，默认为 110000
     */
    public static function getAreaCode() {
        $opens = self::getAreaCodes();
        $defaultCode = 110000;
        $areaCode = self::cookieGet('areaCode');
        if (isset($areaCode->value) && isset($opens[$areaCode->value])) {
            return $areaCode->value;
        }
        $ipInfo = self::getIpInfo();
        if (isset($ipInfo['code']) && $ipInfo['code'] == 0) {
            $cityId = isset($ipInfo['data']['city_id']) ? $ipInfo['data']['city_id'] : '';
            $regionId = isset($ipInfo['data']['region_id']) ? $ipInfo['data']['region_id'] : '';
            if ($cityId && isset($opens[$cityId])) {
                return $cityId;
            } else if ($regionId && isset($opens[$regionId])) {
                return $regionId;
            }
        }
        return $defaultCode;
    }

}
