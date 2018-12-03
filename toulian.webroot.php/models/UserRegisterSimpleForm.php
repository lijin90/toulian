<?php

/**
 * UserRegisterSimpleForm class.
 * UserRegisterSimpleForm is the data structure for keeping
 * user register form data. It is used by the 'register' action of 'UserController'.
 * @author Changfeng Ji <jichf@qq.com>
 */
class UserRegisterSimpleForm extends CFormModel {

    public $usercategory;
    public $enterpriseName;
    public $realName;
    public $mobile;
    public $smsCode;
    public $verifyCode;
    public $agree;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // 检查 usercategory 账户类型是否正确
            array('usercategory', 'usercategoryCheck'),
            // mobile, smsCode and verifyCode are required
            array('mobile, smsCode, verifyCode', 'required', 'message' => '{attribute}不能为空'),
            // 检查 mobile 手机号码是否正确
            array('mobile', 'mobileCheck'),
            // 检查 smsCode 手机验证码是否正确
            array('smsCode', 'smsCodeCheck'),
            // 检查 verifyCode 验证码是否正确
            array('verifyCode', 'verifyCodeCheck', 'message' => '{attribute}不正确'),
            // 必须同意注册协议
            array('agree', 'compare', 'compareValue' => 1, 'message' => '请勾选“我已阅读并同意《投联网用户注册协议》”')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'usercategory' => '账户类型',
            'enterpriseName' => '企业名称',
            'realName' => '个人姓名',
            'mobile' => '手机号码',
            'smsCode' => '手机验证码',
            'verifyCode' => '图片验证码',
            'agree' => '我已阅读并同意《投联网用户注册协议》'
        );
    }

    /**
     * 检查 usercategory 账户类型是否正确
     * @param type $attribute
     * @param type $params
     */
    public function usercategoryCheck($attribute, $params) {
        $label = $this->getAttributeLabel('usercategory');
        if ($this->usercategory != 'individual' && $this->usercategory != 'enterprise') {
            $this->addError('usercategory', $label . '错误');
        }
        if ($this->usercategory == 'individual' && empty($this->realName)) {
            $this->addError('realName', $this->getAttributeLabel('realName') . '不能为空');
        }
        if ($this->usercategory == 'enterprise' && empty($this->enterpriseName)) {
            $this->addError('enterpriseName', $this->getAttributeLabel('enterpriseName') . '不能为空');
        }
    }

    /**
     * 检查 mobile 手机号码是否正确
     * @param type $attribute
     * @param type $params
     */
    public function mobileCheck($attribute, $params) {
        if (empty($this->mobile)) {
            return;
        }
        $label = $this->getAttributeLabel('mobile');
        if (!preg_match('/^1[3578][0-9]{9}$/', $this->mobile)) {
            $this->addError('mobile', $label . '格式错误');
            return;
        }
        $exist = Yii::app()->getDb()
                ->createCommand()
                ->select('ID')
                ->from('t_user')
                ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $this->mobile, ':MobileIsValid' => $this->mobile))
                ->queryScalar();
        if ($exist) {
            $this->addError('mobile', $label . '已绑定其他账户');
        }
    }

    /**
     * 检查 smsCode 手机验证码是否正确
     * @param type $attribute
     * @param type $params
     */
    public function smsCodeCheck($attribute, $params) {
        $smsCode = Yii::app()->getSession()->get('smsCode' . $this->mobile);
        if (empty($smsCode)) {
            $this->addError('smsCode', '请先获取手机验证码');
        } else if ($this->smsCode != $smsCode) {
            $this->addError('smsCode', '手机验证码填写不正确');
        }
    }

    /**
     * 检查 verifyCode 图片验证码是否正确
     * @param type $attribute
     * @param type $params
     */
    public function verifyCodeCheck($attribute, $params) {
        if (!empty($this->verifyCode)) {
            if (strtolower($this->verifyCode) != strtolower(Yii::app()->getSession()->get('verifyCode'))) {
                $label = $this->getAttributeLabel('verifyCode');
                $this->addError('verifyCode', $label . '填写不正确');
            }
        }
    }

    /**
     * 创建用户
     * @return boolean
     */
    public function register() {
        $time = time();
        $userId = Unit::stringGuid();
        $userName = 'toulianwang_' . $this->mobile;
        $password = Unit::stringRandom(6);
        $columns = array(
            'ID' => $userId,
            'RoleID' => $this->usercategory == 'enterprise' ? DbOption::$Role_Id_MYTIP_Enterprise : DbOption::$Role_Id_MYTIP_Individual,
            'UserCategory' => $this->usercategory,
            'UserName' => $userName,
            'UserNameEditable' => 1,
            'Password' => Unit::securityEncrypt(md5($password)),
            'Email' => '',
            'EmailIsValid' => 0,
            'Mobile' => $this->mobile,
            'MobileIsValid' => $this->mobile,
            'AreaCode' => 0,
            'IsNeedValidate' => 0,
            'Status' => 1,
            'CreateTime' => $time,
            'UpdateTime' => $time
        );
        $connection = Yii::app()->getDb();
        $transaction = $connection->beginTransaction();
        try {
            $rt = $connection
                    ->createCommand()
                    ->insert('t_user', $columns);
            if (!$rt) {
                throw new Exception();
            }
            if ($this->usercategory == 'individual') {
                $rt = $connection
                        ->createCommand()
                        ->insert('t_user_individual', array(
                    'ID' => Unit::stringGuid(),
                    'UserID' => $userId,
                    'RealName' => $this->realName,
                    'Gender' => 0
                ));
                if (!$rt) {
                    throw new Exception();
                }
            } else if ($this->usercategory == 'enterprise') {
                $rt = $connection
                        ->createCommand()
                        ->insert('t_user_enterprise', array(
                    'ID' => Unit::stringGuid(),
                    'UserID' => $userId,
                    'EnterpriseName' => $this->enterpriseName,
                    'Leader' => ''
                ));
                if (!$rt) {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
            if (!SMSHelper::SendRegisteredNotice($this->mobile, $this->mobile, $password)) {
                throw new Exception();
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
        }
        return false;
    }

}
