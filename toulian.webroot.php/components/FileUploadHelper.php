<?php

/**
 * FileUploadHelper class.
 * @author Changfeng Ji <jichf@qq.com>
 */
class FileUploadHelper extends CFormModel {

    public static $RULE_IMAGE_Optional = array('attach', 'file',
        'allowEmpty' => true,
        'message' => '{attribute}必须上传',
        'types' => 'jpg, png, gif',
        'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
    );
    public static $RULE_IMAGE_Required = array('attach', 'file',
        'allowEmpty' => false,
        'message' => '{attribute}必须上传',
        'types' => 'jpg, png, gif',
        'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
    );

    /**
     * 获取文件保存路径
     * @param string $type 路径类型:
     *  - images: 图片
     *  - audios: 音频
     *  - videos: 视频
     *  - ............
     * @param boolean $local 是否为本地路径，默认为FALSE（即默认URL路径）
     * @return string 返回文件保存路径，错误则返回空
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getFilePath($type, $local = false) {
        $path = '';
        $webroot = Yii::getPathOfAlias('webroot');
        $baseUrl = Yii::app()->getBaseUrl(true);
        switch ($type) {
            case 'images':
                $baseUrl = YII_DEBUG ? $baseUrl : Yii::app()->params['imageUrl'];
                $path = ($local ? $webroot : $baseUrl) . '/upload/images';
                break;
            case 'audios':
                $path = ($local ? $webroot : $baseUrl) . '/upload/audios';
                break;
            case 'videos':
                $path = ($local ? $webroot : $baseUrl) . '/upload/videos';
                break;
            default :
                $path = ($local ? $webroot : $baseUrl) . '/upload/' . $type;
                break;
        }
        return $path;
    }

    /**
     * 获取文件URL路径（支持压缩图片）
     * 
     * 注：压缩图片需引入 EPhpThumb 扩展。
     * @access public
     * @static
     * @param string $path 文件相对路径
     * @param string $type 路径类型，默认为 images
     * @param int $width 压缩图片的宽度，仅对图片文件有效。默认为 0，表示不压缩图片
     * @param string $height 压缩图片的高度，仅对图片文件有效。默认为 0，表示不压缩图片
     * @return string 返回文件URL路径，错误则返回空
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getFileUrl($path, $type = 'images', $width = 0, $height = 0) {
        if (!$path) {
            return '';
        }
        if ($width > 0 && $height > 0) {
            $localpath = FileUploadHelper::getFilePath($type, true);
            $filepath = FileUploadHelper::getFilePath($type);
            $ext = FileHelper::getExtension($path);
            $filename = FileHelper::getFileName($path);
            if (!in_array($ext, array('jpg', 'png', 'gif')) || !is_file($localpath . $path)) {
                return $filepath . $path;
            }
            $newpath = dirname($path) . '/' . $filename . '_' . $width . 'x' . $height . '.' . $ext;
            if (is_file($localpath . '_thumb' . $newpath)) {
                return $filepath . '_thumb' . $newpath;
            }
            if (!is_dir(dirname($localpath . '_thumb' . $newpath))) {
                FileHelper::createDirectory(dirname($localpath . '_thumb' . $newpath), 0777, true);
            }
            if (!Yii::app()->hasComponent('phpThumb')) {
                Yii::app()->setComponent('phpThumb', array('class' => 'ext.EPhpThumb.EPhpThumb'));
            }
            $thumb = Yii::app()->phpThumb->create($localpath . $path);
            $thumb->adaptiveResize($width, $height);
            $thumb->save($localpath . '_thumb' . $newpath, $ext);
            return $filepath . '_thumb' . $newpath;
        }
        return FileUploadHelper::getFilePath($type) . $path;
    }

    /**
     * 
     * @param CUploadedFile $file
     * @param array $rule
     * @return array errors for the file. Empty array is returned if no error.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function validateUploadedFile($file, $rule) {
        $fm = new FileUploadFormModelHelper();
        $fm->attach = $file;
        $fm->setRule($rule);
        $fm->validate();
        return $fm->getErrors('attach');
    }

    /**
     * 
     * @param CUploadedFile $file
     * @param string $path
     * @return string The path for the uploaded file. FALSE is returned if failed.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function saveUploadedFile($file, $path) {
        if (!($file instanceof CUploadedFile)) {
            return false;
        }
        $time = time();
        $now = date('Ymd', $time);
        $targetPath = $path . '/' . $now;
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $fileName = date('YmdHis', $time) . '_' . rand(10000, 99999) . '.' . strtolower($file->getExtensionName());
        $filePath = $targetPath . '/' . $fileName;
        if ($file->saveAs($filePath)) {
            return '/' . $now . '/' . $fileName;
        }
        return false;
    }

}

class FileUploadFormModelHelper extends CFormModel {

    private $rule;

    public function setRule($rule) {
        $this->rule = $rule;
    }

    public $attach;

    public function rules() {
        return array(
            $this->rule
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'attach' => '附件'
        );
    }

}
