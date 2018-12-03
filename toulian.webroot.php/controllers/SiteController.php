<?php

/**
 * 默认控制器
 * @author Changfeng Ji <jichf@qq.com>
 */
class SiteController extends Controller {

    public function filters() {
        return array(
            array(
                'COutputCache + index, old',
                'duration' => Yii::app()->params['indexCacheSecond'],
                'varyByExpression' => "Unit::cookieGet('areaCode')",
            //'varyByParam' => array('areaCode'),
            ),
        );
    }

    /**
     * 导航条 - 用于百度站内搜索顶部导航
     */
    public function actionNavigationBar() {
        header('X-Frame-Options: ALLOW-FROM http://search.toulianwang.com');
        $this->setPageTitle(Yii::app()->name . ' - 导航条');
        $this->renderPartial('navigationBar', null, false, true);
    }

    public function actionMap() {
        $this->setPageTitle(Yii::app()->name . ' - 地图');
        $this->render('map');
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name);
        $this->render('index-2016', array(
            'sliderList' => $this->getSliderList(),
            'parkOperators' => $this->getParkOperators(),
            'agencies' => $this->getAgencies(),
            'incubators' => $this->getIncubators(),
            'resources' => $this->getResources(),
            'departs' => $this->getDeparts(),
            'enterpriseWorlds' => $this->getEnterpriseWorlds()
        ));
    }

    /**
     * 旧首页
     */
    public function actionOld() {
        $this->setPageTitle(Yii::app()->name);
        $this->layout = '//layouts/main-2017';
        Yii::app()->getClientScript()->reset();
        Unit::cssFile('css/base.css');
        Unit::cssFile('css/head-2017.css');
        Unit::cssFile('css/foot-2017.css');
        Unit::jsFile('js/jquery.js');
        Unit::jsFile('js/jquery.cookie.js');
        Unit::jsFile(Yii::app()->getBaseUrl(true) . '/js/layer/layer.js');
        $this->render('index-2017', array(
            'sliderList' => $this->getSliderList(),
            'parkOperators' => $this->getParkOperators(),
            'agencies' => $this->getAgencies(),
            'incubators' => $this->getIncubators(),
            'resources' => $this->getResources(),
            'departs' => $this->getDeparts(),
            'enterpriseWorlds' => $this->getEnterpriseWorlds()
        ));
    }

    /**
     * 轮播图
     * @return type
     */
    private function getSliderList() {
        $areaCode = Unit::getAreaCode();
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_slider')
                ->where(array('and', array('or', 'EndTime = 0', 'EndTime > :EndTime'), array('in', 'AreaCode', array(0, $areaCode))), array(':EndTime' => time()))
                ->order("Sort ASC")
                ->queryAll();
        return $datas;
    }

    /**
     * 园区招商 - 运营商
     * @return type
     */
    private function getParkOperators() {
        $parkOperators = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*')
                ->from('t_department d')
                ->where(array('and', 'd.DeptType=:DeptType', 'd.CategoryID = :CategoryID'), array(':DeptType' => 'park', ':CategoryID' => '9f9c033c-7cda-4033-a4c4-49fea18b1f9b'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->limit(9)
                ->offset(0)
                ->queryAll();
        return $parkOperators;
    }

    /**
     * 经纪公司
     * @return type
     */
    private function getAgencies() {
        $areaCode = Unit::getAreaCode();
        $acPrefix = rtrim($areaCode, '0');
        $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
        $agencies = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*')
                ->from('t_department d')
                ->where(array('and', 'd.DeptType=:DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'agency'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->limit(4)
                ->offset(0)
                ->queryAll();
        return $agencies;
    }

    /**
     * 孵化器
     * @return type
     */
    private function getIncubators() {
        $areaCode = Unit::getAreaCode();
        $acPrefix = rtrim($areaCode, '0');
        $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
        $count = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_department d')
                ->select('COUNT(ID)')
                ->where(array('and', 'd.DeptType=:DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'incubator'))
                ->queryScalar();
        $incubators = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*')
                ->from('t_department d')
                ->where(array('and', 'd.DeptType=:DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'incubator'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->limit(16)
                ->offset($count > 16 ? rand(0, $count - 16) : 0)
                ->queryAll();
        return $incubators;
    }

    /**
     * 资源
     * @return type
     */
    private function getResources() {
        $areaCode = Unit::getAreaCode();
        $resources = array();
        foreach (DbOption::$resource['category'] as $key => $value) {
            $acPrefix = rtrim($areaCode, '0');
            $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
            $count = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->from('t_resource r')
                    ->join("t_resource_release_status rrs", "r.ID = rrs.ResID")
                    ->select('COUNT(r.ID)')
                    ->where(array(
                        'and',
                        'r.ResCategory=:ResCategory',
                        'r.ResType=:ResType',
                        array('like', 'r.AreaCode', $acPrefix . '%'),
                        'r.Status = 1',
                        'r.IsSearched = 1',
                        'rrs.Status = 3'
                            ), array(':ResCategory' => $key, ':ResType' => 'supply'))
                    ->queryScalar();
            $params = array(
                'resCategory' => Yii::app()->getRequest()->getQuery('resCategory', $key),
                'resType' => 'supply',
                'areaCode' => $areaCode,
                'status' => 1,
                'isSearched' => 1,
                'releaseStatus' => 3,
                'limit' => 10,
                'offset' => $count > 10 ? rand(0, $count - 10) : 0,
                'loadImages' => true
            );
            $resources[$key] = Resource::model()->getResources('ALL', $params);
        }
        foreach ($resources as $k1 => $resource) {
            foreach ($resource['datas'] as $k2 => $val) {
                $autoTitle = array();
                if ($val['AreaCode']) {
                    $val['AreaCode'] = $val['AreaCode'] ? substr($val['AreaCode'], 0, 4) . '00' : $val['AreaCode'];
                    $autoTitle[] = Pcas::code2name($val['AreaCode'], true);
                }
                $autoTitle[] = $val['IntentionName'] == '可租可售' ? '租售' : $val['IntentionName'];
                if ($val['Area']) {
                    $autoTitle[] = $val['Area'] . $val['AreaUnit'];
                }
                $autoTitle[] = $val['BaseName'];
                $resources[$k1]['datas'][$k2]['AutoTitle'] = implode(' ', $autoTitle);
            }
        }
        return $resources;
    }

    /**
     * 部门
     * @return type
     */
    private function getDeparts() {
        $areaCode = Unit::getAreaCode();
        $acPrefix = rtrim($areaCode, '0');
        $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
        $departs = array();
        foreach (array('org', 'park', 'association', 'enterprise') as $value) {
            $conditions = array();
            $conditions[] = 'and';
            $conditions[] = 'd.DeptType=:DeptType';
            if ($value == 'org') {
                $conditions[] = 'd.Logo != ""';
            }
            $conditions[] = array('like', 'd.AreaCode', $acPrefix . '%');
            $count = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->from('t_department d')
                    ->select('COUNT(ID)')
                    ->where($conditions, array(':DeptType' => $value))
                    ->queryScalar();
            $departs[$value] = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('d.*')
                    ->from('t_department d')
                    ->where($conditions, array(':DeptType' => $value))
                    ->order('d.SortNo ASC, d.CreateTime DESC')
                    ->limit(10)
                    ->offset($count > 10 ? rand(0, $count - 10) : 0)
                    ->queryAll();
        }
        return $departs;
    }

    /**
     * 企业天地
     * @return type
     */
    private function getEnterpriseWorlds() {
        $areaCode = Unit::getAreaCode();
        $acPrefix = rtrim($areaCode, '0');
        $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
        $count = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_department d')
                ->select('COUNT(ID)')
                ->where(array('and', 'd.DeptType=:DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'enterpriseworld'))
                ->queryScalar();
        $enterpriseWorlds = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*')
                ->from('t_department d')
                ->where(array('and', 'd.DeptType=:DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'enterpriseworld'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->limit(80)
                ->offset(0)
                ->queryAll();
        return $enterpriseWorlds;
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
