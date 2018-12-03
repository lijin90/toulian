<?php

/**
 * 软文
 * @author Changfeng Ji <jichf@qq.com>
 */
class SofttextController extends Controller {

    public function actionIndex() {
        $id = Yii::app()->getRequest()->getQuery('sstId', '');
        if (empty($id)) {
            throw new CHttpException(404);
        }
        $softtext = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('s.*')
                ->from('t_softtext s')
                ->where('s.ID = :ID', array(':ID' => $id))
                ->queryRow();
        if (!$softtext) {
            throw new CHttpException(404);
        }
        Yii::app()
                ->getDb()
                ->createCommand()
                ->update('t_softtext', array('ViewCount' => new CDbExpression('ViewCount + 1')), 'ID = :ID', array(':ID' => $id));
        $contents = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('c.*')
                ->from('t_softtext_content c')
                ->where('c.STID = :STID', array(':STID' => $softtext['ID']))
                ->order('c.CreateTime ASC')
                ->queryAll();
        $contentGroup = array();
        foreach ($contents as $content) {
            if (!isset($contentGroup[$content['Name']])) {
                $contentGroup[$content['Name']] = array();
            }
            $contentGroup[$content['Name']][] = $content;
        }
        $images = Yii::app()
                ->getDb()
                ->createCommand()
                ->select('i.*')
                ->from('t_softtext_image i')
                ->where('i.STID = :STID', array(':STID' => $softtext['ID']))
                ->order('i.CreateTime ASC')
                ->queryAll();
        $imageGroup = array();
        foreach ($images as $image) {
            if (!isset($imageGroup[$image['ImageName']])) {
                $imageGroup[$image['ImageName']] = array();
            }
            $imageGroup[$image['ImageName']][] = $image;
        }
        $this->setPageTitle(Yii::app()->name . ' - ' . $softtext['Title']);
        $view = 'index';
        if ($softtext['ShowTemplate']) {
            $view .= '-' . $softtext['ShowTemplate'];
        }
        $this->render($view, array(
            'softtext' => $softtext,
            'contents' => $contents,
            'contentGroup' => $contentGroup,
            'images' => $images,
            'imageGroup' => $imageGroup
        ));
    }

}
