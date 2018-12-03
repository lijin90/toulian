<?php

/**
 * This is the model class for table "t_resource_shop_supply".
 *
 * The followings are the available columns in table 't_resource_shop_supply':
 * @property string $ID
 * @property string $IntentionName
 * @property string $DecorationCategory
 * @property string $OFRName
 * @property string $ServiceCategory
 * @property string $RentPrice
 * @property string $RentUnit
 * @property string $SalePrice
 * @property string $SaleUnit
 * @property integer $IsNegotiable
 * @property string $PriceCategory
 * @property integer $IsHasTransferFee
 * @property string $Comment
 * @property string $PCID
 * @property string $PCOther
 * @property string $PMA
 * @property string $PMB
 * @property string $PMComment
 * @property string $BaseFunction
 * @property double $Bearing
 * @property integer $IsBearing
 * @property string $FTSName
 * @property string $RentPeriodA
 * @property string $RentPeriodB
 * @property string $InfoValidPeriod
 * @property string $NoRentalPeriod
 * @property string $UsedName
 * @property string $ShopCategory
 * @property string $PropertyName
 * @property string $Floor
 * @property string $Orientation
 * @property double $Height
 * @property integer $FloorCount
 * @property double $FirstDepth
 * @property double $FirstWeight
 * @property double $FirstHeight
 * @property double $FirstPureHeight
 * @property double $StuctureArea
 * @property double $UsedArea
 * @property double $Usage
 * @property double $Distance
 * @property double $MinArea
 * @property double $StandardArea
 * @property string $PropertyFee
 * @property integer $ParkingOnGround
 * @property integer $ParkingUnderGround
 * @property string $ElevatorBrand
 * @property integer $ElevatorCount
 * @property string $Contact
 * @property string $Phone
 * @property string $ProtocolUrl
 * @property string $Details
 */
class ResourceShopSupply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_shop_supply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID, IsHasTransferFee, Floor', 'required'),
            array('IsNegotiable, IsHasTransferFee, IsBearing, FloorCount, ParkingOnGround, ParkingUnderGround, ElevatorCount', 'numerical', 'integerOnly' => true),
            array('Bearing, Height, FirstDepth, FirstWeight, FirstHeight, FirstPureHeight, StuctureArea, UsedArea, Usage, Distance, MinArea, StandardArea', 'numerical'),
            array('ID, IntentionName, DecorationCategory, OFRName, PriceCategory, PMA, FTSName, InfoValidPeriod, UsedName', 'length', 'max' => 36),
            array('ServiceCategory, Comment, BaseFunction, NoRentalPeriod, ElevatorBrand', 'length', 'max' => 100),
            array('RentPrice, RentUnit, SalePrice, SaleUnit, RentPeriodA, RentPeriodB, Floor, Orientation, PropertyFee', 'length', 'max' => 10),
            array('PCID, PCOther, PMB, PMComment, PropertyName, ProtocolUrl', 'length', 'max' => 255),
            array('ShopCategory, Contact, Phone', 'length', 'max' => 32),
            array('Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, DecorationCategory, OFRName, ServiceCategory, RentPrice, RentUnit, SalePrice, SaleUnit, IsNegotiable, PriceCategory, IsHasTransferFee, Comment, PCID, PCOther, PMA, PMB, PMComment, BaseFunction, Bearing, IsBearing, FTSName, RentPeriodA, RentPeriodB, InfoValidPeriod, NoRentalPeriod, UsedName, ShopCategory, PropertyName, Floor, Orientation, Height, FloorCount, FirstDepth, FirstWeight, FirstHeight, FirstPureHeight, StuctureArea, UsedArea, Usage, Distance, MinArea, StandardArea, PropertyFee, ParkingOnGround, ParkingUnderGround, ElevatorBrand, ElevatorCount, Contact, Phone, ProtocolUrl, Details', 'safe', 'on' => 'search'),
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
            'DecorationCategory' => '商铺装修类型名称',
            'OFRName' => '商铺租售形式名称',
            'ServiceCategory' => '经营类型， 多个类型存储在一起：  xxx|xxx|xxx|',
            'RentPrice' => '出租价格',
            'RentUnit' => '出租价格 (元/m2/天   元/月)',
            'SalePrice' => 'Sale Price',
            'SaleUnit' => '出售价格 (元/m2/天   元/月)',
            'IsNegotiable' => '价格是否可议  (0 代表 是  1 代表 否)',
            'PriceCategory' => '商铺价格类型',
            'IsHasTransferFee' => '是否包含转让费  (0 代表 否  1 代表 是)',
            'Comment' => '备注，如果包含转让费，填写',
            'PCID' => '商铺价格包含选项, 格式 xxx|xxx|xxx',
            'PCOther' => '价格包含，其他选项 输入信息',
            'PMA' => '付款方式 押',
            'PMB' => '付款方式  付',
            'PMComment' => '付款方式， 选择其他 备注输入内容',
            'BaseFunction' => '基本功能列表, 多个类型存储在一起：  xxx|xxx|xxx',
            'Bearing' => '楼板单位承重',
            'IsBearing' => '是否容许增容增压',
            'FTSName' => '临街面名称',
            'RentPeriodA' => '租赁期限A',
            'RentPeriodB' => '租赁期限B',
            'InfoValidPeriod' => '信息有效期',
            'NoRentalPeriod' => '免租期',
            'UsedName' => '产权方名称',
            'ShopCategory' => '商铺类型名称',
            'PropertyName' => '物业名称',
            'Floor' => '楼层',
            'Orientation' => '朝向',
            'Height' => '层高',
            'FloorCount' => '层数',
            'FirstDepth' => '首层进深',
            'FirstWeight' => '首层面宽',
            'FirstHeight' => '首层层高',
            'FirstPureHeight' => '首层净高',
            'StuctureArea' => '建筑面积',
            'UsedArea' => '使用面积',
            'Usage' => '使用率',
            'Distance' => ' 柱间距',
            'MinArea' => '最小分割面积',
            'StandardArea' => '标准层面积',
            'PropertyFee' => '物业费',
            'ParkingOnGround' => '地上停车位数',
            'ParkingUnderGround' => '地下停车位',
            'ElevatorBrand' => '电梯品牌',
            'ElevatorCount' => '电梯数量',
            'Contact' => '联系人',
            'Phone' => '联系电话',
            'ProtocolUrl' => '上传协议路径',
            'Details' => '详细信息',
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
        $criteria->compare('DecorationCategory', $this->DecorationCategory, true);
        $criteria->compare('OFRName', $this->OFRName, true);
        $criteria->compare('ServiceCategory', $this->ServiceCategory, true);
        $criteria->compare('RentPrice', $this->RentPrice, true);
        $criteria->compare('RentUnit', $this->RentUnit, true);
        $criteria->compare('SalePrice', $this->SalePrice, true);
        $criteria->compare('SaleUnit', $this->SaleUnit, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('PriceCategory', $this->PriceCategory, true);
        $criteria->compare('IsHasTransferFee', $this->IsHasTransferFee);
        $criteria->compare('Comment', $this->Comment, true);
        $criteria->compare('PCID', $this->PCID, true);
        $criteria->compare('PCOther', $this->PCOther, true);
        $criteria->compare('PMA', $this->PMA, true);
        $criteria->compare('PMB', $this->PMB, true);
        $criteria->compare('PMComment', $this->PMComment, true);
        $criteria->compare('BaseFunction', $this->BaseFunction, true);
        $criteria->compare('Bearing', $this->Bearing);
        $criteria->compare('IsBearing', $this->IsBearing);
        $criteria->compare('FTSName', $this->FTSName, true);
        $criteria->compare('RentPeriodA', $this->RentPeriodA, true);
        $criteria->compare('RentPeriodB', $this->RentPeriodB, true);
        $criteria->compare('InfoValidPeriod', $this->InfoValidPeriod, true);
        $criteria->compare('NoRentalPeriod', $this->NoRentalPeriod, true);
        $criteria->compare('UsedName', $this->UsedName, true);
        $criteria->compare('ShopCategory', $this->ShopCategory, true);
        $criteria->compare('PropertyName', $this->PropertyName, true);
        $criteria->compare('Floor', $this->Floor, true);
        $criteria->compare('Orientation', $this->Orientation, true);
        $criteria->compare('Height', $this->Height);
        $criteria->compare('FloorCount', $this->FloorCount);
        $criteria->compare('FirstDepth', $this->FirstDepth);
        $criteria->compare('FirstWeight', $this->FirstWeight);
        $criteria->compare('FirstHeight', $this->FirstHeight);
        $criteria->compare('FirstPureHeight', $this->FirstPureHeight);
        $criteria->compare('StuctureArea', $this->StuctureArea);
        $criteria->compare('UsedArea', $this->UsedArea);
        $criteria->compare('Usage', $this->Usage);
        $criteria->compare('Distance', $this->Distance);
        $criteria->compare('MinArea', $this->MinArea);
        $criteria->compare('StandardArea', $this->StandardArea);
        $criteria->compare('PropertyFee', $this->PropertyFee, true);
        $criteria->compare('ParkingOnGround', $this->ParkingOnGround);
        $criteria->compare('ParkingUnderGround', $this->ParkingUnderGround);
        $criteria->compare('ElevatorBrand', $this->ElevatorBrand, true);
        $criteria->compare('ElevatorCount', $this->ElevatorCount);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('ProtocolUrl', $this->ProtocolUrl, true);
        $criteria->compare('Details', $this->Details, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ResourceShopSupply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存商铺供应信息
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
        $fields['RentPeriodA'] = Yii::app()->getRequest()->getPost('RentPeriodA', '');
        $fields['RentPeriodB'] = Yii::app()->getRequest()->getPost('RentPeriodB', '');
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['StuctureArea'] = Yii::app()->getRequest()->getPost('StuctureArea', '');
        $fields['Distance'] = Yii::app()->getRequest()->getPost('Distance', '');
        $fields['Contact'] = Yii::app()->getRequest()->getPost('Contact', '');
        $fields['Phone'] = Yii::app()->getRequest()->getPost('Phone', '');
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Agent) {
            $fields['ProtocolUrl'] = Yii::app()->getRequest()->getPost('ProtocolUrl', '');
        }
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $params['Support'] = Yii::app()->getRequest()->getPost('Support', '');
        //详细信息
        $fields['DecorationCategory'] = Yii::app()->getRequest()->getPost('DecorationCategory', '');
        $fields['OFRName'] = Yii::app()->getRequest()->getPost('OFRName', '');
        $fields['ServiceCategory'] = Yii::app()->getRequest()->getPost('ServiceCategory', '');
        $fields['PriceCategory'] = Yii::app()->getRequest()->getPost('PriceCategory', '');
        $fields['IsHasTransferFee'] = Yii::app()->getRequest()->getPost('IsHasTransferFee', '');
        $fields['Comment'] = Yii::app()->getRequest()->getPost('Comment', '');
        $fields['PCID'] = Yii::app()->getRequest()->getPost('PCID', '');
        $fields['PCOther'] = Yii::app()->getRequest()->getPost('PCOther', '');
        $fields['PMA'] = Yii::app()->getRequest()->getPost('PMA', '');
        $fields['PMB'] = Yii::app()->getRequest()->getPost('PMB', '');
        $fields['PMComment'] = Yii::app()->getRequest()->getPost('PMComment', '');
        $fields['BaseFunction'] = Yii::app()->getRequest()->getPost('BaseFunction', '');
        $fields['IsBearing'] = Yii::app()->getRequest()->getPost('IsBearing', '');
        $fields['Bearing'] = Yii::app()->getRequest()->getPost('Bearing', '');
        $fields['FTSName'] = Yii::app()->getRequest()->getPost('FTSName', '');
        $fields['NoRentalPeriod'] = Yii::app()->getRequest()->getPost('NoRentalPeriod', '');
        $fields['UsedName'] = Yii::app()->getRequest()->getPost('UsedName', '');
        $fields['ShopCategory'] = Yii::app()->getRequest()->getPost('ShopCategory', '');
        $fields['PropertyName'] = Yii::app()->getRequest()->getPost('PropertyName', '');
        $fields['Floor'] = Yii::app()->getRequest()->getPost('Floor', '');
        $fields['Orientation'] = Yii::app()->getRequest()->getPost('Orientation', '');
        $fields['Height'] = Yii::app()->getRequest()->getPost('Height', '');
        $fields['FloorCount'] = Yii::app()->getRequest()->getPost('FloorCount', '');
        $fields['FirstDepth'] = Yii::app()->getRequest()->getPost('FirstDepth', '');
        $fields['FirstWeight'] = Yii::app()->getRequest()->getPost('FirstWeight', '');
        $fields['FirstHeight'] = Yii::app()->getRequest()->getPost('FirstHeight', '');
        $fields['FirstPureHeight'] = Yii::app()->getRequest()->getPost('FirstPureHeight', '');
        $fields['UsedArea'] = Yii::app()->getRequest()->getPost('UsedArea', '');
        $fields['Usage'] = Yii::app()->getRequest()->getPost('Usage', '');
        $fields['MinArea'] = Yii::app()->getRequest()->getPost('MinArea', '');
        $fields['StandardArea'] = Yii::app()->getRequest()->getPost('StandardArea', '');
        $fields['PropertyFee'] = Yii::app()->getRequest()->getPost('PropertyFee', '');
        $fields['ParkingOnGround'] = Yii::app()->getRequest()->getPost('ParkingOnGround', '');
        $fields['ParkingUnderGround'] = Yii::app()->getRequest()->getPost('ParkingUnderGround', '');
        $fields['ElevatorBrand'] = Yii::app()->getRequest()->getPost('ElevatorBrand', '');
        $fields['ElevatorCount'] = Yii::app()->getRequest()->getPost('ElevatorCount', '');
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
        $params['AreaUnit'] = '平方米';
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
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'RentPrice' => '出租价格必须是数字',
            'SalePrice' => '出售价格必须是数字',
            'RentPeriodA' => '租赁期限必须是数字',
            'RentPeriodB' => '租赁期限必须是数字',
            'StuctureArea' => '建筑面积必须是数字',
            'Distance' => '柱间距必须是数字',
            'Bearing' => '楼板单位承重必须是数字',
            'Height' => '层高必须是数字',
            'FloorCount' => '商铺共有层数必须是数字',
            'FirstDepth' => '首层进深必须是数字',
            'FirstWeight' => '首层面宽必须是数字',
            'FirstHeight' => '首层层高必须是数字',
            'FirstPureHeight' => '首层净高必须是数字',
            'UsedArea' => '使用面积必须是数字',
            'Usage' => '使用率必须是数字',
            'MinArea' => '最小分割面积必须是数字',
            'StandardArea' => '标准层面积必须是数字',
            'PropertyFee' => '物业费必须是数字',
            'ParkingOnGround' => '地上停车位数必须是数字',
            'ParkingUnderGround' => '地下停车位数必须是数字',
            'ElevatorCount' => '电梯数量必须是数字'
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
        if (is_numeric($fields['RentPeriodA']) && is_numeric($fields['RentPeriodB']) && (int) $fields['RentPeriodA'] >= (int) $fields['RentPeriodB']) {
            Unit::ajaxJson(1, '租赁期限的范围不正确', array('RentPeriodA' => '租赁期限的范围不正确'));
        }
        //保存入库
        if (isset($data['ID']) && $data['ID']) {
            $params['ResCategory'] = $data['ResCategory'];
            $params['ResType'] = $data['ResType'];
            Resource::model()->editResource($data['ID'], $data['BaseID'], $params, $fields, $mixed);
        } else {
            $params['ResCategory'] = 'shop';
            $params['ResType'] = 'supply';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
