<?php

/**
 * 图片验证码。示例如下: 
 *  - $ic = new ImageCode(80, 30, 4); //实例化
 *  - $_SESSION['code'] = $ic->getCode(); //获取验证码字符串，存储到服务器空间里（比如Session存储）
 *  - $ic->outImg(); //输出验证码图片
 * @author Changfeng Ji <jichf@qq.com>
 */
class ImageCode {

    /**
     * 图片宽度
     * @var int
     */
    private $width;

    /**
     * 图片高度
     * @var int
     */
    private $height;

    /**
     * 验证码字符数量
     * @var int
     */
    private $num;

    /**
     * 验证码字符字体文件（.gdf）
     * @var string
     */
    private $font;

    /**
     * 验证码字符串
     * @var string
     */
    private $code;

    /**
     * 验证码图片
     * @var resource
     */
    private $img;

    /**
     * 图片验证码构造函数
     * @param int $width 图片宽度
     * @param int $height 图片高度
     * @param int $num 验证码字符数量
     * @param string $font 验证码字符字体文件（.gdf）
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function __construct($width = 80, $height = 30, $num = 4, $font = '') {
        $this->width = $width;
        $this->height = $height;
        $this->num = $num;
        $this->font = $font;
        $this->code = $this->createCode();
    }

    /**
     * 自动销毁图像资源
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function __destruct() {
        imagedestroy($this->img);
    }

    /**
     * 生成验证码字符串
     * @return string 验证码字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function createCode() {
        $codes = "ABCDEFGHKLMNPRSTUVWYZabcdefghkmnprstuvwyz23456789";
        $code = "";
        for ($i = 0; $i < $this->num; $i++) {
            $code .= $codes{rand(0, strlen($codes) - 1)};
        }
        return $code;
    }

    /**
     * 获取验证码字符串
     * @return string 验证码字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * 输出验证码图片
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function outImg() {
        //创建背景（颜色、大小、边框）
        $this->createBack();
        //画字（大小、字体颜色）
        $this->outString();
        //设置干扰元素（点、线条）
        $this->setDisturbColor();
        //输出图像
        $this->printImg();
    }

    /**
     * 创建背景（颜色、大小、边框）
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function createBack() {
        //创建资源
        $this->img = imagecreatetruecolor($this->width, $this->height);
        //设置背景填充，使用随机的背景颜色
        $bgcolor = imagecolorallocate($this->img, rand(225, 255), rand(225, 255), rand(225, 255));
        imagefill($this->img, 0, 0, $bgcolor);
        //画边框，使用黑色
        $bordercolor = imagecolorallocate($this->img, 0, 0, 0);
        imagerectangle($this->img, 0, 0, $this->width - 1, $this->height - 1, $bordercolor);
    }

    /**
     * 画字（大小、字体颜色）
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function outString() {
        for ($i = 0; $i < $this->num; $i++) {
            $color = imagecolorallocate($this->img, rand(0, 128), rand(0, 128), rand(0, 128));
            if ($this->font && is_file($this->font)) {
                $font = imageloadfont($this->font);
            } else {
                $font = rand(3, 5);
            }
            $x = 3 + ($this->width / $this->num) * $i; //水平位置
            $y = rand(0, imagefontheight($font) - 3);
            //画出每个字符
            imagechar($this->img, $font, $x, $y, $this->code{$i}, $color);
        }
    }

    /**
     * 设置干扰元素（点、线条）
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function setDisturbColor() {
        //加上点数
        for ($i = 0; $i < 60; $i++) {
            $color = imagecolorallocate($this->img, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($this->img, rand(1, $this->width - 2), rand(1, $this->height - 2), $color);
        }
        //加线条
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocate($this->img, rand(0, 255), rand(0, 128), rand(0, 255));
            imagearc($this->img, rand(-10, $this->width + 10), rand(-10, $this->height + 10), rand(30, 300), rand(30, 300), 55, 44, $color);
        }
    }

    /**
     * 输出图像
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function printImg() {
        if (imagetypes() & IMG_GIF) {
            header("Content-type: image/gif");
            imagegif($this->img);
        } elseif (imagetypes() & IMG_PNG) {
            header("Content-type: image/png");
            imagepng($this->img);
        } elseif (function_exists("imagejpeg")) {
            header("Content-type: image/jpeg");
            imagejpeg($this->img);
        } else {
            die("No image support in this PHP server");
        }
    }

}
