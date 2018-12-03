<?php

/**
 * 静态页面
 * @author Changfeng Ji <jichf@qq.com>
 */
class StaticController extends Controller {

    public function actionHuaXia() {
        $this->setPageTitle(Yii::app()->name . ' - “华夏幸福，与您共建幸福城市” --华夏幸福环北京重点园区');
        $this->render('huaXia');
    }

    public function actionXiCheng() {
        $this->setPageTitle(Yii::app()->name . ' - 印象西城');
        $this->render('xicheng');
    }

    public function actionXiChengInvest() {
        $this->setPageTitle(Yii::app()->name . ' - 投资西城');
        $this->render('xichengInvest');
    }

    public function actionXiChengCulture() {
        $this->setPageTitle(Yii::app()->name . ' - 文化西城');
        $this->render('xichengCulture');
    }

    public function actionJinRong_xicheng() {
        $this->setPageTitle(Yii::app()->name . ' - 金融西城');
        $this->render('jinrong_xicheng');
    }

    public function actionYingLanGuoJi() {
        $this->setPageTitle(Yii::app()->name . ' - 英蓝国际金融中心');
        $this->render('yinglanguoji');
    }

    public function actionShiShaHai() {
        $this->setPageTitle(Yii::app()->name . ' - 什刹海');
        $this->render('shishahai');
    }

    public function actionBridge() {
        $this->setPageTitle(Yii::app()->name . ' - 天桥');
        $this->render('bridge');
    }

    public function actionGuCheng_xinsheng() {
        $this->setPageTitle(Yii::app()->name . ' - 大栅栏 古城新生，文化的传承');
        $this->render('gucheng_xinsheng');
    }

    public function actionJiaohui_gulao() {
        $this->setPageTitle(Yii::app()->name . ' - 大栅栏 交汇的古老');
        $this->render('jiaohui_gulao');
    }

    public function actionRenWen_diyun() {
        $this->setPageTitle(Yii::app()->name . ' - 中关村科技园区德胜（西城）科技园');
        $this->render('renwen_diyun');
    }

    public function actionRuHai_kgu() {
        $this->setPageTitle(Yii::app()->name . ' - 如海控股');
        $this->render('ruhai_kgu');
    }

    /*
     * 以上为正式页面
     * 以下为临时页面
     */
}
