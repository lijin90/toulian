<?php

/**
 * @author zhuangpeng
 * @date 2016-02-19 03:24:24
 */
class ServeController extends Controller {

    /**
     * 投联服务
     */
    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 投联服务');
        $this->render('index');
    }

    /**
     * 服务列表页
     */
    public function actionList() {
        $acId = Yii::app()->getRequest()->getParam('acId');
        if (empty($acId)) {
            $this->redirect(Yii::app()->createUrl('serve/index'));
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('d.ID, d.DeptName, d.CategoryID, dc.Name AS CategoryName')
                ->from('t_department d')
                ->leftJoin('t_department_category dc', 'd.CategoryID = dc.ID')
                ->where(array('and', 'd.CategoryID = :CategoryID'), array(':CategoryID' => $acId))
                ->order('d.CreateTime')
                ->queryAll();
        if (isset($data[0])) {
            $this->setPageTitle(Yii::app()->name . ' - 投联服务 - ' . $data[0]['CategoryName']);
        } else {
            $this->setPageTitle(Yii::app()->name . ' - 投联服务 - 服务列表');
        }
        $this->render('list', array(
            'acId' => $acId,
            'data' => $data
        ));
    }

    /**
     * 投联服务详情页
     */
    public function actionDetail() {
        $SID = Yii::app()->getRequest()->getParam('SID');
        if (empty($SID)) {
            $this->redirect(Yii::app()->createUrl('serve/index'));
        }
        $data = Department::getDepart($SID);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('serve/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - 投联服务 - ' . $data['CategoryName'] . ' - ' . $data['DeptName']);
        $this->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '投联服务', 'url' => Yii::app()->createUrl('serve/index')),
            array('name' => $data['CategoryName'], 'url' => Yii::app()->createUrl('serve/list', array('acId' => $data['CategoryID']))),
            array('name' => $data['DeptName'])
        );
        $brokers = Yii::app()->getDb()
                ->createCommand()
                ->select('m.*')
                ->from('t_department_member m')
                ->join('t_department d', 'd.ID = m.DeptID')
                ->where(array('and', 'd.ID = :ID', 'm.IsEnabled = :IsEnabled'), array(':ID' => $data['ID'], ':IsEnabled' => 0))
                ->queryAll();
        $this->render('detail', array(
            'data' => $data,
            'brokers' => $brokers,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1),
            'showImages' => ShowImage::model()->getShowImages($data['ID'], 1),
        ));
    }

}
