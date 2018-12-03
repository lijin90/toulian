<?php

/**
 * 招聘
 * @author Changfeng Ji <jichf@qq.com>
 */
class RecruitmentController extends Controller {

    public function actionIndex() {
        $datas = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_recruitment r')
                ->select('r.*')
                ->where('r.IsShow = 1')
                ->order('r.SortNo ASC, r.CreateTime DESC')
                ->limit(10)
                ->queryAll();
        $rtIdes = Unit::arrayColumn($datas, 'ID');
        $rtId = Yii::app()->getRequest()->getQuery('rtId', '');
        if (!$rtId || !in_array($rtId, $rtIdes)) {
            $rtId = array_shift($rtIdes);
        }
        $this->setPageTitle(Yii::app()->name . ' - 招聘');
        $this->render('index', array('datas' => $datas, 'rtId' => $rtId));
    }

    public function actionResume() {
        $id = Yii::app()->getRequest()->getQuery('rtId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('recruitment/index'));
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('r.*')
                ->from('t_recruitment r')
                ->where('r.ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('recruitment/index'));
        }
        Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_recruitment', array('ViewCount' => new CDbExpression('ViewCount + 1')), 'ID = :ID', array(':ID' => $id));
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $columns = array(
                'RealName' => '',
                'Gender' => 0,
                'Nation' => '',
                'Marital' => '',
                'Birthday' => '',
                'Native' => '',
                'Telephone' => '',
                'Email' => '',
                'SchoolTag' => '',
                'HighestEducation' => '',
                'MajorName' => '',
                'LanguageCompetence' => '',
                'WorkExperience' => '',
                'PersonalSkill' => '',
                'SelfEvaluation' => '',
                'CareerIntention' => '',
                'Avatar' => '',
                'Attach' => ''
            );
            $allowedColumns = array_keys($columns);
            foreach ($allowedColumns as $allowColumn) {
                $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
            }
            $required = array(
                'RealName' => '姓名必须填写',
                'Gender' => '性别必须选择',
                'Nation' => '民族必须填写',
                'Marital' => '婚姻状况必须填写',
                'Birthday' => '出生日期必须填写',
                'Native' => '籍贯必须填写',
                'Telephone' => '联系电话必须填写',
                'Email' => '电子邮箱必须填写',
                'SchoolTag' => '毕业学校必须填写',
                'HighestEducation' => '最高学历必须选择',
                'MajorName' => '专业名称必须填写',
                    //'LanguageCompetence' => '语言能力必须填写',
                    //'WorkExperience' => '工作经历必须填写',
                    //'PersonalSkill' => '个人技能必须填写',
                    //'SelfEvaluation' => '自我评价必须填写',
                    //'CareerIntention' => '职业意向必须填写',
            );
            foreach ($required as $key => $value) {
                if (strlen($columns[$key]) == 0) {
                    Unit::ajaxJson(1, $value, array($key => $value));
                }
            }
            $columns['ID'] = Unit::stringGuid();
            $columns['RTID'] = $data['ID'];
            $columns['CreateTime'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_recruitment_resume', $columns);
            if ($rt) {
                Unit::ajaxJson(0, '提交成功');
            } else {
                Unit::ajaxJson(1, '提交失败');
            }
        }
        $this->setPageTitle(Yii::app()->name . ' - 简历');
        $this->render('resume', array('data' => $data));
    }

}
