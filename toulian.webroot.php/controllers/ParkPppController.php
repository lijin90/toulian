<?php

/**
 * 园区PPP
 * @author Changfeng Ji <jichf@qq.com>
 */
class ParkPppController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 园区PPP');
        $datas = Yii::app()->getDb()
                ->createCommand()
                ->select('a.*')
                ->from('t_article a')
                ->where('a.ArticleType = :ArticleType', array(':ArticleType' => 'parkppp'))
                ->order('a.CreateTime ASC')
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
        $this->render('index', array(
            'datas' => $datas,
            'trees' => $trees
        ));
    }

    /**
     * 详情页
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getPost('id', '');
        if (!$id) {
            Unit::ajaxJson(1, '缺少参数');
        }
        $data = Yii::app()->getDb()
                ->createCommand()
                ->select('a.*')
                ->from('t_article a')
                ->where('a.ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '数据不存在');
        }
        Unit::ajaxJson(0, '', $data);
    }

}
