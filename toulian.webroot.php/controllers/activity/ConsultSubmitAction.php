<?php

/**
 * 活动咨询 - 咨询提交（AJAX）
 * @author Changfeng Ji <jichf@qq.com>
 */
class ConsultSubmitAction extends CAction {

    public function run() {
        $columns = array('AID' => '', 'Content' => '', 'RealName' => '', 'Mobile' => '');
        $allowedColumns = array_keys($columns);
        foreach ($allowedColumns as $allowColumn) {
            $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
        }
        if (empty($columns['AID'])) {
            Unit::ajaxJson(1, '提交失败');
        }
        if (empty($columns['Content'])) {
            Unit::ajaxJson(1, '内容必须填写');
        }
        if (empty($columns['Mobile'])) {
            Unit::ajaxJson(1, '手机号必须填写');
        } else if (!preg_match('/^1[3578][0-9]{9}$/', $columns['Mobile'])) {
            Unit::ajaxJson(1, '手机号格式错误');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('a.*')
                ->from('t_activity a')
                ->where('a.ID = :ID', array(':ID' => $columns['AID']))
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '提交失败');
        } else if (!$data['Mobile']) {
            Unit::ajaxJson(1, '提交失败');
        }
        $subjects = array();
        $subjects[] = '活动：' . $data['Title'];
        if ($columns['RealName']) {
            $subjects[] = '姓名：' . $columns['RealName'];
        }
        $subjects[] = '手机：' . $columns['Mobile'];
        $subjects[] = '咨询：' . $columns['Content'];
        $subject = implode('；', $subjects) . "【投联活动咨询】";
        $sendStat = SmsHelperKT::sendSMS($data['Mobile'], $subject);
        Yii::app()
                ->getDb()
                ->createCommand()
                ->insert('t_sms_log', array(
                    'UID' => Unit::getLoggedUserId(),
                    'Type' => 1,
                    'Subject' => $subject,
                    'PhoneList' => $data['Mobile'],
                    'PhoneCount' => 1,
                    'Status' => $sendStat ? 2 : 1,
                    'StatusText' => json_encode(SmsHelperKT::$sendResult, JSON_UNESCAPED_UNICODE),
                    'Tag' => '投联活动咨询',
                    'CreateTime' => time()
        ));
        if ($sendStat) {
            Unit::ajaxJson(0, '提交成功');
        } else {
            Unit::ajaxJson(1, '提交失败');
        }
    }

}
