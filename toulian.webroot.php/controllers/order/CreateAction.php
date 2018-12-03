<?php

/**
 * 创建订单
 * @author Changfeng Ji <jichf@qq.com>
 */
class CreateAction extends CAction {

    public function run() {
        $type = Yii::app()->getRequest()->getPost('type');
        $typeId = Yii::app()->getRequest()->getPost('typeId');
        switch ($type) {
            case 'activity_apply'://活动报名
                $this->activityApply($typeId);
                break;
            default:
                Unit::ajaxJson(1, '订单类型不存在');
                break;
        }
    }

    /**
     * 创建订单 - 活动报名
     * @param string $typeId 订单类型ID
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function activityApply($typeId) {
        $type = 'activity_apply';
        if (!$typeId) {
            Unit::ajaxJson(1, '订单类型标识不能为空');
        }
        $activityApply = Activity::getActivityApply($typeId);
        if (!$activityApply) {
            Unit::ajaxJson(1, '报名记录不存在');
        } else if ($activityApply['Fee'] <= 0) {
            Unit::ajaxJson(1, '报名费用为 0，无需支付');
        } else if ($activityApply['FeeState'] == 1) {
            Unit::ajaxJson(1, '报名已缴费，无需重复缴费');
        }
        $activity = Activity::getActivity($activityApply['AID']);
        if (!$activity) {
            Unit::ajaxJson(1, '报名对象不存在');
        }
        $order = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_order')
                ->where(array('and', 'Type = :Type', 'TypeID = :TypeID'), array(':Type' => $type, ':TypeID' => $typeId))
                ->queryRow();
        if ($order) {
            Unit::ajaxJson(0, '订单记录已存在', $order);
        }
        $columns = array(
            'ID' => Unit::stringGuid(),
            'Type' => $type,
            'TypeID' => $typeId,
            'Subject' => $activity['TypeName'] . '报名缴费 - ' . $activity['Title'],
            'Body' => '',
            'TotalFee' => $activityApply['Fee'],
            'TradeMethod' => '',
            'TradeNo' => '',
            'TradeStatus' => 0,
            'TradeMemo' => '',
            'CreateTime' => time()
        );
        $rt = Yii::app()->getDb()->createCommand()->insert('t_order', $columns);
        if ($rt) {
            Unit::ajaxJson(0, '', $columns);
        }
        Unit::ajaxJson(1, '请求失败');
    }

}
