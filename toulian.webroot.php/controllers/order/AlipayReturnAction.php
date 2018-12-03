<?php

/**
 * 支付宝-同步通知
 * @author Changfeng Ji <jichf@qq.com>
 */
class AlipayReturnAction extends CAction {

    public function run() {
        $alipay = Yii::app()->alipay;
        if ($alipay->verifyReturn()) {
            $out_trade_no = $_GET['out_trade_no']; //商户网站唯一订单号
            $trade_no = $_GET['trade_no']; //创建订单生成的交易号
            $total_fee = $_GET['total_fee']; //交易金额
            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                $order = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('*')
                        ->from('t_order')
                        ->where('ID = :ID', array(':ID' => $out_trade_no))
                        ->queryRow();
                if ($order && $order['TradeStatus'] != 1) {
                    $columns = array(
                        'TotalFee' => $total_fee,
                        'TradeMethod' => 'alipay',
                        'TradeNo' => $trade_no,
                        'TradeStatus' => 1,
                        'TradeMemo' => json_encode($_GET, JSON_UNESCAPED_UNICODE)
                    );
                    $rt = Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->update('t_order', $columns, 'ID = :ID', array(':ID' => $order['ID']));
                    if ($rt !== false) {
                        if ($order['Type'] == 'activity_apply') {//活动报名
                            $activityApply = Activity::getActivityApply($order['TypeID']);
                            if ($activityApply) {
                                $columns = array(
                                    'Fee' => $total_fee,
                                    'FeeState' => 1
                                );
                                Yii::app()
                                        ->getDb()
                                        ->createCommand()
                                        ->update('t_activity_apply', $columns, 'ID = :ID', array(':ID' => $activityApply['ID']));
                                $this->getController()->redirect(Yii::app()->createUrl('activity/apply', array('acId' => $activityApply['AID'], 'fee' => 1, 'activityApplyId' => $activityApply['ID'])));
                            }
                        }
                    }
                } else {
                    if ($order['Type'] == 'activity_apply') {//活动报名
                        $activityApply = Activity::getActivityApply($order['TypeID']);
                        if ($activityApply) {
                            $this->getController()->redirect(Yii::app()->createUrl('activity/apply', array('acId' => $activityApply['AID'], 'fee' => 1, 'activityApplyId' => $activityApply['ID'])));
                        }
                    }
                }
            }
        } else {
            //echo "fail";
        }
        exit;
    }

}
