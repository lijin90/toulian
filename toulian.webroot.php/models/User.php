<?php

/**
 * This is the model class for table "t_user".
 *
 * The followings are the available columns in table 't_user':
 * @property string $ID
 * @property string $WechatOpenId
 * @property string $DeptID
 * @property string $RoleID
 * @property string $UserCategory
 * @property string $UserName
 * @property string $Password
 * @property string $Email
 * @property string $EmailIsValid
 * @property string $Mobile
 * @property string $MobileIsValid
 * @property string $Telephone
 * @property string $Avatar
 * @property string $Logo
 * @property integer $AreaCode
 * @property string $Address
 * @property integer $IsNeedValidate
 * @property integer $Status
 * @property integer $CreateTime
 * @property integer $UpdateTime
 * @property integer $LastLoginTime
 */
class User extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID, Password', 'required'),
            array('AreaCode, IsNeedValidate, Status, CreateTime, UpdateTime, LastLoginTime', 'numerical', 'integerOnly' => true),
            array('ID, DeptID, RoleID', 'length', 'max' => 36),
            array('WechatOpenId, Password, Email, Avatar, Logo, Address', 'length', 'max' => 255),
            array('UserCategory, UserName', 'length', 'max' => 50),
            array('EmailIsValid, MobileIsValid', 'length', 'max' => 10),
            array('Mobile, Telephone', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, WechatOpenId, DeptID, RoleID, UserCategory, UserName, Password, Email, EmailIsValid, Mobile, MobileIsValid, Telephone, Avatar, Logo, AreaCode, Address, IsNeedValidate, Status, CreateTime, UpdateTime, LastLoginTime', 'safe', 'on' => 'search'),
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
            'WechatOpenId' => '微信OpenId',
            'DeptID' => '部门ID',
            'RoleID' => '角色ID',
            'UserCategory' => '用户类型  individual:个人  enterprise:企业',
            'UserName' => '用户名',
            'Password' => '密码',
            'Email' => '邮件',
            'EmailIsValid' => '邮件有效性',
            'Mobile' => '手机',
            'MobileIsValid' => '手机有效性',
            'Telephone' => '电话',
            'Avatar' => '头像路径',
            'Logo' => 'Logo路径',
            'AreaCode' => '所属地区ID',
            'Address' => '具体地址',
            'IsNeedValidate' => '是否需要审核  0: 被审核  1 : 免审',
            'Status' => '用户状态  0:禁用  1:启用',
            'CreateTime' => '创建时间',
            'UpdateTime' => '修改时间',
            'LastLoginTime' => '最后登录时间',
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
        $criteria->compare('WechatOpenId', $this->WechatOpenId, true);
        $criteria->compare('DeptID', $this->DeptID, true);
        $criteria->compare('RoleID', $this->RoleID, true);
        $criteria->compare('UserCategory', $this->UserCategory, true);
        $criteria->compare('UserName', $this->UserName, true);
        $criteria->compare('Password', $this->Password, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->compare('EmailIsValid', $this->EmailIsValid, true);
        $criteria->compare('Mobile', $this->Mobile, true);
        $criteria->compare('MobileIsValid', $this->MobileIsValid, true);
        $criteria->compare('Telephone', $this->Telephone, true);
        $criteria->compare('Avatar', $this->Avatar, true);
        $criteria->compare('Logo', $this->Logo, true);
        $criteria->compare('AreaCode', $this->AreaCode);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('IsNeedValidate', $this->IsNeedValidate);
        $criteria->compare('Status', $this->Status);
        $criteria->compare('CreateTime', $this->CreateTime);
        $criteria->compare('UpdateTime', $this->UpdateTime);
        $criteria->compare('LastLoginTime', $this->LastLoginTime);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 检查用户是否存在已绑定手机
     * @staticvar array $exists
     * @param string $userId 用户ID
     * @return boolean 存在则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function existBindedMobile($userId) {
        if (!$userId) {
            return false;
        }
        static $exists;
        if (!isset($exists)) {
            $exists = array();
        }
        if (isset($exists[$userId])) {
            return $exists[$userId] ? true : false;
        }
        $userInfo = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('ID, Mobile, MobileIsValid')
                ->from('t_user')
                ->where('ID = :ID', array(':ID' => $userId))
                ->queryRow();
        $exist = preg_match('/^1[3578][0-9]{9}$/', $userInfo['Mobile']) && $userInfo['Mobile'] == $userInfo['MobileIsValid'] ? true : false;
        $exists[$userId] = $exist;
        $exists[$userId] = $exist;
        return $exist ? true : false;
    }

    /**
     * 获取用户信息
     * @param string $userId 用户ID
     * @param string $userCategory 用户类型
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getUser($userId, $userCategory = null) {
        if (!$userId) {
            return false;
        }
        if ($userCategory != 'individual' && $userCategory != 'enterprise') {
            $userCategory = Yii::app()->getDb()
                    ->createCommand()
                    ->select('UserCategory')
                    ->from('t_user')
                    ->where('ID = :ID', array(':ID' => $userId))
                    ->queryScalar();
        }
        if ($userCategory == 'individual') {
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('u.*, ui.RealName, ui.Gender, ui.EnterpriseName, ui.EnterpriseDepartment, ui.EnterprisePosition, ui.QQ, ui.Wechat, ui.Url, ui.Introduction')
                    ->from('t_user u')
                    ->leftjoin('t_user_individual ui', 'u.ID = ui.UserID')
                    ->where('u.ID = :ID', array(':ID' => $userId))
                    ->queryRow();
        } else if ($userCategory == 'enterprise') {
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('u.*, ue.EnterpriseName, ue.Leader, d.DeptName')
                    ->from('t_user u')
                    ->leftjoin('t_user_enterprise ue', 'u.ID = ue.UserID')
                    ->leftjoin('t_department d', 'u.DeptID = d.ID')
                    ->where('u.ID = :ID', array(':ID' => $userId))
                    ->queryRow();
        } else {
            $data = null;
        }
        return $data;
    }

    /**
     * 获取57个席位的用户ID列表
     * @return array 用户ID列表
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function get57SeatUserIdes() {
        return array(
            '410E8DE3-0051-91CA-169E-C6177C4C8B92', //政府招商 - 北京市投资促进局 - bj-tcj
            'fd95bcf5_9847_4636_acb2_7879c65c768c', //政府招商 - 石景山区投资促进局 - sjsq-tcj
            '1de3b497_0cb4_4cc9_879b_675daddc3f8c', //政府招商 - 门头沟区投资促进局 - mtgq-tcj
            '7f0a04df_68ba_4aa7_b8df_eba2e3d0e82f', //政府招商 - 丰台区投资促进局 - ftq-tcj
            '89ffbf20_0b4f_4bdf_aad7_a00d2ef69650', //政府招商 - 昌平区投资促进局 - cpq-tcj
            '210d12b4_14fb_4a1c_801f_91d3ec64884d', //政府招商 - 平谷区投资促进局 - pgq-tcj
            '5fe094bd_209a_4044_a423_26d0f6c83bef', //政府招商 - 怀柔区投资促进局 - hrq-tcj
            '1cf5087a_3f5d_4ee3_b1de_b7237ef9c94a', //政府招商 - 延庆区投资促进局 - yqx-tcj
            'de80e2dc_8e2c_4ee0_b419_f195eecbdf8b', //政府招商 - 顺义区投资促进局 - syq-tcj
            'd78b62c3_c3c7_4c75_b046_725a1f63c387', //政府招商 - 通州区投资促进局 - tzq-tcj
            'edf569ed_dbe2_44d2_9061_fc9aed551cb4', //政府招商 - 密云区投资促进局 - myx-tcj
            'ed998b3c_8799_4cf4_989d_eea62137a5ed', //政府招商 - 东城区产业和投资促进局 - dcq-tcj
            '3c681004_5179_4872_b472_6ea8eae84d69', //政府招商 - 朝阳区投资促进局 - cyq-tcj
            '451e18a1_2433_4da5_98c6_e29baa482861', //政府招商 - 大兴区投资促进局 - bjjjjs-kfq
            '5cbe201c_38af_45c0_83bb_d54ed6739306', //政府招商 - 房山区投资促进局 - fsq-tcj
            '7de8761c_02c0_4e51_b7b5_22dcff9d9f0e', //政府招商 - 海淀区投资促进局 - hdq-tcj
            '59595a2a_6e97_4c65_8ab1_aeed1d1bd00e', //政府招商 - 北京市西城区功能街区产业发展投资促进局 - xcq-tcj
            '1B3F65A5-3D79-EDC4-66A0-8752910363B7', //政府招商 - 北京市昌平区城南街道 - cpq-cn
            'b8f5dcf1_d8f3_4bff_b3e6_5fff8b9222fc', //政府招商 - 北京良乡经济开发区 - fsq-lxjjkfq
            '8170410E69019786A12C9E4A852402FC', //政府招商 - 朝阳区朝外街道办事处 - cyq-cw
            'ACB1B11E1C27A07EDF2CDD418B0C8EA0', //政府招商 - 东城区崇外街道办事处 - dcq-cw
            'E6069C98E2DD783B32F48119ED5044DD', //政府招商 - 延庆八达岭镇政府 - yq-bdl
            '6F6FF24C-3E30-C88A-0C4F-90E2959FE755', //政府招商 - 北京外商投资企业协会 - wstzxh
            'AEF8918CC857E8E73190C0AE170636CB', //政府招商 - 丰台区马家堡街道办事处 - ftq-mjb
            'FBEA36EDF50C681B3AFD7A0AE9522924', //政府招商 - 石景山金顶街街道办事处 - sjs-jdj
            '5D4F946F99F9A0BCB140E96D93EFA30C', //政府招商 - 海淀区马连洼街道办事处 - hdq-mlw
            '0868E9713AD061B00D299A73865B14E6', //政府招商 - 门头沟大峪街道办事处 - mtg-dy
            '7A65FAA4CC915AA7D48E335232766139', //政府招商 - 通州北苑街道办事处 - tzq-by
            'A7899D585AD3E58AAA4BDD6C9A32E5F1', //政府招商 - 密云果园街道办事处 - my-gy
            '7B9269A06DF32DD377CE3A042A8FCCA0', //政府招商 - 平谷滨河街道办事处 - Pg-bh
            '7bc0adbb_ed92_4e99_9795_ae56faacb87c', //政府招商下属处室 - 北京市外商投资企业服务中心 - ws-tcj
            '3fa6efc6_9aa3_499d_93e8_ae4b74096cc9', //政府招商下属处室 - 信息服务中心 - xxffzx-tcj
            'a27783a7_0295_4bfd_a06c_38597c44f0b0', //园区招商 - 中关村科技园区昌平园 - cpq-cpy
            '25ABDC37-C075-C137-C71F-95E464EC9C78', //园区招商 - 中关村软件园 - zgc-rjy
            '88BA11E3-5BA2-DA70-7EC3-886DAC543456', //园区招商 - 华膳产业园 - hscyy
            'EE7D8EE93C58ABB2A767166173940BC9', //园区招商 - 通州区光机电一体化基地 - tzqgjd
            '0B685844-7307-FE9D-6724-92103EC6BBB9', //园区招商 - 中关村科技园区海淀园 - zgc-hdy
            'D4F66488-25D1-5724-528A-C184938EC24F', //园区招商 - 北京经济技术开发区 - zgc-yzy
            '977C0A55-F3AA-6186-DEF0-6B0825FE2D0E', //园区招商 - 中关村科技园区丰台园 - zgc-fty
            '7F1098C4-BE2D-1086-7C8F-69BC8A461791', //园区招商 - 中关村科技园石景山园 - zgc-sjsy
            'BDAA54D9-F169-DA3F-69FC-8546D326ABD2', //园区招商 - 中关村科技园朝阳园 - zgc-cyy
            '25672C3A-9D82-AACF-29A2-E7FED90F44E7', //园区招商 - 北京石化新材料科技产业基地 - fsq-xcl
            '627E1F2C-3D0D-6638-4829-8CBE31CBBF08', //园区招商 - 中关村科技园延庆园 - zgc-yqy
            'A35FD876-A5F3-5748-CDC6-CE05CB0CA59B', //园区招商 - 中关村科技园密云园 - zgc-myy
            '6449DA35-6D52-4887-6839-983EA8374608', //园区招商 - 中关村科技园怀柔园 - zgc-hry
            '956987C3-F552-A210-E0E4-2C68DFDC7C1A', //园区招商 - 中关村科技园平谷园 - zgc-pgy
            '7B83E182-EBE3-397E-8450-55E9EB2889C2', //园区招商 - 中关村科技园大兴生物医药基地 - zgc-dxy
            '7F771693-8631-CA9D-030E-2638D0376EF4', //园区招商 - 中关村科技园顺义园 - zgc-syy
            '6655C3EE-359D-8571-A9BF-6AB16FEBF8C8', //园区招商 - 中关村科技园通州园 - zgc-tzy
            'B6674062-6ED5-6C17-8768-D9E024DE6EF4', //园区招商 - 中关村科技园门头沟园 - zgc-mtgy
            '084E26F2-BC9A-EE0E-4DDF-8AEDFED01886', //园区招商 - 中关村科技园西城园 - zgc-dsy
            '7CC17F59-226A-025A-D7DC-6B635BB0DE3F', //园区招商 - 中关村科技园东城园 - zgc-dcq
            'b0265935_2740_40f8_888d_a7bdce1723b7', //园区招商 - 密云生态商务区 - myx-stswq
            '71AFB93D-FE74-A4E6-F0D6-B4F74EE741BA', //园区招商 - 北京天竺综合保税区 - tzkxkfq
            'ED1AD3092639676D15B13F01FBE972BF', //园区招商 - 中关村科技园房山园 - zgc-fsy
            'E0C14762C97FFD2BF49279EBEB242C2F', //园区招商 - 北京延庆经济开发区 - yqjjkfq
            'F00AFABB5483CB5886A8CC153D094EDA', //园区招商 - 北京马坊工业园区 - mfgyy
        );
    }

    /**
     * 获取西城区15个街道专区的用户ID列表
     * @return array 用户ID列表
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getXichengStreetUserIdes() {
        return array(
            '372BB121-D86A-2E7E-5D7E-8C26D89943D1', //政府招商 - 北京市西城区白纸坊街道 - xcq-bzf
            '93E9CC59-D004-FA26-DF2B-E95AD394BCB2', //政府招商 - 北京市西城区椿树街道 - xcq-cs
            'C7ADE390-5580-E87A-631D-AEB38E29AB70', //政府招商 - 北京市西城区新街口街道 - xcq-xjk
            'D7D5A960-7F0E-A967-BCAF-93624678A612', //政府招商 - 北京市西城区牛街街道 - xcq-nj
            '45170F12-DEC1-DC13-4A7C-0483F61AA2A7', //政府招商 - 北京市西城区广安门外街道 - xcq-gamw
            'B91C2BDF-C638-A3BC-E60A-7C5C28364513', //政府招商 - 北京市西城区金融街街道 - xcq-jrj
            '1C02A8FB-55F8-62B7-A218-69EE09A00748', //政府招商 - 北京市西城区广安门内街道 - xcq-gamn
            '082E2EFD-7B9A-BEF4-5EA2-56704CF31123', //政府招商 - 北京市西城区展览路街道 - xcq-zll
            'D3293221-AE04-5743-2D11-1C6B0076010A', //政府招商 - 北京市西城区什刹海街道 - xcq-sch
            'D4CE2311-F9B2-7F12-A759-656A924BEC88', //政府招商 - 北京市西城区陶然亭街道 - xcq-trt
            'CFCF4E81-E73E-59F7-4F73-63090B13F50E', //政府招商 - 北京市西城区天桥街道 - xcq-tq
            '91233F91-2B7D-2E02-1BEE-2F220757D1D6', //政府招商 - 北京市西城区大栅栏街道 - xcq-dsl
            '2DA0CC80-DD36-2F54-CC2C-045165924293', //政府招商 - 北京市西城区德胜街道 - xcq-ds
            '7A82EC1D-9E03-5F6A-82E7-A4F18C88D03C', //政府招商 - 北京市西城区西长安街街道 - xcq-xca
            '2D0877F7-D431-E2DE-BC83-EEF3A39C5C32', //政府招商 - 北京市西城区月坛街道 - xcq-yt
        );
    }

    /**
     * 获取用户职员信息
     * @staticvar array $datas
     * @return array
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getUserStaff() {
        static $datas;
        if (isset($datas) && $datas) {
            return $datas;
        }
        $enterpriseNames = array(
            '投联网',
            '传世东方（北京）投资有限公司',
            '传世投联（北京）科技有限公司',
            '国玫思贤（北京）投资有限公司',
            '投联智通（北京）信息技术有限公司',
            '北京卡斯文化研究院'
        );
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('u.ID AS UserID, u.Status, ui.RealName, ui.EnterpriseName')
                ->from('t_user u')
                ->join('t_user_individual ui', 'ui.UserID = u.ID')
                ->where(array('and', 'u.RoleID = :RoleID', array('in', 'ui.EnterpriseName', $enterpriseNames)), array(':RoleID' => DbOption::$Role_Id_Admin))
                ->order('u.Status ASC')
                ->queryAll();
        return $datas;
    }

    /**
     * 通过子级用户ID获取父级用户ID
     * @param string $childId 子级用户ID
     * @return string|false 成功则返回父级用户ID，失败返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getParentId($childId) {
        if (!$childId) {
            return false;
        }
        $userId = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('ParentID')
                ->from('t_user_references')
                ->where('ChildID = :ChildID', array(':ChildID' => $childId))
                ->queryScalar();
        return $userId;
    }

    /**
     * 通过父级用户ID获取子级用户ID列表
     * @param string $parentId 父级用户ID
     * @return array 成功则返回子级用户ID列表，失败返回空数组
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function getChildIdes($parentId) {
        if (!$parentId) {
            return array();
        }
        $userIdes = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('ChildID')
                ->from('t_user_references')
                ->where('ParentID = :ParentID', array(':ParentID' => $parentId))
                ->queryColumn();
        return $userIdes;
    }

    /**
     * 检查子级用户ID是否存在父级用户
     * @staticvar array $counts
     * @param string $childId 子级用户ID
     * @return boolean 存在则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function existParent($childId) {
        if (!$childId) {
            return false;
        }
        static $counts;
        if (!isset($counts)) {
            $counts = array();
        }
        if (isset($counts[$childId])) {
            return $counts[$childId] ? true : false;
        }
        $count = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('COUNT(ID)')
                ->from('t_user_references')
                ->where('ChildID = :ChildID', array(':ChildID' => $childId))
                ->queryScalar();
        $counts[$childId] = $count;
        return $count ? true : false;
    }

    /**
     * 检查父级用户ID是否存在子级用户
     * @staticvar array $counts
     * @param string $parentId 父级用户ID
     * @return boolean 存在则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function existChild($parentId) {
        if (!$parentId) {
            return false;
        }
        static $counts;
        if (!isset($counts)) {
            $counts = array();
        }
        if (isset($counts[$parentId])) {
            return $counts[$parentId] ? true : false;
        }
        $count = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('COUNT(ID)')
                ->from('t_user_references')
                ->where('ParentID = :ParentID', array(':ParentID' => $parentId))
                ->queryScalar();
        $counts[$parentId] = $count;
        return $count ? true : false;
    }

    /**
     * 检查两个用户ID是否存在父子级关系。
     * @staticvar array $counts
     * @param string $parentId 父级用户ID
     * @param string $childId 子级用户ID
     * @return boolean 存在则返回 TRUE，否则返回 FALSE
     * @author Changfeng Ji <jichf@qq.com>
     */
    public static function existParentChild($parentId, $childId) {
        if (!$parentId || !$childId) {
            return false;
        }
        static $counts;
        if (!isset($counts)) {
            $counts = array();
        }
        if (isset($counts[$parentId . '_' . $childId])) {
            return $counts[$parentId . '_' . $childId] ? true : false;
        }
        $count = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('COUNT(ID)')
                ->from('t_user_references')
                ->where(array('and', 'ParentID = :ParentID', 'ChildID = :ChildID'), array(':ParentID' => $parentId, ':ChildID' => $childId))
                ->queryScalar();
        $counts[$parentId . '_' . $childId] = $count;
        return $count ? true : false;
    }

}
