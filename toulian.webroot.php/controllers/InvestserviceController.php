<?php

/**
 * 投资服务
 * @author Changfeng Ji <jichf@qq.com>
 */
class InvestserviceController extends Controller {

    /**
     * 投资服务 - 信息录入
     */
    public function actionIndex() {
        $userName = Yii::app()->getRequest()->getQuery('userName');
        $password = Yii::app()->getRequest()->getQuery('password');
        $owner = false;
        if (!$userName || !$password) {
            Unit::jsVariable('needLogin', true);
        } else {
            $owner = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investservice_owner')
                    ->where(array('and', 'UserName = :UserName', 'SubmitPassword = :SubmitPassword'), array(':UserName' => $userName, ':SubmitPassword' => $password))
                    ->queryRow();
            if (!$owner) {
                Unit::jsVariable('needLogin', true);
            } else {
                Unit::jsVariable('ownerId', $owner['ID']);
            }
        }
        $checkStatistics = $owner ? InvestserviceApply::model()->checkStatistics($owner['ID'], '内资') : false;
        if ($checkStatistics && $checkStatistics['code']) {
            Unit::jsVariable('submitAlert', $checkStatistics['msg']);
        }
        $checkStatistics = $owner ? InvestserviceApply::model()->checkStatistics($owner['ID'], '外资') : false;
        if ($checkStatistics && $checkStatistics['code']) {
            Unit::jsVariable('submitAlert', $checkStatistics['msg']);
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资服务信息录入表');
        $this->render('index');
    }

    /**
     * 投资服务 - 提交
     */
    public function actionSubmit() {
        $columns = array(
            'OwnerID' => '',
            'WechatOpenId' => '',
            'CompanyName' => '',
            'CompanyType' => '',
            'RegisteredDate' => '',
            'RegisteredCapital' => '',
            'RegisteredCapitalUnit' => '',
            'BusinessLicense' => '',
            'Contact' => '',
            'Phone' => '',
            'RepliedBy' => ''
        );
        $allowedColumns = array_keys($columns);
        foreach ($allowedColumns as $allowColumn) {
            $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
        }
        $required = array(
            'OwnerID' => '所属人ID必须填写',
            'CompanyName' => '公司名称必须填写',
            'CompanyType' => '公司类型必须填写',
            'RegisteredDate' => '注册日期必须选择',
            'RegisteredCapital' => '注册资金必须填写',
            'RegisteredCapitalUnit' => '注册资金单位必须填写',
            'BusinessLicense' => '营业执照必须上传',
            'Contact' => '联系人姓名必须填写',
            'Phone' => '联系人电话必须填写',
            'RepliedBy' => '填写人姓名必须填写'
        );
        foreach ($required as $key => $value) {
            if (strlen($columns[$key]) == 0) {
                Unit::ajaxJson(1, $value, array($key => $value));
            }
        }
        $existCompanyName = Yii::app()->getDb()
                ->createCommand()
                ->select('CompanyName')
                ->from('t_investservice_apply')
                ->where(array('and', 'OwnerID = :OwnerID', 'CompanyName = :CompanyName', 'Status != :Status'), array(':OwnerID' => $columns['OwnerID'], ':CompanyName' => $columns['CompanyName'], ':Status' => 2))
                ->queryScalar();
        if ($existCompanyName) {
            Unit::ajaxJson(1, '公司名称已经存在', array('CompanyName' => '公司名称已经存在'));
        }
        if (!is_numeric($columns['RegisteredCapital'])) {
            Unit::ajaxJson(1, '注册资金必须是数字', array('RegisteredCapital' => '注册资金必须是数字'));
        }
        if ($columns['CompanyType'] != '内资' && $columns['CompanyType'] != '外资') {
            Unit::ajaxJson(1, '公司类型格式错误', array('CompanyType' => '公司类型格式错误'));
        }
        if ($columns['RegisteredCapitalUnit'] != '万元/RMB' && $columns['RegisteredCapitalUnit'] != '万元/美元') {
            Unit::ajaxJson(1, '注册资金单位格式错误', array('RegisteredCapitalUnit' => '注册资金单位格式错误'));
        }
        if ($columns['CompanyType'] == '内资' && $columns['RegisteredCapitalUnit'] != '万元/RMB') {
            Unit::ajaxJson(1, '内资注册资金单位只支持“万元/RMB”', array('RegisteredCapitalUnit' => '内资注册资金单位只支持“万元/RMB”'));
        }
        if ($columns['CompanyType'] == '外资' && $columns['RegisteredCapitalUnit'] == '万元/RMB') {
            $columns['RegisteredCapitalMemo'] = '兑换前注册资金：' . $columns['RegisteredCapital'] . $columns['RegisteredCapitalUnit'];
            $usdCny = InvestserviceApply::model()->usdCny();
            $columns['RegisteredCapitalMemo'] .= '，美元人民币汇率：' . $usdCny;
            $columns['RegisteredCapital'] = round($columns['RegisteredCapital'] / $usdCny);
            $columns['RegisteredCapitalUnit'] = '万元/美元';
            $columns['RegisteredCapitalMemo'] .= '，兑换后注册资金：' . $columns['RegisteredCapital'] . $columns['RegisteredCapitalUnit'];
        }
        $value = InvestserviceApply::model()->checkStatistics($columns['OwnerID'], $columns['CompanyType']);
        if ($value['code']) {
            exit(CJSON::encode($value));
        }
        $value = InvestserviceApply::model()->checkRegisteredCapital($columns['OwnerID'], $columns['CompanyType'], $columns['RegisteredCapital']);
        if ($value['code']) {
            exit(CJSON::encode($value));
        }
        $columns['ID'] = Unit::stringGuid();
        $columns['Created'] = time();
        $columns['Status'] = 1;
        $columns['UserID'] = '';
        $columns['Comment'] = '';
        $rt = Yii::app()
                ->getDb()
                ->createCommand()
                ->insert('t_investservice_apply', $columns);
        if ($rt) {
            Unit::ajaxJson(0, '提交成功');
        } else {
            Unit::ajaxJson(1, '提交失败');
        }
    }

}
