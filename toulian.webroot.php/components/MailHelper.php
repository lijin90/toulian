<?php

/**
 * 发送邮件帮助类（需要下载 mailer 扩展）
 * @link http://www.yiiframework.com/extension/mailer
 * @author Changfeng Ji <jichf@qq.com>
 */
class MailHelper {

    public static $Host = 'smtp.126.com';
    public static $Port = 25;
    public static $SMTPAuth = true;
    public static $Username = 'toulianwang@126.com';
    public static $Password = 'tlwtlw123456';
    public static $FromAddress = 'toulianwang@126.com';
    public static $FromName = '投联网';
    public static $CharSet = 'UTF-8';
    public static $IsHTML = true;

    /**
     * 通过SMTP发送邮件
     * @param array $Addresses 收件人数组列表，每个数组元素的键为邮件地址，值为显示名称。示例：array('519210348@qq.com' => 'Coco', 'jichf@qq.com' => 'Changfeng')
     * @param string $Subject Sets the Subject of the message.
     * @param string $AltBody Sets the text-only body of the message.
     *  This automatically sets the email to multipart/alternative.
     *  This body can be read by mail clients that do not have HTML email capability such as mutt.
     *  Clients that can read HTML will view the normal Body.
     * @param string $Body Sets the Body of the message. This can be either an HTML or text body. If HTML then run IsHTML(true).
     * @param array $Attachments Each element is still a array with one to four elements($path[, $name, $encoding, $type]):
     *   - $path(string) Path to the attachment.
     *   - $name(string) Overrides the attachment name.
     *   - $encoding(string) File encoding. Options for this are "8bit", "7bit", "binary", "base64", and "quoted-printable".
     *   - $type(string) File extension (MIME) type.
     * @return boolean/string 发送成功返回TRUE, 否则返回错误信息字符串
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function SMTPSend($Addresses = array(), $Subject = '', $AltBody = '', $Body = '', $Attachments = array()) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->IsSMTP();
        $mailer->Host = self::$Host;
        $mailer->Port = self::$Port;
        $mailer->SMTPAuth = self::$SMTPAuth;
        $mailer->Username = self::$Username;
        $mailer->Password = self::$Password;
        $mailer->CharSet = self::$CharSet;
        $mailer->IsHTML(self::$IsHTML);
        $mailer->SetFrom(self::$FromAddress, self::$FromName);
        $mailer->AddReplyTo(self::$FromAddress, self::$FromName);
        foreach ($Addresses as $address => $name) {
            $mailer->AddAddress($address, $name);
        }
        $mailer->Subject = $Subject;
        $mailer->AltBody = $AltBody;
        if (self::$IsHTML) {
            $Body = preg_replace('/\\\\/', '', $Body); //Strip backslashes
            $mailer->MsgHTML($Body);
        } else {
            $mailer->Body = $Body;
        }
        foreach ($Attachments as $attach) {
            if (is_array($attach) && isset($attach[0]) && is_file($attach[0])) {
                if (!isset($attach[1])) {
                    $mail->AddAttachment($attach[0]);
                } else if (!isset($attach[2])) {
                    $mail->AddAttachment($attach[0], $attach[1]);
                } else if (!isset($attach[3])) {
                    $mail->AddAttachment($attach[0], $attach[1], $attach[2]);
                } else {
                    $mail->AddAttachment($attach[0], $attach[1], $attach[2], $attach[3]);
                }
            }
        }
        ob_start();
        $result = $mailer->Send();
        ob_end_clean();
        if ($result) {
            return true;
        } else {
            return $mailer->ErrorInfo;
        }
    }

}
