<?php

/**
 * 批处理
 * @author Changfeng Ji <jichf@qq.com>
 */
class BatchController extends Controller {

    /**
     * 投联网用户满意度调查表（席位） - 2017年 - 为57个席位的用户生成问卷数据。
     */
    public function actionSatisfactionStudio2017() {
        $user57Seats = Yii::app()->getDb()
                ->createCommand()
                ->select('u.ID, u.DeptID, u.UserName, d.DeptName, d.DeptType')
                ->from('t_user u')
                ->leftJoin('t_department d', 'u.DeptID = d.ID')
                ->where(array('and', 'u.Status = 1', array('in', 'u.ID', User::get57SeatUserIdes())))
                ->order('d.DeptType ASC, d.SortNo ASC')
                ->queryAll();
        $questions = array(
            array(
                'field' => 'login',
                'question' => '1. 您是否经常登陆投联网账号？',
                'answers' => array("经常登陆" => 0, "偶尔来看看" => 0, "登陆过2～4次" => 0, "从未登陆过，这是第1次" => 0, "不关注、没有浏览" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'safe',
                'question' => '2.您觉得工作室登陆方式及安全性如何？',
                'answers' => array("非常好" => 0, "很好" => 0, "好" => 0, "一般" => 0, "差" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'convenient',
                'question' => '3. 您认为本网站个人工作室操作是否便捷？',
                'answers' => array("非常便捷" => 0, "很便捷" => 0, "便捷" => 0, "一般便捷" => 0, "不便捷" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'habit',
                'question' => '4. 本网站整体设计是否符合您的操作习惯？',
                'answers' => array("非常好" => 0, "很好" => 0, "好" => 0, "一般" => 0, "差" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'sudu',
                'question' => '5. 本网站打开的响应速度是否令您满意？',
                'answers' => array("非常满意" => 0, "很满意" => 0, "满意" => 0, "一般" => 0, "不满意" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'buju',
                'question' => '6. 本网站整体的布局和逻辑是否令您满意？',
                'answers' => array("非常满意" => 0, "很满意" => 0, "满意" => 0, "一般" => 0, "不满意" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'serve',
                'question' => '7. 本网站所提供的服务功能是否令您满意？',
                'answers' => array("非常满意" => 0, "很满意" => 0, "满意" => 0, "一般" => 0, "不满意" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'issue',
                'question' => '8. 您是否经常在投联网发布信息？',
                'answers' => array("经常发布" => 0, "偶尔发布" => 0, "发布过2～4次" => 0, "从未发布过" => 0)
            ),
            array(
                'field' => 'fankui',
                'question' => '9. 您在本网站发布的信息反馈效果如何？',
                'answers' => array("效果非常好" => 0, "效果很好" => 0, "效果好" => 0, "效果一般" => 0, "成效差" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'cover',
                'question' => '10. 您认为本网站提供的物业招商信息覆盖全面吗？',
                'answers' => array("非常全面" => 0, "很全面" => 0, "全面" => 0, "一般全面" => 0, "不全面" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'intime',
                'question' => '11. 您认为本网站提供的物业招商信息更新是否及时？',
                'answers' => array("非常及时" => 0, "很及时" => 0, "及时" => 0, "一般及时" => 0, "不及时" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'help',
                'question' => '12. 本网站所呈现的招商信息是否对您有帮助？',
                'answers' => array("非常有帮助" => 0, "很有帮助" => 0, "帮助一般" => 0, "帮助差" => 0, "没有帮助" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'attend',
                'question' => '13. 您是否参加过投联网举办的招商引资推介活动？',
                'answers' => array("参加过" => 0, "没有参加" => 0, "不想参加" => 0, "不知道" => 0)
            ),
            array(
                'field' => 'service',
                'question' => '15. 在网站使用过程中，您对本网站维护总体服务如何评价？',
                'answers' => array("0" => 0, "1" => 0, "2" => 0, "3" => 0, "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, "10" => 0)
            )
        );
        $successCount = 0;
        $failCount = 0;
        $logins = array();
        foreach ($user57Seats as $user) {
            $columns = array(
                'userid' => $user['ID'],
                'ip' => '',
                'created' => rand(strtotime('2017-04-01 00:00:00'), strtotime('2017-12-10 00:00:00'))
            );
            foreach ($questions as $question) {
                $columns[$question['field']] = array_rand(array_splice($question['answers'], 0, 3));
            }
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_survey_satisfaction_studio', $columns);
            if ($rt) {
                $successCount++;
            } else {
                $failCount++;
            }
        }
        echo '成功：' . $successCount . '；失败：' . $failCount;
    }

    /**
     * 招商企业库中，请将”产业招商理论与实务高级研修班-企业（科技、开发公司）“中的8162条通讯录中的”公司名称”按照以下关键字规则分配到以下几个分组中:
     *  - 科技、开发 -> 产业招商理论与实务高级研修班-企业（科技、开发公司）
     *  - 设备、制品、工厂、厂 -> 产业招商理论与实务高级研修班-企业（设备公司、工厂）
     *  - 影视、速递、服务、商贸、食品、节能 -> 产业招商理论与实务高级研修班-企业（生活类公司）
     *  - 房地产 -> 产业招商理论与实务高级研修班-企业（房地产公司）
     */
    public function actionContactPatch1() {
        throw new CHttpException(403);
        $ret = Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_contact', array('ContactGroup' => '产业招商理论与实务高级研修班-企业（科技、开发公司）'), array(
            'and',
            'ContactGroup = :ContactGroupA',
            array(
                'or',
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('科技') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('开发') . '%')
            )), array(':ContactGroupA' => '产业招商理论与实务高级研修班-企业（科技、开发公司）'));
        var_dump($ret);
        $ret = Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_contact', array('ContactGroup' => '产业招商理论与实务高级研修班-企业（设备公司、工厂）'), array(
            'and',
            'ContactGroup = :ContactGroupA',
            array(
                'or',
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('设备') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('制品') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('工厂') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('厂') . '%')
            )), array(':ContactGroupA' => '产业招商理论与实务高级研修班-企业（科技、开发公司）'));
        var_dump($ret);
        $ret = Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_contact', array('ContactGroup' => '产业招商理论与实务高级研修班-企业（生活类公司）'), array(
            'and',
            'ContactGroup = :ContactGroupA',
            array(
                'or',
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('影视') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('速递') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('服务') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('商贸') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('食品') . '%'),
                array('like', 'EnterpriseName', '%' . Unit::escapeLike('节能') . '%')
            )), array(':ContactGroupA' => '产业招商理论与实务高级研修班-企业（科技、开发公司）'));
        var_dump($ret);
        $ret = Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_contact', array('ContactGroup' => '产业招商理论与实务高级研修班-企业（房地产公司）'), array(
            'and',
            'ContactGroup = :ContactGroupA',
            array('like', 'EnterpriseName', '%' . Unit::escapeLike('房地产') . '%')
                ), array(':ContactGroupA' => '产业招商理论与实务高级研修班-企业（科技、开发公司）'));
        var_dump($ret);
    }

    /**
     * 企业数据分析处理
     */
    public function actionEnterprise() {
        $this->setPageTitle(Yii::app()->name . ' - 企业数据分析处理');
        $errors = array();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $path = FileUploadHelper::getFilePath('tmp_enterprises', true);
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'xls, xlsx',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
            );
            $originalFile = CUploadedFile::getInstanceByName('originalFile');
            $originalFileErrors = FileUploadHelper::validateUploadedFile($originalFile, $rule);
            if ($originalFileErrors) {
                $errors['originalFile'] = '上传原始文件失败，请重试';
            } else {
                $originalFile = FileUploadHelper::saveUploadedFile($originalFile, $path);
                if (!$originalFile) { //上传失败
                    $errors['originalFile'] = '保存原始文件失败，请重试';
                }
            }
            $cleanFile = CUploadedFile::getInstanceByName('cleanFile');
            $cleanFileErrors = FileUploadHelper::validateUploadedFile($cleanFile, $rule);
            if ($cleanFileErrors) {
                $errors['cleanFile'] = '上传清洗文件失败，请重试';
            } else {
                $cleanFile = FileUploadHelper::saveUploadedFile($cleanFile, $path);
                if (!$cleanFile) { //上传失败
                    $errors['cleanFile'] = '保存清洗文件失败，请重试';
                }
            }
            $missEnterpriseNameMatch = Yii::app()->getRequest()->getPost('missEnterpriseNameMatch', '');

            if (!$errors) {
                $outPath = Yii::app()->getAssetManager()->getBasePath() . '/enterprises/enterprise_' . date('YmdHis', time()) . '_' . rand(10000, 99999);
                if (!is_dir($outPath)) {
                    FileHelper::createDirectory($outPath, 0777, true);
                }
                set_time_limit(0);
                ini_set('memory_limit', '256M'); //设置内存
                Yii::$enableIncludePath = false;
                Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
                PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);

                $objPHPExcel = PHPExcel_IOFactory::load($path . $originalFile);
                $objPHPExcel->setActiveSheetIndex(0);
                $sheet = $objPHPExcel->getActiveSheet();
                $highestDataRow = $sheet->getHighestDataRow();
                $originalDatas = array();
                for ($i = 2; $i <= $highestDataRow; $i++) {
                    $originalDatas[] = array(
                        'A' => (string) $sheet->getCell('A' . $i)->getValue(), //序号
                        'B' => (string) $sheet->getCell('B' . $i)->getValue(), //楼宇名称
                        'C' => (string) $sheet->getCell('C' . $i)->getValue(), //公司名称
                    );
                }
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);

                $objPHPExcel = PHPExcel_IOFactory::load($path . $cleanFile);
                $objPHPExcel->setActiveSheetIndex(0);
                $sheet = $objPHPExcel->getActiveSheet();
                $highestDataRow = $sheet->getHighestDataRow();
                $cleanDatas = array();
                for ($i = 2; $i <= $highestDataRow; $i++) {
                    $data = array(
                        'A' => (string) $sheet->getCell('A' . $i)->getValue(), //序号
                        'B' => (string) $sheet->getCell('B' . $i)->getValue(), //楼宇名称
                        'C' => (string) $sheet->getCell('C' . $i)->getValue(), //公司名称
                        'D' => (string) $sheet->getCell('D' . $i)->getFormattedValue(), //统一社会信用代码
                        'E' => (string) $sheet->getCell('E' . $i)->getFormattedValue(), //纳税人识别号
                        'F' => (string) $sheet->getCell('F' . $i)->getFormattedValue(), //注册号
                        'G' => (string) $sheet->getCell('G' . $i)->getFormattedValue(), //组织机构代码
                        'H' => (string) $sheet->getCell('H' . $i)->getValue(), //注册资本
                        'I' => (string) $sheet->getCell('I' . $i)->getValue(), //法定代表人
                        'J' => (string) $sheet->getCell('J' . $i)->getValue(), //经营状态
                        'K' => (string) $sheet->getCell('K' . $i)->getValue(), //成立日期
                        'L' => (string) $sheet->getCell('L' . $i)->getValue(), //公司类型
                        'M' => (string) $sheet->getCell('M' . $i)->getValue(), //营业期限
                        'N' => (string) $sheet->getCell('N' . $i)->getValue(), //登记机关
                        'O' => (string) $sheet->getCell('O' . $i)->getValue(), //核准日期
                        'P' => (string) $sheet->getCell('P' . $i)->getValue(), //所属地区
                        'Q' => (string) $sheet->getCell('Q' . $i)->getValue(), //所属行业
                        'R' => (string) $sheet->getCell('R' . $i)->getValue(), //企业地址
                        'S' => (string) $sheet->getCell('S' . $i)->getValue(), //经营范围
                        'T' => (string) $sheet->getCell('T' . $i)->getValue(), //股东
                        'U' => (string) $sheet->getCell('U' . $i)->getValue(), //持股比例
                        'V' => (string) $sheet->getCell('V' . $i)->getValue(), //认缴出资额（万元）
                        'W' => (string) $sheet->getCell('W' . $i)->getValue(), //认缴出资日期
                        'X' => (string) $sheet->getCell('X' . $i)->getValue(), //股东类型
                    );
                    $cleanDatas[] = $data;
                }
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);

                // 生成的企业明细目录
                $detailPath = $outPath . '/detailList';
                if (!is_dir($detailPath)) {
                    FileHelper::createDirectory($detailPath, 0777, true);
                }
                $buildings = Unit::arrayColumn($cleanDatas, 'B');
                $buildings = array_unique($buildings);
                $buildings = array_values($buildings);
                $buildings = array_flip($buildings);
                foreach ($cleanDatas as $key => $value) {
                    $building = $value['B'];
                    if (!is_array($buildings[$building])) {
                        $buildings[$building] = array();
                    }
                    $buildings[$building][] = $value;
                }
                foreach ($buildings as $building => $values) {
                    $objPHPExcel = new PHPExcel();
                    $objPHPExcel->getProperties()
                            ->setCreator("Changfeng Ji")
                            ->setLastModifiedBy("Changfeng Ji")
                            ->setTitle("Office 2007 XLSX Test Document")
                            ->setSubject("Office 2007 XLSX Test Document")
                            ->setDescription("Office document for Office 2007 XLSX, generated using PHP classes.")
                            ->setKeywords("office 2007 openxml php")
                            ->setCategory("Office file");
                    $objSheet = $objPHPExcel->getSheet(0);
                    $objSheet->setTitle($building . '企业明细');
                    $row = 1;
                    $objSheet->setCellValue('A' . $row, '序号');
                    $objSheet->setCellValue('B' . $row, '公司名称');
                    $objSheet->setCellValue('C' . $row, '经营范围');
                    $objSheet->setCellValue('D' . $row, '企业地址');
                    $objSheet->setCellValue('E' . $row, '注册资本');
                    $objSheet->setCellValue('F' . $row, '成立日期');
                    $objSheet->setCellValue('G' . $row, '统一社会信用代码');
                    $objSheet->setCellValue('H' . $row, '法定代表人');
                    $objSheet->setCellValue('I' . $row, '股东');
                    $objSheet->setCellValue('J' . $row, '所属行业');
                    $objSheet->setCellValue('K' . $row, '登记机关');
                    $objSheet->setCellValue('L' . $row, '是否西城注册');
                    $objSheet->getStyle('A' . $row . ':L' . $row)->getFont()->setBold(true);
                    $objSheet->freezePane('A2');
                    foreach ($values as $key => $value) {
                        $row++;
                        $objSheet->setCellValue('A' . $row, $value['A']);
                        $objSheet->setCellValue('B' . $row, $value['C']);
                        $objSheet->setCellValue('C' . $row, $value['S']);
                        $objSheet->setCellValue('D' . $row, $value['R']);
                        $objSheet->setCellValue('E' . $row, $value['H']);
                        $objSheet->setCellValue('F' . $row, $value['K']);
                        if (is_numeric($value['K'])) {
                            //$objSheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
                            $value['K'] = PHPExcel_Shared_Date::ExcelToPHP($value['K']);
                            $value['K'] = date('Y年m月d日', $value['K']);
                            $objSheet->setCellValue('F' . $row, $value['K']);
                        }
                        $objSheet->setCellValueExplicit('G' . $row, $value['D'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $objSheet->setCellValue('H' . $row, $value['I']);
                        $objSheet->setCellValue('I' . $row, $value['T']);
                        $objSheet->setCellValue('J' . $row, $value['Q']);
                        $objSheet->setCellValue('K' . $row, $value['N']);
                        $objSheet->setCellValue('L' . $row, mb_strpos($value['N'], '西城分局') !== false ? '是' : '否');
                    }
                    PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($detailPath . '/' . iconv('utf-8', 'gb2312', $building) . '.xlsx');
                    $objPHPExcel->disconnectWorksheets();
                    unset($objPHPExcel);
                }
                // 生成的缺少的企业名称
                $renameDatas = array();
                $cleanEnterpriseNames = Unit::arrayColumn($cleanDatas, 'C');
                $cleanEnterpriseNames = array_map('trim', $cleanEnterpriseNames);
                $cleanEnterpriseNames = array_unique($cleanEnterpriseNames);
                $cleanEnterpriseNames = array_flip($cleanEnterpriseNames);
                foreach ($originalDatas as $key => $value) {
                    if (!isset($cleanEnterpriseNames[trim($value['C'])])) {
                        $renameDatas[] = $value;
                    }
                }
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                        ->setCreator("Changfeng Ji")
                        ->setLastModifiedBy("Changfeng Ji")
                        ->setTitle("Office 2007 XLSX Test Document")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Office document for Office 2007 XLSX, generated using PHP classes.")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Office file");
                $objSheet = $objPHPExcel->getSheet(0);
                $objSheet->setTitle('缺少的企业名称');
                $row = 1;
                $objSheet->setCellValue('A' . $row, '序号');
                $objSheet->setCellValue('B' . $row, '楼宇名称');
                $objSheet->setCellValue('C' . $row, '原公司名称');
                $objSheet->setCellValue('D' . $row, '更改公司名称');
                $objSheet->setCellValue('E' . $row, '备注');
                $objSheet->setCellValue('F' . $row, '原公司名称自然语言匹配');
                $objSheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
                $objSheet->freezePane('A2');
                $renameDataCount = count($renameDatas);
                $dependency = new CDbCacheDependency('SELECT MAX(id) FROM t_enterprise');
                foreach ($renameDatas as $key => $value) {
                    $row++;
                    $objSheet->setCellValue('A' . $row, $value['A']);
                    $objSheet->setCellValue('B' . $row, $value['B']);
                    $objSheet->setCellValue('C' . $row, $value['C']);
                    $objSheet->setCellValue('D' . $row, '');
                    $objSheet->setCellValue('E' . $row, '');
                    if ($missEnterpriseNameMatch) {
                        $enterpriseInfo = Yii::app()
                                ->getDb()
                                ->cache(604800, $dependency)
                                ->createCommand()
                                ->select('enterpriseName, registrationStatus')
                                ->from('t_enterprise')
                                ->where('MATCH (enterpriseName) AGAINST ("' . Unit::escapeLike($value['C']) . '" IN NATURAL LANGUAGE MODE)')
                                ->limit(1)
                                ->queryRow();
                        $missEnterpriseNameMatchLog = '[' . date('Y-m-d H:i:s', time()) . '] ' . ($key + 1) . '/' . $renameDataCount . ' ' . $value['C'];
                        if ($enterpriseInfo) {
                            $objSheet->setCellValue('D' . $row, $enterpriseInfo['enterpriseName']);
                            $objSheet->setCellValue('E' . $row, $enterpriseInfo['registrationStatus']);
                            $missEnterpriseNameMatchLog .= ' --> ' . $enterpriseInfo['enterpriseName'] . '（' . $enterpriseInfo['registrationStatus'] . '）';
                        }
                        file_put_contents($outPath . '/missEnterpriseNameMatch.log', $missEnterpriseNameMatchLog . PHP_EOL, FILE_APPEND);
                        Yii::getLogger()->flush(true);
                    }
                    $objSheet->setCellValue('F' . $row, '点击打开链接');
                    $objSheet->getCell('F' . $row)->getHyperlink()->setUrl('http://www.toulianwang.com/batch/enterpriseName.html?enterpriseName=' . $value['C']);
                    $objSheet->getCell('F' . $row)->getHyperlink()->setTooltip('点击打开链接');
                    $objSheet->getStyle('F' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                }
                PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save($outPath . '/' . iconv('utf-8', 'gb2312', '缺少的企业名称') . '.xlsx');
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);

                //生成缺少的楼宇名称
                $buildings1 = Unit::arrayColumn($originalDatas, 'B');
                $buildings2 = Unit::arrayColumn($cleanDatas, 'B');
                $buildingsDiff = array_diff(array_unique($buildings1), array_unique($buildings2));
                file_put_contents($outPath . '/' . iconv('utf-8', 'gb2312', '缺少的楼宇名称') . '.txt', implode(PHP_EOL, $buildingsDiff));

                $zipPath = $outPath . '.zip';
                $zip = new ZipArchive;
                if (!$zip->open($zipPath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
                    FileHelper::removeDirectory($outPath);
                    throw new CException(Yii::t(get_class($this), basename($zipPath) . ' can not create'));
                }
                $handler = opendir($detailPath);
                while (($filename = readdir($handler)) !== false) {
                    if ($filename != "." && $filename != ".." && is_file($detailPath . "/" . $filename)) {
                        $zip->addFile($detailPath . "/" . $filename, '/enterprise/' . iconv('utf-8', 'gb2312', '企业明细') . '/' . $filename);
                    }
                }
                @closedir($handler);
                $zip->addFile($outPath . '/' . iconv('utf-8', 'gb2312', '缺少的企业名称') . '.xlsx', '/enterprise/缺少的企业名称.xlsx');
                $zip->addFile($outPath . '/' . iconv('utf-8', 'gb2312', '缺少的楼宇名称') . '.txt', '/enterprise/缺少的楼宇名称.txt');
                if (is_file($outPath . '/missEnterpriseNameMatch.log')) {
                    $zip->addFile($outPath . '/missEnterpriseNameMatch.log', '/enterprise/缺少的企业名称.log');
                }
                $zip->close();
                FileHelper::removeDirectory($outPath);
                Yii::app()->getRequest()->xSendFile($zipPath, array('saveName' => 'enterprise.zip'));
            }
        }
        $this->render('enterprise', array('errors' => $errors));
    }

    /**
     * 企业数据导入企业库
     */
    public function actionEnterpriseImport() {
        $this->setPageTitle(Yii::app()->name . ' - 企业数据导入企业库');
        $errors = array();
        $successCount = 0;
        $failCount = 0;
        $skipCount = 0;
        $failLogs = array();
        $skipLogs = array();
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $path = FileUploadHelper::getFilePath('tmp_enterprises', true);
            $rule = array('attach', 'file',
                'allowEmpty' => false,
                'message' => '{attribute}必须上传',
                'types' => 'xls, xlsx',
                'wrongType' => '文件“{file}”不能上传，仅支持上传文件扩展名为 {extensions} 的文件。'
            );
            $cleanFile = CUploadedFile::getInstanceByName('cleanFile');
            $cleanFileErrors = FileUploadHelper::validateUploadedFile($cleanFile, $rule);
            if ($cleanFileErrors) {
                $errors['cleanFile'] = '上传清洗文件失败，请重试';
            } else {
                $cleanFile = FileUploadHelper::saveUploadedFile($cleanFile, $path);
                if (!$cleanFile) { //上传失败
                    $errors['cleanFile'] = '保存清洗文件失败，请重试';
                }
            }
            $sourceRemark = Yii::app()->getRequest()->getPost('sourceRemark', '');
            if (!$sourceRemark || !in_array($sourceRemark, array('导入', '跑楼'))) {
                $errors['sourceRemark'] = '来源备注必须选择';
            }
            $skipExist = Yii::app()->getRequest()->getPost('skipExist', '');
            if (!$errors) {
                set_time_limit(0);
                ini_set('memory_limit', '256M'); //设置内存
                Yii::$enableIncludePath = false;
                Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
                PHPExcel_Settings::setCacheStorageMethod(PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized);
                $objPHPExcel = PHPExcel_IOFactory::load($path . $cleanFile);
                $objPHPExcel->setActiveSheetIndex(0);
                $sheet = $objPHPExcel->getActiveSheet();
                $highestDataRow = $sheet->getHighestDataRow();
                $cleanDatas = array();
                for ($i = 2; $i <= $highestDataRow; $i++) {
                    $data = array(
                        'A' => (string) $sheet->getCell('A' . $i)->getValue(), //序号
                        'B' => (string) $sheet->getCell('B' . $i)->getValue(), //楼宇名称
                        'C' => (string) $sheet->getCell('C' . $i)->getValue(), //公司名称
                        'D' => (string) $sheet->getCell('D' . $i)->getFormattedValue(), //统一社会信用代码
                        'E' => (string) $sheet->getCell('E' . $i)->getFormattedValue(), //纳税人识别号
                        'F' => (string) $sheet->getCell('F' . $i)->getFormattedValue(), //注册号
                        'G' => (string) $sheet->getCell('G' . $i)->getFormattedValue(), //组织机构代码
                        'H' => (string) $sheet->getCell('H' . $i)->getValue(), //注册资本
                        'I' => (string) $sheet->getCell('I' . $i)->getValue(), //法定代表人
                        'J' => (string) $sheet->getCell('J' . $i)->getValue(), //经营状态
                        'K' => (string) $sheet->getCell('K' . $i)->getValue(), //成立日期
                        'L' => (string) $sheet->getCell('L' . $i)->getValue(), //公司类型
                        'M' => (string) $sheet->getCell('M' . $i)->getValue(), //营业期限
                        'N' => (string) $sheet->getCell('N' . $i)->getValue(), //登记机关
                        'O' => (string) $sheet->getCell('O' . $i)->getValue(), //核准日期
                        'P' => (string) $sheet->getCell('P' . $i)->getValue(), //所属地区
                        'Q' => (string) $sheet->getCell('Q' . $i)->getValue(), //所属行业
                        'R' => (string) $sheet->getCell('R' . $i)->getValue(), //企业地址
                        'S' => (string) $sheet->getCell('S' . $i)->getValue(), //经营范围
                        'T' => (string) $sheet->getCell('T' . $i)->getValue(), //股东
                        'U' => (string) $sheet->getCell('U' . $i)->getValue(), //持股比例
                        'V' => (string) $sheet->getCell('V' . $i)->getValue(), //认缴出资额（万元）
                        'W' => (string) $sheet->getCell('W' . $i)->getValue(), //认缴出资日期
                        'X' => (string) $sheet->getCell('X' . $i)->getValue(), //股东类型
                    );
                    $cleanDatas[] = $data;
                }
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);
                foreach ($cleanDatas as $key => $value) {
                    $value['D'] = trim($value['D']) == '-' ? '' : $value['D'];
                    $value['E'] = trim($value['E']) == '-' ? '' : $value['E'];
                    $value['F'] = trim($value['F']) == '-' ? '' : $value['F'];
                    $value['G'] = trim($value['G']) == '-' ? '' : $value['G'];
                    if (!$value['C'] || (!$value['D'] && !$value['F'])) {
                        $skipCount++;
                        $skipLogs[] = '信息不全：' . $value['A'] . ' | ' . $value['B'] . ' | ' . $value['C'] . ' | ' . $value['D'] . ' | ' . $value['E'] . ' | ' . $value['F'];
                        continue;
                    }
                    $enterpriseData = Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select('*')
                            ->from('t_enterprise')
                            ->where('enterpriseName = :enterpriseName', array(':enterpriseName' => trim($value['C'])))
                            ->limit(1)
                            ->queryRow();
                    if ($enterpriseData && ($enterpriseData['unifiedSocialCreditCode'] || $enterpriseData['registerNumber']) && $skipExist) {
                        $skipCount++;
                        $skipLogs[] = '已存在：' . $value['A'] . ' | ' . $value['B'] . ' | ' . $value['C'] . ' | ' . $value['D'] . ' | ' . $value['E'] . ' | ' . $value['F'];
                        continue;
                    }
                    $registeredCapital = $value['H'];
                    if (mb_strpos($registeredCapital, '美元') !== false) {
                        $registeredCapitalUnit = '万美元';
                    } else {
                        $registeredCapitalUnit = '万人民币';
                    }
                    preg_match("/\d+(\.\d+)?/", $registeredCapital, $matches);
                    $registeredCapital = isset($matches[0]) ? $matches[0] : 0;
                    $dateOfEstablishment = 0;
                    if (is_numeric($value['K'])) {
                        $value['K'] = PHPExcel_Shared_Date::ExcelToPHP($value['K']);
                        $dateOfEstablishment = date('Y-m-d', $value['K']);
                    }
                    $operatingPeriodStart = 0;
                    $operatingPeriodEnd = 0;
                    $operatingPeriods = explode('至', $value['M']);
                    if (isset($operatingPeriods[1])) {
                        $operatingPeriods = array_map('trim', $operatingPeriods);
                        preg_match("/\d{4}\-\d{2}\-\d{2}/", $operatingPeriods[0], $matches);
                        $operatingPeriodStart = isset($matches[0]) ? $matches[0] : '';
                        preg_match("/\d{4}\-\d{2}\-\d{2}/", $operatingPeriods[1], $matches);
                        $operatingPeriodEnd = isset($matches[0]) ? $matches[0] : '';
                    }
                    $approvedDate = 0;
                    if (is_numeric($value['O'])) {
                        $value['O'] = PHPExcel_Shared_Date::ExcelToPHP($value['O']);
                        $approvedDate = date('Y-m-d', $value['O']);
                    }
                    $columns = array(
                        'unifiedSocialCreditCode' => trim($value['D']),
                        'registerNumber' => trim($value['F']),
                        'organizationCode' => trim($value['G']),
                        'enterpriseName' => trim($value['C']),
                        'enterpriseType' => trim($value['L']),
                        'enterpriseIndustry' => trim($value['Q']),
                        'enterpriseArea' => CrawlEnterprise::getAreaFromAddress(trim($value['R'])),
                        'enterpriseAddress' => trim($value['R']),
                        'buildingName' => trim($value['B']),
                        'legalPerson' => trim($value['I']),
                        //'phone' => '',
                        //'mail' => '',
                        'registeredCapital' => $registeredCapital,
                        'registeredCapitalUnit' => $registeredCapitalUnit,
                        'dateOfEstablishment' => $dateOfEstablishment,
                        'operatingPeriodStart' => $operatingPeriodStart,
                        'operatingPeriodEnd' => $operatingPeriodEnd,
                        'registrationAuthority' => trim($value['N']),
                        'approvedDate' => $approvedDate,
                        'registrationStatus' => trim($value['J']),
                        'registrationStatusFormat' => CrawlEnterprise::formatRegistrationStatus(trim($value['J'])),
                        'businessScope' => trim($value['S']),
                        'stockholdersName' => rtrim(trim($value['T']), ','),
                        'stockholdersType' => rtrim(trim($value['X']), ','),
                        'stockholdersMoney' => strtr(rtrim(trim($value['V']), ','), array(',,' => ',')),
                        'stockholdersDate' => strtr(rtrim(trim($value['W']), ','), array(',,' => ',')),
                        'stockholdersPercentage' => rtrim(trim($value['U']), ','),
                        'crawlTime' => date('Y-m-d H:i:s', time()), //抓取时间
                        'sourceUrl' => '', //来源地址
                        'sourceRemark' => $sourceRemark //来源备注
                    );
                    if (!$columns['unifiedSocialCreditCode']) {
                        unset($columns['unifiedSocialCreditCode']);
                    }
                    if (!$columns['registerNumber']) {
                        unset($columns['registerNumber']);
                    }
                    try {
                        if ($enterpriseData) {
                            $columns['registeredCapital'] = $columns['registeredCapital'] ? $columns['registeredCapital'] : $enterpriseData['registeredCapital'];
                            $columns['registeredCapitalUnit'] = $columns['registeredCapital'] ? $columns['registeredCapitalUnit'] : $enterpriseData['registeredCapitalUnit'];
                            $rt = Yii::app()->getDb()->createCommand()->update('t_enterprise', $columns, 'id = :id', array(':id' => $enterpriseData['id']));
                            if ($rt) {
                                $successCount++;
                            } else {
                                $failCount++;
                                $failLogs[] = '更新失败：' . $value['A'] . ' | ' . $value['B'] . ' | ' . $value['C'] . ' | ' . $value['D'] . ' | ' . $value['E'] . ' | ' . $value['F'];
                            }
                        } else {
                            $rt = Yii::app()->getDb()->createCommand()->insert('t_enterprise', $columns);
                            if ($rt) {
                                $successCount++;
                            } else {
                                $failCount++;
                                $failLogs[] = '添加失败：' . $value['A'] . ' | ' . $value['B'] . ' | ' . $value['C'] . ' | ' . $value['D'] . ' | ' . $value['E'] . ' | ' . $value['F'];
                            }
                        }
                    } catch (Exception $exc) {
                        $skipCount++;
                        $skipLogs[] = '出现异常：' . $value['A'] . ' | ' . $value['B'] . ' | ' . $value['C'] . ' | ' . $value['D'] . ' | ' . $value['E'] . ' | ' . $value['F'];
                    }
                }
            }
        }
        $this->render('enterpriseImport', array(
            'errors' => $errors,
            'successCount' => $successCount,
            'failCount' => $failCount,
            'skipCount' => $skipCount,
            'failLogs' => $failLogs,
            'skipLogs' => $skipLogs
        ));
    }

    /**
     * 企业名称自然语言匹配
     */
    public function actionEnterpriseName() {
        $errors = array();
        $enterpriseName = Yii::app()->getRequest()->getQuery('enterpriseName', '');
        $enterpriseNames = array();
        if ($enterpriseName) {
            $dependency = new CDbCacheDependency('SELECT MAX(id) FROM t_enterprise');
            $enterpriseNames = Yii::app()
                    ->getDb()
                    ->cache(604800, $dependency)
                    ->createCommand()
                    ->select('enterpriseName')
                    ->from('t_enterprise')
                    ->where('MATCH (enterpriseName) AGAINST ("' . Unit::escapeLike($enterpriseName) . '" IN NATURAL LANGUAGE MODE)')
                    ->limit(15)
                    ->queryColumn();
        } else {
            $errors['enterpriseName'] = '企业名称必须填写';
        }
        $this->setPageTitle(Yii::app()->name . ' - 企业名称自然语言匹配');
        $this->render('enterpriseName', array('errors' => $errors, 'enterpriseName' => $enterpriseName, 'enterpriseNames' => $enterpriseNames));
    }

    /**
     * 企业地址匹配写字楼
     */
    public function actionEnterpriseMatchOfficeBuilding() {
        set_time_limit(0);
        $addres = CrawlEnterprise::getOfficeBuildingAddress();
        foreach ($addres as $key => $value) {
            Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->update('t_enterprise', array('buildingName' => $key), array('and', 'buildingName = ""', array('like', 'enterpriseAddress', Unit::escapeLike($value) . '%')));
        }
    }

}
