<?php

/**
 * 特色栏目
 * @author Changfeng Ji <jichf@qq.com>
 */
class SpecificationController extends Controller {

    public function actionIndex() {
        $id = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        $data = Department::model()->getDepart($id);
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('site/index'));
        }
        $this->setPageTitle(Yii::app()->name . ' - ' . $data['DeptName'] . ' - 特色栏目');
        Unit::jsVariable('specId', Yii::app()->getRequest()->getQuery('specId', ''));
        $views = array(
            '60111684_a523_438a_8b7d_2ca0b7d896c6' => 'index-xicheng' //西城区投资促进局
        );
        $this->render(isset($views[$data['ID']]) ? $views[$data['ID']] : 'index', array(
            'data' => $data,
            'specifications' => Specification::model()->getSpecifications($data['ID'], 1)
        ));
    }

}
