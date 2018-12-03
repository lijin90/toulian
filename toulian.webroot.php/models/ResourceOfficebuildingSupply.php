<?php

/**
 * This is the model class for table "t_resource_officebuilding_supply".
 *
 * The followings are the available columns in table 't_resource_officebuilding_supply':
 * @property string $ID
 * @property string $IntentionName
 * @property string $DecorationCategory
 * @property string $OFRName
 * @property string $Region
 * @property string $RentPrice
 * @property string $RentUnit
 * @property string $SalePrice
 * @property string $SaleUnit
 * @property integer $IsNegotiable
 * @property string $PriceType
 * @property string $PCID
 * @property string $PCOther
 * @property string $PMA
 * @property string $PMB
 * @property string $PMComment
 * @property string $RentPeriodA
 * @property string $RentPeriodB
 * @property string $NoRentalPeriod
 * @property string $UsedName
 * @property string $LevelName
 * @property string $PropertyName
 * @property string $Floor
 * @property string $Orientation
 * @property double $StuctureArea
 * @property double $UsedArea
 * @property double $Usage
 * @property integer $TotalFloor
 * @property double $FloorHeight
 * @property double $Distance
 * @property double $MinArea
 * @property double $StandardArea
 * @property double $PropertyFee
 * @property integer $ParkingOnGround
 * @property integer $ParkingUnderGround
 * @property string $ElevatorBrand
 * @property integer $ElevatorCount
 * @property string $Contact
 * @property string $Phone
 * @property string $ProtocolUrl
 * @property string $Details
 * @property string $InfoValidPeriod
 */
class ResourceOfficebuildingSupply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_officebuilding_supply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('IsNegotiable, TotalFloor, ParkingOnGround, ParkingUnderGround, ElevatorCount', 'numerical', 'integerOnly' => true),
            array('StuctureArea, UsedArea, Usage, FloorHeight, Distance, MinArea, StandardArea, PropertyFee', 'numerical'),
            array('ID, PCID, PCOther, PMComment, ProtocolUrl', 'length', 'max' => 255),
            array('IntentionName, DecorationCategory, OFRName, PriceType, UsedName, LevelName, InfoValidPeriod', 'length', 'max' => 36),
            array('Region, NoRentalPeriod, PropertyName, ElevatorBrand', 'length', 'max' => 100),
            array('RentPrice, RentUnit, SalePrice, SaleUnit, PMA, PMB, RentPeriodA, RentPeriodB, Floor, Orientation', 'length', 'max' => 10),
            array('Contact, Phone', 'length', 'max' => 32),
            array('Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, DecorationCategory, OFRName, Region, RentPrice, RentUnit, SalePrice, SaleUnit, IsNegotiable, PriceType, PCID, PCOther, PMA, PMB, PMComment, RentPeriodA, RentPeriodB, NoRentalPeriod, UsedName, LevelName, PropertyName, Floor, Orientation, StuctureArea, UsedArea, Usage, TotalFloor, FloorHeight, Distance, MinArea, StandardArea, PropertyFee, ParkingOnGround, ParkingUnderGround, ElevatorBrand, ElevatorCount, Contact, Phone, ProtocolUrl, Details, InfoValidPeriod', 'safe', 'on' => 'search'),
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
            'DecorationCategory' => '写字楼装修类型',
            'OFRName' => '写字楼租售形式',
            'Region' => '区域名称',
            'RentPrice' => '出租价格',
            'RentUnit' => '出租价格 (元/m2/天   元/月)',
            'SalePrice' => 'Sale Price',
            'SaleUnit' => '出租价格 (元/m2/天   元/月)',
            'IsNegotiable' => '价格是否可议  (0 代表 否  1 代表 是)',
            'PriceType' => '写字楼价格类型',
            'PCID' => '写字楼价格包含选项, 格式 xxx|xxx|xxx',
            'PCOther' => '价格包含，其他选项 输入信息',
            'PMA' => '付款方式 押',
            'PMB' => '付款方式  付',
            'PMComment' => '付款方式， 选择其他 备注输入内容',
            'RentPeriodA' => '租赁期限A',
            'RentPeriodB' => '租赁期限B',
            'NoRentalPeriod' => '免租期',
            'UsedName' => '产权方',
            'LevelName' => '楼宇等级',
            'PropertyName' => '物业名称',
            'Floor' => '楼层',
            'Orientation' => '朝向',
            'StuctureArea' => '建筑面积',
            'UsedArea' => '使用面积',
            'Usage' => '使用率',
            'TotalFloor' => '总楼层',
            'FloorHeight' => '层高',
            'Distance' => '柱间距',
            'MinArea' => '最小分割面积',
            'StandardArea' => '标准层面积',
            'PropertyFee' => '物业费',
            'ParkingOnGround' => '地上停车位数',
            'ParkingUnderGround' => '地下停车位',
            'ElevatorBrand' => '电梯品牌',
            'ElevatorCount' => '电梯数量',
            'Contact' => '联系人',
            'Phone' => '联系电话',
            'ProtocolUrl' => '上传代理协议路径',
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
        $criteria->compare('DecorationCategory', $this->DecorationCategory, true);
        $criteria->compare('OFRName', $this->OFRName, true);
        $criteria->compare('Region', $this->Region, true);
        $criteria->compare('RentPrice', $this->RentPrice, true);
        $criteria->compare('RentUnit', $this->RentUnit, true);
        $criteria->compare('SalePrice', $this->SalePrice, true);
        $criteria->compare('SaleUnit', $this->SaleUnit, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('PriceType', $this->PriceType, true);
        $criteria->compare('PCID', $this->PCID, true);
        $criteria->compare('PCOther', $this->PCOther, true);
        $criteria->compare('PMA', $this->PMA, true);
        $criteria->compare('PMB', $this->PMB, true);
        $criteria->compare('PMComment', $this->PMComment, true);
        $criteria->compare('RentPeriodA', $this->RentPeriodA, true);
        $criteria->compare('RentPeriodB', $this->RentPeriodB, true);
        $criteria->compare('NoRentalPeriod', $this->NoRentalPeriod, true);
        $criteria->compare('UsedName', $this->UsedName, true);
        $criteria->compare('LevelName', $this->LevelName, true);
        $criteria->compare('PropertyName', $this->PropertyName, true);
        $criteria->compare('Floor', $this->Floor, true);
        $criteria->compare('Orientation', $this->Orientation, true);
        $criteria->compare('StuctureArea', $this->StuctureArea);
        $criteria->compare('UsedArea', $this->UsedArea);
        $criteria->compare('Usage', $this->Usage);
        $criteria->compare('TotalFloor', $this->TotalFloor);
        $criteria->compare('FloorHeight', $this->FloorHeight);
        $criteria->compare('Distance', $this->Distance);
        $criteria->compare('MinArea', $this->MinArea);
        $criteria->compare('StandardArea', $this->StandardArea);
        $criteria->compare('PropertyFee', $this->PropertyFee);
        $criteria->compare('ParkingOnGround', $this->ParkingOnGround);
        $criteria->compare('ParkingUnderGround', $this->ParkingUnderGround);
        $criteria->compare('ElevatorBrand', $this->ElevatorBrand, true);
        $criteria->compare('ElevatorCount', $this->ElevatorCount);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
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
     * @return ResourceOfficebuildingSupply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存写字楼供应信息
     * @param array $data 资源数据
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function saveData($data) {
        $params = array();
        $fields = array();
        $mixed = array();
        if (Yii::app()->getRequest()->getPost('OfficeRentSaleUserID') && Yii::app()->user->checkAccess('officeRentSaleRelease')) {
            $params['UserID'] = Yii::app()->getRequest()->getPost('OfficeRentSaleUserID', '');
        }
        if (Yii::app()->getRequest()->getPost('OfficeRentSaleRemark') && Yii::app()->user->checkAccess('officeRentSaleRelease')) {
            $params['Remark'] = Yii::app()->getRequest()->getPost('OfficeRentSaleRemark', '');
        }
        if (Yii::app()->getRequest()->getPost('OfficeRentSaleId') && Yii::app()->user->checkAccess('officeRentSaleRelease')) {
            $params['OfficeRentSaleId'] = Yii::app()->getRequest()->getPost('OfficeRentSaleId', '');
        }
        //基本信息
        $fields['IntentionName'] = Yii::app()->getRequest()->getPost('IntentionName', '');
        $fields['DecorationCategory'] = Yii::app()->getRequest()->getPost('DecorationCategory', '');
        $fields['OFRName'] = Yii::app()->getRequest()->getPost('OFRName', '');
        $params['BaseName'] = Yii::app()->getRequest()->getPost('BaseName', '');
        $params['AreaCode'] = Yii::app()->getRequest()->getPost('AreaCode', '');
        $params['Address'] = Yii::app()->getRequest()->getPost('Address', '');
        $fields['IsNegotiable'] = Yii::app()->getRequest()->getPost('IsNegotiable', '');
        $fields['RentPrice'] = Yii::app()->getRequest()->getPost('RentPrice', '');
        $fields['RentUnit'] = Yii::app()->getRequest()->getPost('RentUnit', '');
        $fields['SalePrice'] = Yii::app()->getRequest()->getPost('SalePrice', '');
        $fields['SaleUnit'] = Yii::app()->getRequest()->getPost('SaleUnit', '');
        $fields['RefPropertyPrice'] = Yii::app()->getRequest()->getPost('RefPropertyPrice', '');
        $fields['RefPropertyUnit'] = Yii::app()->getRequest()->getPost('RefPropertyUnit', '');
        $fields['ProjectStatus'] = Yii::app()->getRequest()->getPost('ProjectStatus', '');
        $fields['RentPeriodA'] = Yii::app()->getRequest()->getPost('RentPeriodA', '');
        $fields['RentPeriodB'] = Yii::app()->getRequest()->getPost('RentPeriodB', '');
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['Floor'] = Yii::app()->getRequest()->getPost('Floor', '');
        $fields['StuctureArea'] = Yii::app()->getRequest()->getPost('StuctureArea', '');
        $fields['FloorHeight'] = Yii::app()->getRequest()->getPost('FloorHeight', '');
        $fields['Contact'] = Yii::app()->getRequest()->getPost('Contact', '');
        $fields['Phone'] = Yii::app()->getRequest()->getPost('Phone', '');
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Agent) {
            $fields['ProtocolUrl'] = Yii::app()->getRequest()->getPost('ProtocolUrl', '');
        }
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $params['Support'] = Yii::app()->getRequest()->getPost('Support', '');
        //详细信息
        $fields['PriceType'] = Yii::app()->getRequest()->getPost('PriceType', '');
        $fields['PCID'] = Yii::app()->getRequest()->getPost('PCID', '');
        $fields['PCOther'] = Yii::app()->getRequest()->getPost('PCOther', '');
        $fields['PMA'] = Yii::app()->getRequest()->getPost('PMA', '');
        $fields['PMB'] = Yii::app()->getRequest()->getPost('PMB', '');
        $fields['PMComment'] = Yii::app()->getRequest()->getPost('PMComment', '');
        $fields['NoRentalPeriod'] = Yii::app()->getRequest()->getPost('NoRentalPeriod', '');
        $fields['UsedName'] = Yii::app()->getRequest()->getPost('UsedName', '');
        $fields['LevelName'] = Yii::app()->getRequest()->getPost('LevelName', '');
        $fields['PropertyName'] = Yii::app()->getRequest()->getPost('PropertyName', '');
        $fields['Orientation'] = Yii::app()->getRequest()->getPost('Orientation', '');
        $fields['UsedArea'] = Yii::app()->getRequest()->getPost('UsedArea', '');
        $fields['Usage'] = Yii::app()->getRequest()->getPost('Usage', '');
        $fields['TotalFloor'] = Yii::app()->getRequest()->getPost('TotalFloor', '');
        $fields['Distance'] = Yii::app()->getRequest()->getPost('Distance', '');
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
            'DecorationCategory' => '装修必须选择',
            'OFRName' => '租售形式必须选择',
            'IsNegotiable' => '价格面议必须选择',
            'RefPropertyPrice' => '参考物业管理费必须填写',
            'RefPropertyUnit' => '参考物业管理费单位必须选择',
            'ProjectStatus' => '项目状态必须选择',
            'InfoValidPeriod' => '信息有效期必须选择',
            'StuctureArea' => '建筑面积必须填写',
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'RentPrice' => '出租价格必须是数字',
            'SalePrice' => '出售价格必须是数字',
            'RefPropertyPrice' => '参考物业管理费必须是数字',
            'RentPeriodA' => '租赁期限必须是数字',
            'RentPeriodB' => '租赁期限必须是数字',
            'StuctureArea' => '建筑面积必须是数字',
            'FloorHeight' => '层高必须是数字',
            'UsedArea' => '使用面积必须是数字',
            'Usage' => '使用率必须是数字',
            'TotalFloor' => '总楼层必须是数字',
            'Distance' => '柱间距必须是数字',
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
            $params['ResCategory'] = 'officebuilding';
            $params['ResType'] = 'supply';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
