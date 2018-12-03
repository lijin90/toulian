<?php

/**
 * 政策汇编
 * @author Changfeng Ji <jichf@qq.com>
 */
class PolicycollectionController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 政策汇编');
        $deptId = Yii::app()->getRequest()->getQuery('deptId', '');
        if (empty($deptId)) {
            throw new CHttpException(404);
        }
        $depart = Department::model()->getDepart($deptId);
        if (!$depart) {
            throw new CHttpException(404);
        }
        $columnOne = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('dr.ChildID')
                ->from('t_department_references dr')
                ->where('dr.ParentID=:ParentID', array(':ParentID' => $depart['ID']))
                ->queryColumn();
        $columnTwo = array();
        if ($columnOne) {
            $columnTwo = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('dr.ChildID')
                    ->from('t_department_references dr')
                    ->where(array('in', 'dr.ParentID', $columnOne))
                    ->queryColumn();
        }
        $deptIdes = array();
        $deptIdes[] = $depart['ID'];
        if ($columnOne) {
            $deptIdes = array_merge($deptIdes, $columnOne);
        }
        if ($columnTwo) {
            $deptIdes = array_merge($deptIdes, $columnTwo);
        }
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_article a')
                ->join('t_department d', 'd.ID = a.DeptID')
                ->order('a.CreateTime ASC');
        $query->andWhere('a.ArticleType = :ArticleType', array(':ArticleType' => 'policycollection'));
        if ($depart) {
            $query->andWhere(array('in', 'a.DeptID', $deptIdes));
        }
        $datas = $query
                ->select('a.*, d.DeptName')
                ->queryAll();
        $trees = array();
        foreach ($datas as $key => $data) {
            if (preg_match('/^\d+$/', $data['Section'])) {
                $data['children'] = array();
                $trees[] = $data;
                unset($datas[$key]);
            }
        }
        foreach ($trees as $tkey => $tdata) {
            foreach ($datas as $key => $data) {
                if (preg_match('/^' . $tdata['Section'] . '\.\d+$/', $data['Section'])) {
                    $trees[$tkey]['children'][] = $data;
                    unset($datas[$key]);
                }
            }
        }
        foreach ($datas as $key => $data) {
            $trees[] = $data;
        }
        $this->render('index', array(
            'depart' => $depart,
            'datas' => $datas,
            'trees' => $trees
        ));
    }

}
