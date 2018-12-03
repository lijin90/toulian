<?php

/**
 * @author Changfeng Ji <jichf@qq.com>
 */
class UserController extends Controller {

    /**
     * 生成图片验证码
     */
    public function actionVerifyCode() {
        $ver = new ImageCode(80, 45, 4, 'images/captcha.gdf');
        Yii::app()->getSession()->add('verifyCode', $ver->getCode());
        $ver->outImg();
    }

    /**
     * 极验验证码 - 根据自己的私钥初始化验证
     */
    public function actionStartCaptchaServlet() {
        $GtSdk = new GeetestLib();
        $user_id = "test";
        $status = $GtSdk->pre_process($user_id);
        Yii::app()->getSession()->add('geetest_gtserver', $status);
        Yii::app()->getSession()->add('geetest_user_id', $user_id);
        echo $GtSdk->get_response_str();
    }

    /**
     * 注册
     */
    public function actionRegister() {
        $this->setPageTitle(Yii::app()->name . ' - 用户注册');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = new UserRegisterForm();
            //$model->setAttributes(array_map('trim', $_POST), false);
            $model->usercategory = trim(Yii::app()->getRequest()->getPost('usercategory'));
            $model->username = trim(Yii::app()->getRequest()->getPost('username'));
            $model->enterpriseName = trim(Yii::app()->getRequest()->getPost('enterpriseName'));
            $model->leader = trim(Yii::app()->getRequest()->getPost('leader'));
            $model->realName = trim(Yii::app()->getRequest()->getPost('realName'));
            $model->gender = trim(Yii::app()->getRequest()->getPost('gender'));
            $model->areaCode = trim(Yii::app()->getRequest()->getPost('areaCode'));
            $model->password = trim(Yii::app()->getRequest()->getPost('password'));
            $model->password2 = trim(Yii::app()->getRequest()->getPost('password2'));
            $model->mobile = trim(Yii::app()->getRequest()->getPost('mobile'));
            $model->smsCode = trim(Yii::app()->getRequest()->getPost('smsCode'));
            $model->verifyCode = trim(Yii::app()->getRequest()->getPost('verifyCode'));
            $model->agree = trim(Yii::app()->getRequest()->getPost('agree'));
            if ($model->validate() && $model->register()) {
                Yii::app()->getSession()->remove('smsCode' . $model->mobile);
                Yii::app()->getSession()->remove('smsCodeTime' . $model->mobile);
                Yii::app()->getSession()->remove('verifyCode');
                Unit::ajaxJson(0, '注册成功');
            } else {
                $info = '注册失败，请重试！';
                if ($errors = $model->getErrors()) {
                    $error = array_shift($errors);
                    $info = isset($error[0]) ? $error[0] : $info;
                }
                Unit::ajaxJson(1, $info, $errors);
            }
        }
        $this->render('register-mixed');
    }

    /**
     * 注册成功
     */
    public function actionRegisterSuccess() {
        $this->setPageTitle(Yii::app()->name . ' - 注册成功');
        $this->render('registerSuccess');
    }

    /**
     * 注册 - 简单注册（AJAX）
     */
    public function actionRegisterSimple() {
        $model = new UserRegisterSimpleForm();
        //$model->setAttributes(array_map('trim', $_POST), false);
        $model->usercategory = trim(Yii::app()->getRequest()->getPost('usercategory'));
        $model->enterpriseName = trim(Yii::app()->getRequest()->getPost('enterpriseName'));
        $model->realName = trim(Yii::app()->getRequest()->getPost('realName'));
        $model->mobile = trim(Yii::app()->getRequest()->getPost('mobile'));
        $model->smsCode = trim(Yii::app()->getRequest()->getPost('smsCode'));
        $model->verifyCode = trim(Yii::app()->getRequest()->getPost('verifyCode'));
        $model->agree = trim(Yii::app()->getRequest()->getPost('agree'));
        if ($model->validate() && $model->register()) {
            Yii::app()->getSession()->remove('smsCode' . $model->mobile);
            Yii::app()->getSession()->remove('smsCodeTime' . $model->mobile);
            Yii::app()->getSession()->remove('verifyCode');
            Unit::ajaxJson(0, '注册成功');
        } else {
            $info = '注册失败，请重试！';
            if ($errors = $model->getErrors()) {
                $error = array_shift($errors);
                $info = isset($error[0]) ? $error[0] : $info;
            }
            Unit::ajaxJson(1, $info, $errors);
        }
    }

    /**
     * 登录
     */
    public function actionLogin() {
        $this->setPageTitle(Yii::app()->name . ' - 用户登录');
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $scenario = Yii::app()->getRequest()->getPost('scenario');
            $model = new UserLoginForm($scenario == 'geetest' ? $scenario : 'verifyCode');
            //$model->setAttributes(array_map('trim', $_POST), false);
            $model->username = trim(Yii::app()->getRequest()->getPost('username'));
            $model->password = trim(Yii::app()->getRequest()->getPost('password'));
            if ($scenario == 'geetest') {
                $model->geetest_challenge = trim(Yii::app()->getRequest()->getPost('geetest_challenge'));
                $model->geetest_validate = trim(Yii::app()->getRequest()->getPost('geetest_validate'));
                $model->geetest_seccode = trim(Yii::app()->getRequest()->getPost('geetest_seccode'));
            } else {
                $model->verifyCode = trim(Yii::app()->getRequest()->getPost('verifyCode'));
            }
            $model->rememberMe = trim(Yii::app()->getRequest()->getPost('rememberMe'));
            if ($model->validate() && $model->login()) {
                Yii::app()->getSession()->remove('verifyCode');
                Yii::app()->getSession()->remove('geetest_gtserver');
                Yii::app()->getSession()->remove('geetest_user_id');
                $data = array();
                if (Yii::app()->getUser()->getReturnUrl(false)) {
                    $data['returnUrl'] = Yii::app()->getUser()->getReturnUrl();
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin) {
                    if (Unit::getLoggedUserId() != DbOption::$User_Id_Admin && Yii::app()->user->checkAccess('vocationIndex')) {
                        $data['returnUrl'] = Yii::app()->createUrl('admin/vocation/index');
                    } else {
                        $data['returnUrl'] = Yii::app()->createUrl('admin/site/index');
                    }
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Enterprise) {
                    $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Individual) {
                    $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
                } else {
                    $data['returnUrl'] = Yii::app()->getHomeUrl();
                }
                Unit::ajaxJson(0, '登录成功', $data);
            } else {
                $info = '账户或密码错误';
                if ($errors = $model->getErrors()) {
                    $error = array_shift($errors);
                    $info = isset($error[0]) ? $error[0] : $info;
                }
                Unit::ajaxJson(1, $info);
            }
        }
        if (Yii::app()->getRequest()->getParam('returnUrl')) {
            Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getParam('returnUrl'));
        }
        if (Yii::app()->getRequest()->getQuery('mode') == 'general') {
            $this->render('login-general'); //普通登录
        } else if (Yii::app()->getRequest()->getQuery('mode') == 'geetest') {
            $this->render('login-geetest'); //极验登录
        } else {
            $this->render('login-mixed'); //混合登录
        }
    }

    /**
     * 登录 - 手机号码登录（AJAX）
     */
    public function actionLoginMobileCode() {
        $mobile = trim(Yii::app()->getRequest()->getPost('mobile'));
        if (!$mobile) {
            Unit::ajaxJson(1, '手机号码不能为空');
        } else if (!preg_match('/^1[3578][0-9]{9}$/', $mobile)) {
            Unit::ajaxJson(1, '手机号码格式错误');
        }
        $user = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('*')
                ->from('t_user')
                ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $mobile, ':MobileIsValid' => $mobile))
                ->queryRow();
        if (!$user) {
            Unit::ajaxJson(1, '该手机号码未绑定任何账户');
        } else if ($user['Status'] != 1) {
            Unit::ajaxJson(1, '账户已被锁定');
        }
        $smsCode = trim(Yii::app()->getRequest()->getPost('smsCode'));
        $smsCodeSession = Yii::app()->getSession()->get('smsCode' . $mobile);
        if (empty($smsCode)) {
            Unit::ajaxJson(1, '验证码不能为空');
        } else if (empty($smsCodeSession)) {
            Unit::ajaxJson(1, '请先获取验证码');
        } else if ($smsCode != $smsCodeSession) {
            Unit::ajaxJson(1, '验证码填写不正确');
        }
        $rememberMe = trim(Yii::app()->getRequest()->getPost('rememberMe'));
        $duration = $rememberMe ? 3600 * 24 * 30 : 0; // 30 days
        $identity = new UserIdentity($user['UserName'], '');
        $identity->userid = $user['ID'];
        Yii::app()->user->login($identity, $duration);
        Yii::app()->getSession()->remove('smsCode' . $mobile);
        Yii::app()->getSession()->remove('smsCodeTime' . $mobile);
        $data = array();
        if (Yii::app()->getUser()->getReturnUrl(false)) {
            $data['returnUrl'] = Yii::app()->getUser()->getReturnUrl();
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin) {
            if (Unit::getLoggedUserId() != DbOption::$User_Id_Admin && Yii::app()->user->checkAccess('vocationIndex')) {
                $data['returnUrl'] = Yii::app()->createUrl('admin/vocation/index');
            } else {
                $data['returnUrl'] = Yii::app()->createUrl('admin/site/index');
            }
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Enterprise) {
            $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Individual) {
            $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
        } else {
            $data['returnUrl'] = Yii::app()->getHomeUrl();
        }
        Unit::ajaxJson(0, '登录成功', $data);
    }

    /**
     * 登录 - 微信扫描二维码登录（AJAX）
     */
    public function actionLoginWechatScan() {
        $guid = Yii::app()->getRequest()->getQuery('guid', '');
        if (!$guid) {
            throw new CHttpException(404);
        }
        $value = Yii::app()->cache->get('wechatUserLogin_' . $guid);
        if (!$value || !isset($value['userId']) || !isset($value['userName']) || !isset($value['progress'])) {
            Unit::ajaxJson(1, '请使用微信扫描二维码登录');
        } else {
            if ($value['progress'] == 'loginScanSuccess') {
                Unit::ajaxJson(2, '扫描成功，请在微信上点击确认');
            } else if ($value['progress'] == 'loginConfirmSuccess') {
                $duration = 3600 * 24 * 1; // 1 days
                $identity = new UserIdentity($value['userName'], '');
                $identity->userid = $value['userId'];
                Yii::app()->user->login($identity, $duration);
                $data = array();
                if (Yii::app()->getUser()->getReturnUrl(false)) {
                    $data['returnUrl'] = Yii::app()->getUser()->getReturnUrl();
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Admin) {
                    if (Unit::getLoggedUserId() != DbOption::$User_Id_Admin && Yii::app()->user->checkAccess('vocationIndex')) {
                        $data['returnUrl'] = Yii::app()->createUrl('admin/vocation/index');
                    } else {
                        $data['returnUrl'] = Yii::app()->createUrl('admin/site/index');
                    }
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Enterprise) {
                    $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
                } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Individual) {
                    $data['returnUrl'] = Yii::app()->createUrl('studio/site/index');
                } else {
                    $data['returnUrl'] = Yii::app()->getHomeUrl();
                }
                Unit::ajaxJson(0, '登录成功', $data);
            } else {
                Unit::ajaxJson(1, '请使用微信扫描二维码登录');
            }
        }
    }

    /**
     * 退出
     */
    public function actionLogout() {
        Yii::app()->getUser()->logout();
        $this->redirect(Yii::app()->getHomeUrl());
    }

    /**
     * 注册时，检查登录账户
     */
    public function actionRegisterCheckUserName() {
        $username = trim(Yii::app()->getRequest()->getPost('username'));
        if (!$username) {
            Unit::ajaxJson(1, '登录账户不能为空');
        }
        $strlen = mb_strlen($username, 'utf-8');
        if ($strlen < 6 || $strlen > 20) {
            Unit::ajaxJson(1, '登录账户长度为6-20个字符');
        } else if (!preg_match('/^[a-zA-Z]+\w+$/', $username)) {
            Unit::ajaxJson(1, '登录账户只能使用字母、数字、下划线，需以字母开头');
        } else {
            $exist = Yii::app()->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_user')
                    ->where('UserName = :UserName', array(':UserName' => $username))
                    ->queryScalar();
            if ($exist) {
                Unit::ajaxJson(1, '登录账户已存在');
            }
        }
        Unit::ajaxJson(0, '可以注册');
    }

    /**
     * 注册时，检查手机号码
     */
    public function actionRegisterCheckMobile() {
        $mobile = trim(Yii::app()->getRequest()->getPost('mobile'));
        if (!$mobile) {
            Unit::ajaxJson(1, '手机号码不能为空');
        }
        if (!preg_match('/^1[3578][0-9]{9}$/', $mobile)) {
            Unit::ajaxJson(1, '手机号码格式错误');
        }
        $exist = Yii::app()->getDb()
                ->createCommand()
                ->select('ID')
                ->from('t_user')
                ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $mobile, ':MobileIsValid' => $mobile))
                ->queryScalar();
        if ($exist) {
            Unit::ajaxJson(1, '手机号码已绑定其他账户');
        }
        Unit::ajaxJson(0, '');
    }

    /**
     * 注册时，检查手机验证码
     */
    public function actionRegisterCheckSmsCode() {
        $mobile = trim(Yii::app()->getRequest()->getPost('mobile'));
        if (!$mobile) {
            Unit::ajaxJson(1, '', array('mobile' => '手机号码不能为空'));
        }
        if (!preg_match('/^1[3578][0-9]{9}$/', $mobile)) {
            Unit::ajaxJson(1, '', array('mobile' => '手机号码格式错误'));
        }
        $exist = Yii::app()->getDb()
                ->createCommand()
                ->select('ID')
                ->from('t_user')
                ->where(array('and', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $mobile, ':MobileIsValid' => $mobile))
                ->queryScalar();
        if ($exist) {
            Unit::ajaxJson(1, '', array('mobile' => '手机号码已绑定其他账户'));
        }
        $smsCode = trim(Yii::app()->getRequest()->getPost('smsCode'));
        $smsCodeSession = Yii::app()->getSession()->get('smsCode' . $mobile);
        if (empty($smsCode)) {
            Unit::ajaxJson(1, '', array('smsCode' => '手机验证码不能为空'));
        } else if (empty($smsCodeSession)) {
            Unit::ajaxJson(1, '', array('smsCode' => '请先获取手机验证码'));
        } else if ($smsCode != $smsCodeSession) {
            Unit::ajaxJson(1, '', array('smsCode' => '手机验证码填写不正确'));
        }
        Unit::ajaxJson(0, '', array());
    }

    /**
     * 注册时，检查图片验证码
     */
    public function actionRegisterCheckVerifyCode() {
        $verifyCode = trim(Yii::app()->getRequest()->getPost('verifyCode'));
        if (!$verifyCode) {
            Unit::ajaxJson(1, '图片验证码不能为空');
        }
        if (strtolower($verifyCode) != strtolower(Yii::app()->getSession()->get('verifyCode'))) {
            Unit::ajaxJson(1, '图片验证码填写不正确');
        }
        Unit::ajaxJson(0, '');
    }

    /**
     * 重置密码
     */
    public function actionResetpassword() {
        $this->setPageTitle(Yii::app()->name . ' - 重置密码');
        $step = Yii::app()->getRequest()->getQuery('step', 'forget');
        switch ($step) {
            case 'forget': //忘记密码（确认账号）
                Unit::jsVariable('resetPass.submitUrl', $this->createUrl('user/resetpassword', array('step' => 'forget_submit')));
                Unit::jsVariable('resetPass.nextUrl', $this->createUrl('user/resetpassword', array('step' => 'verify')));
                $this->render('password_forget');
                break;
            case 'forget_submit': //忘记密码-提交
                $username = Yii::app()->getRequest()->getPost('username');
                $verifyCode = Yii::app()->getRequest()->getPost('verifyCode');
                if (!$username) {
                    Unit::ajaxJson(1, '登录账户不能为空');
                } else if (!$verifyCode) {
                    Unit::ajaxJson(1, '图片验证码不能为空');
                } else if (strtolower($verifyCode) != strtolower(Yii::app()->getSession()->get('verifyCode'))) {
                    Unit::ajaxJson(1, '图片验证码填写不正确');
                }
                $data = null;
                if (preg_match('/^1[3578][0-9]{9}$/', $username)) {
                    $data = Yii::app()->getDb()
                            ->createCommand()
                            ->select('ID, UserName, Mobile, MobileIsValid')
                            ->from('t_user')
                            ->where(array('and', 'Status = 1', 'Mobile = :Mobile', 'MobileIsValid = :MobileIsValid'), array(':Mobile' => $username, ':MobileIsValid' => $username))
                            ->queryRow();
                } else {
                    $data = Yii::app()->getDb()
                            ->createCommand()
                            ->select('ID, UserName, Mobile, MobileIsValid')
                            ->from('t_user')
                            ->where(array('and', 'Status = 1', 'UserName = :UserName'), array(':UserName' => $username))
                            ->queryRow();
                }
                if (!$data) {
                    Unit::ajaxJson(1, '账户不存在');
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    Unit::ajaxJson(1, '账户没有绑定手机');
                }
                Yii::app()->getSession()->remove('verifyCode');
                Yii::app()->getSession()->add('resetPassUserId' . date('Ymd'), $data['ID']);
                Unit::ajaxJson(0);
                break;
            case 'verify': //验证账户（安全认证）
                $userId = Yii::app()->getSession()->get('resetPassUserId' . date('Ymd'));
                if (!$userId) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                }
                $data = Yii::app()->getDb()
                        ->createCommand()
                        ->select('ID, UserName, Mobile, MobileIsValid')
                        ->from('t_user')
                        ->where(array('and', 'Status = 1', 'ID = :ID'), array(':ID' => $userId))
                        ->queryRow();
                if (!$data) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                }
                Unit::jsVariable('resetPass.smsCodeUrl', $this->createUrl('user/resetpassword', array('step' => 'verify_smscode')));
                Unit::jsVariable('resetPass.submitUrl', $this->createUrl('user/resetpassword', array('step' => 'verify_submit')));
                Unit::jsVariable('resetPass.nextUrl', $this->createUrl('user/resetpassword', array('step' => 'reset')));
                $this->render('password_verify', array('data' => $data));
                break;
            case 'verify_smscode': //验证账户-获取手机验证码
                $userId = Yii::app()->getSession()->get('resetPassUserId' . date('Ymd'));
                if (!$userId) {
                    Unit::ajaxJson(1, '账户不存在');
                }
                $data = Yii::app()->getDb()
                        ->createCommand()
                        ->select('ID, UserName, Mobile, MobileIsValid')
                        ->from('t_user')
                        ->where(array('and', 'Status = 1', 'ID = :ID'), array(':ID' => $userId))
                        ->queryRow();
                if (!$data) {
                    Unit::ajaxJson(1, '账户不存在');
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    Unit::ajaxJson(1, '账户没有绑定手机');
                }
                $mobile = $data['Mobile'];
                $time = time();
                $smsCodeTime = Yii::app()->getSession()->get('smsCodeTime' . $mobile);
                $smsCodeCount = Yii::app()->getSession()->get('smsCodeCount' . $mobile . date('Ymd', $time));
                if ($smsCodeTime && $smsCodeTime + 60 > $time) {
                    Unit::ajaxJson(1, '请求过于频繁，请稍后');
                } else if ($smsCodeCount && $smsCodeCount >= 6) {
                    Unit::ajaxJson(1, '验证码发送次数超过当日最大次数，请明天再试');
                }
                $smsCode = rand(100000, 999999);
                if (SMSHelper::SendVerificationCode($mobile, $smsCode)) {
                    Yii::app()->getSession()->add('smsCode' . $mobile, $smsCode);
                    Yii::app()->getSession()->add('smsCodeTime' . $mobile, $time);
                    Yii::app()->getSession()->add('smsCodeCount' . $mobile . date('Ymd', $time), is_numeric($smsCodeCount) ? $smsCodeCount + 1 : 1);
                    Unit::ajaxJson(0, '验证码已发送');
                } else {
                    Unit::ajaxJson(1, '发送失败，请重试');
                }
                break;
            case 'verify_submit': //验证账户-提交
                $userId = Yii::app()->getSession()->get('resetPassUserId' . date('Ymd'));
                if (!$userId) {
                    Unit::ajaxJson(1, '账户不存在');
                }
                $data = Yii::app()->getDb()
                        ->createCommand()
                        ->select('ID, UserName, Mobile, MobileIsValid')
                        ->from('t_user')
                        ->where(array('and', 'Status = 1', 'ID = :ID'), array(':ID' => $userId))
                        ->queryRow();
                if (!$data) {
                    Unit::ajaxJson(1, '账户不存在');
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    Unit::ajaxJson(1, '账户没有绑定手机');
                }
                $mobile = $data['Mobile'];
                $smsCode = trim(Yii::app()->getRequest()->getPost('smsCode'));
                $smsCodeSession = Yii::app()->getSession()->get('smsCode' . $mobile);
                if (empty($smsCode)) {
                    Unit::ajaxJson(1, '手机验证码不能为空', array('smsCode' => '手机验证码不能为空'));
                } else if (empty($smsCodeSession)) {
                    Unit::ajaxJson(1, '请先获取手机验证码', array('smsCode' => '请先获取手机验证码'));
                } else if ($smsCode != $smsCodeSession) {
                    Unit::ajaxJson(1, '手机验证码填写不正确', array('smsCode' => '手机验证码填写不正确'));
                }
                Yii::app()->getSession()->remove('smsCode' . $mobile);
                Yii::app()->getSession()->remove('smsCodeTime' . $mobile);
                Yii::app()->getSession()->add('resetPassVerify' . date('Ymd'), $data['ID']);
                Unit::ajaxJson(0);
                break;
            case 'reset': //重置密码
                $userId = Yii::app()->getSession()->get('resetPassUserId' . date('Ymd'));
                if (!$userId) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                }
                $verify = Yii::app()->getSession()->get('resetPassVerify' . date('Ymd'));
                if (!$verify || $userId != $verify) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'verify')));
                }
                $data = Yii::app()->getDb()
                        ->createCommand()
                        ->select('ID, UserName, Mobile, MobileIsValid')
                        ->from('t_user')
                        ->where(array('and', 'Status = 1', 'ID = :ID'), array(':ID' => $userId))
                        ->queryRow();
                if (!$data) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'forget')));
                }
                Unit::jsVariable('resetPass.submitUrl', $this->createUrl('user/resetpassword', array('step' => 'reset_submit')));
                Unit::jsVariable('resetPass.nextUrl', $this->createUrl('user/resetpassword', array('step' => 'success')));
                $this->render('password_reset');
                break;
            case 'reset_submit': //重置密码-提交
                $userId = Yii::app()->getSession()->get('resetPassUserId' . date('Ymd'));
                if (!$userId) {
                    Unit::ajaxJson(1, '账户不存在');
                }
                $verify = Yii::app()->getSession()->get('resetPassVerify' . date('Ymd'));
                if (!$verify || $userId != $verify) {
                    Unit::ajaxJson(1, '账户未认证');
                }
                $data = Yii::app()->getDb()
                        ->createCommand()
                        ->select('ID, UserName, Mobile, MobileIsValid')
                        ->from('t_user')
                        ->where(array('and', 'Status = 1', 'ID = :ID'), array(':ID' => $userId))
                        ->queryRow();
                if (!$data) {
                    Unit::ajaxJson(1, '账户不存在');
                } else if (!preg_match('/^1[3578][0-9]{9}$/', $data['Mobile']) || $data['Mobile'] != $data['MobileIsValid']) {
                    Unit::ajaxJson(1, '账户没有绑定手机');
                }
                $password = trim(Yii::app()->getRequest()->getPost('password'));
                $password2 = trim(Yii::app()->getRequest()->getPost('password2'));
                $strlen = strlen($password);
                if ($strlen == 0) {
                    Unit::ajaxJson(1, '新密码不能为空');
                } else if ($strlen < 6 || $strlen > 20) {
                    Unit::ajaxJson(1, '新密码长度为6-20个字符');
                } else if (strpos($password, ' ')) {
                    Unit::ajaxJson(1, '新密码不能包含空格');
                } else if ($password !== $password2) {
                    Unit::ajaxJson(1, '两次密码不一致');
                }
                $result = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->update('t_user', array('Password' => Unit::securityEncrypt(md5($password))), 'ID = :ID', array(':ID' => $data['ID']));
                if ($result !== false) {
                    Yii::app()->getSession()->remove('resetPassUserId' . date('Ymd'));
                    Yii::app()->getSession()->remove('resetPassVerify' . date('Ymd'));
                    Yii::app()->getSession()->add('resetPassSuccess' . date('Ymd'), $data['ID']);
                    Unit::ajaxJson(0, '重置密码成功');
                } else {
                    Unit::ajaxJson(1, '重置密码失败');
                }
                break;
            case 'success': //成功
                $userId = Yii::app()->getSession()->get('resetPassSuccess' . date('Ymd'));
                if (!$userId) {
                    $this->redirect($this->createUrl('user/resetpassword', array('step' => 'reset')));
                }
                Yii::app()->getSession()->remove('resetPassSuccess' . date('Ymd'));
                $this->render('password_success');
                break;
            default:
                $this->redirect(Yii::app()->getHomeUrl());
                break;
        }
    }

    /**
     * 登录招商小秘书测试账户
     */
    public function actionLoginMytipTest() {
        if (Unit::getLoggedRoleId() == DbOption::$Role_Id_Enterprise) {
            $this->redirect(Yii::app()->createUrl('studio/site/index'));
        } else if (Unit::getLoggedRoleId() == DbOption::$Role_Id_MYTIP_Individual) {
            $this->redirect(Yii::app()->createUrl('studio/site/index'));
        } else if (!Yii::app()->getUser()->getIsGuest()) {
            $this->redirect(Yii::app()->getHomeUrl());
        }
        $time = time();
        $userId = Unit::stringGuid();
        $userName = 'mytip_test_' . date('YmdHis', $time) . '_' . rand(10000, 99999);
        $password = '123456';
        $columns = array(
            'ID' => $userId,
            'RoleID' => DbOption::$Role_Id_MYTIP_Individual,
            'UserCategory' => 'individual',
            'UserName' => $userName,
            'UserNameEditable' => 1,
            'Password' => Unit::securityEncrypt(md5($password)),
            'Email' => '',
            'EmailIsValid' => 0,
            'Mobile' => '',
            'MobileIsValid' => '',
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
            $rt = $connection
                    ->createCommand()
                    ->insert('t_user_individual', array(
                'ID' => Unit::stringGuid(),
                'UserID' => $userId,
                'RealName' => '测测',
                'Gender' => 0
            ));
            if (!$rt) {
                throw new Exception();
            }
            $transaction->commit();
            $duration = 3600 * 24 * 30; // 30 days
            $identity = new UserIdentity($userName, $password);
            $identity->userid = $userId;
            Yii::app()->user->login($identity, $duration);
            $this->redirect(Yii::app()->createUrl('studio/site/index'));
        } catch (Exception $e) {
            $transaction->rollback();
            $this->redirect(Yii::app()->getHomeUrl());
        }
    }

}
