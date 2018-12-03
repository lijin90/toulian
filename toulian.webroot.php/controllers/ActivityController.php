<?php

/**
 * 投联活动
 * @author Changfeng Ji <jichf@qq.com>
 */
class ActivityController extends Controller {

    public function actions() {
        return array(
            'index' => 'application.controllers.activity.IndexAction', //活动列表
            'meeting' => 'application.controllers.activity.MeetingAction', //活动详情
            'map' => 'application.controllers.activity.MapAction', //活动地图
            'apply' => 'application.controllers.activity.ApplyAction', //活动报名 - 填写报名信息
            'applySubmit' => 'application.controllers.activity.ApplySubmitAction', //活动报名 - 报名提交（AJAX）
            'commentSubmit' => 'application.controllers.activity.CommentSubmitAction', //活动评论 - 评论提交（AJAX）
            'consultSubmit' => 'application.controllers.activity.ConsultSubmitAction', //活动咨询 - 咨询提交（AJAX）
        );
    }

}
