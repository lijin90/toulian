<?php

/**
 * This is the model class for table "t_activity".
 *
 * The followings are the available columns in table 't_activity':
 * @property string $ID
 * @property string $UserID
 * @property string $Title
 * @property integer $BeginTime
 * @property integer $EndTime
 * @property integer $LimitCount
 * @property string $ApplyFee
 * @property string $Location
 * @property string $Address
 * @property string $Coordinates
 * @property string $Mobile
 * @property string $Sponsor
 * @property string $Introduce
 * @property integer $Type
 * @property integer $Enable
 * @property integer $CreateTime
 * @property integer $UpdateTime
 */
class Activity extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_activity';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('BeginTime, EndTime, LimitCount, Type, Enable, CreateTime, UpdateTime', 'numerical', 'integerOnly' => true),
            array('ID, UserID', 'length', 'max' => 36),
            array('Title', 'length', 'max' => 200),
            array('ApplyFee', 'length', 'max' => 10),
            array('Address, Coordinates, Sponsor', 'length', 'max' => 255),
            array('Mobile', 'length', 'max' => 20),
            array('Location, Introduce', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, UserID, Title, BeginTime, EndTime, LimitCount, ApplyFee, Location, Address, Coordinates, Mobile, Sponsor, Introduce, Type, Enable, CreateTime, UpdateTime', 'safe', 'on' => 'search'),
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
            'UserID' => '发布者用户ID',
            'Title' => '标题',
            'BeginTime' => '开始时间',
            'EndTime' => '结束时间',
            'LimitCount' => '受限人数',
            'ApplyFee' => '报名费用',
            'Location' => '地点',
            'Address' => '详细地址',
            'Coordinates' => '坐标',
            'Mobile' => '联系手机',
            'Sponsor' => '主办方',
            'Introduce' => '介绍',
            'Type' => '活动类型',
            'Enable' => '是否启用,  0: 隐藏  1: 显示',
            'CreateTime' => '创建日期时间',
            'UpdateTime' => '更新时间',
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
        $criteria->compare('UserID', $this->UserID, true);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('BeginTime', $this->BeginTime);
        $criteria->compare('EndTime', $this->EndTime);
        $criteria->compare('LimitCount', $this->LimitCount);
        $criteria->compare('ApplyFee', $this->ApplyFee, true);
        $criteria->compare('Location', $this->Location, true);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('Coordinates', $this->Coordinates, true);
        $criteria->compare('Mobile', $this->Mobile, true);
        $criteria->compare('Sponsor', $this->Sponsor, true);
        $criteria->compare('Introduce', $this->Introduce, true);
        $criteria->compare('Type', $this->Type);
        $criteria->compare('Enable', $this->Enable);
        $criteria->compare('CreateTime', $this->CreateTime);
        $criteria->compare('UpdateTime', $this->UpdateTime);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取活动信息
     * @param string $id 活动ID
     * @return mixed the first row (in terms of an array) of the query result, false if no result.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getActivity($id) {
        if (!$id) {
            return false;
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_activity')
                ->where('ID = :ID', array(':ID' => $id))
                ->queryRow();
        if ($data) {
            $data['TypeName'] = isset(DbOption::$activity['type'][$data['Type']]) ? DbOption::$activity['type'][$data['Type']] : '活动';
        }
        return $data;
    }

    public static function formatTime($beginTime, $endTime) {
        $weeks = array(0 => '星期天', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六');
        $beginDate = date('Y年m月d日', $beginTime);
        $endDate = date('Y年m月d日', $endTime);
        if ($beginDate === $endDate) {
            $beginWeek = date('w', $beginTime);
            return $beginDate . '（' . $weeks[$beginWeek] . '） ' . date('H:i', $beginTime) . '-' . date('H:i', $endTime);
        } else {
            return $beginDate . '至' . $endDate;
        }
    }

    /**
     * 获取活动报名信息
     * @param string $id 活动报名ID
     * @return mixed the first row (in terms of an array) of the query result, false if no result.
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getActivityApply($id) {
        if (!$id) {
            return false;
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_activity_apply')
                ->where('ID = :ID', array(':ID' => $id))
                ->queryRow();
        return $data;
    }

}
