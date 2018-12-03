<?php

/**
 * 培训列表
 * @author Changfeng Ji <jichf@qq.com>
 */
class IndexAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 投联培训');
        $deptId = Yii::app()->getRequest()->getQuery('deptId', '');
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('a.*, c.Title as ATitle, c.Content, i.ImageName, i.Path')
                ->from('t_activity a')
                ->join('t_activity_content c', 'c.AID = a.ID')
                ->join('t_activity_image i', 'i.AID = a.ID')
                ->where(array('and', 'Enable = :Enable', 'c.Title = :Title', 'i.ImageName = :ImageName'), array(':Enable' => 1, ':Title' => '培训内容', ':ImageName' => '宣传图片'))
                ->order('a.BeginTime DESC, a.CreateTime DESC');
        if ($deptId) {
            $userIdes = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_user')
                    ->where('DeptID=:DeptID', array(':DeptID' => $deptId))
                    ->queryColumn();
            $query->andWhere(array('in', 'a.UserID', $userIdes));
        }
        $query->andWhere('a.BeginTime > :BeginTime', array(':BeginTime' => time()));
        $newDatas = $query->queryAll();
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_activity a')
                ->join('t_activity_content c', 'c.AID = a.ID')
                ->join('t_activity_image i', 'i.AID = a.ID')
                ->where(array('and', 'Enable = :Enable', 'c.Title = :Title', 'i.ImageName = :ImageName'), array(':Enable' => 1, ':Title' => '培训内容', ':ImageName' => '宣传图片'))
                ->order('a.BeginTime DESC, a.CreateTime DESC');
        if ($newDatas) {
            $ides = Unit::arrayColumn($newDatas, 'ID');
            $query->andWhere(array('not in', 'a.ID', $ides));
        }
        if ($deptId) {
            $userIdes = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_user')
                    ->where('DeptID=:DeptID', array(':DeptID' => $deptId))
                    ->queryColumn();
            $query->andWhere(array('in', 'a.UserID', $userIdes));
        }
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(9);
        $datas = $query
                ->select('a.*, c.Title as ATitle, c.Content, i.ImageName, i.Path')
                ->limit($pages->pageSize)
                ->offset($pages->currentPage * $pages->pageSize)
                ->queryAll();
        $this->getController()->render('index', array(
            'deptId' => $deptId,
            'newDatas' => $newDatas,
            'datas' => $datas,
            'pages' => $pages,
            'pagination' => (object) array(
                'itemCount' => $pages->getItemCount(),
                'pageSize' => $pages->getLimit(),
                'pageCount' => $pages->getPageCount(),
                'currentPage' => $pages->getCurrentPage()
            )
        ));
    }

}
