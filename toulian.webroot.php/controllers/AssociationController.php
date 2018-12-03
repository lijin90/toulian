<?php

/**
 * 商业协会
 * @author Changfeng Ji <jichf@qq.com>
 */
class AssociationController extends Controller {

    /**
     * 首页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 商会协会');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $page = Yii::app()->getRequest()->getPost('page', 0);
            $query = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->from('t_department d')
                    ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                    ->leftJoin('t_department_references dr', 'd.ID = dr.ChildID')
                    ->leftJoin('t_department dd', 'dr.ParentID = dd.ID')
                    ->order('d.SortNo ASC, d.CreateTime DESC');
            $query->andWhere('d.DeptType = :DeptType', array(':DeptType' => 'association'));
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
            $cates = array('商会' => 'shanghui', '协会' => 'xiehui', '俱乐部' => 'julebu');
            foreach ($datas as &$data) {
                $data['Logo'] = $data['Logo'] ? FileUploadHelper::getFileUrl($data['Logo']) : DbOption::defaultLogo($data['DeptType'] . '_' . $cates[$data['CategoryName']]);
                $data['Link'] = Yii::app()->createUrl('association/detail', array('deptId' => $data['ID']));
            }
            $html = $datas ? $this->renderPartial('index-item-' . ($page % 2), array('datas' => $datas), true) : '';
            Unit::ajaxJson(0, '', array(
                'html' => $html,
                'pagination' => (object) array(
                    'itemCount' => $pages->getItemCount(),
                    'pageSize' => $pages->getLimit(),
                    'pageCount' => $pages->getPageCount(),
                    'currentPage' => $pages->getCurrentPage()
                )
            ));
        }
        $this->render('index');
    }

    /**
     * 详情页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('association/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('association/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 商会协会 - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '商会协会', 'url' => Yii::app()->createUrl('association/index')),
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
        $this->render('detail', array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
            'resources' => Resource::model()->getResources($userId, $params)
        ));
    }

}
