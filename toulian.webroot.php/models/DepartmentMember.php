<?php

/**
 * This is the model class for table "t_department_member".
 *
 * The followings are the available columns in table 't_department_member':
 * @property string $ID
 * @property string $DeptID
 * @property string $RealName
 * @property integer $Gender
 * @property string $WorkExperience
 * @property string $Contact
 * @property string $Introduction
 * @property string $Avatar
 * @property integer $IsEnabled
 * @property integer $SortNo
 * @property integer $CreateTime
 */
class DepartmentMember extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_department_member';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ID, Gender', 'required'),
			array('Gender, IsEnabled, SortNo, CreateTime', 'numerical', 'integerOnly'=>true),
			array('ID, DeptID', 'length', 'max'=>36),
			array('RealName', 'length', 'max'=>32),
			array('WorkExperience', 'length', 'max'=>10),
			array('Contact', 'length', 'max'=>100),
			array('Introduction, Avatar', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, DeptID, RealName, Gender, WorkExperience, Contact, Introduction, Avatar, IsEnabled, SortNo, CreateTime', 'safe', 'on'=>'search'),
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
			'DeptID' => '部门ID',
			'RealName' => '用户姓名',
			'Gender' => '性别  0 男  1 女',
			'WorkExperience' => '从业年限',
			'Contact' => '联系人',
			'Introduction' => '个人介绍',
			'Avatar' => '头像路径',
			'IsEnabled' => '人员显示状态  0 显示  1 隐藏',
			'SortNo' => '排序号',
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
		$criteria->compare('RealName',$this->RealName,true);
		$criteria->compare('Gender',$this->Gender);
		$criteria->compare('WorkExperience',$this->WorkExperience,true);
		$criteria->compare('Contact',$this->Contact,true);
		$criteria->compare('Introduction',$this->Introduction,true);
		$criteria->compare('Avatar',$this->Avatar,true);
		$criteria->compare('IsEnabled',$this->IsEnabled);
		$criteria->compare('SortNo',$this->SortNo);
		$criteria->compare('CreateTime',$this->CreateTime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DepartmentMember the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
