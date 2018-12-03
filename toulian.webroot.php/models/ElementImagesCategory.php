<?php

/**
 * This is the model class for table "t_element_images_category".
 *
 * The followings are the available columns in table 't_element_images_category':
 * @property string $ID
 * @property string $ResCategory
 * @property string $TypeName
 * @property integer $IsRequired
 */
class ElementImagesCategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_element_images_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('IsRequired', 'numerical', 'integerOnly' => true),
            array('ID', 'length', 'max' => 36),
            array('ResCategory', 'length', 'max' => 64),
            array('TypeName', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, ResCategory, TypeName, IsRequired', 'safe', 'on' => 'search'),
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
            'ResCategory' => '资源类别，包括：land:土地、factory:厂房、officebuilding:写字楼、shop:商铺',
            'TypeName' => '图片类型名称',
            'IsRequired' => '图片类型是否为必填项，包括：0:非必填项、1:必填项',
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
        $criteria->compare('ResCategory', $this->ResCategory, true);
        $criteria->compare('TypeName', $this->TypeName, true);
        $criteria->compare('IsRequired', $this->IsRequired);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ElementImagesCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取资源表单图片选项
     * @param string $resCategory land factory officebuilding shop
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getElementImagesCategory($resCategory) {
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_element_images_category')
                ->where('ResCategory = :ResCategory', array(':ResCategory' => $resCategory))
                ->queryAll();
        return $datas;
    }

}
