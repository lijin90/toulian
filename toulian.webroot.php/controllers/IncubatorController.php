<?php

/**
 * 孵化器
 * @author Changfeng Ji <jichf@qq.com>
 */
class IncubatorController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 孵化器');
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
                ->where(array('and', 'd.DeptType = :DeptType', array('like', 'd.AreaCode', $acPrefix . '%')), array(':DeptType' => 'incubator'))
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

    /**
     * 详情页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('incubator/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('incubator/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 孵化器 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '孵化器', 'url' => Yii::app()->createUrl('incubator/index')),
            array('name' => $data['DeptName'])
        );
        $this->render('detail', array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1)
        ));
    }

}
