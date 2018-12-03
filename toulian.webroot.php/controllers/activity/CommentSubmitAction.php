<?php

/**
 * 活动评论 - 评论提交（AJAX）
 * @author Changfeng Ji <jichf@qq.com>
 */
class CommentSubmitAction extends CAction {

    public function run() {
        $columns = array('AID' => '', 'Content' => '');
        $allowedColumns = array_keys($columns);
        foreach ($allowedColumns as $allowColumn) {
            $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
        }
        if (empty($columns['AID'])) {
            Unit::ajaxJson(1, '评论失败');
        }
        if (empty($columns['Content'])) {
            Unit::ajaxJson(1, '评论必须填写');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('a.*')
                ->from('t_activity a')
                ->where('a.ID = :ID', array(':ID' => $columns['AID']))
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '评论失败');
        }
        $base_columns = array(
            'ID' => Unit::stringGuid(),
            'UID' => Unit::getLoggedUserId(),
            'AID' => $columns['AID'],
            'Content' => $columns['Content'],
            'CreateTime' => time()
        );
        $rt = Yii::app()
                ->getDb()
                ->createCommand()
                ->insert('t_activity_comment', $base_columns);
        if ($rt) {
            Unit::ajaxJson(0);
        } else {
            Unit::ajaxJson(1, '评论失败');
        }
    }

}
