<?php

/**
 * This is the model class for table "t_resource_factory_demand".
 *
 * The followings are the available columns in table 't_resource_factory_demand':
 * @property string $ID
 * @property string $IntentionName
 * @property integer $IsNegotiable
 * @property double $StuctureArea
 * @property double $DemandAreaA
 * @property double $DemandAreaB
 * @property string $StuctureAreaUnit
 * @property double $FloorHeight
 * @property string $StructureName
 * @property string $FunctionName
 * @property string $RentPeriodA
 * @property string $RentPeriodB
 * @property string $Contact
 * @property string $Phone
 * @property string $ProtocolUrl
 * @property string $Details
 * @property string $InfoValidPeriod
 */
class ResourceFactoryDemand extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_factory_demand';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('IsNegotiable', 'numerical', 'integerOnly' => true),
            array('StuctureArea, DemandAreaA, DemandAreaB, FloorHeight', 'numerical'),
            array('ID, IntentionName, StructureName, FunctionName, InfoValidPeriod', 'length', 'max' => 36),
            array('StuctureAreaUnit, RentPeriodA, RentPeriodB', 'length', 'max' => 10),
            array('Contact, Phone', 'length', 'max' => 32),
            array('ProtocolUrl', 'length', 'max' => 255),
            array('Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, IsNegotiable, StuctureArea, DemandAreaA, DemandAreaB, StuctureAreaUnit, FloorHeight, StructureName, FunctionName, RentPeriodA, RentPeriodB, Contact, Phone, ProtocolUrl, Details, InfoValidPeriod', 'safe', 'on' => 'search'),
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
            'IsNegotiable' => '价格是否可议  (0 代表 否  1 代表 是)',
            'StuctureArea' => '建筑面积',
            'DemandAreaA' => '需求面积A',
            'DemandAreaB' => '需求面积B',
            'StuctureAreaUnit' => '建筑面积的单位',
            'FloorHeight' => '厂房层高',
            'StructureName' => '建筑结构名称',
            'FunctionName' => '功能类型名称',
            'RentPeriodA' => '租赁期限A  / 承租期限',
            'RentPeriodB' => '租赁期限B / 承租期限',
            'Contact' => '联系人',
            'Phone' => '联系电话',
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
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('StuctureArea', $this->StuctureArea);
        $criteria->compare('DemandAreaA', $this->DemandAreaA);
        $criteria->compare('DemandAreaB', $this->DemandAreaB);
        $criteria->compare('StuctureAreaUnit', $this->StuctureAreaUnit, true);
        $criteria->compare('FloorHeight', $this->FloorHeight);
        $criteria->compare('StructureName', $this->StructureName, true);
        $criteria->compare('FunctionName', $this->FunctionName, true);
        $criteria->compare('RentPeriodA', $this->RentPeriodA, true);
        $criteria->compare('RentPeriodB', $this->RentPeriodB, true);
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
     * @return ResourceFactoryDemand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存厂房需求信息
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
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['DemandAreaA'] = Yii::app()->getRequest()->getPost('DemandAreaA', '');
        $fields['DemandAreaB'] = Yii::app()->getRequest()->getPost('DemandAreaB', '');
        $fields['StuctureAreaUnit'] = Yii::app()->getRequest()->getPost('StuctureAreaUnit', '');
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
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $mixed['SaveMode'] = Yii::app()->getRequest()->getPost('SaveMode', 1);
        //组装参数
        $params['IntentionName'] = $fields['IntentionName'];
        $params['RequireAreaA'] = $fields['DemandAreaA'];
        $params['RequireAreaB'] = $fields['DemandAreaB'];
        $params['RequireAreaUnit'] = $fields['StuctureAreaUnit'];
        $params['Contact'] = $fields['Contact'];
        $params['Phone'] = $fields['Phone'];
        //验证参数
        if (strlen($params['BaseName']) == 0) {
            Unit::ajaxJson(1, '标题必须填写', array('BaseName' => '标题必须填写'));
        }
        if (strlen($params['AreaCode']) == 0) {
            Unit::ajaxJson(1, '意向地区必须选择', array('AreaCode' => '意向地区必须选择'));
        }
        $required = array(
            'IntentionName' => '意向必须选择',
            'InfoValidPeriod' => '信息有效期必须选择',
            'DemandAreaA' => '需求面积必须填写',
            'DemandAreaB' => '需求面积必须填写',
            'StuctureAreaUnit' => '需求面积单位必须选择',
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'DemandAreaA' => '需求面积必须是数字',
            'DemandAreaB' => '需求面积必须是数字',
            'FloorHeight' => '厂房高度必须是数字',
            'RentPeriodA' => '承租期限必须是数字',
            'RentPeriodB' => '承租期限必须是数字'
        );
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
        if ((int) $fields['DemandAreaA'] >= (int) $fields['DemandAreaB']) {
            Unit::ajaxJson(1, '需求面积的范围不正确', array('DemandAreaA' => '需求面积的范围不正确'));
        }
        if (is_numeric($fields['RentPeriodA']) && is_numeric($fields['RentPeriodB']) && (int) $fields['RentPeriodA'] >= (int) $fields['RentPeriodB']) {
            Unit::ajaxJson(1, '承租期限的范围不正确', array('RentPeriodA' => '承租期限的范围不正确'));
        }
        //保存入库
        if (isset($data['ID']) && $data['ID']) {
            $params['ResCategory'] = $data['ResCategory'];
            $params['ResType'] = $data['ResType'];
            Resource::model()->editResource($data['ID'], $data['BaseID'], $params, $fields, $mixed);
        } else {
            $params['ResCategory'] = 'factory';
            $params['ResType'] = 'demand';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
