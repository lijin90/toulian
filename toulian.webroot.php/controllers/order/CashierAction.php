<?php

/**
 * 收银台
 * @author Changfeng Ji <jichf@qq.com>
 */
class CashierAction extends CAction {

    private $types = array('activity_apply' => '活动报名');

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 收银台');
        $id = Yii::app()->getRequest()->getQuery('orderId');
        if (!$id) {
            throw new CHttpException(404, '订单标识不能为空');
        }
        $order = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_order')
                ->where('ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$order) {
            throw new CHttpException(404, '订单记录不存在');
        }
        switch ($order['Type']) {
            case 'activity_apply'://活动报名
                $this->activityApply($order);
                break;
            default:
                throw new CHttpException(403, '订单类型错误');
                break;
        }
    }

    /**
     * 收银台 - 活动报名
     * @param array $order 订单信息
     * @author Changfeng Ji <jichf@qq.com>
     */
    private function activityApply($order) {
        $activityApply = Activity::getActivityApply($order['TypeID']);
        if (!$activityApply) {
            throw new CHttpException(404, '报名记录不存在');
        }
        if ($order['TotalFee'] == 0 || $order['TradeStatus'] == 1) {
            $this->getController()->redirect(Yii::app()->createUrl('activity/apply', array('acId' => $activityApply['AID'], 'fee' => 1, 'activityApplyId' => $activityApply['ID'])));
        } else if ($activityApply['Fee'] <= 0 || $activityApply['FeeState'] == 1) {
            $this->getController()->redirect(Yii::app()->createUrl('activity/apply', array('acId' => $activityApply['AID'], 'fee' => 1, 'activityApplyId' => $activityApply['ID'])));
        }
        $wxpayUrl = '';
        try {
            Yii::app()->getModule('wechatService')->getComponent('wxpay');
            $biz = new WxPayBizPayUrl();
            $biz->SetProduct_id($order['ID']);
            $values = WxpayApi::bizpayurl($biz);
            $wxpayUrl = "weixin://wxpay/bizpayurl?" . http_build_query($values);
        } catch (Exception $exc) {
            $wxpayUrl = Yii::app()->createAbsoluteUrl('wechatService/order/cashier', array('orderId' => $order['ID']));
        }
        $qrcodeWechat = $this->getController()->widget('application.extensions.qrcode.QRCodeGenerator', array(
            'text' => $wxpayUrl,
            'logo' => Yii::getPathOfAlias('webroot') . '/images/qrcodelogo.jpg',
            'level' => 'M',
            'size' => 5,
            'margin' => 0,
            'imageTagOptions' => array('style' => 'width: 172px;height: 172px;')
                ), true);
        $this->getController()->render('cashier', array(
            'order' => $order,
            'types' => $this->types,
            'qrcodeWechat' => $qrcodeWechat
        ));
    }

}
