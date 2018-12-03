<?php

/**
 * This is the model class for table "t_resource_factory_supply".
 *
 * The followings are the available columns in table 't_resource_factory_supply':
 * @property string $ID
 * @property string $IntentionName
 * @property string $RentPrice
 * @property string $RentUnit
 * @property string $SalePrice
 * @property string $SaleUnit
 * @property integer $IsNegotiable
 * @property double $StuctureArea
 * @property string $StuctureAreaUnit
 * @property double $UsedArea
 * @property string $UsedAreaUnit
 * @property string $CategoryName
 * @property double $FloorHeight
 * @property string $StructureName
 * @property string $FunctionName
 * @property string $RentPeriodA
 * @property string $RentPeriodB
 * @property string $Contact
 * @property string $Phone
 * @property string $RentalType
 * @property double $MinArea
 * @property double $Height
 * @property double $Width
 * @property string $LandLincense
 * @property string $CertificateProperty
 * @property integer $LeftYears
 * @property string $ProtocolUrl
 * @property string $Details
 * @property string $InfoValidPeriod
 */
class ResourceFactorySupply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_factory_supply';
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
            array('StuctureArea, UsedArea, FloorHeight, MinArea, Height, Width', 'numerical'),
            array('ID, IntentionName, CategoryName, StructureName, FunctionName, RentalType, InfoValidPeriod', 'length', 'max' => 36),
            array('RentPrice, RentUnit, SalePrice, SaleUnit, StuctureAreaUnit, UsedAreaUnit, RentPeriodA, RentPeriodB', 'length', 'max' => 10),
            array('Contact, Phone, CertificateProperty', 'length', 'max' => 32),
            array('LandLincense', 'length', 'max' => 18),
            array('ProtocolUrl', 'length', 'max' => 255),
            array('Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, RentPrice, RentUnit, SalePrice, SaleUnit, IsNegotiable, StuctureArea, StuctureAreaUnit, UsedArea, UsedAreaUnit, CategoryName, FloorHeight, StructureName, FunctionName, RentPeriodA, RentPeriodB, Contact, Phone, RentalType, MinArea, Height, Width, LandLincense, CertificateProperty, LeftYears, ProtocolUrl, Details, InfoValidPeriod', 'safe', 'on' => 'search'),
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
            'IntentionName' => '意向名称',
            'RentPrice' => '出租价格',
            'RentUnit' => '价格单位 (元/m2/天； 元/月)',
            'SalePrice' => '出售价格',
            'SaleUnit' => '价格单位 (元/m2/天； 元/月)',
            'IsNegotiable' => '价格是否可议  (0 代表 否  1 代表 是)',
            'StuctureArea' => '建筑面积',
            'StuctureAreaUnit' => '建筑面积的单位',
            'UsedArea' => '使用面积',
            'UsedAreaUnit' => '使用面积单位',
            'CategoryName' => '厂房类型名称',
            'FloorHeight' => '厂房层数',
            'StructureName' => '建筑结构名称',
            'FunctionName' => '功能类型名称',
            'RentPeriodA' => '租赁期限A ',
            'RentPeriodB' => '租赁期限B',
            'Contact' => '联系人',
            'Phone' => '联系电话',
            'RentalType' => '租售类型名称',
            'MinArea' => '最小分割面积',
            'Height' => '厂房高度',
            'Width' => '厂房跨度',
            'LandLincense' => '土地证号 18位',
            'CertificateProperty' => '产权证号',
            'LeftYears' => '土地使用剩余年限',
            'ProtocolUrl' => '代理协议路径',
            'Details' => '详细信息',
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
        $criteria->compare('RentPrice', $this->RentPrice, true);
        $criteria->compare('RentUnit', $this->RentUnit, true);
        $criteria->compare('SalePrice', $this->SalePrice, true);
        $criteria->compare('SaleUnit', $this->SaleUnit, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('StuctureArea', $this->StuctureArea);
        $criteria->compare('StuctureAreaUnit', $this->StuctureAreaUnit, true);
        $criteria->compare('UsedArea', $this->UsedArea);
        $criteria->compare('UsedAreaUnit', $this->UsedAreaUnit, true);
        $criteria->compare('CategoryName', $this->CategoryName, true);
        $criteria->compare('FloorHeight', $this->FloorHeight);
        $criteria->compare('StructureName', $this->StructureName, true);
        $criteria->compare('FunctionName', $this->FunctionName, true);
        $criteria->compare('RentPeriodA', $this->RentPeriodA, true);
        $criteria->compare('RentPeriodB', $this->RentPeriodB, true);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('RentalType', $this->RentalType, true);
        $criteria->compare('MinArea', $this->MinArea);
        $criteria->compare('Height', $this->Height);
        $criteria->compare('Width', $this->Width);
        $criteria->compare('LandLincense', $this->LandLincense, true);
        $criteria->compare('CertificateProperty', $this->CertificateProperty, true);
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
     * @return ResourceFactorySupply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存厂房供应信息
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
        $params['AreaCode'] = Yii::app()->getRequest()->getPost('AreaCode', '');
        $params['Address'] = Yii::app()->getRequest()->getPost('Address', '');
        $fields['IsNegotiable'] = Yii::app()->getRequest()->getPost('IsNegotiable', '');
        $fields['RentPrice'] = Yii::app()->getRequest()->getPost('RentPrice', '');
        $fields['RentUnit'] = Yii::app()->getRequest()->getPost('RentUnit', '');
        $fields['SalePrice'] = Yii::app()->getRequest()->getPost('SalePrice', '');
        $fields['SaleUnit'] = Yii::app()->getRequest()->getPost('SaleUnit', '');
        $fields['RefPrice'] = Yii::app()->getRequest()->getPost('RefPrice', '');
        $fields['RefUnit'] = Yii::app()->getRequest()->getPost('RefUnit', '');
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['StuctureArea'] = Yii::app()->getRequest()->getPost('StuctureArea', '');
        $fields['StuctureAreaUnit'] = Yii::app()->getRequest()->getPost('StuctureAreaUnit', '');
        $fields['UsedArea'] = Yii::app()->getRequest()->getPost('UsedArea', '');
        $fields['UsedAreaUnit'] = Yii::app()->getRequest()->getPost('UsedAreaUnit', '');
        $fields['FloorHeight'] = Yii::app()->getRequest()->getPost('FloorHeight', '');
        $fields['StructureName'] = Yii::app()->getRequest()->getPost('StructureName', '');
        $fields['FunctionName'] = Yii::app()->getRequest()->getPost('FunctionName', '');
        $fields['RentPeriodA'] = Yii::app()->getRequest()->getPost('RentPeriodA', '');
        $fields['RentPeriodB'] = Yii::app()->getRequest()->getPost('RentPeriodB', '');
        $fields['Contact'] = Yii::app()->getRequest()->getPost('Contact', '');
        $fields['Phone'] = Yii::app()->getRequest()->getPost('Phone', '');
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Agent) {
            $fields['ProtocolUrl'] = Yii::app()->getRequest()->getPost('ProtocolUrl', '');
        }
        $fields['Height'] = Yii::app()->getRequest()->getPost('Height', '');
        $fields['Width'] = Yii::app()->getRequest()->getPost('Width', '');
        $fields['LandLincense'] = Yii::app()->getRequest()->getPost('LandLincense', '');
        $fields['CertificateProperty'] = Yii::app()->getRequest()->getPost('CertificateProperty', '');
        $fields['CategoryName'] = Yii::app()->getRequest()->getPost('CategoryName', '');
        $fields['RentalType'] = Yii::app()->getRequest()->getPost('RentalType', '');
        $fields['MinArea'] = Yii::app()->getRequest()->getPost('MinArea', '');
        $fields['LeftYears'] = Yii::app()->getRequest()->getPost('LeftYears', '');
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $params['Support'] = Yii::app()->getRequest()->getPost('Support', '');
        $mixed['SaveMode'] = Yii::app()->getRequest()->getPost('SaveMode', 1);
        $mixed['Images'] = Yii::app()->getRequest()->getPost('Images', '');
        //组装参数
        $params['IntentionName'] = $fields['IntentionName'];
        $params['RentPrice'] = $fields['RentPrice'];
        $params['RentUnit'] = $fields['RentUnit'];
        $params['SalePrice'] = $fields['SalePrice'];
        $params['SaleUnit'] = $fields['SaleUnit'];
        $params['IsNegotiable'] = $fields['IsNegotiable'];
        $params['Area'] = $fields['StuctureArea'];
        $params['AreaUnit'] = $fields['StuctureAreaUnit'];
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
            'IsNegotiable' => '价格面议必须选择',
            'InfoValidPeriod' => '信息有效期必须选择',
            'StuctureArea' => '建筑面积必须填写',
            'StuctureAreaUnit' => '建筑面积单位必须选择',
            'UsedArea' => '使用面积必须填写',
            'UsedAreaUnit' => '使用面积单位必须选择',
            'FloorHeight' => '厂房层数必须选择',
            'StructureName' => '建筑结构必须选择',
            'FunctionName' => '功能类型必须选择',
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'RentPrice' => '出租价格必须是数字',
            'SalePrice' => '出售价格必须是数字',
            'RefPrice' => '参考资源价格必须是数字',
            'StuctureArea' => '建筑面积必须是数字',
            'UsedArea' => '使用面积必须是数字',
            'RentPeriodA' => '租赁期限必须是数字',
            'RentPeriodB' => '租赁期限必须是数字',
            'Height' => '厂房高度必须是数字',
            'Width' => '厂房跨度必须是数字',
            'MinArea' => '最小分割面积必须是数字',
            'LeftYears' => '土地使用权剩余年限必须是数字'
        );
        if ($fields['IsNegotiable'] == 0) {
            if ($fields['IntentionName'] == '出租') {
                $required['RentPrice'] = '出租价格必须填写';
                $required['RentUnit'] = '出租价格单位必须选择';
                $required['RefPrice'] = '参考资源价格必须填写';
                $required['RefUnit'] = '参考资源价格单位必须选择';
            } else if ($fields['IntentionName'] == '出售') {
                $required['SalePrice'] = '出售价格必须填写';
                $required['SaleUnit'] = '出售价格单位必须选择';
                $required['RefPrice'] = '参考资源价格必须填写';
                $required['RefUnit'] = '参考资源价格单位必须选择';
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
        if (is_numeric($fields['RentPeriodA']) && is_numeric($fields['RentPeriodB']) && (int) $fields['RentPeriodA'] >= (int) $fields['RentPeriodB']) {
            Unit::ajaxJson(1, '租赁期限的范围不正确', array('RentPeriodA' => '租赁期限的范围不正确'));
        }
        //保存入库
        if (isset($data['ID']) && $data['ID']) {
            $params['ResCategory'] = $data['ResCategory'];
            $params['ResType'] = $data['ResType'];
            Resource::model()->editResource($data['ID'], $data['BaseID'], $params, $fields, $mixed);
        } else {
            $params['ResCategory'] = 'factory';
            $params['ResType'] = 'supply';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
