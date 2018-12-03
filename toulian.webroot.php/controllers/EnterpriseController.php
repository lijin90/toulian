<?php

/**
 * 企业招商
 * @author Changfeng Ji <jichf@qq.com>
 */
class EnterpriseController extends Controller {

    /**
     * 首页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionIndex() {
        if (Yii::app()->getRequest()->getQuery('old')) {
            $this->indexOld();
            Yii::app()->end();
        }
        $this->setPageTitle(Yii::app()->name . ' - 企业招商');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $page = Yii::app()->getRequest()->getPost('page', 0);
            $areaCode = Unit::getAreaCode();
            $acPrefix = rtrim($areaCode, '0');
            $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
            $query = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->from('t_department d')
                    ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                    ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                    ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                    ->order('d.SortNo ASC, d.CreateTime DESC');
            $query->andWhere('d.DeptType = :DeptType', array(':DeptType' => 'enterprise'));
            $query->andWhere(array('like', 'd.AreaCode', $acPrefix . '%'));
            $queryCount = clone $query;
            $count = $queryCount->select('COUNT(*)')->queryScalar();
            $pages = new CPagination($count);
            $pages->setPageSize(10);
            $pages->setCurrentPage($page);
            $datas = $query
                    ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                    ->limit($pages->pageSize)
                    ->offset($pages->currentPage * $pages->pageSize)
                    ->queryAll();
            foreach ($datas as &$data) {
                $data['Logo'] = $data['Logo'] ? FileUploadHelper::getFileUrl($data['Logo']) : DbOption::defaultLogo($data['DeptType']);
                $data['Link'] = Yii::app()->createUrl('enterprise/detail', array('deptId' => $data['ID']));
            }
            Unit::ajaxJson(0, '', array(
                'datas' => $datas,
                'pagination' => (object) array(
                    'itemCount' => $pages->getItemCount(),
                    'pageSize' => $pages->getLimit(),
                    'pageCount' => $pages->getPageCount(),
                    'currentPage' => $pages->getCurrentPage()
                )
            ));
        }
        $this->render('index-2016');
    }

    private function indexOld() {
        $this->setPageTitle(Yii::app()->name . ' - 企业招商');
        $recommend = array(
            '1c0f44d9_3fa4_469d_a90b_d9cb019b8ee0', // 信德京汇中心
            'A22EDBE0D5EF4EF04045DE295D106C90', // 传世东方（北京）投资有限公司
            '4C739A49B2482C1A87ACDD772B564E5B', // 北京赛迪网信息技术有限公司
        );
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $page = Yii::app()->getRequest()->getPost('page', 0);
            $areaCode = Unit::getAreaCode();
            $acPrefix = rtrim($areaCode, '0');
            $acPrefix = strlen($acPrefix) % 2 == 0 ? $acPrefix : $acPrefix . '0';
            $query = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->from('t_department d')
                    ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                    ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                    ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                    ->order('d.SortNo ASC, d.CreateTime DESC');
            $query->andWhere('d.DeptType = :DeptType', array(':DeptType' => 'enterprise'));
            $query->andWhere(array('not in', 'd.ID', $recommend));
            $query->andWhere(array('like', 'd.AreaCode', $acPrefix . '%'));
            $queryCount = clone $query;
            $count = $queryCount->select('COUNT(*)')->queryScalar();
            $pages = new CPagination($count);
            $pages->setPageSize(4);
            $pages->setCurrentPage($page);
            $datas = $query
                    ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                    ->limit($pages->pageSize)
                    ->offset($pages->currentPage * $pages->pageSize)
                    ->queryAll();
            foreach ($datas as &$data) {
                $data['Logo'] = $data['Logo'] ? FileUploadHelper::getFileUrl($data['Logo']) : DbOption::defaultLogo($data['DeptType']);
                $data['Link'] = Yii::app()->createUrl('enterprise/detail', array('deptId' => $data['ID']));
                $data['AreaName'] = Pcas::code2name($data['AreaCode'], true);
            }
            Unit::ajaxJson(0, '', array(
                'datas' => $datas,
                'pagination' => (object) array(
                    'itemCount' => $pages->getItemCount(),
                    'pageSize' => $pages->getLimit(),
                    'pageCount' => $pages->getPageCount(),
                    'currentPage' => $pages->getCurrentPage()
                )
            ));
        }
        $recommend = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                ->where(array('and', 'd.DeptType = :DeptType', array('in', 'd.ID', $recommend)), array(':DeptType' => 'enterprise'))
                ->order('d.SortNo ASC, d.CreateTime DESC')
                ->queryAll();
        $this->render('index-2017', array('recommend' => $recommend));
    }

    /**
     * 详情页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('enterprise/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('enterprise/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 企业招商 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '企业招商', 'url' => Yii::app()->createUrl('enterprise/index')),
            array('name' => $data['DeptName'])
        );
        $params = array(
            'status' => 1,
            'isSearched' => 1,
            'isRecommend' => 1,
            'releaseStatus' => 3,
            'limit' => 4,
            'loadImages' => true
        );
        $userId = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('ID')
                ->from('t_user')
                ->where('DeptID=:DeptID', array(':DeptID' => $data['ID']))
                ->queryColumn();
        $view = 'detail';
        $views = array(
            '1c0f44d9_3fa4_469d_a90b_d9cb019b8ee0' => array('view' => 'detail-xinde'), // 信德京汇中心
            'A22EDBE0D5EF4EF04045DE295D106C90' => array('view' => 'detail-east'), // 传世东方（北京）投资有限公司
            '4C739A49B2482C1A87ACDD772B564E5B' => array('view' => 'detail-saidi'), // 北京赛迪网信息技术有限公司
        );
        if (isset($views[$data['ID']])) {
            $view = $views[$data['ID']]['view'];
        }
        $this->render($view, array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
            'resources' => Resource::model()->getResources($userId, $params)
        ));
    }

}
