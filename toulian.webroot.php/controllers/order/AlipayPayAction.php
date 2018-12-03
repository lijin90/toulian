<?php

/**
 * 支付宝-支付
 * @author Changfeng Ji <jichf@qq.com>
 */
class AlipayPayAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 支付');
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
        } else if ($order['TotalFee'] == 0) {
            throw new CHttpException(403, '订单金额为 0，无需支付');
        } else if ($order['TradeStatus'] == 1) {
            throw new CHttpException(403, '订单已支付，无需重复支付');
        }
        $alipay = Yii::app()->alipay;
        $alipay->return_url = Yii::app()->createAbsoluteUrl('order/alipayReturn');
        $alipay->notify_url = Yii::app()->createAbsoluteUrl('order/alipayNotify');
        $alipay->show_url = Yii::app()->getBaseUrl(true);
        $request = new AlipayDirectRequest();
        $request->out_trade_no = $order['ID'];
        $request->subject = Unit::stringCut($order['Subject'], 125);
        $request->body = $order['Body'];
        $request->total_fee = $order['TotalFee'];
        $form = $alipay->buildForm($request);
        header('Content-type: text/html;charset=utf-8');
        echo '<!DOCTYPE HTML><html xmlns="http://www.w3.org/1999/xhtml"><head>'
        . '<meta charset="UTF-8">'
        . '<style type="text/css">form{display: none;}</style>'
        . '</head><body style="background-color: #e8f9fc;">'
        . '<div style="margin: 0 auto;text-align: center;"><img src="' . Url::imageUrl() . '/paying.png" alt=""/></div>'
        . $form
        . '</body></html>';
        exit;
    }

}
