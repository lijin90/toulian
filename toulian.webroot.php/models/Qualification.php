<?php

/**
 * This is the model class for table "t_qualification".
 *
 * The followings are the available columns in table 't_qualification':
 * @property string $ID
 * @property string $DeptID
 * @property string $Path
 * @property string $Title
 * @property string $Description
 * @property integer $Status
 * @property integer $CreateTime
 */
class Qualification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_qualification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID', 'required'),
			array('Status, CreateTime', 'numerical', 'integerOnly'=>true),
			array('ID, DeptID', 'length', 'max'=>36),
			array('Path, Title, Description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, DeptID, Path, Title, Description, Status, CreateTime', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'DeptID' => '部门ID、经纪人用户ID',
			'Path' => '路径',
			'Title' => '标题',
			'Description' => '描述',
			'Status' => '资质审核状态  0 待审核  1 已审核  2 已拒绝',
			'CreateTime' => '创建时间',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID,true);
		$criteria->compare('DeptID',$this->DeptID,true);
		$criteria->compare('Path',$this->Path,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Status',$this->Status);
		$criteria->compare('CreateTime',$this->CreateTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Qualification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
