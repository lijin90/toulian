<?php

/**
 * This is the model class for table "t_investservice_apply".
 *
 * The followings are the available columns in table 't_investservice_apply':
 * @property string $ID
 * @property string $WechatOpenId
 * @property string $CompanyName
 * @property string $CompanyType
 * @property string $RegisteredDate
 * @property integer $RegisteredCapital
 * @property string $RegisteredCapitalUnit
 * @property string $BusinessLicense
 * @property string $Contact
 * @property string $Phone
 * @property integer $Created
 * @property integer $Status
 * @property string $UserID
 * @property string $Comment
 */
class InvestserviceApply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_investservice_apply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('RegisteredCapital, Created, Status', 'numerical', 'integerOnly' => true),
            array('ID, UserID', 'length', 'max' => 36),
            array('WechatOpenId, BusinessLicense, Comment', 'length', 'max' => 255),
            array('CompanyName', 'length', 'max' => 100),
            array('CompanyType, RegisteredDate, RegisteredCapitalUnit, Contact, Phone', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, WechatOpenId, CompanyName, CompanyType, RegisteredDate, RegisteredCapital, RegisteredCapitalUnit, BusinessLicense, Contact, Phone, Created, Status, UserID, Comment', 'safe', 'on' => 'search'),
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
            'CompanyName' => '公司名称',
            'CompanyType' => '公司类型，包括：内资、外资',
            'RegisteredDate' => '注册日期',
            'RegisteredCapital' => '注册资金',
            'RegisteredCapitalUnit' => '注册资金单位，包括：万元/RMB、万元/美元',
            'BusinessLicense' => '营业执照',
            'Contact' => '联系人姓名',
            'Phone' => '联系人电话',
            'Created' => '创建时间',
            'Status' => '审核状态，包括：1:审核中、2:审核未通过、3:审核通过',
            'UserID' => '更改审核状态的用户ID',
            'Comment' => '备注，填写拒绝理由',
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
        $criteria->compare('CompanyName', $this->CompanyName, true);
        $criteria->compare('CompanyType', $this->CompanyType, true);
        $criteria->compare('RegisteredDate', $this->RegisteredDate, true);
        $criteria->compare('RegisteredCapital', $this->RegisteredCapital);
        $criteria->compare('RegisteredCapitalUnit', $this->RegisteredCapitalUnit, true);
        $criteria->compare('BusinessLicense', $this->BusinessLicense, true);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('Created', $this->Created);
        $criteria->compare('Status', $this->Status);
        $criteria->compare('UserID', $this->UserID, true);
        $criteria->compare('Comment', $this->Comment, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InvestserviceApply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 获取数量
     * @param string $ownerId 所属人ID
     * @return array
     */
    public function getCounts($ownerId) {
        $counts = array(
            1 => 0, //审核中
            2 => 0, //审核未通过
            3 => 0, //审核通过
        );
        foreach ($counts as $key => $count) {
            $counts[$key] = (int) Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->from('t_investservice_apply')
                            ->select('COUNT(*)')
                            ->where(array('and', 'OwnerID = :OwnerID', 'Status = :Status'), array(':OwnerID' => $ownerId, ':Status' => $key))
                            ->queryScalar();
        }
        return $counts;
    }

    /**
     * 获取统计
     * @param string $ownerId 所属人ID
     * @return array
     */
    public function getStatistics($ownerId) {
        $monthStart = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $monthEnd = mktime(0, 0, 0, date("m") + 1, 1, date("Y")) - 1;
        $statistics = array(
            'domesticCapitalMoney' => 0, //内资注册资金总额
            'domesticCapitalCount' => 0, //内资项目总数量
            'domesticCapitalCountMonth' => 0, //内资项目当前月数量
            'foreignCapitalMoney' => 0, //外资注册资金总额
            'foreignCapitalCount' => 0, //外资项目总数量
        );
        $statistics['domesticCapitalMoney'] = (int) Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->from('t_investservice_apply')
                        ->select('SUM(RegisteredCapital)')
                        ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
                        ->queryScalar();
        $statistics['domesticCapitalCount'] = (int) Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->from('t_investservice_apply')
                        ->select('COUNT(ID)')
                        ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
                        ->queryScalar();
        $statistics['domesticCapitalCountMonth'] = (int) Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->from('t_investservice_apply')
                        ->select('COUNT(ID)')
                        ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'Created > ' . $monthStart, 'Created <= ' . $monthEnd), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
                        ->queryScalar();
        $statistics['foreignCapitalMoney'] = (int) Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->from('t_investservice_apply')
                        ->select('SUM(RegisteredCapital)')
                        ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
                        ->queryScalar();
        $statistics['foreignCapitalCount'] = (int) Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->from('t_investservice_apply')
                        ->select('COUNT(ID)')
                        ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
                        ->queryScalar();
        return $statistics;
    }

    /**
     * 检查统计
     * @param string $ownerId 所属人ID
     * @param string $companyType 公司类型
     * @return array
     */
    public function checkStatistics($ownerId, $companyType) {
        return Unit::ajaxJson(1, '暂不收录', '', true);
        $statistics = $this->getStatistics($ownerId);
        if ($companyType == '内资' && $statistics['domesticCapitalCountMonth'] >= 100) {
//            return Unit::ajaxJson(1, '内资项目数量每月达到100个，当月不再收集内资信息', '', true);
        } else if ($companyType == '内资' && $statistics['domesticCapitalCount'] >= 380) {
//            return Unit::ajaxJson(1, '内资项目数量累计达到380个，不再收集内资信息', '', true);
        } else if ($companyType == '外资' && $statistics['foreignCapitalCount'] >= 90) {
//            return Unit::ajaxJson(1, '外资项目数累计达到90个，不再收集外资信息', '', true);
        } else if ($companyType == '外资' && $statistics['foreignCapitalMoney'] >= 40000) {
//            return Unit::ajaxJson(1, '外资项目注册资金总额累计达到了4亿美元，不再收集外资信息', '', true);
        }
        return Unit::ajaxJson(0, '', '', true);
    }

    /**
     * 检查注册资金
     * @param string $ownerId 所属人ID
     * @param string $companyType 公司类型
     * @param string $registeredCapital 注册资金
     * @return array
     */
    public function checkRegisteredCapital($ownerId, $companyType, $registeredCapital) {
        $statistics = $this->getStatistics($ownerId);
        if ($companyType == '内资' && $registeredCapital < 100) {
            //return Unit::ajaxJson(1, '内资项目注册资金在100万以下，不再收集此项信息', '', true);
        } else if ($companyType == '内资' && $registeredCapital >= 100 && $registeredCapital < 1000) {
            $count = (int) Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->from('t_investservice_apply')
                            ->select('COUNT(ID)')
                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 100', 'RegisteredCapital < 1000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
                            ->queryScalar();
            if ($count >= 100 || $statistics['domesticCapitalMoney'] >= 100000) {
                return Unit::ajaxJson(1, '内资项目注册资金在100万元（含）-1000万元的，数量累计达到了100个，或者注册金额累计达到了10亿元的，不再收集此项信息', '', true);
            }
        } else if ($companyType == '内资' && $registeredCapital >= 1000 && $registeredCapital < 5000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 1000', 'RegisteredCapital < 5000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
//                            ->queryScalar();
//            if ($count >= 200 || $statistics['domesticCapitalMoney'] >= 300000) {
//                return Unit::ajaxJson(1, '内资项目注册资金在1000万元（含）-5000万元的，数量累计达到了200个，或者注册金额累计达到了30亿元的，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '内资' && $registeredCapital >= 5000 && $registeredCapital < 10000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 5000', 'RegisteredCapital < 10000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
//                            ->queryScalar();
//            if ($count >= 50 || $statistics['domesticCapitalMoney'] >= 300000) {
//                return Unit::ajaxJson(1, '内资项目注册资金在5000万元（含）-10000万元的，数量累计达到了50个，或者注册金额累计达到了30亿元的，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '内资' && $registeredCapital >= 10000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 10000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '内资'))
//                            ->queryScalar();
//            if ($count >= 30 || $statistics['domesticCapitalMoney'] >= 400000) {
//                return Unit::ajaxJson(1, '内资项目注册资金在10000万元（含）以上的，数量累计达到了30个，或者注册金额累计达到了40亿元的，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital < 20) {
            //return Unit::ajaxJson(1, '外资项目注册资金在20万美元以下，不再收集此项信息', '', true);
        } else if ($companyType == '外资' && $registeredCapital >= 20 && $registeredCapital < 100) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 20', 'RegisteredCapital < 100'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 40) {
//                return Unit::ajaxJson(1, '外资项目注册资金在20万美元（含）-100万美元的，数量累计达到了40个，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital >= 100 && $registeredCapital < 300) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 100', 'RegisteredCapital < 300'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 10) {
//                return Unit::ajaxJson(1, '外资项目注册资金在100万美元（含）-300万美元的，数量累计达到了10个，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital >= 300 && $registeredCapital < 500) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 300', 'RegisteredCapital < 500'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 10) {
//                return Unit::ajaxJson(1, '外资项目注册资金在300万美元（含）-500万美元的，数量累计达到了10个，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital >= 500 && $registeredCapital < 1000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 500', 'RegisteredCapital < 1000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 10) {
//                return Unit::ajaxJson(1, '外资项目注册资金在500万美元（含）-1000万美元的，数量累计达到了10个，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital >= 1000 && $registeredCapital < 3000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 1000', 'RegisteredCapital < 3000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 10) {
//                return Unit::ajaxJson(1, '外资项目注册资金在1000万美元（含）-3000万美元的，数量累计达到了10个，不再收集此项信息', '', true);
//            }
        } else if ($companyType == '外资' && $registeredCapital >= 3000) {
//            $count = (int) Yii::app()
//                            ->getDb()
//                            ->createCommand()
//                            ->from('t_investservice_apply')
//                            ->select('COUNT(ID)')
//                            ->where(array('and', 'OwnerID = :OwnerID', 'Status != :Status', 'CompanyType = :CompanyType', 'RegisteredCapital >= 3000'), array(':OwnerID' => $ownerId, ':Status' => 2, ':CompanyType' => '外资'))
//                            ->queryScalar();
//            if ($count >= 10) {
//                return Unit::ajaxJson(1, '外资项目注册资金在3000万美元（含）以上的，数量累计达到了10个，不再收集此项信息', '', true);
//            }
        }
        return Unit::ajaxJson(0, '', '', true);
    }

    /**
     * 获取红包统计
     * @param string $ownerId 所属人ID
     * @return array
     */
    public function getRedEnvelopeStatistics($ownerId) {
        $redEnvelopeMoney = array(1 => 0, 2 => 0, 3 => 0); //红包状态：1:可领取、2:已退款、3:已领取
        foreach (array_keys($redEnvelopeMoney) as $key) {
            $redEnvelopeMoney[$key] = (double) Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select('SUM(Money)')
                            ->from('t_investservice_re')
                            ->where(array('and', 'OwnerID = :OwnerID', 'Status = :Status'), array(':OwnerID' => $ownerId, ':Status' => $key))
                            ->queryScalar();
        }
        return $redEnvelopeMoney;
    }

    /**
     * 计算补助红包的金额
     * @param string $companyType 公司类型
     * @param string $registeredCapital 注册资金
     * @return int 金额（单位：元）
     */
    public function calcRedEnvelope($companyType, $registeredCapital) {
        if ($companyType == '内资' && $registeredCapital >= 100 && $registeredCapital < 1000) {
            return 50;
        } else if ($companyType == '内资' && $registeredCapital >= 1000 && $registeredCapital < 5000) {
            return 100;
        } else if ($companyType == '内资' && $registeredCapital >= 5000 && $registeredCapital < 10000) {
            return 200;
        } else if ($companyType == '内资' && $registeredCapital >= 10000) {
            return 1000;
        } else if ($companyType == '外资' && $registeredCapital >= 20 && $registeredCapital < 100) {
            return 100;
        } else if ($companyType == '外资' && $registeredCapital >= 100 && $registeredCapital < 300) {
            return 150;
        } else if ($companyType == '外资' && $registeredCapital >= 300 && $registeredCapital < 500) {
            return 200;
        } else if ($companyType == '外资' && $registeredCapital >= 500 && $registeredCapital < 1000) {
            return 500;
        } else if ($companyType == '外资' && $registeredCapital >= 1000 && $registeredCapital < 3000) {
            return 1000;
        } else if ($companyType == '外资' && $registeredCapital >= 3000) {
            return 1500;
        }
        return 0;
    }

    /**
     * 美元人民币汇率
     * 
     * 2017-02-15 汇率：1美元 = 6.8685人民币元
     * @param double $default 默认汇率，当获取不到实时汇率的时候将返回默认汇率。
     * @return double 返回美元人民币汇率
     */
    public function usdCny($default = 6.8685) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://quote.forex.hexun.com/USDCNY.shtml");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=gb2312'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($curl);
        curl_close($curl);
        if (!$result) {
            return $default;
        }
        $result = iconv('GB2312', 'UTF-8//IGNORE', $result);
        $matches = null;
        preg_match("/<span class=\".*?\" id=\"newprice\">(\d+(\.\d+)?)<\/span>/", $result, $matches);
        return isset($matches[1]) ? $matches[1] : $default;
    }

}
