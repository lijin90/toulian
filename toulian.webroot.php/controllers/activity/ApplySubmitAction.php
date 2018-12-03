<?php

/**
 * 活动报名 - 报名提交（AJAX）
 * @author Changfeng Ji <jichf@qq.com>
 */
class ApplySubmitAction extends CAction {

    public function run() {
        $columns = array(
            'AID' => '',
            'Company' => '',
            'Name' => '',
            'EnterprisePosition' => '',
            'Phone' => '',
            'smsCode' => '',
            'Email' => '',
            'Wechat' => '',
            'ExtendField1' => '',
            'ExtendField2' => '',
            'ExtendField3' => ''
        );
        $allowedColumns = array_keys($columns);
        foreach ($allowedColumns as $allowColumn) {
            $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
        }
        if (empty($columns['AID'])) {
            Unit::ajaxJson(1, '报名失败');
        }
        $data = Activity::getActivity($columns['AID']);
        if (!$data) {
            Unit::ajaxJson(1, '禁止报名');
        } else if ($data['EndTime'] <= time() || !$data['LimitCount']) {
            Unit::ajaxJson(1, '禁止报名');
        } else if ($data['LimitCount']) {
            $applyCount = Yii::app()->getDb()
                    ->createCommand()
                    ->select('COUNT(*)')
                    ->from('t_activity_apply')
                    ->where('AID = :AID', array(':AID' => $columns['AID']))
                    ->queryScalar();
            if ($applyCount >= $data['LimitCount']) {
                Unit::ajaxJson(1, '报名人数已满');
            }
        }
        if (empty($columns['Company'])) {
            Unit::ajaxJson(1, '单位名称必须填写', array('Company' => '单位名称必须填写'));
        }
        if (empty($columns['Name'])) {
            Unit::ajaxJson(1, '姓名必须填写', array('Name' => '姓名必须填写'));
        } else if (mb_strlen($columns['Name'], 'utf-8') < 2) {
            Unit::ajaxJson(1, '姓名不能少于2个字', array('Name' => '姓名不能少于2个字'));
        }
        if (empty($columns['EnterprisePosition'])) {
            Unit::ajaxJson(1, '职务必须填写', array('EnterprisePosition' => '职务必须填写'));
        }
        if (empty($columns['Phone'])) {
            Unit::ajaxJson(1, '手机必须填写', array('Phone' => '手机必须填写'));
        } else if (!preg_match('/^1[3578][0-9]{9}$/', $columns['Phone'])) {
            Unit::ajaxJson(1, '手机格式错误', array('Phone' => '手机格式错误'));
        }
        $smsCodeSession = Yii::app()->getSession()->get('smsCode' . $columns['Phone']);
        if (empty($columns['smsCode'])) {
            Unit::ajaxJson(1, '手机验证码不能为空', array('smsCode' => '手机验证码不能为空'));
        } else if (empty($smsCodeSession)) {
            Unit::ajaxJson(1, '请先获取手机验证码', array('smsCode' => '请先获取手机验证码'));
        } else if ($columns['smsCode'] != $smsCodeSession) {
            Unit::ajaxJson(1, '手机验证码填写不正确', array('smsCode' => '手机验证码填写不正确'));
        }
        if (!empty($columns['Email']) && !preg_match('/^[\w\.\-]{1,26}@([\w\-]{1,20}\.){1,2}[a-z]{2,10}(\.[a-z]{2,10})?$/i', $columns['Email'])) {
            Unit::ajaxJson(1, '邮件格式错误', array('Email' => '邮件格式错误'));
        }
        if ($data['ExtendField1'] && empty($columns['ExtendField1'])) {
            Unit::ajaxJson(1, $data['ExtendField1'] . '必须填写', array('ExtendField2' => $data['ExtendField1'] . '必须填写'));
        }
        if ($data['ExtendField2'] && empty($columns['ExtendField2'])) {
            Unit::ajaxJson(1, $data['ExtendField2'] . '必须填写', array('ExtendField2' => $data['ExtendField2'] . '必须填写'));
        }
        if ($data['ExtendField3'] && empty($columns['ExtendField3'])) {
            Unit::ajaxJson(1, $data['ExtendField3'] . '必须填写', array('ExtendField3' => $data['ExtendField3'] . '必须填写'));
        }
        $apply = Yii::app()->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_activity_apply')
                ->where(array('and', 'AID = :AID', 'Phone = :Phone'), array(':AID' => $columns['AID'], ':Phone' => $columns['Phone']))
                ->queryRow();
        $applyId = $apply ? $apply['ID'] : Unit::stringGuid();
        $reset = Yii::app()->getRequest()->getPost('reset', '');
        if ($apply && $reset) {
            if ($apply['FeeState']) {
                Unit::ajaxJson(1, '您已报名并已缴费，不能修改');
            }
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->delete('t_activity_apply', array('and', 'AID = :AID', 'Phone = :Phone', 'FeeState = 0'), array(':AID' => $columns['AID'], ':Phone' => $columns['Phone']));
            if (!$rt) {
                Unit::ajaxJson(1, '报名失败，请重试');
            }
        } else if ($apply) {
            Yii::app()->getSession()->add('activityApplyId' . date('Ymd'), $apply['ID']);
            Unit::ajaxJson(0, '您已报名，无需重复报名', $apply['ID']);
        }
        $base_columns = array(
            'ID' => $applyId,
            'UID' => Unit::getLoggedUserId(),
            'AID' => $columns['AID'],
            'State' => 1,
            'Fee' => $data['ApplyFee'],
            'FeeState' => 0,
            'Company' => $columns['Company'],
            'Name' => $columns['Name'],
            'EnterprisePosition' => $columns['EnterprisePosition'],
            'Phone' => $columns['Phone'],
            'PhoneState' => 1,
            'Email' => $columns['Email'],
            'Wechat' => $columns['Wechat'],
            'ExtendField1' => $columns['ExtendField1'],
            'ExtendField2' => $columns['ExtendField2'],
            'ExtendField3' => $columns['ExtendField3'],
            'CreateTime' => time()
        );
        $rt = Yii::app()
                ->getDb()
                ->createCommand()
                ->insert('t_activity_apply', $base_columns);
        if ($rt) {
            Yii::app()->getSession()->remove('smsCode' . $columns['Phone']);
            Yii::app()->getSession()->remove('smsCodeTime' . $columns['Phone']);
            Yii::app()->getSession()->add('activityApplyId' . date('Ymd'), $base_columns['ID']);
            $url = Yii::app()->createAbsoluteUrl('wechatService/activity/applyPreview', array('activityApplyId' => $base_columns['ID']));
            $shortUrl = Yourls::shortUrl($url);
            if ($shortUrl && preg_match('/^1[3578][0-9]{9}$/', $base_columns['Phone'])) {
                $smsSubject = strtr($data['ApplySms'], array(
                    '{Title}' => $data['Title'],
                    '{Location}' => $data['Location'],
                    '{BeginTime}' => date('Y-m-d H:i', $data['BeginTime']),
                    '{EndTime}' => date('Y-m-d H:i', $data['EndTime']),
                    '{Name}' => $base_columns['Name'],
                    '{Link}' => $shortUrl
                ));
                $sendStat = SmsHelperKT::sendSMS($base_columns['Phone'], $smsSubject);
                Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->insert('t_sms_log', array(
                            'UID' => Unit::getLoggedUserId(),
                            'Type' => 1,
                            'Subject' => $smsSubject,
                            'PhoneList' => $base_columns['Phone'],
                            'PhoneCount' => 1,
                            'Status' => $sendStat ? 2 : 1,
                            'StatusText' => json_encode(SmsHelperKT::$sendResult, JSON_UNESCAPED_UNICODE),
                            'Tag' => '投联活动报名',
                            'CreateTime' => time()
                ));
            }
            Unit::ajaxJson(0, '报名成功', $base_columns['ID']);
        } else {
            Unit::ajaxJson(1, '报名失败');
        }
    }

}
