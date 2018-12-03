<?php

/**
 * 订单发票
 * @author Changfeng Ji <jichf@qq.com>
 */
class OrderInvoiceController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 开具发票');
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
        } else if ($order['TradeStatus'] != 1) {
            throw new CHttpException(404, '订单记录待支付');
        }
        $invoice = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_order_invoice')
                ->where('OrderID = :OrderID', array(':OrderID' => $id))
                ->queryRow();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if ($invoice) {
                Unit::ajaxJson(1, '发票记录已存在');
            }
            $columns = array(
                'InvoiceType' => '',
                'CustomerType' => '',
                'InvoiceTitle' => '',
                'TaxpayerType' => '',
                'RegisterNo' => '',
                'Bank' => '',
                'BankNo' => '',
                'OperatingLicenseAddress' => '',
                'OperatingLicensePhone' => '',
                'Addressee' => '',
                'AreaCode' => '',
                'Street' => '',
                'PostalCode' => '',
                'Phone' => ''
            );
            $allowedColumns = array_keys($columns);
            foreach ($allowedColumns as $allowColumn) {
                $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
            }
            $required = array(
                'InvoiceType' => '发票性质必须选择',
                'CustomerType' => '开具类型必须选择',
                'InvoiceTitle' => '发票抬头必须填写',
            );
            if ($columns['InvoiceType'] == 'paper') {
                if ($columns['CustomerType'] == 'enterprise') {
                    $required = array_merge($required, array(
                        'TaxpayerType' => '发票类型必须选择',
                        'RegisterNo' => '税务登记证号必须填写',
                    ));
                    if ($columns['TaxpayerType'] == 'special') {
                        $required = array_merge($required, array(
                            'Bank' => '基本开户银行名称必须填写',
                            'BankNo' => '基本开户账号必须填写',
                            'OperatingLicenseAddress' => '注册场所地址必须填写',
                            'OperatingLicensePhone' => '注册固定电话必须填写',
                        ));
                    }
                }
                $required = array_merge($required, array(
                    'Addressee' => '收件人姓名必须填写',
                    'AreaCode' => '所在地区必须选择',
                    'Street' => '街道地址必须填写',
                    'PostalCode' => '邮政编码必须填写',
                    'Phone' => '手机号必须填写',
                ));
            }
            foreach ($required as $key => $value) {
                if (strlen($columns[$key]) == 0) {
                    Unit::ajaxJson(1, $value, array($key => $value));
                }
            }
            $columns['ID'] = Unit::stringGuid();
            $columns['OrderID'] = $order['ID'];
            $columns['InvoiceMoney'] = $order['TotalFee'];
            $columns['Status'] = 1;
            $columns['CreateTime'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_order_invoice', $columns);
            if ($rt) {
                Unit::ajaxJson(0, '提交成功');
            } else {
                Unit::ajaxJson(1, '提交失败');
            }
        }
        if ($invoice) {
            Unit::jsVariable('submitAlert', '发票记录已存在');
        }
        $activityApply = $order['Type'] == 'activity_apply' ? Activity::getActivityApply($order['TypeID']) : false;
        if ($activityApply) {
            Unit::jsVariable('successToUrl', Yii::app()->createUrl('activity/apply', array('acId' => $activityApply['AID'], 'fee' => 1, 'activityApplyId' => $activityApply['ID'])));
        }
        $this->render('index', array(
            'types' => array('activity_apply' => '活动报名'),
            'order' => $order,
            'invoice' => $invoice
        ));
    }

}
