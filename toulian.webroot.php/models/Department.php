<?php

/**
 * This is the model class for table "t_department".
 *
 * The followings are the available columns in table 't_department':
 * @property string $ID
 * @property string $DeptName
 * @property string $DeptType
 * @property string $CategoryID
 * @property string $Url
 * @property string $Logo
 * @property integer $AreaCode
 * @property string $Address
 * @property string $Contact
 * @property string $Mobile
 * @property string $Telephone
 * @property string $Email
 * @property string $Introduction
 * @property integer $IsNeedValidate
 * @property integer $SortNo
 * @property integer $CreateTime
 */
class Department extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_department';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('AreaCode, IsNeedValidate, SortNo, CreateTime', 'numerical', 'integerOnly' => true),
            array('ID, CategoryID', 'length', 'max' => 36),
            array('DeptName', 'length', 'max' => 64),
            array('DeptType', 'length', 'max' => 50),
            array('Url, Logo, Address', 'length', 'max' => 255),
            array('Contact, Email', 'length', 'max' => 100),
            array('Mobile, Telephone', 'length', 'max' => 20),
            array('Introduction', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, DeptName, DeptType, CategoryID, Url, Logo, AreaCode, Address, Contact, Mobile, Telephone, Email, Introduction, IsNeedValidate, SortNo, CreateTime', 'safe', 'on' => 'search'),
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
            'DeptName' => '部门名称',
            'DeptType' => '部门类型，包括：org:政府招商、office:政府招商下属处室、park:园区招商、association:商会/协会/俱乐部、enterprise:企业招商、agency:经纪公司、vendor:交易服务商',
            'CategoryID' => '类别ID，关联表 t_department_category',
            'Url' => '网址',
            'Logo' => 'Logo路径',
            'AreaCode' => '所属地区ID',
            'Address' => '具体地址',
            'Contact' => '联系人',
            'Mobile' => '手机',
            'Telephone' => '电话',
            'Email' => '电子邮箱',
            'Introduction' => '部门介绍',
            'IsNeedValidate' => '是否需要审核  0: 被审核  1 : 免审',
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
        $criteria->compare('DeptName', $this->DeptName, true);
        $criteria->compare('DeptType', $this->DeptType, true);
        $criteria->compare('CategoryID', $this->CategoryID, true);
        $criteria->compare('Url', $this->Url, true);
        $criteria->compare('Logo', $this->Logo, true);
        $criteria->compare('AreaCode', $this->AreaCode);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Mobile', $this->Mobile, true);
        $criteria->compare('Telephone', $this->Telephone, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->compare('Introduction', $this->Introduction, true);
        $criteria->compare('IsNeedValidate', $this->IsNeedValidate);
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
     * @return Department the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取部门类别列表
     * @param string $deptType 部门类型
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getDepartCategories($deptType) {
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_department_category')
                ->where('DeptType = :DeptType', array(':DeptType' => $deptType))
                ->queryAll();
        return $datas;
    }

    /**
     * 获取部门信息
     * @param string $deptId 部门ID
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getDepart($deptId) {
        if (!$deptId) {
            return false;
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                ->where('d.ID = :ID', array(':ID' => $deptId))
                ->queryRow();
        return $data;
    }

    /**
     * 获取部门列表
     * @param string $parentId 父级部门ID
     * @param string $deptType 部门类型，默认全部
     * @param string $limit 获取数量，默认全部
     * @param array $params 扩展参数，包括:
     *  - categoryId: 类别ID
     *  - areaCode: 所属地区ID
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getDeptarts($parentId, $deptType = null, $limit = null, $params = array()) {
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*, dc.Name AS CategoryName, dr.ParentID')
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->order('d.SortNo ASC, d.CreateTime DESC');
        if ($parentId) {
            $query->andWhere('dr.ParentID=:ParentID', array(':ParentID' => $parentId));
        }
        if ($deptType) {
            $query->andWhere('d.DeptType=:DeptType', array(':DeptType' => $deptType));
        }
        if (isset($params['categoryId']) && !empty($params['categoryId'])) {
            $query->andWhere('d.CategoryID=:CategoryID', array(':CategoryID' => $params['categoryId']));
        }
        if (isset($params['areaCode']) && !empty($params['areaCode'])) {
            $acPrefix = rtrim($params['areaCode'], '0');
            $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
            $query->andWhere(array('like', 'd.AreaCode', $acPrefix . '%'));
        }
        if (is_numeric($limit)) {
            $query->limit($limit)->offset(0);
        }
        return $query->queryAll();
    }

    /**
     * 获取部门用户列表
     * @param string $deptId 部门ID
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getDepartUserIdes($deptId) {
        $userIdes = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('ID')
                        ->from('t_user')
                        ->where('DeptID=:DeptID', array(':DeptID' => $deptId))
                        ->queryColumn();
        return $userIdes;
    }

}
