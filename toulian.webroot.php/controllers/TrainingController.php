<?php

/**
 * 投联培训
 * @author Changfeng Ji <jichf@qq.com>
 */
class TrainingController extends Controller {

    public function actions() {
        return array(
            'index' => 'application.controllers.training.IndexAction', //培训列表
            'detail' => 'application.controllers.training.DetailAction', //培训详情
            'apply' => 'application.controllers.activity.ApplyAction', //活动报名 - 填写报名信息
            'train' => 'application.controllers.training.TrainAction', //投联培训
            'statistics' => 'application.controllers.training.StatisticsAction', //培训统计
        );
    }

}
