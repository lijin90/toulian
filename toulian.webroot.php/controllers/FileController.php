<?php

/**
 * 文件控件
 * @author Changfeng Ji <jichf@qq.com>
 */
class FileController extends Controller {

    /**
     * 上传图片
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionUploadImage() {
        $code = 10000;
        $msg = '上传失败';
        $data = array();
        $type = Yii::app()->getRequest()->getParam('type', '');
        $path = FileUploadHelper::getFilePath($type, true);
        if (!$type) {
            $code = 10001;
            $msg = '类型不能为空';
            echo CJSON::encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
            Yii::app()->end();
        }
        $file = CUploadedFile::getInstanceByName('file');
        $rule = FileUploadHelper::$RULE_IMAGE_Required;
        if ($type == 'protocols') {
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'jpg, png, doc, docx, xls, xlsx, pdf',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
            );
        } else if ($type == 'mms') {
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'jpg, gif',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
            );
        } else if ($type == 'im') {
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'jpg, png, gif',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。',
                'maxSize' => 10 * 1024 * 1024,
                'tooLarge' => '文件“{file}”太大，不能超过10MB。',
            );
        } else if ($type == 'resumes') {
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'jpg, png, doc, docx, pdf',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
            );
        }
        $errors = FileUploadHelper::validateUploadedFile($file, $rule);
        if (!$errors) {
            $filePath = FileUploadHelper::saveUploadedFile($file, $path);
            if ($filePath) { //上传成功
                $code = 0;
                $msg = '';
                $data['name'] = $file->getName();
                $data['ext'] = $file->getExtensionName();
                $data['type'] = $file->getType();
                $data['size'] = $file->getSize();
                $data['path'] = $filePath;
                $data['url'] = FileUploadHelper::getFileUrl($filePath, $type);
            } else { //保存失败
                $code = 10003;
                $msg = '文件保存失败';
            }
        } else { //验证失败
            $code = 10002;
            $msg = array_shift($errors);
        }
        echo CJSON::encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
        Yii::app()->end();
    }

    /**
     * 获取文件信息
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionInfo() {
        $path = Yii::app()->getRequest()->getParam('path', '');
        $type = Yii::app()->getRequest()->getParam('type', 'images');
        if (!$path) {
            Unit::ajaxJson(1, '路径不能为空');
        }
        $info = FileHelper::fileInfo(FileUploadHelper::getFilePath($type, true) . $path);
        if ($info) {
            Unit::ajaxJson(0, '', $info);
        } else {
            Unit::ajaxJson(1, '获取失败');
        }
    }

    /**
     * 调整图片的尺寸（宽高）
     * 
     * 调整图片的尺寸尽可能接近给定的尺寸，然后从中心裁切
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionResizeImage() {
        $path = Yii::app()->getRequest()->getParam('path', '');
        $type = Yii::app()->getRequest()->getParam('type', 'images');
        $width = Yii::app()->getRequest()->getParam('width', 0);
        $height = Yii::app()->getRequest()->getParam('height', 0);
        $redirect = Yii::app()->getRequest()->getParam('redirect', '');
        $info = null;
        if (!$path) {
            echo '';
            Yii::app()->end();
        }
        if (!$width || !$height) {
            $info = FileHelper::imageInfo(FileUploadHelper::getFilePath($type, true) . $path);
        }
        if ($info && $width) {
            $height = $width / ($info['width'] / $info['height']);
        } else if ($info && $height) {
            $width = $height * ($info['width'] / $info['height']);
        }
        $url = FileUploadHelper::getFileUrl($path, $type, $width, $height);
        if ($redirect) {
            $this->redirect($url);
        } else {
            echo $url;
        }
    }

}
