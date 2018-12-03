<?php

/**
 * FileHelper class.
 * 
 * 常用函数: 
 *  - file_get_contents() 函数把整个文件读入一个字符串中。
 *  - file_put_contents() 函数把一个字符串写入文件中。
 *  - mkdir() 函数创建目录。
 *  - rmdir() 函数删除空的目录。
 *  - unlink() 函数删除文件。
 *  - copy() 函数拷贝文件。
 *  - rename() 函数重命名文件或目录。
 *  - is_dir() 函数检查指定的文件是否是目录。
 *  - is_file() 函数检查指定的文件名是否是正常的文件。
 *  - is_link() 函数判断指定文件名是否为一个符号连接。
 *  - is_executable() 函数检查指定的文件是否可执行。
 *  - is_readable() 函数判断指定文件名是否可读。
 *  - is_writable() 函数判断指定的文件是否可写。
 *  - is_writeable() 函数判断指定的文件是否可写。
 *  - is_uploaded_file() 函数判断指定的文件是否是通过 HTTP POST 上传的。
 *  - move_uploaded_file() 函数将上传的文件移动到新位置。
 *  - file_exists() 函数检查文件或目录是否存在。
 *  - filesize() 函数返回指定文件的大小。
 *  - pathinfo() 函数以数组的形式返回文件路径的信息。
 *  - realpath() 函数返回绝对路径。
 *  - dirname() 函数返回路径中的目录部分。
 *  - basename() 函数返回路径中的文件名部分。
 * @author Changfeng Ji <jichf@qq.com>
 */
class FileHelper extends CFileHelper {

    public static function createDirectory($dst, $mode = null, $recursive = false) {
        return parent::createDirectory($dst, $mode, $recursive);
    }

    public static function removeDirectory($directory, $options = array()) {
        parent::removeDirectory($directory, $options);
    }

    public static function copyDirectory($src, $dst, $options = array()) {
        parent::copyDirectory($src, $dst, $options);
    }

    public static function findFiles($dir, $options = array()) {
        return parent::findFiles($dir, $options);
    }

    public static function getExtension($path) {
        return parent::getExtension($path);
    }

    public static function getExtensionByMimeType($file, $magicFile = null) {
        return parent::getExtensionByMimeType($file, $magicFile);
    }

    public static function getMimeType($file, $magicFile = null, $checkExtension = true) {
        return parent::getMimeType($file, $magicFile, $checkExtension);
    }

    public static function getMimeTypeByExtension($file, $magicFile = null) {
        return parent::getMimeTypeByExtension($file, $magicFile);
    }

    /**
     * Returns the dir part of a file path.
     * For example, the path "path/to/something.php" would return "path/to".
     * @access public
     * @static
     * @param string $path the file path
     * @return string the dir part of a file path.
     * @see dirname() return the dir part of a file path.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getDirName($path) {
        return pathinfo($path, PATHINFO_DIRNAME);
    }

    /**
     * Returns the file name of a file path.
     * For example, the path "path/to/something.php" would return "something".
     * @access public
     * @static
     * @param string $path the file path
     * @return string the file name without the extension name.
     * @see basename() return the file name with the extension name.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getFileName($path) {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    /**
     * 高效率计算文件行数
     * @param string $file 文件的路径
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function countLine($file) {
        $fp = fopen($file, "rb");
        $i = 0;
        while (!feof($fp)) {
            //每次读取2M
            if ($data = fread($fp, 1024 * 1024 * 2)) {
                //计算读取到的行数
                $num = substr_count($data, "\n");
                $i += $num;
            }
        }
        fclose($fp);
        return $i;
    }

    /**
     * 获取文件信息，包括:
     *  - file_size: 文件大小（单位：字节）
     *  - file_size_format: 格式化的文件大小
     *  - last_access_time: 文件最后访问时间
     *  - last_modified_time: 文件最后修改时间
     *  - pathinfo: 文件路径信息，包括 dirname、basename、extension、filename
     * @param string $file 文件的路径
     * @return array|boolean 执行成功则返回文件信息，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function fileInfo($file) {
        if (!is_file($file)) {
            return false;
        }
        $info = array();
        $info['file_size'] = filesize($file);
        $info['file_size_format'] = FileHelper::formatSize($info['file_size']);
        $info['last_access_time'] = fileatime($file);
        $info['last_modified_time'] = filemtime($file);
        $info['pathinfo'] = pathinfo($file);
        return $info;
    }

    /**
     * 获取图像文件信息，包括:
     *  - width: 图像宽度
     *  - height: 图像高度
     * @param string $file 图像文件的路径，支持 jpg png gif 格式的文件
     * @return array|boolean 执行成功则返回图像文件信息，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function imageInfo($file) {
        if (!is_file($file)) {
            return false;
        }
        $extFile = FileHelper::getExtension($file);
        $im = false;
        if ($extFile == 'jpg') {
            $im = imagecreatefromjpeg($file);
        } else if ($extFile == 'png') {
            $im = imagecreatefrompng($file);
        } else if ($extFile == 'gif') {
            $im = imagecreatefromgif($file);
        } else {
            return false;
        }
        $info = array();
        $info['width'] = imagesx($im);
        $info['height'] = imagesy($im);
        imagedestroy($im);
        return $info;
    }

    /**
     * 图像文件添加水印
     * @param string $file 图像文件的路径，支持 jpg png gif 格式的文件
     * @param string $watermark 水印图像文件的路径，支持 jpg png gif 格式的文件
     * @param string $output 添加水印后图像文件的输出路径，支持 jpg png gif 格式的文件，仅在执行成功后才会输出
     * @return boolean 执行成功则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function imageWatermark($file, $watermark, $output) {
        if (!is_file($file) || !is_file($watermark)) {
            return false;
        }
        $extFile = FileHelper::getExtension($file);
        $im = false;
        if ($extFile == 'jpg') {
            $im = imagecreatefromjpeg($file);
        } else if ($extFile == 'png') {
            $im = imagecreatefrompng($file);
        } else if ($extFile == 'gif') {
            $im = imagecreatefromgif($file);
        } else {
            return false;
        }
        $extWatermark = FileHelper::getExtension($watermark);
        $wk = false;
        if ($extWatermark == 'jpg') {
            $wk = imagecreatefromjpeg($watermark);
        } else if ($extWatermark == 'png') {
            $wk = imagecreatefrompng($watermark);
        } else if ($extWatermark == 'gif') {
            $wk = imagecreatefromgif($watermark);
        } else {
            return false;
        }
        $imWidth = imagesx($im);
        $imHeight = imagesy($im);
        $wkWidth = imagesx($wk);
        $wkHeight = imagesy($wk);
        if (!$imWidth || !$imHeight || !$wkWidth || !$wkHeight) {
            return false;
        }
        if (!imagecopy($im, $wk, $imWidth - $wkWidth, $imHeight - $wkHeight, 0, 0, $wkWidth, $wkHeight)) {
            return false;
        }
        $extOutput = FileHelper::getExtension($output);
        if ($extOutput == 'jpg') {
            return imagejpeg($im, $output, 100);
        } else if ($extOutput == 'png') {
            return imagepng($im, $output);
        } else if ($extOutput == 'gif') {
            return imagegif($im, $output);
        } else {
            return false;
        }
    }

    /**
     * 图像文件转化为base64编码
     * @param string $file 图像文件的路径
     * @return string 返回图像文件的base64编码，失败则返回空字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function imageToBase64($file) {
        if (!is_file($file)) {
            return '';
        }
        $mimeType = self::getMimeType($file);
        if (!$mimeType) {
            return '';
        }
        $data = file_get_contents($file);
        if (!$data) {
            return '';
        }
        $base64 = base64_encode($data);
        //$base64 = chunk_split($base64);
        return "data:{$mimeType};base64," . $base64;
    }

    /**
     * base64字符串转化为图像文件
     * @param string $base64 图像文件的base64字符串
     * @param string $filePath 保存图像文件的目录
     * @param string $fileName 保存图像文件的名称
     * @return string 返回保存图像文件的路径，失败则返回空字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function base64ToImage($base64, $filePath, $fileName) {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)) {
            if (!isset($result[2])) {
                return '';
            } else if ($result[2] == 'jpeg') {
                $result[2] = 'jpg';
            }
            $file = $filePath . '/' . $fileName . '.' . $result[2];
            $data = str_replace($result[1], '', $base64);
            //$data = str_replace(' ', '+', $data);
            $data = base64_decode($data);
            if (file_put_contents($file, $data)) {
                return $file;
            }
        }
        return '';
    }

    /**
     * Convert shorthand php.ini notation into bytes, much like how the PHP source does it
     * @access public
     * @static
     * @param string $val {文件尺寸[数值g|G|m|M|k|K]}.
     * @return int 字节数
     * @link http://pl.php.net/manual/en/function.ini-get.php
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function returnBytes($val) {
        $val = trim($val);
        if (!$val) {
            return 0;
        }
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }

    /**
     * Parses a given byte count.
     * @param string/int $size A size expressed as a number of bytes with optional SI or IEC binary unit
     *   prefix (e.g. 2, 3K, 5MB, 10G, 6GiB, 8 bytes, 9mbytes).
     * @return int An integer representation of the size in bytes.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function parseSize($size) {
        $kilobyte = 1024;
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow($kilobyte, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    /**
     * Generates a string representation for the given byte count.
     * @param int $size A size in bytes.
     * @return string A translated string representation of the size.
     */
    public static function formatSize($size) {
        $kilobyte = 1024;
        if ($size < $kilobyte) {
            return $size . ' bytes';
        } else {
            $size = $size / $kilobyte; // Convert bytes to kilobytes.
            $units = array('@size KB', '@size MB', '@size GB', '@size TB', '@size PB', '@size EB', '@size ZB', '@size YB');
            foreach ($units as $unit) {
                if (round($size, 2) >= $kilobyte) {
                    $size = $size / $kilobyte;
                } else {
                    break;
                }
            }
            return str_replace('@size', round($size, 2), $unit);
        }
    }

    /**
     *
     * @access public
     * @static
     * @param string $url The url.
     * @param mixed $post <p>
     * May be an array or object containing properties.
     * </p>
     * <p>
     * If <i>query_data</i> is an array, it may be a simple
     * one-dimensional structure, or an array of arrays (which in
     * turn may contain other arrays).
     * </p>
     * <p>
     * If <i>query_data</i> is an object, then only public
     * properties will be incorporated into the result.
     * </p>
     * @return string The function returns the read data or FALSE on failure.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function PostUrl($url, $post = array()) {
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => http_build_query($post),
                'timeout' => 15 * 60 // timeout(unit:s)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    /**
     *
     * @access public
     * @static
     * @param string $url The url.
     * @param array $get
     * @return string The function returns the read data or FALSE on failure.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function GetUrl($url, $get = array()) {
        $newget = array();
        foreach ($get as $key => $value) {
            $newget[] = $key . '=' . $value;
        }
        $result = file_get_contents($url . '?' . implode('&', $newget));
        return $result;
    }

}
