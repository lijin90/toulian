<?php

/**
 * This is the model class for table "t_survey_satisfaction_new".
 *
 * The followings are the available columns in table 't_survey_satisfaction_new':
 * @property integer $id
 * @property string $wechatOpenId
 * @property string $serviceObject
 * @property string $attention
 * @property string $register
 * @property string $first_three
 * @property string $first_four
 * @property string $first_five
 * @property string $first_six
 * @property string $first_seven
 * @property string $first_enght
 * @property string $first_nine
 * @property string $first_ten
 * @property string $second_three
 * @property string $second_four
 * @property string $second_five
 * @property string $second_six
 * @property string $second_seven
 * @property string $second_enght
 * @property string $second_nine
 * @property string $second_ten
 * @property string $third_three
 * @property string $third_four
 * @property string $third_five
 * @property string $third_six
 * @property string $third_seven
 * @property string $third_enght
 * @property string $third_nine
 * @property string $third_ten
 * @property string $fourth_three
 * @property string $fourth_four
 * @property string $fourth_five
 * @property string $fourth_six
 * @property string $fourth_seven
 * @property string $fourth_enght
 * @property string $fourth_nine
 * @property string $fourth_ten
 * @property integer $status
 * @property string $userId
 * @property string $comment
 * @property string $ip
 * @property integer $created
 *
 * The followings are the available model relations:
 * @property TSurveySatisfactionNewRe[] $tSurveySatisfactionNewRes
 */
class SurveySatisfactionNew extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_survey_satisfaction_new';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, created', 'numerical', 'integerOnly' => true),
            array('wechatOpenId, serviceObject, attention, register, first_three, first_four, first_five, first_six, first_seven, first_enght, second_three, second_four, second_five, second_six, second_seven, second_enght, third_three, third_four, third_five, third_six, third_seven, third_enght, fourth_three, fourth_four, fourth_five, fourth_six, fourth_seven, fourth_enght, comment', 'length', 'max' => 255),
            array('userId', 'length', 'max' => 36),
            array('ip', 'length', 'max' => 50),
            array('first_nine, first_ten, second_nine, second_ten, third_nine, third_ten, fourth_nine, fourth_ten', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, wechatOpenId, serviceObject, attention, register, first_three, first_four, first_five, first_six, first_seven, first_enght, first_nine, first_ten, second_three, second_four, second_five, second_six, second_seven, second_enght, second_nine, second_ten, third_three, third_four, third_five, third_six, third_seven, third_enght, third_nine, third_ten, fourth_three, fourth_four, fourth_five, fourth_six, fourth_seven, fourth_enght, fourth_nine, fourth_ten, status, userId, comment, ip, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tSurveySatisfactionNewRes' => array(self::HAS_MANY, 'TSurveySatisfactionNewRe', 'SurveyID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'wechatOpenId' => '微信OpenId',
            'serviceObject' => '您属于哪种类型的投联网服务对象？',
            'attention' => '1. 您是否关注或浏览投联网？',
            'register' => '2. 您是否愿意注册成为本网站的用户？',
            'first_three' => '3. 您对投联网举办的招商引资推介活动整体满意度如何？',
            'first_four' => '4. 您参加投联网举办的招商引资推介活动，是否收费？',
            'first_five' => '5. 您认为投联网举办的招商引资推介活动对于公司市场业务发展的实际指导意义如何？',
            'first_six' => '6. 会议议程的安排（包括内容、顺序、时间），您是否满意？',
            'first_seven' => '7. 会议会务人员的服务质量和服务态度，您是否满意？',
            'first_enght' => '8. 您愿意经常参加投联网举办的招商引资推介活动吗？',
            'first_nine' => '9. 参加会议，您认为最有收获的会议内容是哪些？请举例说明。',
            'first_ten' => '10. 请针对会议各方面情况，提出您的宝贵意见。',
            'second_three' => '3. 您对投联网提供的投资北京促落地服务整体满意度如何？',
            'second_four' => '4. 投联网给您提供的投资北京促落地服务，是否收费？',
            'second_five' => '5. 您认为投联网提供的服务，对于你投资北京注册公司是否有帮助？',
            'second_six' => '6. 您认为投联网提供的服务，对于你了解北京投资环境、政策咨询等信息是否有帮助？',
            'second_seven' => '7. 投联网工作人员的服务质量和服务态度，您是否满意？',
            'second_enght' => '8. 如您后续还有投资北京意向，是否愿意投联网继续为您提供促落地服务？',
            'second_nine' => '9. 如您身边的朋友或投资人有投资北京意向，您是否愿意推荐投联网为其提供促落地服务？',
            'second_ten' => '10. 请针对投联网提供的投资北京促落地服务情况，提出您的宝贵意见。',
            'third_three' => '3. 您在投联网发布的是哪一类的投资北京项目信息？',
            'third_four' => '4. 您在投联网发布投资北京项目信息，是否收费？',
            'third_five' => '5. 您认为在投联网发布投资北京项目信息操作便捷吗？',
            'third_six' => '6. 您在投联网发布投资北京项目信息反馈效果明显吗？',
            'third_seven' => '7. 针对您发布的投资北京项目信息，投联网会定期定向推送给企业客户，您是否知晓？',
            'third_enght' => '8. 您发布的投资北京项目信息，您是否愿意投联网进行定向推送给企业客户？',
            'third_nine' => '9. 投联网将您发布的投资北京项目信息定向推送给企业客户，是否收费？',
            'third_ten' => '10. 请针对在投联网发布的投资北京项目信息情况，提出您的宝贵意见。',
            'fourth_three' => '3. 您经常在投联网发布写字楼租售信息吗？频次多少？',
            'fourth_four' => '4. 您在投联网发布写字楼租售信息，是否收费？',
            'fourth_five' => '5. 您认为在投联网发布写字楼租售信息操作便捷吗？',
            'fourth_six' => '6. 您在投联网发布写字楼租售信息反馈效果明显吗？',
            'fourth_seven' => '7. 针对您发布的写字楼租售信息，投联网会定期定向推送给企业客户，您是否知晓？',
            'fourth_enght' => '8. 您发布的写字楼租售信息，您是否愿意投联网进行定向推送给企业客户？',
            'fourth_nine' => '9. 投联网将您发布的写字楼租售信息定向推送给企业客户，是否收费？',
            'fourth_ten' => '10. 请针对在投联网发布的写字楼租售信息情况，提出您的宝贵意见。',
            'status' => '审核状态，包括：1:审核中、2:审核未通过、3:审核通过',
            'userId' => '更改审核状态的用户ID',
            'comment' => '备注，填写拒绝理由',
            'ip' => 'IP地址',
            'created' => '创建时间',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('wechatOpenId', $this->wechatOpenId, true);
        $criteria->compare('serviceObject', $this->serviceObject, true);
        $criteria->compare('attention', $this->attention, true);
        $criteria->compare('register', $this->register, true);
        $criteria->compare('first_three', $this->first_three, true);
        $criteria->compare('first_four', $this->first_four, true);
        $criteria->compare('first_five', $this->first_five, true);
        $criteria->compare('first_six', $this->first_six, true);
        $criteria->compare('first_seven', $this->first_seven, true);
        $criteria->compare('first_enght', $this->first_enght, true);
        $criteria->compare('first_nine', $this->first_nine, true);
        $criteria->compare('first_ten', $this->first_ten, true);
        $criteria->compare('second_three', $this->second_three, true);
        $criteria->compare('second_four', $this->second_four, true);
        $criteria->compare('second_five', $this->second_five, true);
        $criteria->compare('second_six', $this->second_six, true);
        $criteria->compare('second_seven', $this->second_seven, true);
        $criteria->compare('second_enght', $this->second_enght, true);
        $criteria->compare('second_nine', $this->second_nine, true);
        $criteria->compare('second_ten', $this->second_ten, true);
        $criteria->compare('third_three', $this->third_three, true);
        $criteria->compare('third_four', $this->third_four, true);
        $criteria->compare('third_five', $this->third_five, true);
        $criteria->compare('third_six', $this->third_six, true);
        $criteria->compare('third_seven', $this->third_seven, true);
        $criteria->compare('third_enght', $this->third_enght, true);
        $criteria->compare('third_nine', $this->third_nine, true);
        $criteria->compare('third_ten', $this->third_ten, true);
        $criteria->compare('fourth_three', $this->fourth_three, true);
        $criteria->compare('fourth_four', $this->fourth_four, true);
        $criteria->compare('fourth_five', $this->fourth_five, true);
        $criteria->compare('fourth_six', $this->fourth_six, true);
        $criteria->compare('fourth_seven', $this->fourth_seven, true);
        $criteria->compare('fourth_enght', $this->fourth_enght, true);
        $criteria->compare('fourth_nine', $this->fourth_nine, true);
        $criteria->compare('fourth_ten', $this->fourth_ten, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('created', $this->created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SurveySatisfactionNew the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOptions() {
        $options = array(
            'serviceObject' => array(
                'type' => 'radio',
                'question' => '您属于哪种类型的投联网服务对象？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '参加投联网举办的招商引资推介活动的企业或个人',
                    '投联网服务的投资北京企业',
                    '在投联网发布投资北京项目信息的企业或个人',
                    '在投联网发布写字楼租售信息的企业或个人'
                ),
                'answersNotes' => array(),
                'answersRequireds' => array(
                    '参加投联网举办的招商引资推介活动的企业或个人' => 'first_three,first_four,first_five,first_six,first_seven,first_enght,first_nine,first_ten',
                    '投联网服务的投资北京企业' => 'second_three,second_four,second_five,second_six,second_seven,second_enght,second_nine,second_ten',
                    '在投联网发布投资北京项目信息的企业或个人' => 'third_three,third_four,third_five,third_six,third_seven,third_enght,third_nine,third_ten',
                    '在投联网发布写字楼租售信息的企业或个人' => 'fourth_three,fourth_four,fourth_five,fourth_six,fourth_seven,fourth_enght,fourth_nine,fourth_ten'
                )
            ),
            'attention' => array(
                'type' => 'radio',
                'question' => '1. 您是否关注或浏览投联网？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('非常关注、经常浏览', '非常关注、偶尔浏览', '很关注、浏览少', '关注一般、浏览极少', '不关注、没有浏览', '不知道'),
                'answersNotes' => array()
            ),
            'register' => array(
                'type' => 'radio',
                'question' => '2. 您是否愿意注册成为本网站的用户？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('非常愿意', '很愿意', '愿意', '不愿意', '非常不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'first_three' => array(
                'type' => 'radio',
                'question' => '3. 您对投联网举办的招商引资推介活动整体满意度如何？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常满意', '很满意', '满意', '一般', '不满意', '不知道'),
                'answersNotes' => array()
            ),
            'first_four' => array(
                'type' => 'radio',
                'question' => '4. 您参加投联网举办的招商引资推介活动，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'first_five' => array(
                'type' => 'radio',
                'question' => '5. 您认为投联网举办的招商引资推介活动对于公司市场业务发展的实际指导意义如何？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常有帮助', '很有帮助', '帮助一般', '帮助差', '没有帮助', '不知道'),
                'answersNotes' => array()
            ),
            'first_six' => array(
                'type' => 'radio',
                'question' => '6. 会议议程的安排（包括内容、顺序、时间），您是否满意？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常满意', '很满意', '满意', '一般', '不满意', '不知道'),
                'answersNotes' => array()
            ),
            'first_seven' => array(
                'type' => 'radio',
                'question' => '7. 会议会务人员的服务质量和服务态度，您是否满意？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常满意', '很满意', '满意', '一般', '不满意', '不知道'),
                'answersNotes' => array()
            ),
            'first_enght' => array(
                'type' => 'radio',
                'question' => '8. 您愿意经常参加投联网举办的招商引资推介活动吗？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常愿意', '很愿意', '愿意', '一般', '不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'first_nine' => array(
                'type' => 'text',
                'question' => '9. 参加会议，您认为最有收获的会议内容是哪些？请举例说明。',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'first_ten' => array(
                'type' => 'text',
                'question' => '10. 请针对会议各方面情况，提出您的宝贵意见。',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'second_three' => array(
                'type' => 'radio',
                'question' => '3. 您对投联网提供的投资北京促落地服务整体满意度如何？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常满意', '很满意', '满意', '一般', '不满意', '不知道'),
                'answersNotes' => array()
            ),
            'second_four' => array(
                'type' => 'radio',
                'question' => '4. 投联网给您提供的投资北京促落地服务，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'second_five' => array(
                'type' => 'radio',
                'question' => '5. 您认为投联网提供的服务，对于你投资北京注册公司是否有帮助？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常有帮助', '很有帮助', '帮助一般', '帮助差', '没有帮助', '不知道'),
                'answersNotes' => array()
            ),
            'second_six' => array(
                'type' => 'radio',
                'question' => '6. 您认为投联网提供的服务，对于你了解北京投资环境、政策咨询等信息是否有帮助？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常有帮助', '很有帮助', '帮助一般', '帮助差', '没有帮助', '不知道'),
                'answersNotes' => array()
            ),
            'second_seven' => array(
                'type' => 'radio',
                'question' => '7. 投联网工作人员的服务质量和服务态度，您是否满意？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常满意', '很满意', '满意', '一般', '不满意', '不知道'),
                'answersNotes' => array()
            ),
            'second_enght' => array(
                'type' => 'radio',
                'question' => '8. 如您后续还有投资北京意向，是否愿意投联网继续为您提供促落地服务？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常愿意', '很愿意', '愿意', '一般', '不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'second_nine' => array(
                'type' => 'radio',
                'question' => '9. 如您身边的朋友或投资人有投资北京意向，您是否愿意推荐投联网为其提供促落地服务？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常愿意', '很愿意', '愿意', '一般', '不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'second_ten' => array(
                'type' => 'text',
                'question' => '10. 请针对投联网提供的投资北京促落地服务情况，提出您的宝贵意见。',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'third_three' => array(
                'type' => 'radio',
                'question' => '3. 您在投联网发布的是哪一类的投资北京项目信息？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('投资项目信息', '融资项目信息', '写字楼招商项目信息', '园区招商项目信息', '土地招商项目信息', '其他'),
                'answersNotes' => array()
            ),
            'third_four' => array(
                'type' => 'radio',
                'question' => '4. 您在投联网发布投资北京项目信息，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'third_five' => array(
                'type' => 'radio',
                'question' => '5. 您认为在投联网发布投资北京项目信息操作便捷吗？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常便捷', '很便捷', '便捷', '一般便捷', '不便捷', '不知道'),
                'answersNotes' => array()
            ),
            'third_six' => array(
                'type' => 'radio',
                'question' => '6. 您在投联网发布投资北京项目信息反馈效果明显吗？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('效果非常好', '效果很好', '效果好', '效果一般', '成效差', '不知道'),
                'answersNotes' => array()
            ),
            'third_seven' => array(
                'type' => 'radio',
                'question' => '7. 针对您发布的投资北京项目信息，投联网会定期定向推送给企业客户，您是否知晓？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('知道，已收到了投联网的推送信息和客户的反馈', '知道，已收到了投联网的推送信息', '不知道'),
                'answersNotes' => array()
            ),
            'third_enght' => array(
                'type' => 'radio',
                'question' => '8. 您发布的投资北京项目信息，您是否愿意投联网进行定向推送给企业客户？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常愿意', '很愿意', '愿意', '一般', '不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'third_nine' => array(
                'type' => 'radio',
                'question' => '9. 投联网将您发布的投资北京项目信息定向推送给企业客户，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'third_ten' => array(
                'type' => 'text',
                'question' => '10. 请针对在投联网发布的投资北京项目信息情况，提出您的宝贵意见。',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'fourth_three' => array(
                'type' => 'radio',
                'question' => '3. 您经常在投联网发布写字楼租售信息吗？频次多少？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常频繁 一周至少发布一次', '频繁 一月至少发布一次', '偶尔 一季度或是半年发布一次', '从来不发布'),
                'answersNotes' => array()
            ),
            'fourth_four' => array(
                'type' => 'radio',
                'question' => '4. 您在投联网发布写字楼租售信息，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'fourth_five' => array(
                'type' => 'radio',
                'question' => '5. 您认为在投联网发布写字楼租售信息操作便捷吗？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常便捷', '很便捷', '便捷', '一般便捷', '不便捷', '不知道'),
                'answersNotes' => array()
            ),
            'fourth_six' => array(
                'type' => 'radio',
                'question' => '6. 您在投联网发布写字楼租售信息反馈效果明显吗？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('效果非常好', '效果很好', '效果好', '效果一般', '成效差', '不知道'),
                'answersNotes' => array()
            ),
            'fourth_seven' => array(
                'type' => 'radio',
                'question' => '7. 针对您发布的写字楼租售信息，投联网会定期定向推送给企业客户，您是否知晓？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('知道，已收到了投联网的推送信息和客户的反馈', '知道，已收到了投联网的推送信息', '不知道'),
                'answersNotes' => array()
            ),
            'fourth_enght' => array(
                'type' => 'radio',
                'question' => '8. 您发布的写字楼租售信息，您是否愿意投联网进行定向推送给企业客户？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('非常愿意', '很愿意', '愿意', '一般', '不愿意', '不知道'),
                'answersNotes' => array()
            ),
            'fourth_nine' => array(
                'type' => 'radio',
                'question' => '9. 投联网将您发布的写字楼租售信息定向推送给企业客户，是否收费？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array('收费', '免费'),
                'answersNotes' => array()
            ),
            'fourth_ten' => array(
                'type' => 'text',
                'question' => '10. 请针对在投联网发布的写字楼租售信息情况，提出您的宝贵意见。',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
        );
        return $options;
    }

}
