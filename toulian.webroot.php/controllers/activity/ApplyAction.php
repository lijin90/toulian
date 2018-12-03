<?php

/**
 * 活动报名 - 填写报名信息
 * @author Changfeng Ji <jichf@qq.com>
 */
class ApplyAction extends CAction {

    public function run() {
        $id = Yii::app()->getRequest()->getQuery('acId');
        $activityApplyId = Yii::app()->getRequest()->getQuery('activityApplyId');
        $activityApplyId = $activityApplyId ? $activityApplyId : Yii::app()->getSession()->get('activityApplyId' . date('Ymd'));
        $activity = Activity::getActivity($id);
        if (!$activity) {
            $this->getController()->redirect(Yii::app()->createUrl('activity/index'));
        } else if ($activity['Type'] == 3 && $this->getController()->getId() !== 'training') {
            $params = array(
                'acId' => Yii::app()->getRequest()->getQuery('acId', ''),
                'activityApplyId' => Yii::app()->getRequest()->getQuery('activityApplyId', ''),
                'apply' => Yii::app()->getRequest()->getQuery('apply', 0),
                'fee' => Yii::app()->getRequest()->getQuery('fee', 0)
            );
            $this->getController()->redirect(Yii::app()->createUrl('training/apply', $params));
        }
        $activityApply = Activity::getActivityApply($activityApplyId);
        if (!$activityApply || $activityApply['AID'] != $activity['ID']) {
            $activityApply = false;
        }
        $activityApplyOrder = false;
        $activityApplyOrderInvoice = false;
        if ($activityApply) {
            $activityApplyOrder = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_order')
                    ->where(array('and', 'Type = :Type', 'TypeID = :TypeID'), array(':Type' => 'activity_apply', ':TypeID' => $activityApplyId))
                    ->queryRow();
        }
        if ($activityApplyOrder) {
            $activityApplyOrderInvoice = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_order_invoice')
                    ->where('OrderID = :OrderID', array(':OrderID' => $activityApplyOrder['ID']))
                    ->queryRow();
        }
        $this->getController()->setPageTitle(Yii::app()->name . ' - 投联' . $activity['TypeName'] . ' - ' . $activity['TypeName'] . '报名');
        $this->getController()->render('/activity/apply', array(
            'activity' => $activity,
            'activityApply' => $activityApply,
            'activityApplyOrder' => $activityApplyOrder,
            'activityApplyOrderInvoice' => $activityApplyOrderInvoice
        ));
    }

}
