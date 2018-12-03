<?php

/**
 * 活动详情
 * @author Changfeng Ji <jichf@qq.com>
 */
class MeetingAction extends CAction {

    public function run() {
        $id = Yii::app()->getRequest()->getQuery('acId');
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('a.*, i.ImageName, i.Path')
                ->from('t_activity a')
                ->join('t_activity_image i', 'i.AID = a.ID')
                ->where(array('and', 'a.Enable = :Enable', 'a.ID = :ID', 'i.ImageName = :Name'), array(':Enable' => '1', ':ID' => $id, ':Name' => '宣传图片'))
                ->queryRow();
        if (!$data) {
            $this->getController()->redirect(Yii::app()->createUrl('activity/index'));
        }
        $this->getController()->setPageTitle(Yii::app()->name . ' - 投联活动 - ' . $data['Title']);
        $content = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('c.*')
                ->from('t_activity_content c')
                ->join('t_activity a', 'c.AID = a.ID')
                ->where(array('and', 'a.ID = :ID', 'c.IsShow = :IsShow'), array(':ID' => $id, ':IsShow' => 1))
                ->order('SortNo ASC')
                ->queryAll();
        $this->getController()->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '投联活动', 'url' => Yii::app()->createUrl('activity/index')),
            array('name' => $data['Title'])
        );
        $image = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('i.*')
                ->from('t_activity_image i')
                ->where(array('and', 'i.AID = :AID', 'i.ImageName = :Name'), array(':AID' => $data['ID'], ':Name' => '活动风采'))
                ->queryAll();
        $this->getController()->render('meeting', array(
            'data' => $data,
            'content' => $content,
            'image' => $image
        ));
    }

}
