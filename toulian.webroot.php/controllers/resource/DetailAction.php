<?php

/**
 * 详情页
 * @author Changfeng Ji <jichf@qq.com>
 */
class DetailAction extends CAction {

    public function run() {
        $id = Yii::app()->getRequest()->getQuery('resId', '');
        if (!$id) {
            $this->getController()->redirect(Yii::app()->createUrl('resource/supply'));
        }
        $params = array(
            'id' => $id,
            'status' => 1,
            'isSearched' => 1,
            'limit' => 1,
            'loadTradeStatuses' => true,
            'loadImages' => true,
            'loadInfo' => true
        );
        $data = Resource::model()->getResources('ALL', $params);
        if (!isset($data['datas'][0])) {
            $this->getController()->redirect(Yii::app()->createUrl('resource/supply'));
        }
        $data = $data['datas'][0];
        $recommends = $this->getRecommends($data);
        $data['User'] = User::getUser($data['UserID']);
        $data['Dept'] = Department::getDepart($data['User']['DeptID']);
        $user = User::getUser(Unit::getLoggedUserId());
        $dept = Department::getDepart(Unit::getLoggedDeptId());
        Unit::jsVariable('resource.ID', $data['ID']);
        Unit::jsVariable('resource.UserID', $data['UserID']);
        Unit::jsVariable('resource.ReleaseStatus', $data['ReleaseStatus']);
        Unit::jsVariable('resource.User', $data['User']);
        Unit::jsVariable('resource.Dept', $data['Dept']);
        if ($data['User']['UserCategory'] == 'individual') {
            $data['Owner'] = $data['User']['RealName'] ? $data['User']['RealName'] : $data['User']['UserName'];
        } else if ($data['Dept'] && $data['Dept']['DeptName']) {
            $data['Owner'] = $data['Dept']['DeptName'];
        } else {
            $data['Owner'] = $data['User']['Leader'] ? $data['User']['Leader'] : ($data['User']['EnterpriseName'] ? $data['User']['EnterpriseName'] : $data['User']['UserName']);
        }
        Unit::jsVariable('resource.Owner', $data['Owner']);
        Unit::jsVariable('user.deptName', $dept ? $dept['DeptName'] : '');
        if ($user['UserCategory'] == 'individual') {
            Unit::jsVariable('user.userName', $user['RealName'] ? $user['RealName'] : $user['UserName']);
        } else {
            Unit::jsVariable('user.userName', $user['Leader'] ? $user['Leader'] : ($user['EnterpriseName'] ? $user['EnterpriseName'] : $user['UserName']));
        }
        if (preg_match('/^1[3578][0-9]{9}$/', $user['Mobile']) && $user['Mobile'] == $user['MobileIsValid']) {
            Unit::jsVariable('user.mobileIsValid', true);
        } else {
            Unit::jsVariable('user.mobile', $user['Mobile'] ? $user['Mobile'] : '');
            Unit::jsVariable('user.mobileIsValid', false);
        }
        $showPhone = false;
        if (Unit::getLoggedUserId()) {
            $showPhone = $data['UserID'] == Unit::getLoggedUserId() ? true : $showPhone;
        }
        if (!$showPhone && Unit::getLoggedUserId() && $data['tradeStatuses']) {
            foreach ($data['tradeStatuses'] as $trade) {
                if ($trade['FounderID'] == Unit::getLoggedUserId() && in_array($trade['Status'], array(0, 1, 4, 8, 10, 11, 12))) {
                    $showPhone = true;
                    break;
                }
            }
        }
        $this->getController()->setPageTitle(Yii::app()->name . ' - 商用物业 - ' . $data['BaseName']);
        $view = '';
        if ($data['ResType'] == 'supply') {
            $view = 'detail-' . $data['ResCategory'];
        } else {
            $view = 'demand-detail';
            if (!DbOption::hasBusinessDemand(Unit::getLoggedRoleId()) && $data['UserID'] != Unit::getLoggedUserId() && Unit::getLoggedUserId() != DbOption::$User_Id_Admin) {
                throw new CHttpException(403);
            }
        }
        $xichengDeptIdes = array(
            '60111684_a523_438a_8b7d_2ca0b7d896c6', //北京市西城区产业发展促进局
            'T-va4o9uxBbjJOjh3ijCe-s_4gpZyUviLY9f', //北京市西城区白纸坊街道
            'MCMSwvf7DLMKI8y5RPnWW5iljFHRBSA8_4oW', //北京市西城区椿树街道
            'kCx_3mQKztwQQyGREq8BMZV_2J70xBTucsdL', //北京市西城区新街口街道
            'O9U5npNEBH4-icAKbXxePCuwA4VOnQwk8h8Z', //北京市西城区牛街街道
            'pg-7yNrB10IcwNXnMKYxGD7oEdHG2JYOHD37', //北京市西城区广安门外街道
            'JCA5ufP_1uGTxdW_-BGWhJwdIqXPUyx5T-SV', //北京市西城区金融街街道
            'Pr1oja1GHh9OFEsNVci70vAdan_TcOYiPgys', //北京市西城区广安门内街道
            'JFNXdLBi2RWci4fJnglVxLxf4VWzLCvaVUD-', //北京市西城区展览路街道
            'lIxOtgq4rZHFZBLeBf2mTUrbCVMqw3zPPxJG', //北京市西城区什刹海街道
            'srVPgh8sfrJcoTdNPzV_N0ll0G5eJs0gV5Vg', //北京市西城区陶然亭街道
            'FRsdoOWoAU_tqwi_zbGTfTCY0C3WohWDN2YK', //北京市西城区天桥街道
            'hzT2__KZBG180tYzAXNK3dNZqCswhz9XHKDJ', //北京市西城区大栅栏街道
            'ojJSzyC5EDNzwRNhOFDPS3RvloNNbAfADYTt', //北京市西城区德胜街道
            'GPqMfU9jL2HueI8LJBUAoD9D-s4JGIr2d3eN', //北京市西城区西长安街街道
            'aojBx0HmdSoSuS_0t0PAZeZlpO-xDRGICUuV', //北京市西城区月坛街道
        );
        if ($data['Dept'] && $data['ResCategory'] == 'officebuilding' && in_array($data['Dept']['ID'], $xichengDeptIdes)) {
            //西城区投资促进局-写字楼
            $view = 'detail-officebuilding-xicheng';
        }
        $this->getController()->render($view, array(
            'data' => $data,
            'showPhone' => $showPhone,
            'recommends' => isset($recommends['datas'][0]) ? $recommends['datas'] : array(),
            'user' => $user,
            'dept' => $dept
        ));
    }

    /**
     * 获取相关推荐资源
     * @param array $data 资源
     */
    private function getRecommends($data) {
        $param = array(
            'status' => 1,
            'isSearched' => 1,
            'releaseStatus' => 3,
            'limit' => 5,
            'loadImages' => true,
        );
        if ($data['ResType'] == 'supply') {
            $param['customWhere'] = array('and', 'r.ID != "' . $data['ID'] . '"');
            $recommend = Resource::model()->getResources($data['UserID'], $param);
        } else {
            $param['resCategory'] = $data['ResCategory'];
            $param['resType'] = 'supply';
            $param['areaCode'] = substr($data['AreaCode'], 0, 4);
            $recommend = Resource::model()->getResources('ALL', $param);
        }
        return $recommend;
    }

}
