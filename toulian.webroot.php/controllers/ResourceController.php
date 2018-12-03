<?php

/**
 * 资源
 * @author Changfeng Ji <jichf@qq.com>
 */
class ResourceController extends Controller {

    public function actions() {
        return array(
            'supply' => 'application.controllers.resource.SupplyAction', //商用物业（供应）
            'demand' => 'application.controllers.resource.DemandAction', //企业选址（需求）
            'detail' => 'application.controllers.resource.DetailAction' //详情页
        );
    }

    public function actionFilter() {
        $userId = Yii::app()->getRequest()->getPost('userId', Unit::getLoggedUserId());
        $userId = $userId ? $userId : 'ALL';
        $params = array(
            'resCategory' => Yii::app()->getRequest()->getPost('resCategory', ''),
            'status' => 1,
            'isSearched' => 1,
            'releaseStatus' => 3,
            'keyword' => Yii::app()->getRequest()->getPost('keyword', ''),
            'limit' => 10,
            'page' => Yii::app()->getRequest()->getPost('page', 0)
        );
        $data = Resource::model()->getResources($userId, $params);
        foreach ($data['datas'] as &$val) {
            $titles = array();
            $titles[] = $val['IntentionName'];
            if (isset($val['AreaCode']) && $val['AreaCode']) {
                $titles[] = Pcas::code2name($val['AreaCode']);
            }
            if (isset($val['Area']) && $val['Area']) {
                $titles[] = $val['Area'] . $val['AreaUnit'];
            }
            if (isset($val['RequireAreaA']) && $val['RequireAreaA'] && isset($val['RequireAreaB']) && $val['RequireAreaB']) {
                $titles[] = $val['RequireAreaA'] . '-' . $val['RequireAreaB'] . $val['RequireAreaUnit'];
            }
            if (isset($val['IsNegotiable']) && $val['IsNegotiable']) {
                $titles[] = '面议';
            } else if (isset($val['RentPrice']) && $val['RentPrice']) {
                $titles[] = $val['RentPrice'] . $val['RentUnit'];
            } else if (isset($val['SalePrice']) && $val['SalePrice']) {
                $titles[] = $val['SalePrice'] . $val['SaleUnit'];
            }
            $titles[] = $val['BaseName'];
            $val['Title'] = implode(' ', $titles);
        }
        Unit::ajaxJson(0, '', $data);
    }

    /**
     * 资源交易
     */
    public function actionTrade() {
        $resId = Yii::app()->getRequest()->getPost('resId', '');
        $status = Yii::app()->getRequest()->getPost('status', '');
        $userId = Unit::getLoggedUserId();
        if (empty($resId) || !is_numeric($status)) {
            Unit::ajaxJson(1, '缺少参数');
        }
        if (!$userId) {
            Unit::ajaxJson(1, '账户未登录');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('r.*, rrs.Status AS ReleaseStatus')
                ->from('t_resource r')
                ->join("t_resource_release_status rrs", "r.ID = rrs.ResID")
                ->where(array(
                    'and',
                    'r.Status = 1',
                    'r.IsSearched = 1',
                    'r.ID = :ID'), array(':ID' => $resId))
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '数据不存在');
        } else if ($data['ReleaseStatus'] != 3) {
            Unit::ajaxJson(1, '资源未被审核通过，不能交易');
        }
        switch ($status) {
            case 0://申请代理
                $existTradeStatus = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('rts.ID')
                        ->from('t_resource_trade_status rts')
                        ->where(array(
                            'and',
                            array('in', 'Status', array(0, 1, 4)),
                            'rts.ResID = :ResID',
                            'rts.FounderID = :FounderID'), array(':ResID' => $resId, ':FounderID' => $userId))
                        ->queryScalar();
                if ($existTradeStatus) {
                    Unit::ajaxJson(1, '已存在正在进行的代理');
                }
                $connection = Yii::app()->getDb();
                $transaction = $connection->beginTransaction();
                try {
                    $rt = $connection->createCommand()->insert('t_resource_trade_status', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $resId,
                        'Status' => $status,
                        'Comment' => '',
                        'FounderID' => $userId,
                        'ResponseID' => '',
                        'CreateTime' => time()
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                    $rt = $connection->createCommand()->insert('t_resource_trade_status_details', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $resId,
                        'Status' => $status,
                        'Comment' => '',
                        'FounderID' => $userId,
                        'ResponseID' => '',
                        'UserID' => $userId,
                        'CreateTime' => time()
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                    $transaction->commit();
                    Unit::ajaxJson(0);
                } catch (Exception $e) {
                    $transaction->rollback();
                    Unit::ajaxJson(1, '代理失败');
                }
                break;
            case 8://经纪合作或资源交易
                $existTradeStatus = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('rts.ID')
                        ->from('t_resource_trade_status rts')
                        ->where(array(
                            'and',
                            array('in', 'Status', array(8, 10, 11, 12)),
                            'rts.ResID = :ResID',
                            'rts.FounderID = :FounderID'), array(':ResID' => $resId, ':FounderID' => $userId))
                        ->queryScalar();
                if ($existTradeStatus) {
                    Unit::ajaxJson(1, '已存在正在进行的交易');
                }
                $connection = Yii::app()->getDb();
                $transaction = $connection->beginTransaction();
                try {
                    $rt = $connection->createCommand()->insert('t_resource_trade_status', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $resId,
                        'Status' => $status,
                        'Comment' => '',
                        'FounderID' => $userId,
                        'ResponseID' => Yii::app()->getRequest()->getPost('responseId', ''),
                        'CreateTime' => time()
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                    $rt = $connection->createCommand()->insert('t_resource_trade_status_details', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $resId,
                        'Status' => $status,
                        'Comment' => '',
                        'FounderID' => $userId,
                        'ResponseID' => Yii::app()->getRequest()->getPost('responseId', ''),
                        'UserID' => $userId,
                        'CreateTime' => time()
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                    $transaction->commit();
                    Unit::ajaxJson(0);
                } catch (Exception $e) {
                    $transaction->rollback();
                    Unit::ajaxJson(1, '申请失败');
                }
                break;
            default:
                Unit::ajaxJson(1, '异常错误');
                break;
        }
    }

    /**
     * 获取资源联系电话，并发送到用户绑定手机
     */
    public function actionContact() {
        $userId = Unit::getLoggedUserId();
        if (!$userId) {
            Unit::ajaxJson(1, '账户未登录');
        }
        $user = User::getUser($userId);
        if (!$user) {
            Unit::ajaxJson(1, '账户异常');
        }
        if (!preg_match('/^1[3578][0-9]{9}$/', $user['Mobile']) || $user['Mobile'] != $user['MobileIsValid']) {
            Unit::ajaxJson(1, '账户手机号未验证');
        }
        $resId = Yii::app()->getRequest()->getPost('resId', '');
        if (!$resId) {
            Unit::ajaxJson(1, '缺少参数');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('r.*, rrs.Status AS ReleaseStatus')
                ->from('t_resource r')
                ->join("t_resource_release_status rrs", "r.ID = rrs.ResID")
                ->where(array(
                    'and',
                    'r.Status = 1',
                    'r.IsSearched = 1',
                    'r.ID = :ID'), array(':ID' => $resId))
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '数据不存在');
        } else if ($data['ReleaseStatus'] != 3) {
            Unit::ajaxJson(1, '资源未被审核通过，不能查看联系方式');
        }
        $contact = $data['Phone'];
        if (!is_numeric($contact)) {
            preg_match_all('/\d+/', $contact, $out);
            if (isset($out[0])) {
                $contact = implode('', $out[0]);
            }
        }
        if (is_numeric($contact)) {
            $ret = SMSHelper::SendResourceContact($user['Mobile'], $contact);
            if ($ret) {
                Unit::ajaxJson(0, '联系方式已发送到您的手机', $data['Phone']);
            }
        }
        Unit::ajaxJson(0, '', $data['Phone']);
    }

}
