<?php

/**
 * 短信
 * @author Changfeng Ji <jichf@qq.com>
 */
class SmsController extends Controller {

    /**
     * 发送手机验证码（AJAX）
     * @param int $mobile 手机号码
     * @param string $usage 用途，包括:
     *  - default: 用于默认验证
     *  - register: 用于注册账户验证
     *  - login: 用于登录账户验证
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionSendCode($mobile, $usage = 'default') {
        if (!$mobile) {
            Unit::ajaxJson(1, '手机号码不能为空');
        } else if (!preg_match('/^1[3578][0-9]{9}$/', $mobile)) {
            Unit::ajaxJson(1, '手机号码格式错误');
        }
        switch ($usage) {
            case 'default':
                $this->sendCodeDefault($mobile);
                break;
            case 'register':
                $exist = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('ID')
                        ->from('t_user')
                        ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $mobile, ':MobileIsValid' => $mobile))
                        ->queryScalar();
                if ($exist) {
                    Unit::ajaxJson(1, '该手机号码已绑定其他账户');
                }
                $this->sendCodeDefault($mobile);
                break;
            case 'login':
                $exist = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('ID')
                        ->from('t_user')
                        ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $mobile, ':MobileIsValid' => $mobile))
                        ->queryScalar();
                if (!$exist) {
                    Unit::ajaxJson(1, '该手机号码未绑定任何账户');
                }
                $this->sendCodeDefault($mobile);
                break;
            default:
                Unit::ajaxJson(1, '未知用途');
                break;
        }
    }

    private function sendCodeDefault($mobile) {
        $time = time();
        $smsCodeTime = Yii::app()->getSession()->get('smsCodeTime' . $mobile);
        $smsCodeCount = Yii::app()->getSession()->get('smsCodeCount' . $mobile . date('Ymd', $time));
        if ($smsCodeTime && $smsCodeTime + 60 > $time) {
            Unit::ajaxJson(1, '请求过于频繁，请稍后');
        } else if ($smsCodeCount && $smsCodeCount >= 5) {
            Unit::ajaxJson(1, '验证码发送次数超过当日最大次数，请明天再试');
        }
        $smsCode = rand(100000, 999999);
        if (SMSHelper::SendVerificationCode($mobile, $smsCode)) {
            Yii::app()->getSession()->add('smsCode' . $mobile, $smsCode);
            Yii::app()->getSession()->add('smsCodeTime' . $mobile, $time);
            Yii::app()->getSession()->add('smsCodeCount' . $mobile . date('Ymd', $time), is_numeric($smsCodeCount) ? $smsCodeCount + 1 : 1);
            Unit::ajaxJson(0, '验证码已发送');
        } else {
            Unit::ajaxJson(1, '发送失败，请重试');
        }
    }

}
