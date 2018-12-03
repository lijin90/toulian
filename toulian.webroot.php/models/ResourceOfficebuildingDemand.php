<?php

/**
 * This is the model class for table "t_resource_officebuilding_demand".
 *
 * The followings are the available columns in table 't_resource_officebuilding_demand':
 * @property string $ID
 * @property string $IntentionName
 * @property string $DecorationCategory
 * @property string $PlanPurpose
 * @property integer $IsNegotiable
 * @property string $RentPeriodA
 * @property string $RentPeriodB
 * @property string $LevelName
 * @property string $Contact
 * @property string $Phone
 * @property string $ProtocolUrl
 * @property string $Details
 * @property double $RequireAreaA
 * @property double $RequireAreaB
 * @property string $RequreAreaUnit
 * @property string $Category
 * @property string $InfoValidPeriod
 */
class ResourceOfficebuildingDemand extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource_officebuilding_demand';
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
            array('RequireAreaA, RequireAreaB', 'numerical'),
            array('ID, ProtocolUrl', 'length', 'max' => 255),
            array('IntentionName, DecorationCategory, PlanPurpose, LevelName, InfoValidPeriod', 'length', 'max' => 36),
            array('RentPeriodA, RentPeriodB, RequreAreaUnit', 'length', 'max' => 10),
            array('Contact, Phone', 'length', 'max' => 32),
            array('Category', 'length', 'max' => 20),
            array('Details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, IntentionName, DecorationCategory, PlanPurpose, IsNegotiable, RentPeriodA, RentPeriodB, LevelName, Contact, Phone, ProtocolUrl, Details, RequireAreaA, RequireAreaB, RequreAreaUnit, Category, InfoValidPeriod', 'safe', 'on' => 'search'),
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
            'PlanPurpose' => '规划用途',
            'IsNegotiable' => '价格是否可议  (0 代表 否  1 代表 是)',
            'RentPeriodA' => '租赁期限A',
            'RentPeriodB' => '租赁期限B',
            'LevelName' => '楼宇等级',
            'Contact' => '联系人',
            'Phone' => '联系电话',
            'ProtocolUrl' => '上传代理协议路径',
            'Details' => '详细信息',
            'RequireAreaA' => '需求面积A',
            'RequireAreaB' => '需求面积B(需求信息)',
            'RequreAreaUnit' => '需求面积单位 (平方米；亩) ',
            'Category' => '写字楼类型名称 ',
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
        $criteria->compare('PlanPurpose', $this->PlanPurpose, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('RentPeriodA', $this->RentPeriodA, true);
        $criteria->compare('RentPeriodB', $this->RentPeriodB, true);
        $criteria->compare('LevelName', $this->LevelName, true);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('ProtocolUrl', $this->ProtocolUrl, true);
        $criteria->compare('Details', $this->Details, true);
        $criteria->compare('RequireAreaA', $this->RequireAreaA);
        $criteria->compare('RequireAreaB', $this->RequireAreaB);
        $criteria->compare('RequreAreaUnit', $this->RequreAreaUnit, true);
        $criteria->compare('Category', $this->Category, true);
        $criteria->compare('InfoValidPeriod', $this->InfoValidPeriod, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ResourceOfficebuildingDemand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 保存写字楼需求信息
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
        $fields['DecorationCategory'] = Yii::app()->getRequest()->getPost('DecorationCategory', '');
        $fields['LevelName'] = Yii::app()->getRequest()->getPost('LevelName', '');
        $fields['InfoValidPeriod'] = Yii::app()->getRequest()->getPost('InfoValidPeriod', '');
        $fields['RequireAreaA'] = Yii::app()->getRequest()->getPost('RequireAreaA', '');
        $fields['RequireAreaB'] = Yii::app()->getRequest()->getPost('RequireAreaB', '');
        $fields['RequreAreaUnit'] = Yii::app()->getRequest()->getPost('RequreAreaUnit', '');
        $fields['PlanPurpose'] = Yii::app()->getRequest()->getPost('PlanPurpose', '');
        $fields['Contact'] = Yii::app()->getRequest()->getPost('Contact', '');
        $fields['Phone'] = Yii::app()->getRequest()->getPost('Phone', '');
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Agent) {
            $fields['ProtocolUrl'] = Yii::app()->getRequest()->getPost('ProtocolUrl', '');
        }
        $fields['Details'] = Yii::app()->getRequest()->getPost('Details', '');
        $mixed['SaveMode'] = Yii::app()->getRequest()->getPost('SaveMode', 1);
        //组装参数
        $params['IntentionName'] = $fields['IntentionName'];
        $params['RequireAreaA'] = $fields['RequireAreaA'];
        $params['RequireAreaB'] = $fields['RequireAreaB'];
        $params['RequireAreaUnit'] = $fields['RequreAreaUnit'];
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
            'DecorationCategory' => '装修必须选择',
            'LevelName' => '楼宇等级必须选择',
            'InfoValidPeriod' => '信息有效期必须选择',
            'RequireAreaA' => '需求面积必须填写',
            'RequireAreaB' => '需求面积必须填写',
            'RequreAreaUnit' => '需求面积单位必须选择',
            'PlanPurpose' => '需求用途必须选择',
            'Contact' => '联系人必须填写',
            'Phone' => '联系电话必须填写',
            'Details' => '资源描述必须填写'
        );
        $numbers = array(
            'RequireAreaA' => '需求面积必须是数字',
            'RequireAreaB' => '需求面积必须是数字'
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
        if ((int) $fields['RequireAreaA'] >= (int) $fields['RequireAreaB']) {
            Unit::ajaxJson(1, '需求面积的范围不正确', array('RequireAreaA' => '需求面积的范围不正确'));
        }
        //保存入库
        if (isset($data['ID']) && $data['ID']) {
            $params['ResCategory'] = $data['ResCategory'];
            $params['ResType'] = $data['ResType'];
            Resource::model()->editResource($data['ID'], $data['BaseID'], $params, $fields, $mixed);
        } else {
            $params['ResCategory'] = 'officebuilding';
            $params['ResType'] = 'demand';
            Resource::model()->addResource($params, $fields, $mixed);
        }
    }

}
