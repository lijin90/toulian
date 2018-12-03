<?php

/**
 * This is the model class for table "t_element_options".
 *
 * The followings are the available columns in table 't_element_options':
 * @property string $ID
 * @property string $Name
 * @property string $Value
 * @property string $TableName
 */
class ElementOptions extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_element_options';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('ID', 'length', 'max' => 36),
            array('Name, Value, TableName', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, Name, Value, TableName', 'safe', 'on' => 'search'),
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
            'Name' => '选项的字段名称',
            'Value' => '选项的值列表，存储样式例如：A|B|C',
            'TableName' => '选项对应的表名',
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
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('Value', $this->Value, true);
        $criteria->compare('TableName', $this->TableName, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ElementOptions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取资源表单选项
     * @param string $resCategory land factory officebuilding shop
     * @param string $resType supply demand
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getElementOptions($resCategory, $resType) {
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('Name, Value')
                ->from('t_element_options')
                ->where(array('or', 'TableName = :TableName', array('like', 'TableName', '%t_resource_' . $resCategory . '_' . $resType . '%')), array(':TableName' => ''))
                ->queryAll();
        $datas = Unit::arrayColumn($datas, 'Value', 'Name');
        foreach ($datas as $key => $val) {
            $datas[$key] = explode('|', $val);
        }
        if ($resCategory == 'land' && $resType == 'supply') {
            $datas['LPID'] = array(
                '国有' => array(
                    '划拨',
                    '出让',
                    '作价出资（入股）',
                    '租赁',
                    '授权经营',
                    '其他1'
                ),
                '集体' => array(
                    '荒地拍卖',
                    '批准拨用宅基地',
                    '批准拨用企业用地',
                    '集体土地入股（联营）',
                    '其他2'
                )
            );
        }
        return $datas;
    }

}
