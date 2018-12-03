<?php

/**
 * This is the model class for table "t_specification".
 *
 * The followings are the available columns in table 't_specification':
 * @property string $ID
 * @property string $DeptID
 * @property string $Title
 * @property string $Content
 * @property integer $IsShow
 * @property integer $SortNo
 * @property integer $CreateTime
 */
class Specification extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_specification';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('IsShow, CreateTime', 'numerical', 'integerOnly' => true),
            array('ID, DeptID', 'length', 'max' => 36),
            array('Title', 'length', 'max' => 255),
            array('Content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, DeptID, Title, Content, IsShow, SortNo, CreateTime', 'safe', 'on' => 'search'),
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
            'DeptID' => '部门ID',
            'Title' => '标题',
            'Content' => '内容',
            'IsShow' => '是否显示  0 隐藏  1 显示',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('ID', $this->ID, true);
        $criteria->compare('DeptID', $this->DeptID, true);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('Content', $this->Content, true);
        $criteria->compare('IsShow', $this->IsShow);
        $criteria->compare('SortNo', $this->SortNo);
        $criteria->compare('CreateTime', $this->CreateTime);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Specification the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取特色栏目列表
     * @param string $deptId 部门ID
     * @param string $isShow 是否显示  0 隐藏  1 显示  默认加载全部
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getSpecifications($deptId, $isShow = null) {
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_specification')
                ->where('DeptID = :DeptID', array(':DeptID' => $deptId))
                ->order('SortNo ASC, CreateTime DESC');
        if ($isShow == 0) {
            $query->andWhere('IsShow = :IsShow', array(':IsShow' => 0));
        } else if ($isShow == 1) {
            $query->andWhere('IsShow = :IsShow', array(':IsShow' => 1));
        }
        return $query->queryAll();
    }

}
