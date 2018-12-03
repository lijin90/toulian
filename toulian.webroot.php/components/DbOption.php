<?php

/**
 * 数据库选项
 * @author Changfeng Ji <jichf@qq.com>
 */
class DbOption {

    public static $User_Id_Admin = '7141A396-262E-C158-83A1-8B95E8E71FC4';
    public static $User_Id_Anonymous = '5d82b1b6-ebdb-479f-8aff-f27ffb9eba75';
    public static $Role_Id_Admin = 'f9f4a690-2904-45b9-988d-d5f544df0b8f';
    public static $Role_Id_Org = '4f16a4cd-6a0c-47eb-8266-eeefbe42f735';
    public static $Role_Id_Office = '9c928f87-22ce-415d-aba2-f6449d74cb4a';
    public static $Role_Id_Park_Chanyeyuan = '3b109065-d713-4f7a-94f4-4cb0901e4eb2';
    public static $Role_Id_Park_Kaifaqu = '5f08289a-0dc9-4dec-b815-b26e9e682aa9';
    public static $Role_Id_Park_Yunyingshang = '9f9c033c-7cda-4033-a4c4-49fea18b1f9b';
    public static $Role_Id_Association_Shanghui = 'a2896d5d-34ef-4ab6-9a6a-f37d28c1b150';
    public static $Role_Id_Association_Xiehui = '06c1bab1-baab-4196-a5d3-b3b14ed86984';
    public static $Role_Id_Association_Julebu = '677bea7c-b8e8-4d6b-9ad5-10e0ddf2a31b';
    public static $Role_Id_Enterprise = '45746e55-6e26-44dc-b805-9991f8b62883';
    public static $Role_Id_Agency = '22733acf-ea59-4019-945b-46e97ef8b613';
    public static $Role_Id_Agent = 'cf92e44a-28f8-46db-a268-fa8d940746fa';
    public static $Role_Id_Vendor_Qiyezhuce = 'd156f018-6326-45de-b4c1-a19611bebeca';
    public static $Role_Id_Vendor_Zhengcezixun = '8e6e1342-993d-4687-a0e0-90ee9bc459a4';
    public static $Role_Id_Vendor_Caishuifuwu = 'b279e533-e61f-4f4d-bb4f-75097349163e';
    public static $Role_Id_Vendor_Falvfuwu = 'aec0bfa3-49c9-48e0-87e1-c70a59b73a72';
    public static $Role_Id_Vendor_Tourongfuwu = 'fae1b41d-0369-4034-8657-09357470f1ba';
    public static $Role_Id_Vendor_Lietoufuwu = '2b04874f-ef33-4721-a5ca-d21b07f7b54c';
    public static $Role_Id_Vendor_ITfuwu = '39d59fa6-08e4-4b57-8544-0b788259dc3e';
    public static $Role_Id_Vendor_Xinmeixuanchuan = '608e0952-aa25-4706-b581-b34a0e66ad64';
    public static $Role_Id_MYTIP_Enterprise = '59ea6927-ab96-4b8c-a7a9-d06e34abfe78';
    public static $Role_Id_MYTIP_Individual = '91f447f5-f992-473f-a9e2-1d89e25b6433';
    public static $Role_Id_Common_Enterprise = '7b65dfa7-a3a5-4f7a-b431-374a90223c92';
    public static $Role_Id_Common_Individual = 'ce27269d-3e6b-491e-867b-99fa5c10b9f6';
    public static $Role_Id_Anonymous = 'b1993975-7c92-43d6-a4f2-6ef6843b0a6d';

    /**
     * 角色
     * @var array
     */
    public static $role = array(
        'f9f4a690-2904-45b9-988d-d5f544df0b8f' => '管理员',
        '4f16a4cd-6a0c-47eb-8266-eeefbe42f735' => '政府招商',
        '9c928f87-22ce-415d-aba2-f6449d74cb4a' => '政府招商下属处室',
        '3b109065-d713-4f7a-94f4-4cb0901e4eb2' => '产业园',
        '5f08289a-0dc9-4dec-b815-b26e9e682aa9' => '开发区',
        '9f9c033c-7cda-4033-a4c4-49fea18b1f9b' => '运营商',
        'a2896d5d-34ef-4ab6-9a6a-f37d28c1b150' => '商会',
        '06c1bab1-baab-4196-a5d3-b3b14ed86984' => '协会',
        '677bea7c-b8e8-4d6b-9ad5-10e0ddf2a31b' => '俱乐部',
        '45746e55-6e26-44dc-b805-9991f8b62883' => '企业招商',
        '22733acf-ea59-4019-945b-46e97ef8b613' => '经纪公司',
        'cf92e44a-28f8-46db-a268-fa8d940746fa' => '经纪人/招商顾问',
        'd156f018-6326-45de-b4c1-a19611bebeca' => '企业注册',
        '8e6e1342-993d-4687-a0e0-90ee9bc459a4' => '政策咨询',
        'b279e533-e61f-4f4d-bb4f-75097349163e' => '财税服务',
        'aec0bfa3-49c9-48e0-87e1-c70a59b73a72' => '法律服务',
        'fae1b41d-0369-4034-8657-09357470f1ba' => '投融服务',
        '2b04874f-ef33-4721-a5ca-d21b07f7b54c' => '猎头服务',
        '39d59fa6-08e4-4b57-8544-0b788259dc3e' => 'IT服务',
        '608e0952-aa25-4706-b581-b34a0e66ad64' => '物业管理',
        '59ea6927-ab96-4b8c-a7a9-d06e34abfe78' => '招商秘书台',
        '91f447f5-f992-473f-a9e2-1d89e25b6433' => '招商小秘书',
        '7b65dfa7-a3a5-4f7a-b431-374a90223c92' => '企业',
        'ce27269d-3e6b-491e-867b-99fa5c10b9f6' => '个人',
        'b1993975-7c92-43d6-a4f2-6ef6843b0a6d' => '匿名'
    );

    /**
     * 角色-用户类型
     * @var array
     */
    public static $role_userCategory = array(
        'individual' => array(
            'f9f4a690-2904-45b9-988d-d5f544df0b8f' => '管理员',
            'cf92e44a-28f8-46db-a268-fa8d940746fa' => '经纪人/招商顾问',
            '91f447f5-f992-473f-a9e2-1d89e25b6433' => '招商小秘书',
            'ce27269d-3e6b-491e-867b-99fa5c10b9f6' => '个人',
            'b1993975-7c92-43d6-a4f2-6ef6843b0a6d' => '匿名'
        ),
        'enterprise' => array(
            '4f16a4cd-6a0c-47eb-8266-eeefbe42f735' => '政府招商',
            '9c928f87-22ce-415d-aba2-f6449d74cb4a' => '政府招商下属处室',
            '3b109065-d713-4f7a-94f4-4cb0901e4eb2' => '产业园',
            '5f08289a-0dc9-4dec-b815-b26e9e682aa9' => '开发区',
            '9f9c033c-7cda-4033-a4c4-49fea18b1f9b' => '运营商',
            'a2896d5d-34ef-4ab6-9a6a-f37d28c1b150' => '商会',
            '06c1bab1-baab-4196-a5d3-b3b14ed86984' => '协会',
            '677bea7c-b8e8-4d6b-9ad5-10e0ddf2a31b' => '俱乐部',
            '45746e55-6e26-44dc-b805-9991f8b62883' => '企业招商',
            '22733acf-ea59-4019-945b-46e97ef8b613' => '经纪公司',
            'd156f018-6326-45de-b4c1-a19611bebeca' => '企业注册',
            '8e6e1342-993d-4687-a0e0-90ee9bc459a4' => '政策咨询',
            'b279e533-e61f-4f4d-bb4f-75097349163e' => '财税服务',
            'aec0bfa3-49c9-48e0-87e1-c70a59b73a72' => '法律服务',
            'fae1b41d-0369-4034-8657-09357470f1ba' => '投融服务',
            '2b04874f-ef33-4721-a5ca-d21b07f7b54c' => '猎头服务',
            '39d59fa6-08e4-4b57-8544-0b788259dc3e' => 'IT服务',
            '608e0952-aa25-4706-b581-b34a0e66ad64' => '物业管理',
            '59ea6927-ab96-4b8c-a7a9-d06e34abfe78' => '招商秘书台',
            '7b65dfa7-a3a5-4f7a-b431-374a90223c92' => '企业'
        )
    );

    /**
     * 部门
     * @var array
     */
    public static $dept = array(
        'org' => '政府招商',
        'office' => '政府招商下属处室',
        'park' => '园区招商',
        'association' => '商会/协会/俱乐部',
        'enterprise' => '企业招商',
        'agency' => '经纪公司',
        'vendor' => '交易服务商',
        'incubator' => '孵化器',
        'enterpriseworld' => '企业天地',
        'investorlibrary' => '投资人库'
    );

    /**
     * 用户类型
     * @var array
     */
    public static $userCategory = array(
        'individual' => '个人',
        'enterprise' => '企业'
    );

    /**
     * 用户状态
     * @var array
     */
    public static $userStatus = array(
        1 => '启用',
        2 => '禁用',
        4 => '删除'
    );

    /**
     * 资源
     * @var array
     */
    public static $resource = array(
        'category' => array(//资源类别
            'land' => '商用土地',
            'factory' => '商用厂房',
            'officebuilding' => '写字楼',
            'shop' => '商铺'
        ),
        'type' => array(//资源类型
            'supply' => '供应',
            'demand' => '需求'
        ),
        'isSearched' => array(//资源是否被搜索筛选出来， 0 不被搜索  1 被搜索
            '0' => '已屏蔽',
            '1' => '被搜索'
        ),
        'isRecommend' => array(//是否推荐
            '0' => '否',
            '1' => '是'
        ),
        'releaseStatus' => array(//发布状态
            '0' => '草稿',
            '1' => '待审核',
            '2' => '已拒绝',
            '3' => '已审核'
        ),
        'tradeStatus' => array(//交易状态
            '0' => '申请代理',
            '1' => '同意代理',
            '2' => '拒绝代理',
            '3' => '关闭代理',
            '4' => '已代理',
            '5' => '申请委托',
            '6' => '拒绝委托',
            '7' => '已委托',
            '8' => '洽谈中',
            '9' => '终止',
            '10' => '已洽谈',
            '11' => '已签约',
            '12' => '已评价',
            '13' => '分配'
        ),
        'protocolType' => array(//协议类型
            '0' => '代理协议',
            '1' => '委托协议',
            '2' => '用户确认函'
        )
    );

    /**
     * 投联活动
     * @var array 
     */
    public static $activity = array(
        'type' => array(//活动类别
            '1' => '活动',
            '2' => '会议',
            '3' => '培训'
        ),
        'contentType' => array(
            '1' => array(
                '活动内容',
                '活动介绍',
                '出席人员',
                '活动日程',
                '时间地点',
                '活动风采'
            ),
            '2' => array(
                '活动内容',
                '活动介绍',
                '出席人员',
                '活动日程',
                '时间地点',
                '活动风采'
            ),
            '3' => array(
                '培训内容',
                '培训咨询',
                '培训专家',
                '培训人员',
                '培训课程',
                '培训日程',
                '培训位置',
                '时间地点'
            )
        ),
        'imageType' => array(
            '1' => array(
                '宣传图片',
                '活动风采'
            ),
            '2' => array(
                '宣传图片',
                '活动风采'
            ),
            '3' => array(
                '宣传图片',
                '培训风采'
            )
        )
    );

    /**
     * 文章
     * @var array
     */
    public static $article = array(
        'policycollection' => '政策汇编',
        'parkppp' => '园区PPP',
        'projectreporting' => '项目汇报'
    );

    /**
     * 默认图片路径
     * @param string $type 图片类型，包括: 
     *  - org 政府招商
     *  - office 政府招商下属处室（暂无）
     *  - park_chanyeyuan 园区招商-产业园
     *  - park_kaifaqu 园区招商-开发区
     *  - park_yunyingshang 园区招商-运营商（暂无）
     *  - association_shanghui 商会/协会/俱乐部-商会
     *  - association_xiehui 商会/协会/俱乐部-协会
     *  - association_julebu 商会/协会/俱乐部-俱乐部（暂无）
     *  - enterprise 企业招商
     *  - agency 经纪公司
     *  - vendor_qiyezhuce 交易服务商-企业注册
     *  - vendor_zhengcezixun 交易服务商-政策咨询
     *  - vendor_caishuifuwu 交易服务商-财税服务
     *  - vendor_falvfuwu 交易服务商-法律服务
     *  - vendor_tourongfuwu 交易服务商-投融服务
     *  - vendor_lietoufuwu 交易服务商-猎头服务
     *  - vendor_itfuwu 交易服务商-IT服务
     *  - vendor_xinmeixuanchuan 交易服务商-物业管理
     *  - incubator 孵化器
     *  - enterpriseworld 企业天地
     *  - investorlibrary 投资人库
     *  - activity 投联活动
     *  - male 先生
     *  - female 女士
     *  - land 土地
     *  - factory 厂房
     *  - officebuilding 写字楼
     *  - shop 商铺
     * @return string
     */
    public static function defaultLogo($type = 'default') {
        $url = '';
        $baseUrl = Yii::app()->getBaseUrl();
        switch ($type) {
            case 'org':
                $url = Url::imageUrl() . '/default/org.jpg';
                break;
            //case 'office':
            //    break;
            case 'park_chanyeyuan':
                $url = Url::imageUrl() . '/default/park_chanyeyuan.png';
                break;
            case 'park_kaifaqu':
                $url = Url::imageUrl() . '/default/park_kaifaqu.png';
                break;
            //case 'park_yunyingshang':
            //    break;
            case 'association_shanghui':
                $url = Url::imageUrl() . '/default/association_shanghui.png';
                break;
            case 'association_xiehui':
                $url = Url::imageUrl() . '/default/association_xiehui.png';
                break;
            //case 'association_julebu':
            //    break;
            case 'enterprise':
                $url = Url::imageUrl() . '/default/enterprise.jpg';
                break;
            case 'agency':
                $url = Url::imageUrl() . '/default/agency.jpg';
                break;
            case 'vendor_qiyezhuce':
                $url = Url::imageUrl() . '/default/vendor_qiyezhuce.jpg';
                break;
            case 'vendor_zhengcezixun':
                $url = Url::imageUrl() . '/default/vendor_zhengcezixun.jpg';
                break;
            case 'vendor_caishuifuwu':
                $url = Url::imageUrl() . '/default/vendor_caishuifuwu.jpg';
                break;
            case 'vendor_falvfuwu':
                $url = Url::imageUrl() . '/default/vendor_falvfuwu.jpg';
                break;
            case 'vendor_tourongfuwu':
                $url = Url::imageUrl() . '/default/vendor_tourongfuwu.jpg';
                break;
            case 'vendor_lietoufuwu':
                $url = Url::imageUrl() . '/default/vendor_lietoufuwu.jpg';
                break;
            //case 'vendor_itfuwu':
            //    break;
            //case 'vendor_xinmeixuanchuan':
            //    break;
            //case 'incubator':
            //    break;
            //case 'enterpriseworld':
            //    break;
            case 'investorlibrary':
                $url = Url::imageUrl() . '/default/investorlibrary.jpg';
                break;
            case 'activity':
                $url = Url::imageUrl() . '/default/activity.png';
                break;
            case 'male':
                $url = Url::imageUrl() . '/default/male.png';
                break;
            case 'female':
                $url = Url::imageUrl() . '/default/female.png';
                break;
            case 'land':
            case 'factory':
            case 'officebuilding':
            case 'shop':
                $url = Url::imageUrl() . '/default/resource/' . $type . rand(1, 3) . '.jpg';
                break;
            default:
                $url = Url::imageUrl() . '/default/default.png';
                break;
        }
        return $url;
    }

    /**
     * 检查指定角色是否拥有下级部门
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasChildDept($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否拥有下级部门-政府招商
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasChildDeptOrg($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否拥有下级部门-政府招商下级处室
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasChildDeptOffice($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否能够代理需求资源
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasBusinessDemand($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Agent
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否拥有资源
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasResource($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Admin,
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Office,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Agent,
            DbOption::$Role_Id_MYTIP_Enterprise,
            DbOption::$Role_Id_MYTIP_Individual,
            DbOption::$Role_Id_Common_Enterprise,
            DbOption::$Role_Id_Common_Individual
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否能够审核资源
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasResourceAudit($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Admin,
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Agency
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否能够保存资源
     * @param string $roleId 角色ID
     * @return boolean
     */
    public static function hasResourceSave($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Admin,
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Agent,
            DbOption::$Role_Id_MYTIP_Enterprise,
            DbOption::$Role_Id_MYTIP_Individual,
            DbOption::$Role_Id_Common_Enterprise,
            DbOption::$Role_Id_Common_Individual
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有基本信息管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasDeptInfo($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Office,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有特色栏目/展示图片管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasInfoColumn($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有资质证书管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasInfoQualify($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Agent
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有服务人员管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasInfoStaff($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有经纪人、招商顾问管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasInfoAgent($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有账号管理功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasAccount($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Org,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Park_Chanyeyuan,
            DbOption::$Role_Id_Park_Kaifaqu,
            DbOption::$Role_Id_Park_Yunyingshang,
            DbOption::$Role_Id_Association_Shanghui,
            DbOption::$Role_Id_Association_Xiehui,
            DbOption::$Role_Id_Association_Julebu,
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Office,
            DbOption::$Role_Id_Vendor_Caishuifuwu,
            DbOption::$Role_Id_Vendor_Falvfuwu,
            DbOption::$Role_Id_Vendor_Lietoufuwu,
            DbOption::$Role_Id_Vendor_Qiyezhuce,
            DbOption::$Role_Id_Vendor_Tourongfuwu,
            DbOption::$Role_Id_Vendor_Zhengcezixun,
            DbOption::$Role_Id_Vendor_ITfuwu,
            DbOption::$Role_Id_Vendor_Xinmeixuanchuan
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 检查指定角色是否有实名认证功能
     * @param type $roleId
     * @return boolean
     */
    public static function hasCertification($roleId) {
        $allowedRoles = array(
            DbOption::$Role_Id_Enterprise,
            DbOption::$Role_Id_Agency,
            DbOption::$Role_Id_Agent,
            DbOption::$Role_Id_MYTIP_Enterprise,
            DbOption::$Role_Id_MYTIP_Individual,
            DbOption::$Role_Id_Common_Enterprise,
            DbOption::$Role_Id_Common_Individual
        );
        if (in_array($roleId, $allowedRoles)) {
            return true;
        }
        return false;
    }

    /**
     * 获取当前用户开通的空间布局
     * @return boolean
     */
    public static function getOpenedLayout() {
        $layout = '/layouts/main';
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin) {
            if (Unit::getLoggedUserId() != DbOption::$User_Id_Admin && Yii::app()->user->checkAccess('vocationIndex')) {
                $layout = '/layouts/main-vocation';
            } else {
                $layout = '/layouts/main';
            }
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Enterprise) {
            $layout = '/layouts/main-mytip';
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Individual) {
            $layout = '/layouts/main-mytip';
        } else if (in_array(Unit::getLoggedUserId(), array_merge(User::get57SeatUserIdes(), User::getXichengStreetUserIdes()))) {
            $layout = '/layouts/main-new'; //57个席位的用户 + 57个席位的用户
        } else {
            $layout = '/layouts/main';
        }
        return $layout;
    }

}
