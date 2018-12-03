<?php

/**
 * This is the model class for table "t_resource_land_supply".
 *
 * The followings are the available columns in table 't_resource_land_supply':
 * @property string $ID
 * @property string $IntentionName
 * @property string $User
 * @property string $CategoryName
 * @property string $LandNo
 * @property string $StatusName
 * @property string $PlanPurpose
 * @property string $GetPrice
 * @property string $GetPriceUnit
 * @property string $EndDate
 * @property string $RentPrice
 * @property string $RentUnit
 * @property string $SalePrice
 * @property string $SaleUnit
 * @property double $LandArea
 * @property string $LandAreaUnit
 * @property double $UsedArea
 * @property string $UsedAreaUnit
 * @property double $SharedArea
 * @property string $TradeType
 * @property string $TradePrice
 * @property string $TradeUnit
 * @property integer $IsNegotiable
 * @property string $Contact
 * @property string $Phone
 * @property string $RentalType
 * @property double $MinArea
 * @property string $MinAreaUnit
 * @property string $LPID
 * @property integer $LeftYears
 * @property string $ProtocolUrl
 * @property string $Details
 * @property string $InfoValidPeriod
 */
class ResourceLandSupply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_land_supply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('IsNegotiable, LeftYears', 'numerical', 'integerOnly' => true),
            array('LandArea, UsedArea, SharedArea, MinArea', 'numerical'),
            array('ID, IntentionName, CategoryName, StatusName, PlanPurpose, LandAreaUnit, UsedAreaUnit, TradeType, RentalType, MinAreaUnit, LPID, InfoValidPeriod', 'length', 'max' => 36),
            array('User, LandNo', 'length', 'max' => 100),
            array('GetPrice, GetPriceUnit, RentPrice, RentUnit, SalePrice, SaleUnit, TradePrice, TradeUnit', 'length', 'max' => 10),
            array('Contact, Phone', 'length', 'max' => 32),
            array('ProtocolUrl', 'length', 'max' => 255),
            array('EndDate, Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, User, CategoryName, LandNo, StatusName, PlanPurpose, GetPrice, GetPriceUnit, EndDate, RentPrice, RentUnit, SalePrice, SaleUnit, LandArea, LandAreaUnit, UsedArea, UsedAreaUnit, SharedArea, TradeType, TradePrice, TradeUnit, IsNegotiable, Contact, Phone, RentalType, MinArea, MinAreaUnit, LPID, LeftYears, ProtocolUrl, Details, InfoValidPeriod', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ID' => 'ID',
            'IntentionName' => '交易意向名称',
            'User' => '土地方',
            'CategoryName' => '土地类型名称',
            'LandNo' => '地号',
            'StatusName' => '土地现状名称',
            'PlanPurpose' => '规划用途',
            'GetPrice' => '取得价格',
            'GetPriceUnit' => '取得价格单位: (万元/建筑平米； 万元/亩)',
            'EndDate' => '终止日期',
            'RentPrice' => '出租价格',
            'RentUnit' => '价格单位 (万元/建筑平米； 万元/亩)',
            'SalePrice' => '出售价格',
            'SaleUnit' => '价格单位 (万元/建筑平米； 万元/亩)',
            'LandArea' => '土地面积',
            'LandAreaUnit' => '土地面积单位',
            'UsedArea' => '使用权面积',
            'UsedAreaUnit' => '使用权面积单位',
            'SharedArea' => 'Shared Area',
            'TradeType' => '交易方式',
            'TradePrice' => '交易价格',
            'TradeUnit' => '交易价格单位 (万元/建筑平米)',
            'IsNegotiable' => '价格是否可议  (0 代表 否  1 代表 是)',
            'Contact' => '联系人',
            'Phone' => '联系人电话',
            'RentalType' => '租售形式',
            'MinArea' => '最小分割面积',
            'MinAreaUnit' => '最小分割面积单位',
            'LPID' => '土地使用权类型选项名称, 通过子选项可以获取到使用权类型',
            'LeftYears' => '土地使用剩余年限',
            'ProtocolUrl' => '上传的代理协议的路径',
            'Details' => '详细说明',
            'InfoValidPeriod' => '信息有效期',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('ID', $this->ID, true);
        $criteria->compare('IntentionName', $this->IntentionName, true);
        $criteria->compare('User', $this->User, true);
        $criteria->compare('CategoryName', $this->CategoryName, true);
        $criteria->compare('LandNo', $this->LandNo, true);
        $criteria->compare('StatusName', $this->StatusName, true);
        $criteria->compare('PlanPurpose', $this->PlanPurpose, true);
        $criteria->compare('GetPrice', $this->GetPrice, true);
        $criteria->compare('GetPriceUnit', $this->GetPriceUnit, true);
        $criteria->compare('EndDate', $this->EndDate, true);
        $criteria->compare('RentPrice', $this->RentPrice, true);
        $criteria->compare('RentUnit', $this->RentUnit, true);
        $criteria->compare('SalePrice', $this->SalePrice, true);
        $criteria->compare('SaleUnit', $this->SaleUnit, true);
        $criteria->compare('LandArea', $this->LandArea);
        $criteria->compare('LandAreaUnit', $this->LandAreaUnit, true);
        $criteria->compare('UsedArea', $this->UsedArea);
        $criteria->compare('UsedAreaUnit', $this->UsedAreaUnit, true);
        $criteria->compare('SharedArea', $this->SharedArea);
        $criteria->compare('TradeType', $this->TradeType, true);
        $criteria->compare('TradePrice', $this->TradePrice, true);
        $criteria->compare('TradeUnit', $this->TradeUnit, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('RentalType', $this->RentalType, true);
        $criteria->compare('MinArea', $this->MinArea);
        $criteria->compare('MinAreaUnit', $this->MinAreaUnit, true);
        $criteria->compare('LPID', $this->LPID, true);
        $criteria->compare('LeftYears', $this->LeftYears);
        $criteria->compare('ProtocolUrl', $this->ProtocolUrl, true);
        $criteria->compare('Details', $this->Details, true);
        $criteria->compare('InfoValidPeriod', $this->InfoValidPeriod, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ResourceLandSupply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存土地供应信息
     * @param array $data 资源数据
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function saveData($data) {
        $params = array();
        $fields = array();
        $mixed = array();
        //基本信息
        $fields['IntentionName'] = Yii::app()->getRequest()->getPost('IntentionName', '');
        $params['BaseName'] = Yii::app()->getRequest()->getPost('BaseName', '');
        $fields['CategoryName'] = Yii::app()->getRequest()->getPost('CategoryName', '');
        $params['AreaCode'] = Yii::app()->getRequest()->getPost('AreaCode', '');
        $params['Address'] = Yii::app()->getRequest()->getPost('Address', '');
        $fields['PlanPurpose'] = Yii::app()->getRequest()->getPost('PlanPurpose', '');
        $fields['IsNegotiable'] = Yii::app()->getRequest()->getPost('IsNegotiable', '');
        $fields['RentPrice'] = Yii::app()->getRequest()->getPost('RentPrice', '');
        $fields['RentUnit'] = Yii::app()->getRequest()->getPost('RentUnit', '');
        $fields['SalePrice'] = Yii::app()->getRequest()->getPost('SalePrice', '');
        $fields['SaleUnit'] = Yii::app()->getRequest()->getPost('SaleUnit', '');
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['LandArea'] = Yii::app()->getRequest()->getPost('LandArea', '');
        $fields['LandAreaUnit'] = Yii::app()->getRequest()->getPost('LandAreaUnit', '');
        $fields['Contact'] = Yii::app()->getRequest()->getPost('Contact', '');
        $fields['Phone'] = Yii::app()->getRequest()->getPost('Phone', '');
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Agent) {
            $fields['ProtocolUrl'] = Yii::app()->getRequest()->getPost('ProtocolUrl', '');
        }
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $params['Support'] = Yii::app()->getRequest()->getPost('Support', '');
        //详细信息
        $fields['User'] = Yii::app()->getRequest()->getPost('User', '');
        $fields['LandNo'] = Yii::app()->getRequest()->getPost('LandNo', '');
        $fields['StatusName'] = Yii::app()->getRequest()->getPost('StatusName', '');
        $fields['EndDate'] = Yii::app()->getRequest()->getPost('EndDate', '');
        $fields['UsedArea'] = Yii::app()->getRequest()->getPost('UsedArea', '');
        $fields['UsedAreaUnit'] = Yii::app()->getRequest()->getPost('UsedAreaUnit', '');
        $fields['TradePrice'] = Yii::app()->getRequest()->getPost('TradePrice', '');
        $fields['TradeUnit'] = Yii::app()->getRequest()->getPost('TradeUnit', '');
        $fields['GetPrice'] = Yii::app()->getRequest()->getPost('GetPrice', '');
        $fields['GetPriceUnit'] = Yii::app()->getRequest()->getPost('GetPriceUnit', '');
        $fields['TradeType'] = Yii::app()->getRequest()->getPost('TradeType', '');
        $fields['RentalType'] = Yii::app()->getRequest()->getPost('RentalType', '');
        $fields['MinArea'] = Yii::app()->getRequest()->getPost('MinArea', '');
        $fields['MinAreaUnit'] = Yii::app()->getRequest()->getPost('MinAreaUnit', '');
        $fields['LPID'] = Yii::app()->getRequest()->getPost('LPID', '');
        $fields['LeftYears'] = Yii::app()->getRequest()->getPost('LeftYears', '');
        $mixed['SaveMode'] = Yii::app()->getRequest()->getPost('SaveMode', 1);
        $mixed['Images'] = Yii::app()->getRequest()->getPost('Images', '');
        //组装参数
        $params['IntentionName'] = $fields['IntentionName'];
        $params['RentPrice'] = $fields['RentPrice'];
        $params['RentUnit'] = $fields['RentUnit'];
        $params['SalePrice'] = $fields['SalePrice'];
        $params['SaleUnit'] = $fields['SaleUnit'];
        $params['IsNegotiable'] = $fields['IsNegotiable'];
        $params['Area'] = $fields['LandArea'];
        $params['AreaUnit'] = $fields['LandAreaUnit'];
        $params['Contact'] = $fields['Contact'];
        $params['Phone'] = $fields['Phone'];
        //验证参数
        if (strlen($params['BaseName']) == 0) {
            Unit::ajaxJson(1, '标题必须填写', array('BaseName' => '标题必须填写'));
        }
        if (strlen($params['AreaCode']) == 0) {
            Unit::ajaxJson(1, '所在地区必须选择', array('AreaCode' => '所在地区必须选择'));
        }
        if (strlen($params['Support']) == 0) {
            Unit::ajaxJson(1, '配套信息必须填写', array('Support' => '配套信息必须填写'));
        }
        $required = array(
            'IntentionName' => '意向必须选择',
            'CategoryName' => '土地类型必须选择',
            'PlanPurpose' => '规划用途必须选择',
            'IsNegotiable' => '价格面议必须选择',
            'InfoValidPeriod' => '信息有效期必须选择',
            'LandArea' => '土地面积必须填写',
            'LandAreaUnit' => '土地面积单位必须选择',
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'RentPrice' => '出租价格必须是数字',
            'SalePrice' => '出售价格必须是数字',
            'LandArea' => '土地面积必须是数字',
            'UsedArea' => '使用权面积必须是数字',
            'TradePrice' => '交易价格必须是数字',
            'GetPrice' => '取得价格必须是数字',
            'MinArea' => '最小分割面积必须是数字',
            'LeftYears' => '土地使用权剩余年限必须是数字',
        );
        if ($fields['IsNegotiable'] == 0) {
            if ($fields['IntentionName'] == '出租') {
                $required['RentPrice'] = '出租价格必须填写';
                $required['RentUnit'] = '出租价格单位必须选择';
            } else if ($fields['IntentionName'] == '出售') {
                $required['SalePrice'] = '出售价格必须填写';
                $required['SaleUnit'] = '出售价格单位必须选择';
            } else if ($fields['IntentionName'] == '可租可售') {
                $required['RentPrice'] = '出租价格必须填写';
                $required['RentUnit'] = '出租价格单位必须选择';
                $required['SalePrice'] = '出售价格必须填写';
                $required['SaleUnit'] = '出售价格单位必须选择';
            }
        }
        foreach ($required as $key => $value) {
            if (strlen($fields[$key]) == 0) {
                Unit::ajaxJson(1, $value, array($key => $value));
            }
        }
        foreach ($numbers as $key => $value) {
            if (strlen($fields[$key]) > 0 && !is_numeric($fields[$key])) {
                Unit::ajaxJson(1, $value, array($key => $value));
            }
        }
        //保存入库
        if (isset($data['ID']) && $data['ID']) {
            $params['ResCategory'] = $data['ResCategory'];
            $params['ResType'] = $data['ResType'];
            Resource::model()->editResource($data['ID'], $data['BaseID'], $params, $fields, $mixed);
        } else {
            $params['ResCategory'] = 'land';
            $params['ResType'] = 'supply';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
