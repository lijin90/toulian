<?php

/**
 * @author Changfeng Ji <jichf@qq.com>
 */
class SurveyForm extends CFormModel {

    public $Base_EnterpriseName;
    public $Base_EnterpriseAddress;
    public $Base_MainBusiness;
    public $Base_MainProduct;
    public $Base_Industry;
    public $Base_EnterpriseType;
    public $Base_EnterpriseScale;
    public $Develop_Industry;
    public $Develop_Asset;
    public $Develop_Address;
    public $Develop_Money;
    public $Develop_Corporation;
    public $Develop_Demand;
    public $Contact_Name;
    public $Contact_Mobile;
    public $Contact_Fax;
    public $Contact_Qq;
    public $Contact_Wechat;
    public $Contact_Mail;

    public function rules() {
        return array(
            // username and password are required
            array(
                'Base_EnterpriseName, Base_EnterpriseAddress, Base_MainProduct, Base_EnterpriseType, Base_EnterpriseScale',
                'required',
                'message' => '{attribute}不能为空',
                'on' => 'step1'
            ),
            array(
                'Develop_Industry, Develop_Asset, Develop_Address, Develop_Money',
                'required',
                'message' => '{attribute}不能为空',
                'on' => 'step2'
            ),
            array('Develop_Money', 'numerical', 'message' => '{attribute}必须是数值', 'on' => 'step2'),
            array(
                'Contact_Name, Contact_Mobile, Contact_Wechat, Contact_Mail',
                'required',
                'message' => '{attribute}不能为空',
                'on' => 'step3'
            ),
            array('Contact_Mobile', 'mobileCheck', 'on' => 'step3'),
            array('Contact_Mail', 'mailCheck', 'on' => 'step3'),
        );
    }

    public function mobileCheck($attribute, $params) {
        if (!empty($this->Contact_Mobile) && !preg_match('#^1[3578][0-9]{9}$#', $this->Contact_Mobile)) {
            $label = $this->getAttributeLabel('Contact_Mobile');
            $this->addError('Contact_Mobile', $label . '格式错误');
            return;
        }
    }

    public function mailCheck($attribute, $params) {
        if (!empty($this->Contact_Mail) && !preg_match('#^[\w\.]{1,20}@[\d\w]{1,20}\.[a-z]{2,3}(\.[a-z]{2,3})?$#i', $this->Contact_Mail)) {
            $label = $this->getAttributeLabel('Contact_Mail');
            $this->addError('Contact_Mail', $label . '格式错误');
            return;
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'Base_EnterpriseName' => '企业名称',
            'Base_EnterpriseAddress' => '企业地址',
            'Base_MainBusiness' => '主营业务',
            'Base_MainProduct' => '主要产品',
            'Base_Industry' => '所属行业',
            'Base_EnterpriseType' => '企业类型',
            'Base_EnterpriseScale' => '企业规模',
            'Develop_Industry' => '拟涉足行业',
            'Develop_Asset' => '已有资产',
            'Develop_Address' => '拟发展地点',
            'Develop_Money' => '拟出资金额',
            'Develop_Corporation' => '拟合作方式',
            'Develop_Demand' => '当前发展需求',
            'Contact_Name' => '联系人',
            'Contact_Mobile' => '手机',
            'Contact_Fax' => '传真',
            'Contact_Qq' => 'QQ',
            'Contact_Wechat' => '微信',
            'Contact_Mail' => 'E-mail',
        );
    }

}
