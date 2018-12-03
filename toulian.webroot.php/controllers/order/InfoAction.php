<?php

/**
 * 查看订单信息
 * @author Changfeng Ji <jichf@qq.com>
 */
class InfoAction extends CAction {

    public function run() {
        $id = Yii::app()->getRequest()->getPost('orderId');
        if (!$id) {
            Unit::ajaxJson(1, '订单标识不能为空');
        }
        $order = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_order')
                ->where('ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$order) {
            Unit::ajaxJson(1, '订单记录不存在');
        }
        Unit::ajaxJson(0, '', $order);
    }

}
