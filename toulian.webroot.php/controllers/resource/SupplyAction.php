<?php

/**
 * 商用物业（供应）
 * @author Changfeng Ji <jichf@qq.com>
 */
class SupplyAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 商用物业');
        $this->getController()->breadcrumbs = array(
            array('name' => '首页', 'url' => Yii::app()->getHomeUrl()),
            array('name' => '商用物业')
        );
        $params = array(
            'resCategory' => Yii::app()->getRequest()->getQuery('resCategory', ''),
            'resType' => 'supply',
            'areaCode' => Yii::app()->getRequest()->getQuery('areaCode', Unit::getAreaCode()),
            'intentionName' => Yii::app()->getRequest()->getQuery('intentionName', ''),
            'status' => 1,
            'isSearched' => 1,
            'releaseStatus' => 3,
            'keyword' => Yii::app()->getRequest()->getQuery('keyword', ''),
            'rentPrice0' => Yii::app()->getRequest()->getQuery('rentPrice0', ''),
            'rentPrice1' => Yii::app()->getRequest()->getQuery('rentPrice1', ''),
            'salePrice0' => Yii::app()->getRequest()->getQuery('salePrice0', ''),
            'salePrice1' => Yii::app()->getRequest()->getQuery('salePrice1', ''),
            'area0' => Yii::app()->getRequest()->getQuery('area0', ''),
            'area1' => Yii::app()->getRequest()->getQuery('area1', ''),
            'updateTimeStart' => Yii::app()->getRequest()->getQuery('updateTimeStart', ''),
            'updateTimeEnd' => Yii::app()->getRequest()->getQuery('updateTimeEnd', ''),
            'limit' => 10,
            'loadImages' => true,
            'deptId' => Yii::app()->getRequest()->getQuery('deptId', '')
        );
        if ($params['intentionName'] == '') {
            $params['rentPrice0'] = '';
            $params['rentPrice1'] = '';
            $params['salePrice0'] = '';
            $params['salePrice1'] = '';
        } else if ($params['intentionName'] == '出租') {
            $params['salePrice0'] = '';
            $params['salePrice1'] = '';
        } else if ($params['intentionName'] == '出售') {
            $params['rentPrice0'] = '';
            $params['rentPrice1'] = '';
        }
        $customWhere = array();
        if ($params['keyword']) {
            /* $customWhere[] = array(
              'or',
              array('like', 'r.BaseName', '%' . Unit::escapeLike($params['keyword']) . '%'),
              array('like', 'r.Address', '%' . Unit::escapeLike($params['keyword']) . '%')
              ); */
            $customWhere[] = 'MATCH (r.BaseName,r.Address) AGAINST ("+' . Unit::escapeLike(strtr($params['keyword'], array('+' => '', '-' => '', ' ' => ' +'))) . '" IN BOOLEAN MODE)';
        }
        if ($params['rentPrice0'] && preg_match('/^\d+~\d+$/', $params['rentPrice0'])) {
            $arr = explode('~', $params['rentPrice0']);
            $customWhere[] = array(
                'and',
                'r.RentPrice >= ' . $arr[0],
                'r.RentPrice <= ' . $arr[1],
                'r.RentUnit = "元/m²/天"',
                'r.IsNegotiable = 0'
            );
        }
        if ($params['rentPrice1'] && preg_match('/^\d+~\d+$/', $params['rentPrice1'])) {
            $arr = explode('~', $params['rentPrice1']);
            $customWhere[] = array(
                'and',
                'r.RentPrice >= ' . $arr[0],
                'r.RentPrice <= ' . $arr[1],
                'r.RentUnit = "元/月"',
                'r.IsNegotiable = 0'
            );
        }
        if ($params['salePrice0'] && preg_match('/^\d+~\d+$/', $params['salePrice0'])) {
            $arr = explode('~', $params['salePrice0']);
            $customWhere[] = array(
                'and',
                'r.SalePrice >= ' . $arr[0],
                'r.SalePrice <= ' . $arr[1],
                'r.SaleUnit = "元/m²"',
                'r.IsNegotiable = 0'
            );
        }
        if ($params['salePrice1'] && preg_match('/^\d+~\d+$/', $params['salePrice1'])) {
            $arr = explode('~', $params['salePrice1']);
            $customWhere[] = array(
                'and',
                'r.SalePrice >= ' . $arr[0],
                'r.SalePrice <= ' . $arr[1],
                'r.SaleUnit = "万元"',
                'r.IsNegotiable = 0'
            );
        }
        if ($params['area0'] && preg_match('/^\d+~\d+$/', $params['area0'])) {
            $arr = explode('~', $params['area0']);
            $customWhere[] = array(
                'and',
                'r.Area >= ' . $arr[0],
                'r.Area <= ' . $arr[1],
                'r.AreaUnit = "平方米"'
            );
        }
        if ($params['area1'] && preg_match('/^\d+~\d+$/', $params['area1'])) {
            $arr = explode('~', $params['area1']);
            $customWhere[] = array(
                'and',
                'r.Area >= ' . $arr[0],
                'r.Area <= ' . $arr[1],
                'r.AreaUnit = "亩"'
            );
        }
        if ($params['updateTimeStart']) {
            $params['updateTimeStart'] = strtotime($params['updateTimeStart']);
        }
        if ($params['updateTimeEnd']) {
            $params['updateTimeEnd'] = strtotime($params['updateTimeEnd']);
        }
        if (count($customWhere) > 1) {
            array_unshift($customWhere, 'and');
            $params['customWhere'] = $customWhere;
        } else if ($customWhere) {
            $params['customWhere'] = $customWhere[0];
        }
        $userId = 'ALL';
        $department = null;
        if ($params['deptId']) {
            $department = Department::model()->getDepart($params['deptId']);
            $userIdes = Yii::app()
                    ->getDb()
                    ->createCommand()
                    ->select('ID')
                    ->from('t_user')
                    ->where('DeptID=:DeptID', array(':DeptID' => $params['deptId']))
                    ->queryColumn();
            $userId = $userIdes ? $userIdes : $userId;
            if ($department['DeptType'] == 'org' && $department['ID'] != '899a1eb9_6c0e_4155_a55b_8b85d7984beb') {
                $deptIdes = Yii::app()
                        ->getDb()
                        ->createCommand()
                        ->select('ChildID')
                        ->from('t_department_references')
                        ->where('ParentID=:ParentID', array(':ParentID' => $department['ID']))
                        ->queryColumn();
                if ($deptIdes) {
                    $subDeptIdes = Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select('ChildID')
                            ->from('t_department_references')
                            ->where(array('in', 'ParentID', $deptIdes))
                            ->queryColumn();
                    $deptIdes = $subDeptIdes ? array_merge($deptIdes, $subDeptIdes) : $deptIdes;
                }
                if ($deptIdes) {
                    $userIdes = Yii::app()
                            ->getDb()
                            ->createCommand()
                            ->select('ID')
                            ->from('t_user')
                            ->where(array('in', 'DeptID', $deptIdes))
                            ->queryColumn();
                    $userId = $userIdes ? array_merge($userId, $userIdes) : $userId;
                }
            }
        }
        $data = Resource::model()->getResources($userId, $params);
        if ($department) {
            $data['department'] = $department;
        }
        foreach ($data['datas'] as &$val) {
            $titles = explode(' ', $val['Title']);
            if (isset($titles[0])) {
                $titles[0] = '【' . $titles[0] . '】';
            }
            $val['Title'] = implode(' ', $titles);
        }
        $data['intentionNames'] = array('出租', '出售', '可租可售');
        $data['rentPrices'] = array(
            'rentPrice0' => array(//价格(出租，元/m²/天)
                array(
                    'id' => '0~3',
                    'name' => '0~3'
                ),
                array(
                    'id' => '3~5',
                    'name' => '3~5'
                ),
                array(
                    'id' => '5~10',
                    'name' => '5~10'
                ),
                array(
                    'id' => '10~100',
                    'name' => '10~100'
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1000'
                )
            ),
            'rentPrice1' => array(//价格(出租，元/月)
                array(
                    'id' => '0~100',
                    'name' => '0~100'
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1000'
                ),
                array(
                    'id' => '1000~10000',
                    'name' => '1000~1万',
                ),
                array(
                    'id' => '10000~100000',
                    'name' => '1万以上'
                )
            )
        );
        $data['salePrices'] = array(
            'salePrice0' => array(//价格(出售，元/m²)
                array(
                    'id' => '0~100',
                    'name' => '0~100'
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1000'
                ),
                array(
                    'id' => '1000~10000',
                    'name' => '1000~1万',
                ),
                array(
                    'id' => '10000~100000',
                    'name' => '1万~10万',
                ),
                array(
                    'id' => '100000~1000000',
                    'name' => '10万以上',
                )
            ),
            'salePrice1' => array(//价格(出售，万元)
                array(
                    'id' => '0~10',
                    'name' => '0~10',
                ),
                array(
                    'id' => '10~50',
                    'name' => '10~50',
                ),
                array(
                    'id' => '50~100',
                    'name' => '50~100'
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1000'
                ),
                array(
                    'id' => '1000~10000',
                    'name' => '1000以上'
                )
            )
        );
        $data['areas'] = array(
            'area0' => array(//面积(平方米)
                array(
                    'id' => '0~100',
                    'name' => '0~100'
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1000'
                ),
                array(
                    'id' => '1000~10000',
                    'name' => '1000~1万'
                ),
                array(
                    'id' => '10000~100000',
                    'name' => '1万~10万'
                ),
                array(
                    'id' => '100000~1000000',
                    'name' => '10万以上'
                )
            ),
            'area1' => array(//面积(亩)
                array(
                    'id' => '0~5',
                    'name' => '0~5'
                ),
                array(
                    'id' => '5~10',
                    'name' => '5~10'
                ),
                array(
                    'id' => '10~100',
                    'name' => '10~100',
                ),
                array(
                    'id' => '100~1000',
                    'name' => '100~1千',
                ),
                array(
                    'id' => '1000~10000',
                    'name' => '1千~1万'
                )
            )
        );
        $data['queries'] = array(
            'resCategory' => htmlspecialchars($params['resCategory']),
            'areaCode' => htmlspecialchars($params['areaCode']),
            'intentionName' => htmlspecialchars($params['intentionName']),
            'keyword' => htmlspecialchars($params['keyword']),
            'rentPrice0' => htmlspecialchars($params['rentPrice0']),
            'rentPrice1' => htmlspecialchars($params['rentPrice1']),
            'salePrice0' => htmlspecialchars($params['salePrice0']),
            'salePrice1' => htmlspecialchars($params['salePrice1']),
            'area0' => htmlspecialchars($params['area0']),
            'area1' => htmlspecialchars($params['area1']),
            'updateTimeStart' => $params['updateTimeStart'] ? date('Y-m-d H:i:s', $params['updateTimeStart']) : '',
            'updateTimeEnd' => $params['updateTimeEnd'] ? date('Y-m-d H:i:s', $params['updateTimeEnd']) : '',
            'deptId' => $params['deptId']
        );
        $args = $data['queries'];
        unset($args['keyword']);
        Unit::jsVariable('searchUrl', Yii::app()->getBaseUrl() . '/resource/supply?' . http_build_query($args));
        $views = array(
            '60111684_a523_438a_8b7d_2ca0b7d896c6' => 'supply-xicheng' //西城区投资促进局
        );
        $this->getController()->render(isset($views[$data['queries']['deptId']]) ? $views[$data['queries']['deptId']] : 'supply', $data);
    }

}
