<?php

/**
 * 级联地址操作类
 * @author Changfeng Ji <jichf@qq.com>
 */
class Pcas {

    private static $pcas_table = 't_pcasdict';
    private static $pcas_fields = 'code, name, en_name, letter, pid, level';

    /**
     * 检查是否加载了 Cache 组件
     * @return boolean
     * @author Changfeng Ji <jichf@qq.com>
     */
    private static function hasCache() {
        return Yii::app()->hasComponent('cache');
    }

    /**
     * 获取地址列表
     * @param int $pid 城市的父ID，默认为 0
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getList($pid = 0) {
        if (!is_numeric($pid)) {
            return array();
        }
        if (!self::hasCache()) {
            return Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select(self::$pcas_fields)
                            ->from(self::$pcas_table)
                            ->where('pid = :pid', array(':pid' => $pid))
                            ->queryAll();
        }
        $id = __CLASS__ . '_' . __FUNCTION__ . '_pid_' . $pid;
        $cache = Yii::app()->getCache()->get($id);
        if ($cache) {
            return $cache;
        }
        $list = Yii::app()
                ->getDb()
                ->createCommand()
                ->select(self::$pcas_fields)
                ->from(self::$pcas_table)
                ->where('pid = :pid', array(':pid' => $pid))
                ->queryAll();
        if ($list) {
            $list = array_reduce($list, create_function('$array, $item', '$array[$item["code"]] = $item;return $array;'));
        }
        Yii::app()->getCache()->set($id, $list, 86400); //默认为86400(1天)
        return $list;
    }

    /**
     * 获取地址信息
     * @param int $code 城市路径信息
     * @param boolean $fullname 是否获取完整的名称，默认为 FALSE
     * @return array/false
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getOne($code, $fullname = false) {
        if (!is_numeric($code) || strlen($code) !== 6) {
            return false;
        }
        $item = false;
        if (!self::hasCache()) {
            $item = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select(self::$pcas_fields)
                    ->from(self::$pcas_table)
                    ->where('code = :code', array(':code' => $code))
                    ->queryRow();
        } else {
            $pid = 0;
            if (substr($code, 2, 4) == 0) {
                $pid = 0;
            } else if (substr($code, 4, 2) == 0) {
                $pid = substr($code, 0, 2) . '0000';
            } else {
                $pid = substr($code, 0, 4) . '00';
            }
            $list = self::getList($pid);
            if (isset($list[$code])) {
                $item = $list[$code];
            } else {
                $item = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select(self::$pcas_fields)
                        ->from(self::$pcas_table)
                        ->where('code = :code', array(':code' => $code))
                        ->queryRow();
            }
        }
        if ($item && $fullname) {
            $item['fullcode'] = array();
            $item['fullname'] = array();
            $superiors = array();
            if ($item['level'] == 2) {
                $superiors[] = self::getOne(substr($code, 0, 2) . '0000', false);
            } else if ($item['level'] == 3) {
                $superiors[] = self::getOne(substr($code, 0, 2) . '0000', false);
                $superiors[] = self::getOne(substr($code, 0, 4) . '00', false);
            }
            foreach ($superiors as $superior) {
                $item['fullcode'][] = $superior['code'];
                $item['fullname'][] = $superior['name'];
            }
            $item['fullcode'][] = $item['code'];
            $item['fullname'][] = $item['name'];
        }
        return $item;
    }

    /**
     * 获取地址名称
     * @param int $code 城市路径信息
     * @param boolean $fullname 是否获取完整的名称，默认为 FALSE
     * @param string $delimiter 分隔符，默认为空字符串，仅在 $fullname 为 TRUE 时有效
     * @return string
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function code2name($code, $fullname = false, $delimiter = '') {
        $item = self::getOne($code, $fullname);
        if ($item && isset($item['fullname'])) {
            return implode($delimiter, $item['fullname']);
        } else if ($item) {
            return $item['name'];
        }
        return '';
    }

}
