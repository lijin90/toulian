<?php

/**
 * 园区招商
 * @author Changfeng Ji <jichf@qq.com>
 */
class ParkController extends Controller {

    /**
     * 首页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionIndex() {
        if (Yii::app()->getRequest()->getQuery('old')) {
            $this->indexOld();
            Yii::app()->end();
        }
        $this->setPageTitle(Yii::app()->name . ' - 园区招商');
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
            $query->andWhere('d.DeptType = :DeptType', array(':DeptType' => 'park'));
            $query->andWhere(array('like', 'd.AreaCode', $acPrefix . '%'));
            $queryCount = clone $query;
            $count = $queryCount->select('COUNT(*)')->queryScalar();
            $pages = new CPagination($count);
            $pages->setPageSize(5);
            $pages->setCurrentPage($page);
            $datas = $query
                    ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                    ->limit($pages->pageSize)
                    ->offset($pages->currentPage * $pages->pageSize)
                    ->queryAll();
            $cates = array('产业园' => 'chanyeyuan', '开发区' => 'kaifaqu', '运营商' => 'yunyingshang');
            foreach ($datas as &$data) {
                $data['Logo'] = $data['Logo'] ? FileUploadHelper::getFileUrl($data['Logo']) : DbOption::defaultLogo($data['DeptType'] . '_' . $cates[$data['CategoryName']]);
                $data['Link'] = Yii::app()->createUrl('park/detail', array('deptId' => $data['ID']));
                $data['Introduction'] = $data['Introduction'] ? strip_tags($data['Introduction']) : '';
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
        $this->setPageTitle(Yii::app()->name . ' - 园区招商');
        $recommend = array(
            'SMBlE49pX4YmI2TP3a6NFFfmvyEh97p8GPpy', // 中关村国家自主创新示范区
            '5D85AB3C-869A-0B6C-3DBA-2210A563549D', // 北京天竺空港经济开发区
            'ABg6TpTMLmYp8871BGBSb5Oh8zAwjKLVRztJ', // 北京经济技术开发区
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
            $query->andWhere('d.DeptType = :DeptType', array(':DeptType' => 'park'));
            $query->andWhere(array('not in', 'd.ID', $recommend));
            $query->andWhere(array('like', 'd.AreaCode', $acPrefix . '%'));
            $queryCount = clone $query;
            $count = $queryCount->select('COUNT(*)')->queryScalar();
            $pages = new CPagination($count);
            $pages->setPageSize(5);
            $pages->setCurrentPage($page);
            $datas = $query
                    ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                    ->limit($pages->pageSize)
                    ->offset($pages->currentPage * $pages->pageSize)
                    ->queryAll();
            $cates = array('产业园' => 'chanyeyuan', '开发区' => 'kaifaqu', '运营商' => 'yunyingshang');
            foreach ($datas as &$data) {
                $data['Logo'] = $data['Logo'] ? FileUploadHelper::getFileUrl($data['Logo']) : DbOption::defaultLogo($data['DeptType'] . '_' . $cates[$data['CategoryName']]);
                $data['Link'] = Yii::app()->createUrl('park/detail', array('deptId' => $data['ID']));
                $data['Introduction'] = $data['Introduction'] ? strip_tags($data['Introduction']) : '';
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
                ->where(array('and', 'd.DeptType = :DeptType', array('in', 'd.ID', $recommend)), array(':DeptType' => 'park'))
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
            $this->redirect(Yii::app()->createUrl('park/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('park/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 园区招商 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '园区招商', 'url' => Yii::app()->createUrl('park/index')),
            array('name' => $data['CategoryName']),
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
            'SMBlE49pX4YmI2TP3a6NFFfmvyEh97p8GPpy' => array('view' => 'detail-zhongguancun'), // 中关村国家自主创新示范区
            'ABg6TpTMLmYp8871BGBSb5Oh8zAwjKLVRztJ' => array('view' => 'detail-economic'), // 北京经济技术开发区
            '5D85AB3C-869A-0B6C-3DBA-2210A563549D' => array('view' => 'detail-tianzhu'), // 北京天竺综合保税区
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
