<?php

/**
 * 培训统计
 * @author Changfeng Ji <jichf@qq.com>
 */
class StatisticsAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 培训统计');
        $items = array('0', '1', '2', '3', '4', '5', '6');
        $time = time();
        $date = date("y-m-d", $time);
        $dates = date("Y-m-d H:i:s", $time);
        $connection = Yii::app()->getDb();
        $study = $connection
                ->createCommand()
                ->select('s.*')
                ->from('t_statistics s')
                ->where('s.datetime < :datetime', array(':datetime' => $dates))
                ->queryAll();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $month = Yii::app()->getRequest()->getPost('month');
            $data = $connection
                    ->createCommand()
                    ->select('s.date, s.count')
                    ->from('t_statistics s')
                    ->where('s.month = :month', array(':month' => $month))
                    ->queryAll();
            foreach ($data as $key => $value) {
                $data[$key]['date'] = strtr($value['date'], array('15-' => ''));
            }
            Unit::ajaxJson(0, '', $data);
        }
        $this->getController()->render('statistics', array('study' => $study));
    }

}
