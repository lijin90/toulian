<?php

/**
 * 公司页面
 * @author Changfeng Ji <jichf@qq.com>
 */
class CompanyController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('deny',
                'actions' => array('surveyStudio'),
                'users' => array('?'),
            ),
        );
    }

    public function actionGuomeisixian() {
        $this->setPageTitle(Yii::app()->name . ' - 国玫思贤（北京）投资有限公司');
        $this->render('guomeisixian');
    }

    public function actionChuanshidongfang() {
        $this->setPageTitle(Yii::app()->name . ' - 传世东方（北京）投资有限公司');
        $this->render('chuanshidongfang');
    }

    public function actionChuanshitoulian() {
        $this->setPageTitle(Yii::app()->name . ' - 传世投联（北京）科技有限公司');
        $this->render('chuanshitoulian');
    }

    public function actionToulianzhitong() {
        $this->setPageTitle(Yii::app()->name . ' - 投联智通（北京）信息技术有限公司');
        $this->render('toulianzhitong');
    }

    public function actionKasiwenhua() {
        $this->setPageTitle(Yii::app()->name . ' - 北京卡斯文化研究院');
        $this->render('kasiwenhua');
    }

    public function actionEtiquette() {
        $this->setPageTitle(Yii::app()->name . ' - 商务礼仪培训');
        $this->render('etiquette');
    }

    public function actionHandbook() {
        $this->setPageTitle(Yii::app()->name . ' - 员工手册');
        $this->render('handbook');
    }

    public function actionContract() {
        $this->setPageTitle(Yii::app()->name . ' - 劳动合同');
        $this->render('contract');
    }

    public function actionContentApproval() {
        $this->setPageTitle(Yii::app()->name . ' - 内容审核');
        $this->render('contentApproval');
    }

    public function actionAgreement() {
        $this->setPageTitle(Yii::app()->name . ' - 用户注册协议');
        $this->render('agreement');
    }

    public function actionPrivacy() {
        $this->setPageTitle(Yii::app()->name . ' - 隐私权保护声明');
        $this->render('privacy');
    }

    public function actionIntroduction() {
        $this->setPageTitle(Yii::app()->name . ' - 投联网简介');
        $this->render('introduction');
    }

    public function actionContact() {
        $this->setPageTitle(Yii::app()->name . ' - 联系我们');
        $this->render('contact');
    }

    public function actionRecruit() {
        $this->setPageTitle(Yii::app()->name . ' - 职位招聘');
        $this->render('recruit');
    }

    public function actionResume() {
        $this->setPageTitle(Yii::app()->name . ' - 张悦琪简历');
        $this->render('resume');
    }

    public function actionGuide() {
        $this->setPageTitle(Yii::app()->name . ' - 新媒体招商 服务功能指南');
        $this->render('guide');
    }

    public function actionPpt() {
        $this->setPageTitle(Yii::app()->name . ' - 新媒体产业招商在线分类平台PPT');
        $this->render('ppt');
    }

    public function actionToulianhuoban() {
        $this->setPageTitle(Yii::app()->name . ' - 投联伙伴');
        $datas = array(
            array('name' => '北京协宏房地产经纪有限公司', 'url' => 'http://www.xuanhaozhi.com'),
            array('name' => '北京东光物业管理有限公司', 'url' => 'http://www.dgwycn.com'),
            array('name' => '上海共融投资管理有限公司', 'url' => 'http://www.creative-fortune.cn'),
            array('name' => '上海蓝点投资有限公司', 'url' => 'http://www.shbpi.com'),
            array('name' => '北京信息科技大学', 'url' => 'http://www.bistu.edu.cn'),
            array('name' => '中国社会科学院政治学研究所', 'url' => 'http://chinaps.cass.cn'),
            array('name' => '北京市投资促进局', 'url' => 'http://www.investbeijing.gov.cn'),
            array('name' => '石景山区投资促进局', 'url' => 'http://www.investsjs.gov.cn'),
            array('name' => '门头沟区投资促进局', 'url' => 'http://tzcjj.bjmtg.gov.cn'),
            array('name' => '丰台区投资促进局', 'url' => 'http://www.ftinvest.gov.cn'),
            array('name' => '昌平区投资促进局', 'url' => 'http://www.cpol.gov.cn'),
            array('name' => '平谷区投资促进局', 'url' => 'http://www.investpinggu.gov.cn/gb/index.do'),
            array('name' => '怀柔区投资促进局', 'url' => 'http://www.investhuairou.com.cn'),
            array('name' => '延庆县投资促进局', 'url' => 'http://www.bjyq.gov.cn/zwxx/jgzn/qtbm/tzcjj/sy'),
            array('name' => '顺义区投资促进局', 'url' => 'http://www.investshunyi.bjshy.gov.cn'),
            array('name' => '通州区投资促进局', 'url' => 'http://tzcj.bjtzh.gov.cn'),
            array('name' => '密云县投资促进局', 'url' => 'http://mytcj.bjmy.gov.cn'),
            array('name' => '东城区产业和投资促进局', 'url' => 'http://ccj.bjdch.gov.cn/gb/index.do'),
            array('name' => '朝阳区投资促进局', 'url' => 'http://www.investchaoyang.gov.cn'),
            array('name' => '大兴区含北京经济技术开发区', 'url' => 'http://www.bda.gov.cn'),
            array('name' => '房山区投资促进局', 'url' => 'http://tzcj.bjfsh.gov.cn'),
            array('name' => '海淀区投资促进局', 'url' => 'http://www.investhd.gov.cn'),
            array('name' => '西城区投资促进局', 'url' => 'http://gcj.bjxch.gov.cn'),
            array('name' => '首都之窗', 'url' => 'http://www.beijing.gov.cn'),
            array('name' => '国家产业转移信息服务平台', 'url' => 'http://cyzy.miit.gov.cn'),
            array('name' => '互联网+投资促进服务', 'url' => 'http://www.biecc.com.cn/fushulanmu/biaoshuxiazai/2017/0313/2209.html'),
            array('name' => '北京市投资促进局互联网+投资促进服务竞争性磋商', 'url' => 'http://www.ccgp.gov.cn/cggg/dfgg/jzxcs/201703/t20170313_7993873.htm'),
        );
        $this->render('toulianhuoban', array('datas' => $datas));
    }

    public function actionSurvey() {
        $this->setPageTitle(Yii::app()->name . ' - 投联网用户满意度调查表');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $columns = array(
                'guanzhu' => '',
                'zhuce' => '',
                'sudu' => '',
                'fuwu' => '',
                'neirong' => '',
                'yichu' => '',
                'quanmian' => '',
                'bianjie' => '',
                'fankui' => '',
                'style' => '',
                'activity' => '',
                'bring' => '',
                'jianyi' => ''
            );
            $allowedColumns = array_keys($columns);
            foreach ($allowedColumns as $allowColumn) {
                $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
            }
            $required = array(
                'guanzhu' => '1. 您是否关注或浏览投联网？',
                'zhuce' => '2. 您是否愿意注册成为本网站的用户？',
                'sudu' => '3. 您觉得本网站登录速度、加载速度如何？',
                'fuwu' => '4. 对本网站所提供的服务功能，您是否满意？',
                'neirong' => '5. 本网站所呈现的内容对您是否有帮助？',
                'yichu' => '6. 您认为本网站对您了解政府、企业、园区等机构招商有益处吗？',
                'quanmian' => '7. 您认为本网站提供的物业招商信息全面吗？',
                'bianjie' => '8. 您认为本网站个人工作室操作便捷吗？',
                'fankui' => '9. 您在本网站发布招商信息反馈效果明显吗？',
                'style' => '10. 您觉得本网站整体布局、逻辑架构、设计风格如何？',
                'activity' => '11. 您参加过投联网举办的线下活动吗？',
                'bring' => '12. 使用本网站为您带来了什么？',
                'jianyi' => '13. 您对本网站的优化建议是什么？'
            );
            foreach ($required as $key => $value) {
                if (strlen($columns[$key]) == 0) {
                    Unit::ajaxJson(1, $value);
                }
            }
            $columns['ip'] = Unit::getIp();
            $columns['created'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_survey_satisfaction', $columns);
            if ($rt) {
                Unit::ajaxJson(0);
            } else {
                Unit::ajaxJson(1, '提交失败');
            }
        }
        $this->render('survey');
    }

    /**
     * 投联网用户满意度调查表（席位）
     */
    public function actionSurveyStudio() {
        $this->setPageTitle(Yii::app()->name . ' - 投联网用户满意度调查表（席位）');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $columns = array(
                'login' => '',
                'safe' => '',
                'convenient' => '',
                'habit' => '',
                'sudu' => '',
                'buju' => '',
                'serve' => '',
                'issue' => '',
                'fankui' => '',
                'cover' => '',
                'intime' => '',
                'help' => '',
                'attend' => '',
                'better' => '',
                'better_other' => '',
                'service' => ''
            );
            $allowedColumns = array_keys($columns);
            foreach ($allowedColumns as $allowColumn) {
                $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
            }
            $required = array(
                'login' => '1. 您是否经常登陆投联网账号？',
                'safe' => '2. 您觉得工作室登陆方式及安全性如何？',
                'convenient' => '3. 您认为本网站个人工作室操作是否便捷？',
                'habit' => '4. 本网站整体设计是否符合您的操作习惯？',
                'sudu' => '5. 本网站打开的响应速度是否令您满意？',
                'buju' => '6. 本网站整体的布局和逻辑是否令您满意？',
                'serve' => '7. 本网站所提供的服务功能是否令您满意？',
                'issue' => '8. 您是否经常在投联网发布信息？',
                'fankui' => '9. 您在本网站发布的信息反馈效果如何？',
                'cover' => '10. 您认为本网站提供的物业招商信息覆盖全面吗？',
                'intime' => '11. 您认为本网站提供的物业招商信息更新是否及时？',
                'help' => '12. 本网站所呈现的招商信息是否对您有帮助？',
                'attend' => '13. 您是否参加过投联网举办的招商引资推介活动？',
                'better' => '14. 您认为当前网站有哪些问题需要进一步改善？（多选）',
                'better_other' => '14. 其他信息必须填写',
                'service' => '15. 在网站使用过程中，您对本网站维护总体服务如何评价？'
            );
            if (mb_strpos($columns['better'], '其他') === false) {
                unset($required['better_other']);
            }
            foreach ($required as $key => $value) {
                if (strlen($columns[$key]) == 0) {
                    Unit::ajaxJson(1, $value);
                }
            }
            $columns['ip'] = Unit::getIp();
            $columns['userid'] = Unit::getLoggedUserId();
            $columns['created'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_survey_satisfaction_studio', $columns);
            if ($rt) {
                Unit::ajaxJson(0);
            } else {
                Unit::ajaxJson(1, '提交失败');
            }
        }
        $this->render('surveyStudio');
    }

    public function actionSurveyEntOpEnv() {
        $this->setPageTitle(Yii::app()->name . ' - “全国中小微企业经营环境”系列调查问卷');
        $userName = Yii::app()->getRequest()->getQuery('userName');
        $password = Yii::app()->getRequest()->getQuery('password');
        $allowed = false;
        if (!$userName || !$password) {
            Unit::jsVariable('needLogin', true);
        } else {
            $allowed = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_survey_ent_op_env_user')
                    ->where(array('and', 'UserName = :UserName', 'Password = :Password'), array(':UserName' => $userName, ':Password' => $password))
                    ->queryScalar();
            if (!$allowed) {
                Unit::jsVariable('needLogin', true);
            }
        }
        $options = SurveyEntOpEnv::model()->getOptions();
        $types = array('all' => array(), 'radio' => array(), 'checkbox' => array());
        foreach ($options as $key => $option) {
            $types['all'][] = $key;
            if ($option['type'] == 'radio') {
                $types['radio'][] = $key;
            } else if ($option['type'] == 'checkbox') {
                $types['checkbox'][] = $key;
            }
        }
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if (!$allowed) {
                Unit::ajaxJson(1, '拒绝访问');
            }
            $area = Yii::app()->getRequest()->getQuery('area', '');
            if (!$area) {
                Unit::ajaxJson(1, '提交失败');
            }
            $columns = array_flip($types['all']);
            $columns['industry_scale'] = '';
            $columns['industry_scale_unit'] = '';
            $allowedColumns = array_keys($columns);
            foreach ($allowedColumns as $allowColumn) {
                $columns[$allowColumn] = trim(Yii::app()->getRequest()->getPost($allowColumn, ''));
            }
            $required = array();
            foreach ($options as $key => $option) {
                if ($option['questionRequired']) {
                    $required[$key] = $option['question'];
                } else {
                    $required[$key] = false;
                }
                if ($option['questionRequired'] && $key == 'industry') {
                    $required['industry_scale'] = '1. 请选择企业规模？';
                }
            }
            foreach ($options as $key => $option) {
                if (!isset($option['answersJumps'])) {
                    continue;
                }
                foreach ($option['answersJumps'] as $answer => $jumpKeys) {
                    $jumpKeys = explode(',', $jumpKeys);
                    foreach ($jumpKeys as $jumpKey) {
                        if ($option['type'] == 'radio' && $columns[$key] == $answer) {
                            $required[$jumpKey] = false;
                            $columns[$jumpKey] = '';
                        } else if ($option['type'] == 'checkbox' && strpos($columns[$key], $answer) !== false) {
                            $required[$jumpKey] = false;
                            $columns[$jumpKey] = '';
                        }
                    }
                }
            }
            foreach ($options as $key => $option) {
                if (!isset($option['answersRequireds'])) {
                    continue;
                }
                foreach ($option['answersRequireds'] as $answer => $requiredKeys) {
                    $requiredKeys = explode(',', $requiredKeys);
                    foreach ($requiredKeys as $requiredKey) {
                        if ($option['type'] == 'radio' && $columns[$key] == $answer) {
                            $required[$requiredKey] = $options[$requiredKey]['question'];
                        } else if ($option['type'] == 'checkbox' && strpos($columns[$key], $answer) !== false) {
                            $required[$requiredKey] = $options[$requiredKey]['question'];
                        }
                    }
                }
            }
            if (Unit::getLoggedUserId() == '2177AC9A2CF4D185EDF96F13E62AFAA4' || Unit::getLoggedUserId() == '177728FFED6F62520F8D1D5D3F60D3E2') {
                $required['fault_depts_buies'] = false;
                $required['fault_depts_jobs'] = false;
                $required['policysupport_depts'] = false;
            }
            foreach ($required as $key => $value) {
                if ($value && strlen($columns[$key]) == 0) {
                    Unit::ajaxJson(1, $value);
                }
            }
            $onlyThreeAnswers = array(
                'punish_reason' => '31. 最多选三题，请在所选序号上划√',
                'punish_way' => '32. 最多选三题，请在所选序号上划√',
                'disturb_reason' => '34. 最多选三题，请在所选序号上划√',
                'disturb_solution' => '35. 最多选三题，请在所选序号上划√',
                'association_aspect' => '45. 最多选三题，请在所选序号上划√'
            );
            foreach ($onlyThreeAnswers as $key => $value) {
                if ($columns[$key]) {
                    $answers = explode('|', $columns[$key]);
                    if (count($answers) > 3) {
                        Unit::ajaxJson(1, $value);
                    }
                }
            }
            $columns['area'] = $area;
            $columns['ip'] = Unit::getIp();
            $columns['created'] = time();
            $rt = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->insert('t_survey_ent_op_env', $columns);
            if ($rt) {
                Unit::ajaxJson(0);
            } else {
                Unit::ajaxJson(1, '提交失败');
            }
        }
        Yii::app()->getClientScript()->reset();
        Yii::app()->getClientScript()->registerMetaTag('width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no', 'viewport');
        Unit::jsFile('js/jquery.js');
        Unit::jsFile(Yii::app()->getBaseUrl(true) . '/js/layer/layer.js');
        Unit::cssFile(Yii::app()->getBaseUrl(true) . '/css/bootstrap/css/bootstrap.min.css');
        Unit::jsFile(Yii::app()->getBaseUrl(true) . '/css/bootstrap/js/bootstrap.min.js');
        $type = Yii::app()->getRequest()->getQuery('type', 'index'); //index：首页、form：表单页、success：成功页
        $this->render('surveyEntOpEnv-' . $type, array(
            'options' => $options,
            'types' => $types
        ));
    }

}
