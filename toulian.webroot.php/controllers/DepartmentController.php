<?php

/**
 * 部门管理
 * @author Changfeng Ji <jichf@qq.com>
 */
class DepartmentController extends Controller {

    public function actionFilter() {
        $page = Yii::app()->getRequest()->getPost('page', 0);
        $deptType = Yii::app()->getRequest()->getPost('deptType', '');
        $keyword = Yii::app()->getRequest()->getPost('keyword', '');
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->order('d.SortNo ASC, d.CreateTime DESC');
        if (!empty($deptType)) {
            $query->andWhere('d.DeptType=:DeptType', array(':DeptType' => $deptType));
        }
        if (!empty($keyword)) {
            $query->andWhere(array('like', 'DeptName', '%' . Unit::escapeLike($keyword) . '%'));
        }
        if (!Yii::app()->user->checkAccess('departmentList') && Yii::app()->user->checkAccess('departmentListSelf')) {
            $query->andWhere(array('in', 'd.UserID', array_merge(User::getChildIdes(Unit::getLoggedUserId()), array(Unit::getLoggedUserId()))));
        }
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(10);
        $pages->setCurrentPage($page);
        $datas = $query
                ->select('d.*, dc.Name AS CategoryName, dr.ParentID')
                ->limit($pages->pageSize)
                ->offset($pages->currentPage * $pages->pageSize)
                ->queryAll();
        Unit::ajaxJson(0, '', array(
            'scope' => Yii::app()->user->checkAccess('departmentList') ? 'all' : 'self',
            'datas' => $datas,
            'pagination' => (object) array(
                'itemCount' => $pages->getItemCount(),
                'pageSize' => $pages->getLimit(),
                'pageCount' => $pages->getPageCount(),
                'currentPage' => $pages->getCurrentPage()
            )
        ));
    }

}
