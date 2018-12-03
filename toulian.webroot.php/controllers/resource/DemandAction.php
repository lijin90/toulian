<?php

/**
 * 企业选址（需求）
 * @author Changfeng Ji <jichf@qq.com>
 */
class DemandAction extends CAction {

    public function run() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 企业选址');
        $this->getController()->render('demand');
    }

    public function run_old() {
        $this->getController()->setPageTitle(Yii::app()->name . ' - 企业选址');
        $params = array(
            'resCategory' => Yii::app()->getRequest()->getQuery('resCategory', ''),
            'resType' => 'demand',
            'areaCode' => Yii::app()->getRequest()->getQuery('areaCode', '110000'),
            'intentionName' => Yii::app()->getRequest()->getQuery('intentionName', ''),
            'status' => 1,
            'isSearched' => 1,
            'releaseStatus' => 3,
            'keyword' => Yii::app()->getRequest()->getQuery('keyword', ''),
            'limit' => 10
        );
        if ($params['keyword']) {
            $params['customWhere'] = array(
                'or',
                array('like', 'r.BaseName', '%' . Unit::escapeLike($params['keyword']) . '%'),
                array('like', 'r.Address', '%' . Unit::escapeLike($params['keyword']) . '%')
            );
        }
        $data = Resource::model()->getResources('ALL', $params);
        foreach ($data['datas'] as &$val) {
            $titles = explode(' ', $val['Title']);
            if (isset($titles[0])) {
                $titles[0] = '【' . $titles[0] . '】';
            }
            $val['Title'] = implode(' ', $titles);
        }
        $data['intentionNames'] = array('求租', '求购', '可租可购');
        $data['queries'] = array(
            'resCategory' => $params['resCategory'],
            'areaCode' => $params['areaCode'],
            'intentionName' => $params['intentionName'],
            'keyword' => htmlspecialchars($params['keyword'])
        );
        $args = $data['queries'];
        unset($args['keyword']);
        Unit::jsVariable('searchUrl', Yii::app()->getBaseUrl() . '/resource/demand?' . http_build_query($args));
        $this->getController()->render('demand-old', $data);
    }

}
