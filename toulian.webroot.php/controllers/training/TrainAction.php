<?php

/**
 * 投联培训
 * @author Changfeng Ji <jichf@qq.com>
 */
class TrainAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 在线使用培训');
        $time = time();
        $date = date("y-m-d", $time);
        $rand = rand(1, 5);
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('s.*')
                ->from('t_statistics s')
                ->where('s.date = :date', array(':date' => $date))
                ->queryRow();
        $connection = Yii::app()->getDb();
        $rt = $connection
                ->createCommand()
                ->update('t_statistics', ['count' => $data['count'] + $rand], 'date = :date', array(':date' => $date));
        $this->getController()->render('train', array('data' => $data));
    }

}
