<?php

/**
 * 工作报告（项目汇报）
 * @author Changfeng Ji <jichf@qq.com>
 */
class ProjectreportingController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function filterAccessControl($filterChain) {
        $isAdmin = Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin; //管理员
        $isBjtcj = Unit::getLoggedDeptId() == '899a1eb9_6c0e_4155_a55b_8b85d7984beb'; //北京市投资促进局
        if (!$isAdmin && !$isBjtcj) {
            Yii::app()->getUser()->setFlash('loginAlert', '请登录北京市投资促进局账户');
            Yii::app()->getUser()->loginRequired();
        }
        parent::filterAccessControl($filterChain);
    }

    public function actionIndex() {
        $this->setPageTitle(Yii::app()->name . ' - 工作报告');
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_article a')
                ->order('a.CreateTime DESC');
        $query->andWhere('a.ArticleType = :ArticleType', array(':ArticleType' => 'projectreporting'));
        $datas = $query
                ->select('a.*')
                ->queryAll();
        $trees = array();
        foreach ($datas as $key => $data) {
            if (!$data['Section']) {
                continue;
            }
            if (!isset($trees[$data['Section']])) {
                $trees[$data['Section']] = array('周工作报告' => array(), '月工作报告' => array(), '总工作报告' => array(), '其他工作报告' => array());
            }
            if (mb_strpos($data['Title'], '周工作报告') !== false) {
                $trees[$data['Section']]['周工作报告'][] = $data;
            } else if (mb_strpos($data['Title'], '月工作报告') !== false) {
                $trees[$data['Section']]['月工作报告'][] = $data;
            } else if (mb_strpos($data['Title'], '总工作报告') !== false) {
                $trees[$data['Section']]['总工作报告'][] = $data;
            } else {
                $trees[$data['Section']]['其他工作报告'][] = $data;
            }
            unset($datas[$key]);
        }
        $this->render('index', array(
            'datas' => $datas,
            'trees' => $trees
        ));
    }

}
