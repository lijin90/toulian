<?php

/**
 * UserLoginForm class.
 * UserLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'UserController'.
 * @author Changfeng Ji <jichf@qq.com>
 */
class UserLoginForm extends CFormModel {

    public $username;
    public $password;
    public $verifyCode;
    public $geetest_challenge;
    public $geetest_validate;
    public $geetest_seccode;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required', 'message' => '{attribute}不能为空'),
            // 检查 verifyCode 验证码是否正确
            array('verifyCode', 'required', 'message' => '{attribute}不能为空', 'on' => 'verifyCode'),
            array('verifyCode', 'verifyCodeCheck', 'message' => '{attribute}不正确', 'on' => 'verifyCode'),
            // 检查 geetest 极验验证码是否正确
            array('geetest_challenge, geetest_validate, geetest_seccode', 'required', 'message' => '请先完成验证', 'on' => 'geetest'),
            array('geetest_challenge', 'geetestCheck', 'message' => '{attribute}不正确', 'on' => 'geetest'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => '登录账户',
            'password' => '登录密码',
            'verifyCode' => '验证码',
            'geetest_challenge' => '极验验证二次验证参数1',
            'geetest_validate' => '极验验证二次验证参数2',
            'geetest_seccode' => '极验验证二次验证参数3',
            'rememberMe' => '自动登录',
        );
    }

    /**
     * 检查 verifyCode 验证码是否正确
     * @param type $attribute
     * @param type $params
     */
    public function verifyCodeCheck($attribute, $params) {
        if (!empty($this->verifyCode)) {
            if (strtolower($this->verifyCode) != strtolower(Yii::app()->getSession()->get('verifyCode'))) {
                $label = $this->getAttributeLabel('verifyCode');
                $this->addError('verifyCode', $label . '错误');
            }
        }
    }

    /**
     * 检查 geetest 极验验证码是否正确
     * @param type $attribute
     * @param type $params
     */
    public function geetestCheck($attribute, $params) {
        if (empty($this->geetest_challenge) || empty($this->geetest_validate) || empty($this->geetest_seccode)) {
            return;
        }
        $GtSdk = new GeetestLib();
        $gtserver = Yii::app()->getSession()->get('geetest_gtserver');
        $user_id = Yii::app()->getSession()->get('geetest_user_id');
        if ($gtserver == 1) {
            $result = $GtSdk->success_validate($this->geetest_challenge, $this->geetest_validate, $this->geetest_seccode, $user_id);
            if (!$result) {
                $this->addError('geetest_challenge', '验证码错误');
            }
        } else {
            if (!$GtSdk->fail_validate($this->geetest_challenge, $this->geetest_validate, $this->geetest_seccode)) {
                $this->addError('geetest_challenge', '验证码错误');
            }
        }
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                $this->addError('password', '账户或密码错误');
            }
        }
    }

    /**
     * 检查登录账户是否已被锁定
     * @param type $attribute
     * @param type $params
     */
    public function isBlocked($userId) {
        $status = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('Status')
                ->from('t_user')
                ->where('ID = :ID', array(':ID' => $userId))
                ->queryScalar();
        if ($status == 1) {
            return false;
        }
        return true;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $userId = $this->_identity->getId();
            if ($this->isBlocked($userId)) {
                $this->addError('username', '账户已被锁定');
                return false;
            }
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

}
