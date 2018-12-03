<?php

/**
 * 招商项目
 * @author Changfeng Ji <jichf@qq.com>
 */
class InvestprojectController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('guide'),
                'roles' => array('investprojectGuide'),
            ),
            array('allow',
                'actions' => array('financing', 'land', 'officebuilding', 'park', 'investment', 'save'),
                'roles' => array('investprojectAdd', 'investprojectEdit'),
            ),
            array('allow',
                'actions' => array('list'),
                'roles' => array('investprojectList'),
            ),
            array('allow',
                'actions' => array('detail'),
                'roles' => array('investprojectDetail'),
            ),
            array('allow',
                'actions' => array('download'),
                'roles' => array('investprojectDownload'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('investprojectDelete'),
            ),
            array('allow',
                'actions' => array('setStatus'),
                'roles' => array('investprojectSetStatus'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * 填报指南
     */
    public function actionGuide() {
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 招商项目填报指南');
        $content = $this->renderPartial('guide', array(), true, false);
        $this->render('layout', array('current' => 'guide', 'content' => $content));
    }

    /**
     * 添加|编辑 - 融资项目信息表
     */
    public function actionFinancing() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        $data = false;
        if ($id) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $id))
                    ->order('CreateTime DESC')
                    ->queryRow();
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 融资项目信息表');
        $content = $this->renderPartial('financing', array('data' => $data), true, false);
        $this->render('layout', array('current' => 'financing', 'content' => $content));
    }

    /**
     * 添加|编辑 - 土地招商项目信息表
     */
    public function actionLand() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        $data = false;
        if ($id) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $id))
                    ->order('CreateTime DESC')
                    ->queryRow();
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 土地招商项目信息表');
        $content = $this->renderPartial('land', array('data' => $data), true, false);
        $this->render('layout', array('current' => 'land', 'content' => $content));
    }

    /**
     * 添加|编辑 - 写字楼招商项目信息表
     */
    public function actionOfficebuilding() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        $data = false;
        if ($id) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $id))
                    ->order('CreateTime DESC')
                    ->queryRow();
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 写字楼招商项目信息表');
        $content = $this->renderPartial('officebuilding', array('data' => $data), true, false);
        $this->render('layout', array('current' => 'officebuilding', 'content' => $content));
    }

    /**
     * 添加|编辑 - 园区招商项目信息表
     */
    public function actionPark() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        $data = false;
        if ($id) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $id))
                    ->order('CreateTime DESC')
                    ->queryRow();
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 园区招商项目信息表');
        $content = $this->renderPartial('park', array('data' => $data), true, false);
        $this->render('layout', array('current' => 'park', 'content' => $content));
    }

    /**
     * 添加|编辑 - 投资项目信息表
     */
    public function actionInvestment() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        $data = false;
        if ($id) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                throw new CHttpException(403, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $data = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('*')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $id))
                    ->order('CreateTime DESC')
                    ->queryRow();
        }
        $this->setPageTitle(Yii::app()->name . ' - 投资北京项目信息采集表 - 投资项目信息表');
        $content = $this->renderPartial('investment', array('data' => $data), true, false);
        $this->render('layout', array('current' => 'investment', 'content' => $content));
    }

    /**
     * 添加|编辑 - 保存
     */
    public function actionSave() {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }
        $columns = array(
            'ID' => '',
            'Type' => '',
            'Year' => '',
            'Name' => '',
            'Industry' => '',
            'Content' => '',
            'Money' => '',
            'Region' => '',
            'TotalArea' => '',
            'InvestArea' => '',
            'InvestRequire' => '',
            'Prospect' => '',
            'Supplement' => '',
            'InvestorName' => '',
            'InvestorBackground' => '',
            'InvestorContact' => '',
            'InvestorPhone' => '',
            'InvestorMail' => ''
        );
        $allowedColumns = array_keys($columns);
        foreach ($allowedColumns as $allowColumn) {
            $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
        }
        $required = array(
            'Type' => '类型必须填写',
            'Year' => '年份必须填写',
            'Name' => '项目名称必须填写',
            'Industry' => '所属行业必须填写',
            'Content' => '项目内容必须填写',
            //'Money' => '投资金额必须填写',
            //'Region' => '投资区域必须填写',
            //'TotalArea' => '总面积必须填写',
            //'InvestArea' => '招商面积必须填写',
            //'InvestRequire' => '招商要求必须填写',
            //'Prospect' => '项目前景必须填写',
            'Supplement' => '所缺条件及政府服务事项必须填写',
            //'InvestorName' => '投资方名称必须填写',
            'InvestorBackground' => '投资方背景必须填写',
            'InvestorContact' => '联系人必须填写',
            'InvestorPhone' => '联系电话必须填写',
                //'InvestorMail' => '电子邮件必须填写'
        );
        if ($columns['Type'] == 'financing' || $columns['Type'] == 'investment') {
            $required = array_merge($required, array(
                'Money' => '投资金额必须填写',
                'Region' => '投资区域必须填写',
                'Prospect' => '项目前景必须填写'
            ));
        } else if ($columns['Type'] == 'land') {
            $required = array_merge($required, array(
                'TotalArea' => '总面积必须填写',
                'InvestArea' => '招商面积必须填写',
                'InvestRequire' => '招商要求必须填写',
            ));
        } else if ($columns['Type'] == 'officebuilding' || $columns['Type'] == 'park') {
            $required = array_merge($required, array(
                'TotalArea' => '总面积必须填写',
                'InvestArea' => '招商面积必须填写',
                'Prospect' => '项目前景必须填写'
            ));
        }
        $numbers = array(
            'Year' => '年份必须是数字',
            'Money' => '投资金额必须是数字',
            'TotalArea' => '总面积必须是数字',
            'InvestArea' => '招商面积必须是数字',
        );
        foreach ($required as $key => $value) {
            if (strlen($columns[$key]) == 0) {
                Unit::ajaxJson(1, $value, array($key => $value));
            }
        }
        foreach ($numbers as $key => $value) {
            if (strlen($columns[$key]) > 0 && !is_numeric($columns[$key])) {
                Unit::ajaxJson(1, $value, array($key => $value));
            }
        }
        if (strlen($columns['InvestorMail']) > 0 && !preg_match('/^[\w\.\-]{1,26}@([\w\-]{1,20}\.){1,2}[a-z]{2,10}(\.[a-z]{2,10})?$/i', $columns['InvestorMail'])) {
            Unit::ajaxJson(1, '电子邮件格式错误', array('InvestorMail' => '电子邮件格式错误'));
        }
        if ($columns['ID']) {
            $columns['ID'] = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_investproject')
                    ->where('ID = :ID', array(':ID' => $columns['ID']))
                    ->order('CreateTime DESC')
                    ->queryScalar();
        }
        if ($columns['ID']) {
            if (!Yii::app()->user->checkAccess('investprojectEdit')) {
                Unit::ajaxJson(1, Yii::t('yii', 'You are not authorized to perform this action.'));
            }
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->update('t_investproject', $columns, 'ID = :ID', array(':ID' => $columns['ID']));
            if ($rt !== false) {
                Unit::ajaxJson(0, '修改成功', Yii::app()->createUrl('investproject/detail', array('ipId' => $columns['ID'])));
            }
        } else {
            $columns['ID'] = Unit::stringGuid();
            $columns['UID'] = Unit::getLoggedUserId();
            $columns['Status'] = 1;
            $columns['CreateTime'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_investproject', $columns);
            if ($rt) {
                Unit::ajaxJson(0, '提交成功');
            }
        }
        Unit::ajaxJson(1, '提交失败');
    }

    /**
     * 列表
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionList() {
        $types = array(
            'financing' => '融资项目信息表',
            'land' => '土地招商项目信息表',
            'officebuilding' => '写字楼招商项目信息表',
            'park' => '园区招商项目信息表',
            'investment' => '投资项目信息表',
        );
        $year = Yii::app()->getRequest()->getQuery('year', date('Y'));
        $type = Yii::app()->getRequest()->getQuery('type', 'financing');
        $type = isset($types[$type]) ? $type : 'financing';
        $keyword = Yii::app()->getRequest()->getQuery('keyword', '');
        $this->setPageTitle(Yii::app()->name . ' - 北京市招商引资项目库 - ' . $types[$type]);
        $query = Yii::app()
                ->getDb()
                ->createCommand()
                ->from('t_investproject')
                ->order('CreateTime DESC');
        if ($year && is_numeric($year)) {
            $query->andWhere('Year = :Year', array(':Year' => $year));
        } else {
            $year = date('Y');
        }
        if (Yii::app()->user->checkAccess('investprojectSetStatus')) {
            $query->andWhere('Type = :Type', array(':Type' => $type));
        } else {
            $query->andWhere(array('and', 'Type = :Type', 'Status = 1'), array(':Type' => $type));
        }
        if ($keyword) {
            $query->andWhere(array('like', 'Name', '%' . Unit::escapeLike($keyword) . '%'));
        }
        $queryCount = clone $query;
        $count = $queryCount->select('COUNT(*)')->queryScalar();
        $pages = new CPagination($count);
        $pages->setPageSize(21);
        $datas = $query
                ->select('*')
                ->limit($pages->pageSize)
                ->offset($pages->currentPage * $pages->pageSize)
                ->queryAll();
        $this->render('list', array(
            'queries' => array(
                'year' => htmlspecialchars($year),
                'type' => htmlspecialchars($type),
                'keyword' => htmlspecialchars($keyword)
            ),
            'datas' => $datas,
            'pages' => $pages,
            'pagination' => (object) array(
                'itemCount' => $pages->getItemCount(),
                'pageSize' => $pages->getLimit(),
                'pageCount' => $pages->getPageCount(),
                'currentPage' => $pages->getCurrentPage()
        )));
    }

    /**
     * 详情
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDetail() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        if (empty($id)) {
            $this->redirect(Yii::app()->createUrl('investproject/list'));
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_investproject')
                ->where('ID = :ID', array(':ID' => $id))
                ->order('CreateTime DESC')
                ->queryRow();
        if (!$data) {
            $this->redirect(Yii::app()->createUrl('investproject/list'));
        } else if (!$data['Status'] && !Yii::app()->user->checkAccess('setStatus')) {
            $this->redirect(Yii::app()->createUrl('investproject/list'));
        }
        $types = array(
            'financing' => '融资项目信息表',
            'land' => '土地招商项目信息表',
            'officebuilding' => '写字楼招商项目信息表',
            'park' => '园区招商项目信息表',
            'investment' => '投资项目信息表',
        );
        $this->setPageTitle(Yii::app()->name . ' - 北京市招商引资项目库 - ' . $types[$data['Type']] . ' - ' . $data['Name']);
        $content = $this->renderPartial('detail-' . $data['Type'], array('data' => $data), true, false);
        $this->render('layout-view', array('current' => $data['Type'], 'content' => $content));
    }

    /**
     * 下载（Word文档）
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDownload() {
        $id = Yii::app()->getRequest()->getQuery('ipId', '');
        if (empty($id)) {
            throw new CHttpException(404);
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_investproject')
                ->where('ID = :ID', array(':ID' => $id))
                ->order('CreateTime DESC')
                ->queryRow();
        if (!$data) {
            throw new CHttpException(404);
        }
        $fileName = $data['Type'] . '_' . date('YmdHis', time()) . '_' . rand(10000, 99999) . '.docx';
        $outFile = Yii::app()->getAssetManager()->getBasePath() . '/' . $fileName;
        Yii::import('application.extensions.PHPWord.PHPWord', 1);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Changfeng Ji');
        $properties->setLastModifiedBy('Changfeng Ji');
        $properties->setTitle('Office 2007 DOCX Test Document');
        $properties->setSubject('Office 2007 DOCX Test Document');
        $properties->setDescription('Project document for Office 2007 DOCX, generated using PHPWord.');
        $properties->setKeywords('office 2007 openxml php');
        $properties->setCategory('Project file');
        $phpWord->addTitleStyle(1, array('bold' => true, 'name' => '宋体', 'size' => 16), array('align' => 'center'));
        $section = $phpWord->addSection();
        $styleTable = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'width' => 100);
        $styleCell = array('valign' => \PhpOffice\PhpWord\Style\Cell::VALIGN_CENTER);
        $fontStyle = array('name' => '宋体', 'size' => 12, 'bold' => true);
        $paragraphStyle = array('align' => 'center');
        $phpWord->addTableStyle('myOwnTableStyle', $styleTable);
        $cellWidth = ($section->getStyle()->getPageSizeW() - $section->getStyle()->getMarginLeft() - $section->getStyle()->getMarginRight()) / 6;
        $rowHeight = 500;
        switch ($data['Type']) {
            case 'financing':
                $section->addTextBreak(3);
                $section->addTitle('拟投资北京( 融资 ) 项目信息表(' . $data['Year'] . '年)', 1);
                $section->addTextBreak();
                $table = $section->addTable('myOwnTableStyle');
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('项目名称', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Name'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('所属行业', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Industry'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Content'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('投资金额', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Money'] . '万元', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('投资区域', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Region'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目前景', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Prospect'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('所缺条件及政府服务事项', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Supplement'], $fontStyle, $paragraphStyle);
                break;
            case 'land':
                $section->addTextBreak(3);
                $section->addTitle('拟投资北京( 土地招商 ) 项目信息表(' . $data['Year'] . '年)', 1);
                $section->addTextBreak();
                $table = $section->addTable('myOwnTableStyle');
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('项目名称', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Name'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('所属行业', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Industry'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Content'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('土地总面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['TotalArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('招商面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('招商要求', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestRequire'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('所缺条件及政府服务事项', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Supplement'], $fontStyle, $paragraphStyle);
                break;
            case 'officebuilding':
                $section->addTextBreak(3);
                $section->addTitle('拟投资北京( 写字楼 ) 项目信息表(' . $data['Year'] . '年)', 1);
                $section->addTextBreak();
                $table = $section->addTable('myOwnTableStyle');
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('项目名称', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Name'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('所属行业', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Industry'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Content'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('建筑总面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['TotalArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('招商面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目前景', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Prospect'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('所缺条件及政府服务事项', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Supplement'], $fontStyle, $paragraphStyle);
                break;
            case 'park':
                $section->addTextBreak(3);
                $section->addTitle('拟投资北京( 园区招商 ) 项目信息表(' . $data['Year'] . '年)', 1);
                $section->addTextBreak();
                $table = $section->addTable('myOwnTableStyle');
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('项目名称', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Name'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('所属行业', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Industry'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Content'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('建筑总面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['TotalArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('招商面积', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestArea'] . '平方米', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目前景', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Prospect'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('所缺条件及政府服务事项', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Supplement'], $fontStyle, $paragraphStyle);
                break;
            case 'investment':
                $section->addTextBreak(3);
                $section->addTitle('拟投资北京项目信息表(' . $data['Year'] . '年)', 1);
                $section->addTextBreak();
                $table = $section->addTable('myOwnTableStyle');
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('项目名称', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Name'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth * 2, array_merge($styleCell, array('gridSpan' => 2)))->addText('所属行业', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Industry'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Content'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('投资金额', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Money'] . '万元', $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('投资区域', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Region'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('项目前景', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Prospect'], $fontStyle, $paragraphStyle);
                $table->addRow($rowHeight);
                $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('项目内容', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth, $styleCell)->addText('所缺条件及政府服务事项', $fontStyle, $paragraphStyle);
                $table->addCell($cellWidth * 4, $styleCell)->addText($data['Supplement'], $fontStyle, $paragraphStyle);
                break;
            default:
                throw new CHttpException(404);
                break;
        }
        $table->addRow($rowHeight);
        $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'restart')))->addText('投资方信息', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth, $styleCell)->addText('投资方名称', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestorName'], $fontStyle, $paragraphStyle);
        $table->addRow($rowHeight);
        $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('投资方信息', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth, $styleCell)->addText('投资方背景', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestorBackground'], $fontStyle, $paragraphStyle);
        $table->addRow($rowHeight);
        $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('投资方信息', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth, $styleCell)->addText('联系人', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestorContact'], $fontStyle, $paragraphStyle);
        $table->addRow($rowHeight);
        $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('投资方信息', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth, $styleCell)->addText('联系电话', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestorPhone'], $fontStyle, $paragraphStyle);
        $table->addRow($rowHeight);
        $table->addCell($cellWidth, array_merge($styleCell, array('vMerge' => 'continue')))->addText('投资方信息', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth, $styleCell)->addText('电子邮件', $fontStyle, $paragraphStyle);
        $table->addCell($cellWidth * 4, $styleCell)->addText($data['InvestorMail'], $fontStyle, $paragraphStyle);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($outFile);
        if (is_file($outFile)) {
            $content = file_get_contents($outFile);
            unlink($outFile);
            Yii::app()->getRequest()->sendFile($fileName, $content);
        }
    }

    /**
     * 删除
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionDelete() {
        $id = Yii::app()->getRequest()->getPost('id', '');
        if (empty($id)) {
            Unit::ajaxJson(1, '缺少参数');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_investproject')
                ->where('ID = :ID', array(':ID' => $id))
                ->order('CreateTime DESC')
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '数据不存在');
        }
        $result = Yii::app()
                ->getDb()
                ->createCommand()
                ->delete('t_investproject', 'ID = :ID', array(':ID' => $id));
        if ($result) {
            Unit::ajaxJson(0, '删除成功', Yii::app()->createUrl('investproject/list', array('type' => $data['Type'])));
        } else {
            Unit::ajaxJson(1, '删除失败');
        }
    }

    /**
     * 设置状态
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionSetStatus() {
        $id = Yii::app()->getRequest()->getPost('id', '');
        if (empty($id)) {
            Unit::ajaxJson(1, '缺少参数');
        }
        $data = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_investproject')
                ->where('ID = :ID', array(':ID' => $id))
                ->order('CreateTime DESC')
                ->queryRow();
        if (!$data) {
            Unit::ajaxJson(1, '数据不存在');
        }
        $status = $data['Status'] ? 0 : 1;
        $result = Yii::app()->getDb()->createCommand()->update('t_investproject', array('Status' => $status), 'ID = :ID', array(':ID' => $id));
        if ($result !== false) {
            Unit::ajaxJson(0, '设置成功');
        } else {
            Unit::ajaxJson(1, '设置失败');
        }
    }

}
