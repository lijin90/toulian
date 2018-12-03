<?php

/**
 * 订单
 * @author Changfeng Ji <jichf@qq.com>
 */
class OrderController extends Controller {

    public function actions() {
        return array(
            'create' => 'application.controllers.order.CreateAction', //创建订单（AJAX-POST）
            'info' => 'application.controllers.order.InfoAction', //查看订单信息（AJAX-POST）
            'cashier' => 'application.controllers.order.CashierAction', //收银台
            'alipayPay' => 'application.controllers.order.AlipayPayAction', //支付宝-支付
            'alipayReturn' => 'application.controllers.order.AlipayReturnAction', //支付宝-同步通知
            'alipayNotify' => 'application.controllers.order.AlipayNotifyAction', //支付宝-异步通知
        );
    }

}
