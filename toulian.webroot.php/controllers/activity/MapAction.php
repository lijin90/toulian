<?php

/**
 * 活动地图
 * @author Changfeng Ji <jichf@qq.com>
 */
class MapAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 地图');
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
        $this->getController()->render('map', array(
            'data' => $data
        ));
    }

}
