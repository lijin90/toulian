<?php

/**
 * 北京市投资促进局企业情况登记表
 * @author Changfeng Ji <jichf@qq.com>
 */
class SurveyController extends Controller {
    
    private $steps = array(1, 2, 3);
    private $last = 3;

    /**
     * @author Changfeng Ji <jichf@qq.com>
     */
    public function actionIndex() {
        $validate = Yii::app()->getRequest()->getParam('validate', '');
        if(in_array($validate, $this->steps)){
            return $this->surveyValidate($validate);
        }
        $step = Yii::app()->getRequest()->getParam('step', 1);
        if(!in_array($step, $this->steps)){
            throw new CHttpException(404);
        }
        $sf = new SurveyForm('step' . $step);
        $sf->setAttributes(Yii::app()->getSession()->get('surveyCache'), false);
        $this->renderPartial('index-step-' . $step, array('sf' => $sf, 'data' => $sf->getAttributes(), 'errors' => $sf->getErrors()));
    }
    
    public function actionSuccess() {
        $this->renderPartial('success');
    }
    
    private function surveyValidate($step){
        $sf = new SurveyForm('step' . $step);
        //$sf->setAttributes(Yii::app()->getSession()->get('surveyCache'), false);
        $sf->setAttributes($_REQUEST, false);
        if($sf->validate()){
            $this->surveyCache($sf->getAttributes());
            if($step == $this->last){
                if($this->surveySave()){
                    //保存成功
                    Yii::app()->getSession()->remove('surveyCache');
                    $this->redirect(Yii::app()->createUrl('survey/success'));
                }else{
                    //保存失败
                    $this->redirect(Yii::app()->createUrl('survey/index', array('step' => 1)));
                }
            }else{
                $this->redirect(Yii::app()->createUrl('survey/index', array('step' => ++$step)));
            }
        }else{
            $this->renderPartial('index-step-' . $step, array('sf' => $sf, 'data' => $sf->getAttributes(), 'errors' => $sf->getErrors()));
        }
    }
    
    private function surveyCache($data){
        $value = Yii::app()->getSession()->get('surveyCache');
        if($value){
            foreach($value as $k => $v){
                if(isset($data[$k]) && !empty($data[$k])){
                    $value[$k] = $data[$k];
                }
            }
        }else{
            $value = $data;
        }
        Yii::app()->getSession()->add('surveyCache', $value);
    }
    
    private function surveySave(){
        $value = Yii::app()->getSession()->get('surveyCache');
        if(!$value){
            return false;
        }
        foreach($value as $k => $v){
            if(is_array($v)){
                $value[$k] = implode('|', $v);
            }
        }
        return (boolean)(Yii::app()->getDb()->createCommand()->insert('t_survey', $value));
    }
    
    public function surveyValues($key){
        $values = array(
            'Base_Industry' => array(
                '农、林、牧、渔业', '采矿业', '制造业', '建筑业', '电力、燃气及水的生产和供应业',
                '教育', '卫生', '批发和零售业', '住宿和餐饮业', '房地产业',
                '信息传输、计算机服务和软件业', '文化、体育和娱乐业', '租赁和商务服务业', '交通运输、仓储和邮政业', '科学研究、技术服务和地质勘查业',
                '金融业', '水利、环境和公共设施管理业', '居民服务和其他服务业'
            ),
            'Base_EnterpriseType' => array(
                '国有企业', '国有控股企业', '国有参股企业', '外商投资企业', '其他企业'
                
            ),
            'Base_EnterpriseScale' => array(
                '大', '中', '小', '微'
            ),
            'Develop_Industry' => array(
                '农、林、牧、渔业', '采矿业', '制造业', '建筑业', '电力、燃气及水的生产和供应业',
                '教育', '卫生', '批发和零售业', '住宿和餐饮业', '房地产业',
                '信息传输、计算机服务和软件业', '文化、体育和娱乐业', '租赁和商务服务业', '交通运输、仓储和邮政业', '科学研究、技术服务和地质勘查业',
                '金融业', '水利、环境和公共设施管理业', '居民服务和其他服务业'
            ),
            'Develop_Asset' => array(
                '土地', '厂房', '商务楼宇', '商用物业', '技术专利',
                '高端人才'
            ),
            'Develop_Address' => array(
                '北京', '京外', '国外'
            ),
            'Develop_Corporation' => array(
                '投资合作', '合资公司', '股份转让', '合作开发', '资源合作',
                '代销产品'
            ),
            'Develop_Demand' => array(
                '政策支持', '土地', '厂房', '商务楼宇', '商用物业',
                '技术专利', '高端人才', '政策咨询', '企业注册', '财税服务',
                '法律服务', '融资服务', '猎头服务'
            )
        );
        return isset($values[$key]) ? $values[$key] : array();
    }

}
