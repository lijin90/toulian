<?php

/**
 * 支付宝-异步通知
 * @author Changfeng Ji <jichf@qq.com>
 */
class AlipayNotifyAction extends CAction {

    public function run() {
        $alipay = Yii::app()->alipay;
        if ($alipay->verifyNotify()) {
            $out_trade_no = $_POST['out_trade_no']; //商户网站唯一订单号
            $trade_no = $_POST['trade_no']; //创建订单生成的交易号
            $total_fee = $_POST['total_fee']; //交易金额
            if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
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
                        'TradeMemo' => json_encode($_POST, JSON_UNESCAPED_UNICODE)
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
                            }
                        }
                    }
                }
                echo "success";
            } else {
                echo "success";
            }
        } else {
            echo "fail";
        }
        exit;
    }

}
