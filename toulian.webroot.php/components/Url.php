<?php

/**
 * 公用网址类库
 * @author Changfeng Ji <jichf@qq.com>
 */
class Url {

    /**
     * @return string 图片的路径
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function imageUrl() {
        $baseUrl = Yii::app()->getBaseUrl();
        $baseUrl = YII_DEBUG ? $baseUrl : Yii::app()->params['imageUrl'];
        return $baseUrl . '/images';
    }

    /**
     * @return string CSS 的路径
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function cssUrl() {
        $baseUrl = Yii::app()->getBaseUrl();
        $baseUrl = YII_DEBUG ? $baseUrl : Yii::app()->params['imageUrl'];
        return $baseUrl . '/css';
    }

    /**
     * @return string JavaScript 的路径
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function jsUrl() {
        $baseUrl = Yii::app()->getBaseUrl();
        $baseUrl = YII_DEBUG ? $baseUrl : Yii::app()->params['imageUrl'];
        return $baseUrl . '/js';
    }

    /**
     * @return string 上传文件的路径
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function uploadUrl() {
        $baseUrl = Yii::app()->getBaseUrl();
        $baseUrl = YII_DEBUG ? $baseUrl : Yii::app()->params['imageUrl'];
        return $baseUrl . '/upload';
    }

}
