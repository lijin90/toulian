<?php

/**
 * 企业邮箱
 * @author Changfeng Ji <jichf@qq.com>
 */
class MailController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 企业邮箱');
        $this->render('index');
    }

}
