<?php

/**
 * This is the model class for table "t_resource".
 *
 * The followings are the available columns in table 't_resource':
 * @property string $ID
 * @property string $UserID
 * @property string $BaseID
 * @property string $ResCategory
 * @property string $ResType
 * @property string $Title
 * @property string $BaseName
 * @property string $Support
 * @property integer $AreaCode
 * @property string $Address
 * @property string $IntentionName
 * @property string $RentPrice
 * @property string $RentUnit
 * @property string $SalePrice
 * @property string $SaleUnit
 * @property integer $IsNegotiable
 * @property double $Area
 * @property string $AreaUnit
 * @property double $RequireAreaA
 * @property double $RequireAreaB
 * @property string $RequireAreaUnit
 * @property string $Contact
 * @property string $Phone
 * @property integer $Status
 * @property integer $IsSearched
 * @property integer $IsRecommend
 * @property string $SortRecommend
 * @property string $Assigner
 * @property integer $AssignTime
 * @property string $Recommender
 * @property integer $RecommendTime
 * @property integer $CreateTime
 * @property integer $UpdateTime
 */
class Resource extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_resource';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ID', 'required'),
            array('AreaCode, IsNegotiable, Status, IsSearched, IsRecommend, AssignTime, RecommendTime, CreateTime, UpdateTime', 'numerical', 'integerOnly' => true),
            array('Area, RequireAreaA, RequireAreaB', 'numerical'),
            array('ID, UserID, BaseID, IntentionName, Assigner, Recommender', 'length', 'max' => 36),
            array('ResCategory, ResType', 'length', 'max' => 64),
            array('Title, BaseName, Address', 'length', 'max' => 255),
            array('RentPrice, RentUnit, SalePrice, SaleUnit, AreaUnit, RequireAreaUnit', 'length', 'max' => 10),
            array('Contact, Phone', 'length', 'max' => 32),
            array('SortRecommend', 'length', 'max' => 5),
            array('Support', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ID, UserID, BaseID, ResCategory, ResType, Title, BaseName, Support, AreaCode, Address, IntentionName, RentPrice, RentUnit, SalePrice, SaleUnit, IsNegotiable, Area, AreaUnit, RequireAreaA, RequireAreaB, RequireAreaUnit, Contact, Phone, Status, IsSearched, IsRecommend, SortRecommend, Assigner, AssignTime, Recommender, RecommendTime, CreateTime, UpdateTime', 'safe', 'on' => 'search'),
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
            'UserID' => '用户ID',
            'BaseID' => '基本信息ID, 基本信息可以是供应基本信息（t_resource_xxx_supply）或者需求基本信息（t_resource_xxx_demand）',
            'ResCategory' => '资源类别，包括：land:土地、factory:厂房、officebuilding:写字楼、shop:商铺',
            'ResType' => '资源类型，包括：supply:供应、demand:需求',
            'Title' => '标题党',
            'BaseName' => '供需资源名称, 例如：写字楼名称、厂房名称、商铺名称、土地名称',
            'Support' => '配套信息',
            'AreaCode' => '所属地区ID',
            'Address' => '具体地址',
            'IntentionName' => '意向名称：出租、出售、可租可售、求租、求购、可租可购',
            'RentPrice' => '出租价格',
            'RentUnit' => '出租单位，包括：元/m2/天、元/月',
            'SalePrice' => '出售价格',
            'SaleUnit' => '出售单位，包括：元/m2、万元、万元/亩(土地)',
            'IsNegotiable' => '价格是否可议 (0 代表 否  1 代表 是)',
            'Area' => '面积, 要素的建筑面积, 土地就是土地面积，其他的要素均为建筑面积',
            'AreaUnit' => '面积单位，包括：平方米、亩',
            'RequireAreaA' => '需求面积A',
            'RequireAreaB' => '需求面积B',
            'RequireAreaUnit' => '需求面积单位，包括：平方米、亩',
            'Contact' => '联系人',
            'Phone' => '联系电话',
            'Status' => '资源状态，包括：0:删除、1:正常',
            'IsSearched' => '资源是否被搜索筛选出来， 0 不被搜索  1 被搜索 （不被搜索的规则有 1. 资源未发布 2. 角色为个人的用户发布的资源未被代理 3. 资源已完成交易）',
            'IsRecommend' => '是否推荐，针对后台操作。0 否  1 是',
            'SortRecommend' => '推荐排序，DESC排序',
            'Assigner' => '分配用户ID',
            'AssignTime' => '分配时间',
            'Recommender' => '推荐人用户ID',
            'RecommendTime' => '推荐时间',
            'CreateTime' => '创建时间',
            'UpdateTime' => '修改时间',
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
        $criteria->compare('BaseID', $this->BaseID, true);
        $criteria->compare('ResCategory', $this->ResCategory, true);
        $criteria->compare('ResType', $this->ResType, true);
        $criteria->compare('Title', $this->Title, true);
        $criteria->compare('BaseName', $this->BaseName, true);
        $criteria->compare('Support', $this->Support, true);
        $criteria->compare('AreaCode', $this->AreaCode);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('IntentionName', $this->IntentionName, true);
        $criteria->compare('RentPrice', $this->RentPrice, true);
        $criteria->compare('RentUnit', $this->RentUnit, true);
        $criteria->compare('SalePrice', $this->SalePrice, true);
        $criteria->compare('SaleUnit', $this->SaleUnit, true);
        $criteria->compare('IsNegotiable', $this->IsNegotiable);
        $criteria->compare('Area', $this->Area);
        $criteria->compare('AreaUnit', $this->AreaUnit, true);
        $criteria->compare('RequireAreaA', $this->RequireAreaA);
        $criteria->compare('RequireAreaB', $this->RequireAreaB);
        $criteria->compare('RequireAreaUnit', $this->RequireAreaUnit, true);
        $criteria->compare('Contact', $this->Contact, true);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('Status', $this->Status);
        $criteria->compare('IsSearched', $this->IsSearched);
        $criteria->compare('IsRecommend', $this->IsRecommend);
        $criteria->compare('SortRecommend', $this->SortRecommend, true);
        $criteria->compare('Assigner', $this->Assigner, true);
        $criteria->compare('AssignTime', $this->AssignTime);
        $criteria->compare('Recommender', $this->Recommender, true);
        $criteria->compare('RecommendTime', $this->RecommendTime);
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
     * @return Resource the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     * @param string/array $userId  用户ID或用户ID列表。默认为 ALL，即列举全部
     * @param array $params 扩展参数，包括:
     *  - id: 资源ID或资源ID列表
     *  - resCategory: 资源类别，包括：land:土地、factory:厂房、officebuilding:写字楼、shop:商铺
     *  - resType: 资源类型，包括：supply:供应、demand:需求
     *  - title: [模糊查询]标题党
     *  - baseName: [模糊查询]供需资源名称, 例如：写字楼名称、厂房名称、商铺名称、土地名称
     *  - areaCode: 所属地区ID
     *  - intentionName: 意向名称：出租、出售、可租可售、求租、求购、可租可购
     *  - status: 资源状态，包括：0:删除、1:正常
     *  - isSearched: 资源是否被搜索筛选出来， 0 不被搜索  1 被搜索
     *  - isRecommend: 是否推荐，针对后台操作。0 否  1 是
     *  - releaseStatus: 发布状态，包括：0:草稿、1:待审核、2:已拒绝、3:已审核
     *  - tradeStatus: 交易状态，包括：0:申请代理、1:同意代理 2:拒绝代理、3:关闭代理、4:已代理、5:申请委托、
     *          6:已委托、7:洽谈中、8:终止、9:已洽谈、10:已签约、
     *          11:已评价、12:分配、13:已发布、14:拒绝委托
     *  - updateTimeStart: 开始更新时间
     *  - updateTimeEnd: 结束更新时间
     *  - customWhere: 自定义WHERE条件
     *  - limit: number of items in each page
     *  - offset: Sets the OFFSET part of the query
     *  - page: the zero-based index of the current page
     *  - loadReleaseStatuses: 是否加载资源的发布状态详情，默认为FALSE
     *  - loadTradeStatuses: 是否加载资源的交易状态详情，默认为FALSE
     *  - loadImages: 是否加载资源的图片，默认为FALSE。注：当为TRUE时，同时也加载资源Logo完整路径
     *  - loadProtocols: 是否加载资源的资源，默认为FALSE
     *  - loadInfo: 是否加载基本信息表
     * @return array 返回资源列表，失败则返回<b>FALSE</b>
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function getResources($userId = 'ALL', $params = array()) {
        if (empty($userId)) {
            return false;
        }
        $selects = array();
        $selects[] = 'r.*';
        $selects[] = 'rrs.Status AS ReleaseStatus';
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from("t_resource r")
                ->join("t_resource_release_status rrs", "r.ID = rrs.ResID")
                ->order('r.SortRecommend DESC, r.CreateTime DESC');
        if (is_string($userId) && $userId != 'ALL') {
            $query->andWhere(array(
                'or', array('and', 'r.UserID=:UserID', 'r.Assigner=""', 'r.Recommender=""'),
                'r.Assigner=:UserID2'), array(':UserID' => $userId, ':UserID2' => $userId));
        } else if (is_array($userId)) {
            $query->andWhere(array('in', 'r.UserID', $userId));
        }
        if (isset($params['id']) && !empty($params['id']) && is_string($params['id'])) {
            $query->andWhere('r.ID=:ID', array(':ID' => $params['id']));
        } else if (isset($params['id']) && !empty($params['id']) && is_array($params['id'])) {
            $query->andWhere(array('in', 'r.ID', $params['id']));
        }
        if (isset($params['resCategory']) && !empty($params['resCategory'])) {
            $query->andWhere('r.ResCategory=:ResCategory', array(':ResCategory' => $params['resCategory']));
        }
        if (isset($params['resType']) && !empty($params['resType'])) {
            $query->andWhere('r.ResType=:ResType', array(':ResType' => $params['resType']));
        }
        if (isset($params['title']) && !empty($params['title'])) {
            $query->andWhere(array('like', 'r.Title', '%' . Unit::escapeLike($params['title']) . '&'));
        }
        if (isset($params['baseName']) && !empty($params['baseName'])) {
            $query->andWhere(array('like', 'r.BaseName', '%' . Unit::escapeLike($params['baseName']) . '&'));
        }
        if (isset($params['areaCode']) && !empty($params['areaCode'])) {
            $acPrefix = rtrim($params['areaCode'], '0');
            $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
            $query->andWhere(array('like', 'r.AreaCode', $acPrefix . '%'));
        }
        if (isset($params['intentionName']) && !empty($params['intentionName'])) {
            $query->andWhere('r.IntentionName=:IntentionName', array(':IntentionName' => $params['intentionName']));
        }
        if (isset($params['status']) && strlen($params['status']) > 0) {
            $query->andWhere('r.Status=:Status', array(':Status' => $params['status']));
        }
        if (isset($params['isSearched']) && strlen($params['isSearched']) > 0) {
            $query->andWhere('r.IsSearched=:IsSearched', array(':IsSearched' => $params['isSearched']));
        }
        if (isset($params['isRecommend']) && strlen($params['isRecommend']) > 0) {
            $query->andWhere('r.IsRecommend=:IsRecommend', array(':IsRecommend' => $params['isRecommend']));
        }
        if (isset($params['releaseStatus']) && strlen($params['releaseStatus']) > 0) {
            $query->andWhere('rrs.Status=:ReleaseStatus', array(':ReleaseStatus' => $params['releaseStatus']));
        }
        if (isset($params['tradeStatus']) && strlen($params['tradeStatus']) > 0) {
            $selects[] = 'rts.Status AS TradeStatus';
            $query->join("t_resource_trade_status rts", "r.ID = rts.ResID");
            $query->andWhere('rts.Status=:TradeStatus', array(':TradeStatus' => $params['tradeStatus']));
        }
        if (isset($params['updateTimeStart']) && is_numeric($params['updateTimeStart'])) {
            $query->andWhere('r.UpdateTime >= :UpdateTimeStart', array(':UpdateTimeStart' => $params['updateTimeStart']));
        }
        if (isset($params['updateTimeEnd']) && is_numeric($params['updateTimeEnd'])) {
            $query->andWhere('r.UpdateTime <= :UpdateTimeEnd', array(':UpdateTimeEnd' => $params['updateTimeEnd']));
        }
        if (isset($params['customWhere']) && !empty($params['customWhere'])) {
            $query->andWhere($params['customWhere']);
        }
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(r.ID)')->queryScalar();
        $pages = new CPagination($count);
        if (isset($params['limit']) && is_numeric($params['limit'])) {
            $pages->setPageSize($params['limit']);
        } else {
            $pages->setPageSize($count);
        }
        if (isset($params['page']) && is_numeric($params['page'])) {
            $pages->setCurrentPage($params['page']);
        }
        $offset = $pages->currentPage * $pages->pageSize;
        if (isset($params['offset']) && is_numeric($params['offset'])) {
            $offset = $params['offset'];
        }
        $datas = $query
                ->select(implode(', ', $selects))
                ->limit($pages->pageSize)
                ->offset($offset)
                ->queryAll();
        if ($datas) {
            $ides = Unit::arrayColumn($datas, 'ID');
            $datas = Unit::arrayColumn($datas, null, 'ID');
            foreach ($datas as $key => $data) {
                $datas[$key]['Price'] = $data['RentPrice'] && $data['RentPrice'] > 0 ? $data['RentPrice'] : $data['SalePrice'];
                $datas[$key]['PriceUnit'] = $data['RentPrice'] && $data['RentPrice'] > 0 ? $data['RentUnit'] : $data['SaleUnit'];
                $datas[$key]['images'] = array();
                $datas[$key]['protocols'] = array();
                $datas[$key]['releaseStatuses'] = array();
                $datas[$key]['tradeStatuses'] = array();
                $datas[$key]['tradeStatusIdes'] = array();
                $datas[$key]['info'] = array();
            }
            if (isset($params['loadReleaseStatuses']) && $params['loadReleaseStatuses']) {
                $releaseStatuses = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('rrs.*')
                        ->from("t_resource_release_status rrs")
                        ->where(array('in', 'rrs.ResID', $ides))
                        ->queryAll();
                foreach ($releaseStatuses as $releaseStatus) {
                    if (isset($datas[$releaseStatus['ResID']])) {
                        $datas[$releaseStatus['ResID']]['releaseStatuses'][] = $releaseStatus;
                    }
                }
            }
            if (isset($params['loadTradeStatuses']) && $params['loadTradeStatuses']) {
                $tradeStatuses = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('rts.*')
                        ->from("t_resource_trade_status rts")
                        ->where(array('in', 'rts.ResID', $ides))
                        ->order('rts.CreateTime DESC')
                        ->queryAll();
                foreach ($tradeStatuses as $tradeStatus) {
                    if (isset($datas[$tradeStatus['ResID']])) {
                        $datas[$tradeStatus['ResID']]['tradeStatuses'][] = $tradeStatus;
                        $datas[$tradeStatus['ResID']]['tradeStatusIdes'][] = $tradeStatus['Status'];
                    }
                }
            }
            if (isset($params['loadImages']) && $params['loadImages']) {
                $images = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('ri.*, eic.ResCategory, eic.TypeName, eic.IsRequired')
                        ->from("t_resource_images ri")
                        ->join("t_element_images_category eic", "ri.ImageCategoryID = eic.ID")
                        ->where(array('in', 'ri.ResID', $ides))
                        ->order('ri.SortNo ASC')
                        ->queryAll();
                foreach ($images as $image) {
                    if (isset($datas[$image['ResID']])) {
                        $datas[$image['ResID']]['images'][] = $image;
                    }
                }
                foreach ($datas as &$data) {
                    $data['Logo'] = '';
                    foreach ($data['images'] as $image) {
                        if ($image['TypeName'] == '外观图') {
                            $data['Logo'] = FileUploadHelper::getFileUrl($image['ImagePath']);
                            break;
                        }
                    }
                    if (!$data['Logo'] && $data['images']) {
                        $data['Logo'] = FileUploadHelper::getFileUrl($data['images'][0]['ImagePath']);
                    }
                    $data['Logo'] = $data['Logo'] ? $data['Logo'] : DbOption::defaultLogo($data['ResCategory']);
                }
            }
            if (isset($params['loadProtocols']) && $params['loadProtocols']) {
                $protocols = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('rp.*')
                        ->from("t_resource_protocol rp")
                        ->where(array('in', 'rp.ResID', $ides))
                        ->queryAll();
                foreach ($protocols as $protocol) {
                    if (isset($datas[$protocol['ResID']])) {
                        $datas[$protocol['ResID']]['protocols'][] = $protocol;
                    }
                }
            }
            if (isset($params['loadInfo']) && $params['loadInfo']) {
                $baseIDes = Unit::arrayColumn($datas, 'BaseID');
                $datas = Unit::arrayColumn($datas, null, 'BaseID');
                $infos = array();
                $infoTables = array_reduce($datas, create_function('$v,$w', '$v[] = "t_resource_" . $w["ResCategory"] . "_" . $w["ResType"];return $v;'));
                $infoTables = array_unique($infoTables);
                foreach ($infoTables as $infoTable) {
                    $infos = array_merge(
                            $infos, Yii::app()
                                    ->getDb()
                                    ->createCommand()
                                    ->select('rb.*')
                                    ->from($infoTable . " rb")
                                    ->where(array('in', 'rb.ID', $baseIDes))
                                    ->queryAll()
                    );
                }
                foreach ($infos as $info) {
                    if (isset($datas[$info['ID']])) {
                        $datas[$info['ID']]['info'] = $info;
                    }
                }
            }
            $datas = array_values($datas);
        }
        return array(
            'datas' => $datas,
            'pages' => $pages,
            'pagination' => (object) array(
                'itemCount' => $pages->getItemCount(),
                'pageSize' => $pages->getLimit(),
                'pageCount' => $pages->getPageCount(),
                'currentPage' => $pages->getCurrentPage()
            )
        );
    }

    /**
     * 添加资源
     * @param array $params 字段参数，存储到 t_resource 表
     * @param array $fields 字段参数，存储到 t_resource_land_supply 表
     * @param array $mixed 混合参数，包括: 
     *  - SaveMode: 保存模式，包括：1-草稿、2-发布
     *  - Images: 上传图片列表
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function addResource($params, $fields, $mixed = array()) {
        $time = time();
        $id = Unit::stringGuid();
        $baseId = Unit::stringGuid();
        $params['ID'] = $id;
        if (!isset($params['UserID'])) {
            $userId = Unit::getLoggedUserId();
            $params['UserID'] = $userId ? $userId : DbOption::$User_Id_Anonymous;
        }
        $params['BaseID'] = $baseId;
        /* 组装标题党 - 开始 */
        $titles = array();
        $titles[] = $params['IntentionName'];
        if (isset($params['AreaCode']) && $params['AreaCode']) {
            //$titles[] = Pcas::code2name($params['AreaCode']);
        }
        if (isset($params['Area']) && $params['Area']) {
            $titles[] = $params['Area'] . $params['AreaUnit'];
        }
        if (isset($params['RequireAreaA']) && $params['RequireAreaA'] && isset($params['RequireAreaB']) && $params['RequireAreaB']) {
            $titles[] = $params['RequireAreaA'] . '-' . $params['RequireAreaB'] . $params['RequireAreaUnit'];
        }
        if (isset($params['IsNegotiable']) && $params['IsNegotiable']) {
            $titles[] = '面议';
        } else if (isset($params['RentPrice']) && is_numeric($params['RentPrice']) && $params['RentPrice'] > 0) {
            $titles[] = $params['RentPrice'] . $params['RentUnit'];
        } else if (isset($params['SalePrice']) && is_numeric($params['SalePrice']) && $params['SalePrice'] > 0) {
            $titles[] = $params['SalePrice'] . $params['SaleUnit'];
        }
        $titles[] = $params['BaseName'];
        $params['Title'] = implode(' ', $titles);
        /* 组装标题党 - 结束 */
        $params['Status'] = 1;
        $params['IsSearched'] = 1;
        $params['IsRecommend'] = 0;
        $params['CreateTime'] = $time;
        $params['UpdateTime'] = $time;
        $fields['ID'] = $baseId;
        $connection = Yii::app()->getDb();
        $transaction = $connection->beginTransaction();
        try {
            $rt = $connection->createCommand()->insert('t_resource', $params);
            if (!$rt) {
                throw new Exception();
            }
            $rt = $connection->createCommand()->insert('t_resource_' . $params['ResCategory'] . '_' . $params['ResType'], $fields);
            if (!$rt) {
                throw new Exception();
            }
            $releaseStatus = isset($mixed['SaveMode']) && $mixed['SaveMode'] == 2 ? ($this->isAuditPass() ? 3 : 1) : 0;
            $releaseStatus = $params['ResType'] == 'demand' ? 3 : $releaseStatus;
            $rt = $connection->createCommand()->insert('t_resource_release_status', array(
                'ID' => Unit::stringGuid(),
                'ResID' => $id,
                'Status' => $releaseStatus
            ));
            if (!$rt) {
                throw new Exception();
            }
            if (isset($mixed['Images']) && $mixed['Images']) {
                foreach ($mixed['Images'] as $image) {
                    $rt = $connection->createCommand()->insert('t_resource_images', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $id,
                        'ImageName' => $image['ImageName'],
                        'ImagePath' => $image['ImagePath'],
                        'ImageCategoryID' => $image['ImageCategoryID'],
                        'SortNo' => $image['SortNo']
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                }
            }
            $transaction->commit();
            Unit::ajaxJson(0, '', $params['Title']);
        } catch (Exception $e) {
            $transaction->rollback();
            $category = DbOption::$resource['category'][$params['ResCategory']];
            $type = DbOption::$resource['type'][$params['ResType']];
            Unit::ajaxJson(1, '发布' . $category . $type . '信息失败');
        }
    }

    /**
     * 编辑资源
     * @param array $resId 资源ID
     * @param array $baseId 基本信息ID
     * @param array $params 字段参数，存储到 t_resource 表
     * @param array $fields 字段参数，存储到 t_resource_land_supply 表
     * @param array $mixed 混合参数，包括: 
     *  - SaveMode: 保存模式，包括：1-草稿、2-发布
     *  - Images: 上传图片列表
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function editResource($id, $baseId, $params, $fields, $mixed = array()) {
        $time = time();
        /* 组装标题党 - 开始 */
        $titles = array();
        $titles[] = $params['IntentionName'];
        if (isset($params['AreaCode']) && $params['AreaCode']) {
            //$titles[] = Pcas::code2name($params['AreaCode']);
        }
        if (isset($params['Area']) && $params['Area']) {
            $titles[] = $params['Area'] . $params['AreaUnit'];
        }
        if (isset($params['RequireAreaA']) && $params['RequireAreaA'] && isset($params['RequireAreaB']) && $params['RequireAreaB']) {
            $titles[] = $params['RequireAreaA'] . '-' . $params['RequireAreaB'] . $params['RequireAreaUnit'];
        }
        if (isset($params['IsNegotiable']) && $params['IsNegotiable']) {
            $titles[] = '面议';
        } else if (isset($params['RentPrice']) && is_numeric($params['RentPrice']) && $params['RentPrice'] > 0) {
            $titles[] = $params['RentPrice'] . $params['RentUnit'];
        } else if (isset($params['SalePrice']) && is_numeric($params['SalePrice']) && $params['SalePrice'] > 0) {
            $titles[] = $params['SalePrice'] . $params['SaleUnit'];
        }
        $titles[] = $params['BaseName'];
        $params['Title'] = implode(' ', $titles);
        $params['UpdateTime'] = $time;
        /* 组装标题党 - 结束 */
        $connection = Yii::app()->getDb();
        $transaction = $connection->beginTransaction();
        try {
            $rt = $connection->createCommand()->update('t_resource', $params, 'ID = :ID', array(':ID' => $id));
            if ($rt === false) {
                throw new Exception();
            }
            $rt = $connection->createCommand()->update('t_resource_' . $params['ResCategory'] . '_' . $params['ResType'], $fields, 'ID = :ID', array(':ID' => $baseId));
            if ($rt === false) {
                throw new Exception();
            }
            $releaseStatus = isset($mixed['SaveMode']) && $mixed['SaveMode'] == 2 ? ($this->isAuditPass() ? 3 : 1) : 0;
            $rt = $connection->createCommand()->update('t_resource_release_status', array('Status' => $releaseStatus), 'ResID = :ResID', array(':ResID' => $id));
            if ($rt === false) {
                throw new Exception();
            }
            if (isset($mixed['Images']) && $mixed['Images']) {
                foreach ($mixed['Images'] as $image) {
                    $rt = $connection->createCommand()->insert('t_resource_images', array(
                        'ID' => Unit::stringGuid(),
                        'ResID' => $id,
                        'ImageName' => $image['ImageName'],
                        'ImagePath' => $image['ImagePath'],
                        'ImageCategoryID' => $image['ImageCategoryID'],
                        'SortNo' => $image['SortNo']
                    ));
                    if (!$rt) {
                        throw new Exception();
                    }
                }
            }
            $transaction->commit();
            Unit::ajaxJson(0, '', $params['Title']);
        } catch (Exception $e) {
            $transaction->rollback();
            $category = DbOption::$resource['category'][$params['ResCategory']];
            $type = DbOption::$resource['type'][$params['ResType']];
            Unit::ajaxJson(1, '修改' . $category . $type . '信息失败');
        }
    }

    /**
     * 检查资源是否允许编辑
     * @param array $tradeStatusIdes 交易状态ID列表
     * @return boolean/string 允许编辑时返回 TRUE，不允许编辑时返回当前交易状态名称
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function isAllowEdit($tradeStatusIdes) {
        if (empty($tradeStatusIdes)) {
            return true;
        }
        foreach ($tradeStatusIdes as $tradeStatusId) {
            if (!in_array($tradeStatusId, array(0, 2, 3, 5, 6, 8, 9))) {
                return isset(DbOption::$resource['tradeStatus'][$tradeStatusId]) ? DbOption::$resource['tradeStatus'][$tradeStatusId] : '';
            }
        }
        return true;
    }

    /**
     * 检查当前用户是否可以直接发布已审核的资源
     * @return boolean
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function isAuditPass() {
        $yesno = false;
        $userId = Unit::getLoggedUserId();
        $roleId = Unit::getLoggedRoleId();
        if (!$userId || !$roleId) {
            return $yesno;
        }
        switch ($roleId) {
            case DbOption::$Role_Id_Admin:
                $yesno = true;
            case DbOption::$Role_Id_Agent:
            case DbOption::$Role_Id_Common_Enterprise:
            case DbOption::$Role_Id_Common_Individual:
                $isNeedValidate = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select("IsNeedValidate")
                        ->from('t_user')
                        ->where("ID = :ID", array(':ID' => $userId))
                        ->queryScalar();
                $yesno = $isNeedValidate ? true : false;
                break;
            default:
                $deptId = Unit::getLoggedDeptId();
                if (!$deptId) {
                    return $yesno;
                }
                $hasParent = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select("ParentID")
                        ->from('t_department_references')
                        ->where("ChildID = :ChildID", array(':ChildID' => $deptId))
                        ->queryScalar();
                if ($hasParent) {
                    $isNeedValidate = Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select("IsNeedValidate")
                            ->from('t_department')
                            ->where("ID = :ID", array(':ID' => $deptId))
                            ->queryScalar();
                    $yesno = $isNeedValidate ? true : false;
                } else {
                    $yesno = true;
                }
                break;
        }
        return $yesno;
    }

}
