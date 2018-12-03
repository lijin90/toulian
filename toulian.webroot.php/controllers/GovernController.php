<?php

/**
 * 政府招商
 * @author Changfeng Ji <jichf@qq.com>
 */
class GovernController extends Controller {

    public function filters() {
        return array(
            array(
                'COutputCache + index',
                'duration' => Yii::app()->params['indexCacheSecond'],
                'varyByExpression' => "Unit::cookieGet('areaCode')",
            ),
        );
    }

    /**
     * 首页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 政府招商');
        $deptList = Department::getDeptarts(null, 'org', 17);
        $firstDept = array_shift($deptList);
        shuffle($deptList);
        array_unshift($deptList, $firstDept);
        $changpingList = Department::getDeptarts('9a0ec180_9624_4796_9673_cc53fdff6e59', 'org');
        shuffle($changpingList);
        $fangshanList = Department::getDeptarts('58736ac1_848c_42ab_8030_3f02ff52e7a2', 'org');
        shuffle($fangshanList);
        $xichengList = Department::getDeptarts('60111684_a523_438a_8b7d_2ca0b7d896c6', 'org');
        shuffle($xichengList);
        $deptIdes = Unit::arrayColumn($deptList, 'ID');
        $deptIdes = array_merge($deptIdes, Unit::arrayColumn($changpingList, 'ID'));
        $deptIdes = array_merge($deptIdes, Unit::arrayColumn($fangshanList, 'ID'));
        $deptIdes = array_merge($deptIdes, Unit::arrayColumn($xichengList, 'ID'));
        $otherList = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*, dr.ParentID')
                ->from('t_department d')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->where(array('and', 'd.DeptType=:DeptType', array('not in', 'd.ID', $deptIdes)), array(':DeptType' => 'org'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->queryAll();
        $otherTree = array();
        foreach ($otherList as $data) {
            if ($data['ParentID'] == '899a1eb9_6c0e_4155_a55b_8b85d7984beb') {
                continue;
            }
            $key = $data['AreaCode'] ? substr($data['AreaCode'], 0, 4) . '00' : 'other';
            if (!isset($otherTree[$key])) {
                $otherTree[$key] = array();
            }
            $otherTree[$key][] = $data;
        }
        ksort($otherTree);
        $this->render('index', array(
            'deptList' => $deptList,
            'changpingList' => $changpingList,
            'fangshanList' => $fangshanList,
            'xichengList' => $xichengList,
            //'otherList' => $otherList,
            'otherTree' => $otherTree
        ));
    }

    /**
     * 详情页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('govern/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('govern/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 政府招商 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '政府招商', 'url' => Yii::app()->createUrl('govern/index')),
            array('name' => $data['DeptName'])
        );
        $views = array(
            '899a1eb9_6c0e_4155_a55b_8b85d7984beb' => array('view' => 'detail-bj', 'childOrgLimit' => 16, 'resourceLimit' => 4), //北京市投资促进局
            '58736ac1_848c_42ab_8030_3f02ff52e7a2' => array('view' => 'detail-bj-fangshan', 'childOrgLimit' => 50, 'resourceLimit' => 4), //房山区投资促进局
            '9a0ec180_9624_4796_9673_cc53fdff6e59' => array('view' => 'detail-bj-changping', 'childOrgLimit' => 49, 'resourceLimit' => 4), //昌平区投资促进局
            'a45b1d58_5176_4edf_90ea_c928c8145761' => array('view' => 'detail-bj-haidian', 'childOrgLimit' => 30, 'resourceLimit' => 4), //海淀区投资促进局
            'ae0f5e56_5982_40f8_99c8_4276c7c6fe52' => array('view' => 'detail-bj-chaoyang', 'childOrgLimit' => 49, 'resourceLimit' => 4), //朝阳区投资促进局
            '60111684_a523_438a_8b7d_2ca0b7d896c6' => array('view' => 'detail-bj-xicheng', 'childOrgLimit' => 16, 'resourceLimit' => 10), //北京市西城区产业发展促进局
        );
        if ($data['ParentID'] == '60111684_a523_438a_8b7d_2ca0b7d896c6') { //西城区15个街道专区
            $views[$data['ID']] = array('view' => 'detail-bj-xicheng-street', 'childOrgLimit' => 16, 'resourceLimit' => 10);
        }
        $params = array(
            'resType' => 'supply',
            'status' => 1,
            'isSearched' => 1,
            'isRecommend' => 1,
            'releaseStatus' => 3,
            'limit' => isset($views[$data['ID']]) ? $views[$data['ID']]['resourceLimit'] : 4,
            'loadImages' => true
        );
        $userId = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('ID')
                ->from('t_user')
                ->where('DeptID=:DeptID', array(':DeptID' => $data['ID']))
                ->queryColumn();
        $resources = Resource::model()->getResources($userId, $params);
        if (isset($resources['datas'])) {
            foreach ($resources['datas'] as &$val) {
                $titles = explode(' ', $val['Title']);
                if (isset($titles[0])) {
                    $titles[0] = '【' . $titles[0] . '】';
                }
                $val['Title'] = implode(' ', $titles);
            }
        }
        if (isset($views[$data['ID']])) {
            $this->render($views[$data['ID']]['view'], array(
                'data' => $data,
                'childOrgs' => Department::model()->getDeptarts($data['ID'], 'org', $views[$data['ID']]['childOrgLimit']),
                'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
                'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
                'resources' => $resources
            ));
            Yii::app()->end();
        }
        $this->render('detail', array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
            'resources' => $resources
        ));
    }

    /**
     * 北京市投资促进局 - 招商类别
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionZslb() {
        $this->setPageTitle(Yii::app()->name . ' - 北京市投资促进局 - 招商类别');
        $this->render('zslb');
    }

    /**
     * 北京市西城区产业发展促进局 - 欧盟中国科技创新中心项目建议书
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionXichengwppt() {
        $this->setPageTitle(Yii::app()->name . ' - 北京市西城区产业发展促进局 - 欧盟中国科技创新中心项目建议书');
        $this->render('xicheng-wppt');
    }

    /**
     * 北京市西城区产业发展促进局 - 大数据
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionXichengbigdata() {
        $this->setPageTitle(Yii::app()->name . ' - 北京市西城区产业发展促进局 - 大数据西城2016');
        $this->render('xicheng-bigdata');
    }

    /**
     * 北京市西城区产业发展促进局 - 写字楼趋势分析报告
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionXichengtrend() {
        $this->setPageTitle(Yii::app()->name . ' - 北京市西城区产业发展促进局 - 写字楼趋势分析报告');
        $this->render('xicheng-trend');
    }

}
