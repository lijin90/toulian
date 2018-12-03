<?php

/**
 * 投资人库
 * @author Changfeng Ji <jichf@qq.com>
 */
class InvestorlibraryController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function filterAccessControl($filterChain) {
        $isAdmin = Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin; //管理员
        $isBjtcj = Unit::getLoggedDeptId() == '899a1eb9_6c0e_4155_a55b_8b85d7984beb'; //北京市投资促进局
        if (!$isAdmin && !$isBjtcj) {
            Yii::app()->getUser()->setFlash('loginAlert', '请登录北京市投资促进局账户');
            Yii::app()->getUser()->loginRequired();
        }
        parent::filterAccessControl($filterChain);
    }

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 投资人库');
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                ->where('d.DeptType = :DeptType', array(':DeptType' => 'investorlibrary'))
                ->order('d.SortNo ASC, d.CreateTime DESC');
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(18);
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
            $this->redirect(Yii::app()->createUrl('investorlibrary/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('investorlibrary/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资人库 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '投资人库', 'url' => Yii::app()->createUrl('investorlibrary/index')),
            array('name' => $data['DeptName'])
        );
        $this->render('detail', array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1)
        ));
    }

}
