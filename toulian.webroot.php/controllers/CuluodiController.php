<?php

/**
 * 促落地
 * @author Changfeng Ji <jichf@qq.com>
 */
class CuluodiController extends Controller {

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 2017投资北京促落地企业宣传专区');
        $companyDepand = Yii::app()->getRequest()->getQuery('companyDepand', '');
        $area = Yii::app()->getRequest()->getQuery('area', '');
        $establishDate = Yii::app()->getRequest()->getQuery('establishDate', '');
        $companyName = Yii::app()->getRequest()->getQuery('companyName', '');
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_culuodi c')
                ->order('c.CreateTime DESC');
        if (!empty($companyDepand)) {
            $query->andWhere('c.CompanyDepand = :CompanyDepand', array(':CompanyDepand' => $companyDepand));
        }
        if (!empty($area)) {
            $query->andWhere(array('like', 'c.ProjectLatest', '%' . Unit::escapeLike($area) . '%'));
        }
        if ($establishDate == '1年以下') {
            $query->andWhere('c.EstablishDate > :EstablishDate', array(':EstablishDate' => time() - 86400 * 30 * 12 * 1));
        } else if ($establishDate == '1年-3年') {
            $query->andWhere('c.EstablishDate > :EstablishDateStart', array(':EstablishDateStart' => time() - 86400 * 30 * 12 * 3));
            $query->andWhere('c.EstablishDate < :EstablishDateEnd', array(':EstablishDateEnd' => time() - 86400 * 30 * 12 * 1));
        } else if ($establishDate == '3年-5年') {
            $query->andWhere('c.EstablishDate > :EstablishDateStart', array(':EstablishDateStart' => time() - 86400 * 30 * 12 * 5));
            $query->andWhere('c.EstablishDate < :EstablishDateEnd', array(':EstablishDateEnd' => time() - 86400 * 30 * 12 * 3));
        } else if ($establishDate == '5年以上') {
            $query->andWhere('c.EstablishDate < :EstablishDate', array(':EstablishDate' => time() - 86400 * 30 * 12 * 5));
        }
        if (!empty($companyName)) {
            $query->andWhere(array('like', 'c.ProjectName', '%' . Unit::escapeLike($companyName) . '%'));
        }
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(30);
        $datas = $query
                ->select('*')
                ->limit($pages->pageSize)
                ->offset($pages->currentPage * $pages->pageSize)
                ->queryAll();
        foreach ($datas as $key => $data) {
            $datas[$key]['CompanyName'] = $data['ProjectName'];
            if (mb_strpos($data['ProjectName'], '设立', 0, 'utf-8') !== false) {
                $datas[$key]['CompanyName'] = mb_substr($data['ProjectName'], mb_strpos($data['ProjectName'], '设立', 0, 'utf-8') + 2, null, 'utf-8');
            }
        }
        $this->render('index', array(
            'queries' => array(
                'companyDepand' => $companyDepand,
                'area' => $area,
                'establishDate' => $establishDate,
                'companyName' => $companyName
            ),
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

    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('culuodiId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('culuodi/index'));
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('c.*')
                ->from('t_culuodi c')
                ->where('c.ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('culuodi/index'));
        }
        $companyName = $data['ProjectName'];
        if (mb_strpos($data['ProjectName'], '设立', 0, 'utf-8') !== false) {
            $companyName = mb_substr($data['ProjectName'], mb_strpos($data['ProjectName'], '设立', 0, 'utf-8') + 2, null, 'utf-8');
        }
        $data['CompanyName'] = $companyName;
        $this->setPageTitle(Yii::app()->name . ' - 2017投资北京促落地企业宣传专区 - ' . $companyName);
        $this->render('detail', array('data' => $data));
    }

}
