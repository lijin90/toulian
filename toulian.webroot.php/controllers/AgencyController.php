<?php

/**
 * 物业经纪
 * @author Changfeng Ji <jichf@qq.com>
 */
class AgencyController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 物业经纪');
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
                ->where(array('and', 'd.DeptType = :DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'agency'))
                ->order('d.SortNo ASC, d.CreateTime DESC');
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(9);
        $datas = $query
                ->select('d.*, dc.Name AS CategoryName, dr.ParentID, dd.DeptName AS ParentName')
                ->limit($pages->pageSize)
                ->offset($pages->currentPage * $pages->pageSize)
                ->queryAll();
        $this->render('index', array(
            'datas' => $datas,
            'pages' => $pages,
            'pagination' => (object) array(
                'itemCount' => $pages->getItemCount(),
                'pageSize' => $pages->getLimit(),
                'pageCount' => $pages->getPageCount(),
                'currentPage' => $pages->getCurrentPage()
            )
        ));
    }

    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('agency/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!($data)) {
            $this->redirect(Yii::app()->createUrl('agency/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 物业经纪 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '物业经纪', 'url' => Yii::app()->createUrl('agency/index')),
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
        $brokers = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('u.*, ui.RealName, ui.Gender, ub.IsShow')
                ->from('t_user u')
                ->join('t_user_broker ub', 'u.ID = ub.UserID')
                ->join('t_user_individual ui', 'ui.UserID = u.ID')
                ->where('u.DeptID = :DeptID', array(':DeptID' => $data['ID']))
                ->queryAll();
        $this->render('detail', array(
            'data' => $data,
            'brokers' => $brokers,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
            'resources' => Resource::model()->getResources($userId, $params)
        ));
    }

}
