<?php

/**
 * This is the model class for table "t_survey_bus_env".
 *
 * The followings are the available columns in table 't_survey_bus_env':
 * @property integer $id
 * @property string $wechatOpenId
 * @property string $companyName
 * @property string $companyContact
 * @property string $email
 * @property string $wechat
 * @property string $mobile
 * @property string $industry
 * @property string $annualSalesVolume
 * @property string $evaluate
 * @property string $prominentProblem
 * @property string $effortNotEnough
 * @property string $talentShortage
 * @property string $lessCompetitive
 * @property string $lessCommunicationMechanism
 * @property string $approvalLowEfficiency
 * @property string $environmentalImprovementNotObvious
 * @property string $investmentInventiveIncompleteness
 * @property string $companyDifficulty
 * @property string $intellectualPropertyNeedEnhance
 * @property string $incentiveFaultiness
 * @property string $measure_effortNotEnough
 * @property string $measure_talentShortage
 * @property string $measure_lessCompetitive
 * @property string $measure_lessCommunicationMechanism
 * @property string $measure_approvalLowEfficiency
 * @property string $measure_environmentalImprovementNotObvious
 * @property string $measure_investmentInventiveIncompleteness
 * @property string $measure_companyDifficulty
 * @property string $measure_intellectualPropertyNeedEnhance
 * @property string $measure_other
 * @property string $ip
 * @property integer $created
 */
class SurveyBusEnv extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_survey_bus_env';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created', 'numerical', 'integerOnly' => true),
            array('wechatOpenId, companyName, companyContact, email, wechat, mobile, industry, annualSalesVolume, evaluate, prominentProblem, effortNotEnough, talentShortage, lessCompetitive, lessCommunicationMechanism, approvalLowEfficiency, environmentalImprovementNotObvious, investmentInventiveIncompleteness, companyDifficulty, intellectualPropertyNeedEnhance, incentiveFaultiness, measure_effortNotEnough, measure_talentShortage, measure_lessCompetitive, measure_lessCommunicationMechanism, measure_approvalLowEfficiency, measure_environmentalImprovementNotObvious, measure_investmentInventiveIncompleteness, measure_companyDifficulty, measure_intellectualPropertyNeedEnhance, measure_other', 'length', 'max' => 255),
            array('ip', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, wechatOpenId, companyName, companyContact, email, wechat, mobile, industry, annualSalesVolume, evaluate, prominentProblem, effortNotEnough, talentShortage, lessCompetitive, lessCommunicationMechanism, approvalLowEfficiency, environmentalImprovementNotObvious, investmentInventiveIncompleteness, companyDifficulty, intellectualPropertyNeedEnhance, incentiveFaultiness, measure_effortNotEnough, measure_talentShortage, measure_lessCompetitive, measure_lessCommunicationMechanism, measure_approvalLowEfficiency, measure_environmentalImprovementNotObvious, measure_investmentInventiveIncompleteness, measure_companyDifficulty, measure_intellectualPropertyNeedEnhance, measure_other, ip, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'wechatOpenId' => '微信OpenId',
            'companyName' => '基本情况 - 1. 您所在企业名称',
            'companyContact' => '基本情况 - 1. 企业联系人及职务',
            'email' => '基本情况 - 1. 电子邮箱',
            'wechat' => '基本情况 - 1. 微信号',
            'mobile' => '基本情况 - 1. 手机号码',
            'industry' => '基本情况 - 2. 您所在企业所属类型',
            'annualSalesVolume' => '基本情况 - 3. 您所在企业近三年（2014年—2016年）平均年营业收入范围',
            'evaluate' => '主要问题 - 1. 您对北京市营商环境现状的总体评价',
            'prominentProblem' => '主要问题 - 2. 与上海、深圳、广州、天津、重庆、杭州、厦门等城市相比，请您将北京市在营商环境方面存在的突出问题，按照您最不满意的程度在选项后的括号内进行打分（0-10分），最不满意为10分，以此类推',
            'effortNotEnough' => '主要问题 - 3. 关于“政府部门为投资人和企业解决困难和问题工作力度不够”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'talentShortage' => '主要问题 - 4. 关于“缺乏吸引全球创新型人才、顶尖人才的区别性政策，企业人才环境有待改善”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'lessCompetitive' => '主要问题 - 5. 关于“政府部门各类扶持支持企业发展的政策缺乏竞争力”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'lessCommunicationMechanism' => '主要问题 - 6. 关于“政府部门制定和执行涉及企业切身利益的政策时，缺乏有效的政企沟通机制和反馈机制”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'approvalLowEfficiency' => '主要问题 - 7. 关于“市场准入的审批服务效率不高”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'environmentalImprovementNotObvious' => '主要问题 - 8. 关于“政府部门对市场和企业的监管环境改善不明显”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'investmentInventiveIncompleteness' => '主要问题 - 9. 关于“政府部门引导天使投资、风险投资等投向科技创新领域的投融资鼓励政策不够完备”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'companyDifficulty' => '主要问题 - 10. 关于“企业自建办公场所购地难，租用办公用房难，以及企业购车缺乏区别性政策等”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'intellectualPropertyNeedEnhance' => '主要问题 - 11. 关于“知识产权的保护及资本化还需加强”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'incentiveFaultiness' => '主要问题 - 12. 关于“鼓励企业创业创新发展的产业配套与供应链系统不完善”的问题，您认为政府部门应采取哪些政策措施',
            'measure_effortNotEnough' => '对策建议 - 1. 为解决“政府部门为投资人和企业解决困难和问题工作力度不够”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_talentShortage' => '对策建议 - 2. 为解决“缺乏吸引全球创新型人才、顶尖人才的区别性政策，企业人才环境有待改善”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_lessCompetitive' => '对策建议 - 3. 为解决“政府部门各类扶持支持企业发展的政策缺乏竞争力”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'measure_lessCommunicationMechanism' => '对策建议 - 4. 为解决“政府部门制定和执行涉及企业切身利益的政策时，缺乏有效的政企沟通机制和反馈机制”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_approvalLowEfficiency' => '对策建议 - 5. 为解决“市场准入的审批服务效率不高”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_environmentalImprovementNotObvious' => '对策建议 - 6. 为解决“政府部门对市场和企业的监管环境改善不明显”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的为10分，以此类推',
            'measure_investmentInventiveIncompleteness' => '对策建议 - 7. 为解决“政府部门引导天使投资、风险投资等投向科技创新领域的投融资鼓励政策不够完备”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_companyDifficulty' => '对策建议 - 8. 为解决“企业自建办公场所购地难，租用办公用房难，以及企业购车缺乏区别性政策等”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_intellectualPropertyNeedEnhance' => '对策建议 - 9. 为解决“知识产权的保护及资本化还需加强”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
            'measure_other' => '对策建议 - 10. 您对改善北京市营商环境还有哪些意见和建议',
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
        $criteria->compare('companyName', $this->companyName, true);
        $criteria->compare('companyContact', $this->companyContact, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('wechat', $this->wechat, true);
        $criteria->compare('mobile', $this->mobile, true);
        $criteria->compare('industry', $this->industry, true);
        $criteria->compare('annualSalesVolume', $this->annualSalesVolume, true);
        $criteria->compare('evaluate', $this->evaluate, true);
        $criteria->compare('prominentProblem', $this->prominentProblem, true);
        $criteria->compare('effortNotEnough', $this->effortNotEnough, true);
        $criteria->compare('talentShortage', $this->talentShortage, true);
        $criteria->compare('lessCompetitive', $this->lessCompetitive, true);
        $criteria->compare('lessCommunicationMechanism', $this->lessCommunicationMechanism, true);
        $criteria->compare('approvalLowEfficiency', $this->approvalLowEfficiency, true);
        $criteria->compare('environmentalImprovementNotObvious', $this->environmentalImprovementNotObvious, true);
        $criteria->compare('investmentInventiveIncompleteness', $this->investmentInventiveIncompleteness, true);
        $criteria->compare('companyDifficulty', $this->companyDifficulty, true);
        $criteria->compare('intellectualPropertyNeedEnhance', $this->intellectualPropertyNeedEnhance, true);
        $criteria->compare('incentiveFaultiness', $this->incentiveFaultiness, true);
        $criteria->compare('measure_effortNotEnough', $this->measure_effortNotEnough, true);
        $criteria->compare('measure_talentShortage', $this->measure_talentShortage, true);
        $criteria->compare('measure_lessCompetitive', $this->measure_lessCompetitive, true);
        $criteria->compare('measure_lessCommunicationMechanism', $this->measure_lessCommunicationMechanism, true);
        $criteria->compare('measure_approvalLowEfficiency', $this->measure_approvalLowEfficiency, true);
        $criteria->compare('measure_environmentalImprovementNotObvious', $this->measure_environmentalImprovementNotObvious, true);
        $criteria->compare('measure_investmentInventiveIncompleteness', $this->measure_investmentInventiveIncompleteness, true);
        $criteria->compare('measure_companyDifficulty', $this->measure_companyDifficulty, true);
        $criteria->compare('measure_intellectualPropertyNeedEnhance', $this->measure_intellectualPropertyNeedEnhance, true);
        $criteria->compare('measure_other', $this->measure_other, true);
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
     * @return SurveyBusEnv the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOptions() {
        $options = array(
            'companyName' => array(
                'type' => 'text',
                'question' => '基本情况 - 1. 您所在企业名称',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'companyContact' => array(
                'type' => 'text',
                'question' => '基本情况 - 1. 企业联系人及职务',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'email' => array(
                'type' => 'text',
                'question' => '基本情况 - 1. 电子邮箱',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'wechat' => array(
                'type' => 'text',
                'question' => '基本情况 - 1. 微信号',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'mobile' => array(
                'type' => 'text',
                'question' => '基本情况 - 1. 手机号码',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'industry' => array(
                'type' => 'checkbox',
                'question' => '基本情况 - 2. 您所在企业所属类型',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '央企',
                    '市属、区属或外省市国企',
                    '大型民企',
                    '跨国公司地区总部、外商投资性公司、外资企业',
                    '金融与股权投资机构',
                    '行业产业的龙头企业、领军企业和上市公司',
                    '高成长性创新型企业（高新技术企业）',
                    '外国和外省市驻京商会及其大型骨干会员企业',
                    '投资中介机构',
                ),
                'answersNotes' => array()
            ),
            'annualSalesVolume' => array(
                'type' => 'radio',
                'question' => '基本情况 - 3. 您所在企业近三年（2014年—2016年）平均年营业收入范围',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '3000万元人民币以下',
                    '3000万元人民币至1亿元人民币',
                    '1亿元人民币（含）以上',
                ),
                'answersNotes' => array()
            ),
            'evaluate' => array(
                'type' => 'radio',
                'question' => '主要问题 - 1. 您对北京市营商环境现状的总体评价',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '满意',
                    '比较满意',
                    '基本满意',
                    '不满意',
                ),
                'answersNotes' => array()
            ),
            'prominentProblem' => array(
                'type' => 'rate',
                'question' => '主要问题 - 2. 与上海、深圳、广州、天津、重庆、杭州、厦门等城市相比，请您将北京市在营商环境方面存在的突出问题，按照您最不满意的程度在选项后的括号内进行打分（0-10分），最不满意为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门为投资人和企业解决困难和问题工作力度不够',
                    '缺乏吸引全球创新型人才、顶尖人才的区别性政策，企业人才环境有待改善',
                    '政府部门各类扶持支持企业发展的政策缺乏竞争力',
                    '政府部门制定和执行涉及企业切身利益的政策时，缺乏有效的政企沟通机制和反馈机制',
                    '市场准入的审批服务效率不高',
                    '政府部门对市场和企业的监管环境改善不明显',
                    '政府部门引导天使投资、风险投资等投向科技创新领域的投融资鼓励政策不够完备',
                    '企业自建办公场所购地难，租用办公用房难，以及企业购车缺乏区别性政策等',
                    '知识产权的保护及资本化还需加强',
                    '鼓励企业创业创新发展的产业配套与供应链系统不完善',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'effortNotEnough' => array(
                'type' => 'rate',
                'question' => '主要问题 - 3. 关于“政府部门为投资人和企业解决困难和问题工作力度不够”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门以发展为中心的责任意识不够强',
                    '政府部门未普遍建立政企对接平台和沟通机制，企业反映困难问题的渠道不畅',
                    '政府部门对解决企业的困难问题缺乏足够的压力和动力，缺少鼓励职能部门主动作为的激励机制',
                    '政府部门对解决企业困难问题的督查和问责不够',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'talentShortage' => array(
                'type' => 'rate',
                'question' => '主要问题 - 4. 关于“缺乏吸引全球创新型人才、顶尖人才的区别性政策，企业人才环境有待改善”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '全球创新型人才、顶尖人才在京购房缺乏优惠政策',
                    '全球创新型人才、顶尖人才在京就医缺乏优惠政策',
                    '全球创新型人才、顶尖人才子女在京入学缺乏优惠政策',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'lessCompetitive' => array(
                'type' => 'rate',
                'question' => '主要问题 - 5. 关于“政府部门各类扶持支持企业发展的政策缺乏竞争力”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '与其它竞争城市相比，各类扶持支持企业发展政策的针对性不强、优惠程度不够',
                    '各类扶持支持企业发展政策的宣传推介不够',
                    '企业申请优惠政策时，政府部门审批过程透明度不高',
                    '对符合条件的企业，扶持支持政策不能及时足额兑现',
                    '面对企业竞争和发展需要，政府部门未能及时快速制定有竞争力的新政策',
                    '优惠政策多变，缺乏长期性、连续性和稳定性',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'lessCommunicationMechanism' => array(
                'type' => 'rate',
                'question' => '主要问题 - 6. 关于“政府部门制定和执行涉及企业切身利益的政策时，缺乏有效的政企沟通机制和反馈机制”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门制定涉企政策时，未事先广泛征求商协会和企业的意见建议',
                    '针对涉企政策的执行，没有专门的反馈渠道来收集商协会和企业的意见建议',
                    '政府部门对新出台的涉企政策权威精准的宣传解读不够',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'approvalLowEfficiency' => array(
                'type' => 'rate',
                'question' => '主要问题 - 7. 关于“市场准入的审批服务效率不高”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '部分审批事项和申报材料还存在应取消未取消现象，还需进一步简政放权',
                    '政府部门对《北京市新增产业的禁止和限制目录》等政策的解释执行存在不统一现象',
                    '部分政府部门行政审批实行网上预约，导致企业办事等候时间长',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'environmentalImprovementNotObvious' => array(
                'type' => 'rate',
                'question' => '主要问题 - 8. 关于“政府部门对市场和企业的监管环境改善不明显”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门监管政策制定的条文清晰度不高、明确性不够',
                    '政府部门监管政策执行中，不同的区、不同的人执行口径不统一、标准不一致',
                    '政府部门对企业的监管执法结果没有向社会公示公开',
                    '企业对监管执法结果申诉效果不明显',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'investmentInventiveIncompleteness' => array(
                'type' => 'rate',
                'question' => '主要问题 - 9. 关于“政府部门引导天使投资、风险投资等投向科技创新领域的投融资鼓励政策不够完备”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门在科技创新领域的产业引导基金规模还不够大',
                    '政府部门鼓励天使投资、风险投资等投向科技创新领域的政策不够优惠',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'companyDifficulty' => array(
                'type' => 'rate',
                'question' => '主要问题 - 10. 关于“企业自建办公场所购地难，租用办公用房难，以及企业购车缺乏区别性政策等”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '面对企业自建办公场所的需求，缺乏供应合适区域、合适面积的供地政策',
                    '企业自建办公场所办事手续繁琐，政府部门审批时间长',
                    '企业“摇号”购车没有区别性政策',
                    '企业购买、租赁办公用房没有全市统一信息发布平台',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'intellectualPropertyNeedEnhance' => array(
                'type' => 'rate',
                'question' => '主要问题 - 11. 关于“知识产权的保护及资本化还需加强”的问题，您认为产生问题的原因有以下哪些？请您根据原因的重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '保护知识产权的执法效率还不够高',
                    '知识产权出资、质押融资等方面的支持政策不够完善',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'incentiveFaultiness' => array(
                'type' => 'text',
                'question' => '主要问题 - 12. 关于“鼓励企业创业创新发展的产业配套与供应链系统不完善”的问题，您认为政府部门应采取哪些政策措施',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(),
                'answersNotes' => array()
            ),
            'measure_effortNotEnough' => array(
                'type' => 'rate',
                'question' => '对策建议 - 1. 为解决“政府部门为投资人和企业解决困难和问题工作力度不够”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门要牢固树立责任意识，始终将抓发展作为中心工作',
                    '建立各级政府部门的政企对接平台和沟通机制，畅通企业反映困难问题的渠道',
                    '利用移动互联网等新技术手段，建立企业实时反映困难问题的网上平台，平台数据供市领导、各级政府、问题责任部门、政府监督部门等实时共享、实时查看，增强责任部门解决困难问题的压力和动力',
                    '政府部门进一步加强对解决企业困难问题的督查和问责',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_talentShortage' => array(
                'type' => 'rate',
                'question' => '对策建议 - 2. 为解决“缺乏吸引全球创新型人才、顶尖人才的区别性政策，企业人才环境有待改善”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门放宽全球创新型人才、顶尖人才等在京购房的资格条件',
                    '政府部门制定全球创新型人才、顶尖人才等在京就医的优惠政策',
                    '政府部门制定全球创新型人才、顶尖人才其子女在京入学的倾斜政策',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_lessCompetitive' => array(
                'type' => 'rate',
                'question' => '对策建议 - 3. 为解决“政府部门各类扶持支持企业发展的政策缺乏竞争力”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '与其它竞争城市相比，进一步加强北京市扶持支持企业发展优惠政策的针对性和优惠力度',
                    '切实做好各类扶持支持企业发展政策的广而告之工作',
                    '减少政府部门对企业申请优惠政策的审批程序，增加透明度',
                    '对符合条件的企业应及时足额兑现扶持支持政策',
                    '根据企业竞争和发展需要，及时快速制定新的有竞争力的支持扶持政策',
                    '减少优惠政策多变，保持政策的长期性、连续性和稳定性',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_lessCommunicationMechanism' => array(
                'type' => 'rate',
                'question' => '对策建议 - 4. 为解决“政府部门制定和执行涉及企业切身利益的政策时，缺乏有效的政企沟通机制和反馈机制”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府部门制定涉企政策时，应事先广泛征求商协会和企业的意见建议',
                    '针对涉企政策的执行，要建立专门的反馈渠道，收集商协会和企业的意见建议',
                    '政府部门要加强对新出台的涉企政策权威精准的宣传解读工作',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_approvalLowEfficiency' => array(
                'type' => 'rate',
                'question' => '对策建议 - 5. 为解决“市场准入的审批服务效率不高”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '进一步取消审批事项、减少审批申报材料，实现企业“只跑一次”政府部门即可办结',
                    '进一步细化完善《北京市新增产业的禁止和限制目录》等政策，提高政策执行的统一性和一致性',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_environmentalImprovementNotObvious' => array(
                'type' => 'rate',
                'question' => '对策建议 - 6. 为解决“政府部门对市场和企业的监管环境改善不明显”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府监管政策要努力做到条文表述明确清晰具体、可操作性强',
                    '加强工作培训，进一步提高政府部门行政执法人员的业务素质',
                    '政府部门要高度重视企业申诉工作，加大依法复核审理企业申诉工作的力度',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_investmentInventiveIncompleteness' => array(
                'type' => 'rate',
                'question' => '对策建议 - 7. 为解决“政府部门引导天使投资、风险投资等投向科技创新领域的投融资鼓励政策不够完备”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '大幅度提高政府部门在科技创新领域的产业引导基金的规模',
                    '政府部门要制定鼓励天使投资、风险投资等投向科技创新领域有竞争力的优惠政策，如借鉴《上海市天使投资风险补偿管理暂行办法》等，制定相关政策',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_companyDifficulty' => array(
                'type' => 'rate',
                'question' => '对策建议 - 8. 为解决“企业自建办公场所购地难，租用办公用房难，以及企业购车缺乏区别性政策等”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '根据企业自建办公场所的需求，供应合适区域、合适面积的地块',
                    '将企业自建办公场所项目，参照“一会三函”公共服务类建设项目，简化优化审批手续',
                    '提高企业购车“摇号”的中签率',
                    '建立全市办公用房出租信息的统一发布平台',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_intellectualPropertyNeedEnhance' => array(
                'type' => 'rate',
                'question' => '对策建议 - 9. 为解决“知识产权的保护及资本化还需加强”的问题，您认为下列哪个工作措施最为重要？请您根据重要程度进行打分（0-10分），最重要的工作措施为10分，以此类推',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '提高保护知识产权的执法效率',
                    '制定完善允许知识产权出资、质押融资等方面的扶持政策',
                    '其它',
                ),
                'answersNotes' => array()
            ),
            'measure_other' => array(
                'type' => 'text',
                'question' => '对策建议 - 10. 您对改善北京市营商环境还有哪些意见和建议',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(),
                'answersNotes' => array()
            ),
        );
        return $options;
    }

}
