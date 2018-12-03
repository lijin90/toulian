<?php

/**
 * This is the model class for table "t_survey_ent_op_env".
 *
 * The followings are the available columns in table 't_survey_ent_op_env':
 * @property integer $id
 * @property string $area
 * @property string $industry
 * @property string $industry_scale
 * @property string $industry_scale_unit
 * @property string $reduce_capacity
 * @property string $polluting_emission
 * @property string $reg_to_year
 * @property string $profit_status
 * @property string $staff_number
 * @property string $fault
 * @property string $fault_items
 * @property string $fault_depts_buies
 * @property string $fault_depts_jobs
 * @property string $baffle
 * @property string $baffle_event
 * @property string $baffle_depts
 * @property string $policysupport
 * @property string $policysupport_benefit
 * @property string $policysupport_depts
 * @property string $policysupport_failcause
 * @property string $gift
 * @property string $gift_officers
 * @property string $gift_officers_change
 * @property string $gift_need
 * @property string $gift_includes
 * @property string $situation
 * @property string $conduct
 * @property string $check_condition
 * @property string $check_frequency
 * @property string $check_depts
 * @property string $check_gift_case
 * @property string $punish_reason
 * @property string $punish_way
 * @property string $disturb
 * @property string $disturb_reason
 * @property string $disturb_solution
 * @property string $feedback
 * @property string $feedback_effect
 * @property string $feedback_result
 * @property string $feedback_opposite
 * @property string $tax_care
 * @property string $tax_care_reason
 * @property string $tax_upper_limit
 * @property string $association
 * @property string $association_useful
 * @property string $association_aspect
 * @property string $ip
 * @property integer $created
 */
class SurveyEntOpEnv extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_survey_ent_op_env';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created', 'numerical', 'integerOnly' => true),
            array('area, ip', 'length', 'max' => 50),
            array('industry, industry_scale, industry_scale_unit, reduce_capacity, polluting_emission, reg_to_year, profit_status, staff_number, fault, fault_items, fault_depts_buies, fault_depts_jobs, baffle, baffle_event, baffle_depts, policysupport, policysupport_benefit, policysupport_depts, policysupport_failcause, gift, gift_officers, gift_officers_change, gift_need, gift_includes, situation, conduct, check_condition, check_frequency, check_depts, check_gift_case, punish_reason, punish_way, disturb, disturb_reason, disturb_solution, feedback, feedback_effect, feedback_result, feedback_opposite, tax_care, tax_care_reason, tax_upper_limit, association, association_useful, association_aspect', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, area, industry, industry_scale, industry_scale_unit, reduce_capacity, polluting_emission, reg_to_year, profit_status, staff_number, fault, fault_items, fault_depts_buies, fault_depts_jobs, baffle, baffle_event, baffle_depts, policysupport, policysupport_benefit, policysupport_depts, policysupport_failcause, gift, gift_officers, gift_officers_change, gift_need, gift_includes, situation, conduct, check_condition, check_frequency, check_depts, check_gift_case, punish_reason, punish_way, disturb, disturb_reason, disturb_solution, feedback, feedback_effect, feedback_result, feedback_opposite, tax_care, tax_care_reason, tax_upper_limit, association, association_useful, association_aspect, ip, created', 'safe', 'on' => 'search'),
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
            'area' => '地区',
            'industry' => '1. 您企业属于哪一行业？',
            'industry_scale' => '企业规模',
            'industry_scale_unit' => '企业规模单位',
            'reduce_capacity' => '2. 您企业属于“去产能”行业吗？',
            'polluting_emission' => '3. 您企业属于污染排放企业吗？',
            'reg_to_year' => '4. 截至2016年底，您企业开办了多少年？',
            'profit_status' => '5. 2016年，您企业的盈利状况如何？',
            'staff_number' => '6. 2016年，您企业聘用的专职员工有多少人？',
            'fault' => '7. 2016年，您企业是否遇到过公职人员不当行为？',
            'fault_items' => '8. 2016年，您企业遇到的公职人员不当行为包括哪些？',
            'fault_depts_buies' => '9. 据您了解，2016年哪些部门的公职人员曾要求您企业或其他企业购买关联企业的产品和服务？',
            'fault_depts_jobs' => '10. 据您了解，2016年哪些部门的公职人员曾要求您企业或其他企业为他的亲朋好友安排就业岗位？',
            'baffle' => '11. 2016年，您企业在与政府部门打交道时是否遇到令您为难的事情？',
            'baffle_event' => '12. 2016年，您企业在与政府部门打交道时遇到的最令您为难的事是哪件？',
            'baffle_depts' => '13. 2016年，最令您为难的事涉及哪些政府部门？',
            'policysupport' => '14. 2016年，您企业是否获得过正当的政策性倾斜？',
            'policysupport_benefit' => '15. 2016年，您企业为争取正当的政策性倾斜是否需要给公职人员“好处”？',
            'policysupport_depts' => '16. 2016年，为获得正当的政策性倾斜，您企业曾经给哪些政府部门公职人员“好处”？',
            'policysupport_failcause' => '17. 您企业没有获得政策性倾斜的原因是什么？',
            'gift' => '18. 2016年，您企业逢年过节时，是否给公职人员赠送礼品礼金？',
            'gift_officers' => '19. 2016年，您企业逢年过节时，给多少位公职人员赠送了礼品礼金？',
            'gift_officers_change' => '20. 相比2015年，您企业2016年赠送礼品礼金的公职人员数量有没有变化？',
            'gift_need' => '21. 您企业2016年在办理企业经营关键事务时是否需要赠送公职人员礼品礼金？',
            'gift_includes' => '22. 2016年，需要赠送公职人员礼品礼金才能办好的关键事务，包括哪些？',
            'situation' => '23. 您企业2016年在办理各类审批和申报手续时遇到的情形是哪种？',
            'conduct' => '24. 据您了解，在2016年，公职人员的哪些行为，导致企业去政府部门办事难？',
            'check_condition' => '25. 2016年，除了企业自身出现事故之外，在什么情况下公职人员会上门检查您企业？',
            'check_frequency' => '26. 您的企业2016年在一个月内最多曾接待多少批次公职人员的检查？',
            'check_depts' => '27. 2016年，经常来企业上门检查的是哪些政府部门的人员？',
            'check_gift_case' => '28. 2016年，公职人员上门检查时，您企业赠送礼品礼金的情况是什么？',
            'punish_reason' => '29. 您企业和您了解的其他企业，2016年，公职人员检查后，如要处罚企业，最常见的原由和情况是什么？',
            'punish_way' => '30. 您企业和您了解的其他企业，2016年，被查出问题后想整改过关，最常采用的方式是什么？',
            'disturb' => '31. 2016年，您企业所在的社区或村（含他们主办的企业园区）的工作人员，是否有干扰企业经营的不当行为？',
            'disturb_reason' => '32. 社区或村（含他们主办的企业园区）给企业运行造成困难的不当行为中，最常见的原由和情形包括？',
            'disturb_solution' => '33. 您企业一般是采用哪些方式解决了社区或村（含他们主办的企业园区）给企业运行造成的困难的？',
            'feedback' => '34. 2016年，您是否曾经向政府有关部门（包括人大、党委、政府、政协、纪检监察等部门）反映过公职人员的不当行为？',
            'feedback_effect' => '35. 您的反映行为产生了什么样的效果？',
            'feedback_result' => '36. 您的反映行为所产生的积极效果主要包括哪些？',
            'feedback_opposite' => '37. 您为什么没有向有关政府部门反映公职人员的不当行为？',
            'tax_care' => '38. 据您了解，周边企业是否普遍存在避税和争取税务人员“关照”的现象？',
            'tax_care_reason' => '39. 您认为，企业避税和争取税务人员“关照”的原因是什么？',
            'tax_upper_limit' => '40. 您认为，您企业可以承受多高的增值税税率，不会给经营造成困难？',
            'association' => '41. 您所属行业在当地是否成立了行业协会，您是否加入了协会？',
            'association_useful' => '42. 您认为加入行业协会，对您经营企业是否有用？',
            'association_aspect' => '43. 您认为行业协会应该在哪些方面更好地发挥作用？',
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
        $criteria->compare('area', $this->area, true);
        $criteria->compare('industry', $this->industry, true);
        $criteria->compare('industry_scale', $this->industry_scale, true);
        $criteria->compare('industry_scale_unit', $this->industry_scale_unit, true);
        $criteria->compare('reduce_capacity', $this->reduce_capacity, true);
        $criteria->compare('polluting_emission', $this->polluting_emission, true);
        $criteria->compare('reg_to_year', $this->reg_to_year, true);
        $criteria->compare('profit_status', $this->profit_status, true);
        $criteria->compare('staff_number', $this->staff_number, true);
        $criteria->compare('fault', $this->fault, true);
        $criteria->compare('fault_items', $this->fault_items, true);
        $criteria->compare('fault_depts_buies', $this->fault_depts_buies, true);
        $criteria->compare('fault_depts_jobs', $this->fault_depts_jobs, true);
        $criteria->compare('baffle', $this->baffle, true);
        $criteria->compare('baffle_event', $this->baffle_event, true);
        $criteria->compare('baffle_depts', $this->baffle_depts, true);
        $criteria->compare('policysupport', $this->policysupport, true);
        $criteria->compare('policysupport_benefit', $this->policysupport_benefit, true);
        $criteria->compare('policysupport_depts', $this->policysupport_depts, true);
        $criteria->compare('policysupport_failcause', $this->policysupport_failcause, true);
        $criteria->compare('gift', $this->gift, true);
        $criteria->compare('gift_officers', $this->gift_officers, true);
        $criteria->compare('gift_officers_change', $this->gift_officers_change, true);
        $criteria->compare('gift_need', $this->gift_need, true);
        $criteria->compare('gift_includes', $this->gift_includes, true);
        $criteria->compare('situation', $this->situation, true);
        $criteria->compare('conduct', $this->conduct, true);
        $criteria->compare('check_condition', $this->check_condition, true);
        $criteria->compare('check_frequency', $this->check_frequency, true);
        $criteria->compare('check_depts', $this->check_depts, true);
        $criteria->compare('check_gift_case', $this->check_gift_case, true);
        $criteria->compare('punish_reason', $this->punish_reason, true);
        $criteria->compare('punish_way', $this->punish_way, true);
        $criteria->compare('disturb', $this->disturb, true);
        $criteria->compare('disturb_reason', $this->disturb_reason, true);
        $criteria->compare('disturb_solution', $this->disturb_solution, true);
        $criteria->compare('feedback', $this->feedback, true);
        $criteria->compare('feedback_effect', $this->feedback_effect, true);
        $criteria->compare('feedback_result', $this->feedback_result, true);
        $criteria->compare('feedback_opposite', $this->feedback_opposite, true);
        $criteria->compare('tax_care', $this->tax_care, true);
        $criteria->compare('tax_care_reason', $this->tax_care_reason, true);
        $criteria->compare('tax_upper_limit', $this->tax_upper_limit, true);
        $criteria->compare('association', $this->association, true);
        $criteria->compare('association_useful', $this->association_useful, true);
        $criteria->compare('association_aspect', $this->association_aspect, true);
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
     * @return SurveyEntOpEnv the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOptions() {
        $options = array(
            'industry' => array(
                'type' => 'industry',
                'question' => '1. 您企业属于哪一行业？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '农林牧渔业' => array(
                        'list' => array('500≤Y<20000', '50≤Y<500', 'Y<50'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '采矿业' => array(
                        'list' => array('2000≤Y<40000', '300≤Y<2000', 'Y<300'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '制造业' => array(
                        'list' => array('2000≤Y<40000', '300≤Y<2000', 'Y<300'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '电力、热力、燃气及水生产和供应业' => array(
                        'list' => array('2000≤Y<40000', '300≤Y<2000', 'Y<300'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '建筑业' => array(
                        'list' => array('6000≤Y<80000', '300≤Y<6000', 'Y<300'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '批发业' => array(
                        'list' => array('5000≤Y<40000', '1000≤Y<5000', 'Y<1000'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '零售业' => array(
                        'list' => array('500≤Y<20000', '100≤Y<500', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '交通运输业' => array(
                        'list' => array('3000≤Y<30000', '200≤Y<3000', 'Y<200'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '仓储业' => array(
                        'list' => array('1000≤Y<30000', '100≤Y<1000', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '邮政业' => array(
                        'list' => array('2000≤Y<30000', '100≤Y<2000', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '住宿和餐饮业' => array(
                        'list' => array('2000≤Y<10000', '100≤Y<2000', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '信息传输业' => array(
                        'list' => array('1000≤Y<100000', '100≤Y<1000', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '软件和信息技术服务业' => array(
                        'list' => array('1000≤Y<10000', '50≤Y<1000', 'Y<50'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '金融业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '房地产业' => array(
                        'list' => array('1000≤Y<200000', '100≤Y<1000', 'Y<100'),
                        'note' => 'Y为营业收入；单位：万元'
                    ),
                    '租赁和商务服务业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '科学研究和技术服务业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '水利、环境和公共设施管理业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '居民服务、修理和其他服务业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '教育' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '卫生和社会工作' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '文化、体育和娱乐业' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                    '新业态' => array(
                        'list' => array('100≤X<300', '10≤X<100', 'X<10'),
                        'note' => 'X为从业人员；单位：人'
                    ),
                ),
                'answersNotes' => array()
            ),
            'reduce_capacity' => array(
                'type' => 'radio',
                'question' => '2. 您企业属于“去产能”行业吗？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array()
            ),
            'polluting_emission' => array(
                'type' => 'radio',
                'question' => '3. 您企业属于污染排放企业吗？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array()
            ),
            'reg_to_year' => array(
                'type' => 'radio',
                'question' => '4. 截至2016年底，您企业开办了多少年？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('3年以下', '3-5年', '6-10年', '10-20年', '20-30年', '30年以上'),
                'answersNotes' => array()
            ),
            'profit_status' => array(
                'type' => 'radio',
                'question' => '5. 2016年，您企业的盈利状况如何？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('盈利', '收支平衡', '亏损'),
                'answersNotes' => array()
            ),
            'staff_number' => array(
                'type' => 'radio',
                'question' => '6. 2016年，您企业聘用的专职员工有多少人？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('10人以下', '10-20人', '20-50人', '50-80人', '80-100人', '100人以上'),
                'answersNotes' => array()
            ),
            'fault' => array(
                'type' => 'radio',
                'question' => '7. 2016年，您企业是否遇到过公职人员不当行为？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第11题'),
                'answersJumps' => array('否' => 'fault_items,fault_depts_buies,fault_depts_jobs')
            ),
            'fault_items' => array(
                'type' => 'checkbox',
                'question' => '8. 2016年，您企业遇到的公职人员不当行为包括哪些？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '以无政策依据为由不办事',
                    '严格执行不符合实际的规定',
                    '无理刁难，索要好处',
                    '迫使企业缴纳培训费、咨询费、赞助费等',
                    '迫使企业购买关联企业产品',
                    '要求企业帮助其亲朋好友安排就业岗位',
                    '其他'
                ),
                'answersNotes' => array('迫使企业购买关联企业产品' => '如选此项，必答第9题', '要求企业帮助其亲朋好友安排就业岗位' => '如选此项，必答第10题'),
                'answersRequireds' => array('迫使企业购买关联企业产品' => 'fault_depts_buies', '要求企业帮助其亲朋好友安排就业岗位' => 'fault_depts_jobs')
            ),
            'fault_depts_buies' => array(
                'type' => 'checkbox',
                'question' => '9. 据您了解，2016年哪些部门的公职人员曾要求您企业或其他企业购买关联企业的产品和服务？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(
                    '公安部门', '发改委部门', '环境保护部门', '国土资源部门',
                    '卫生部门', '食药监部门', '防疫部门', '交通运输部门',
                    '住建部门', '水利部门', '农业部门', '教育部门',
                    '民政部门', '商务部门', '文化部门', '工信部门',
                    '工商部门', '税务部门', '人社部门', '科学技术部门',
                    '消防部门', '安监部门', '海关部门', '城市规划部门',
                    '法院', '纪检', '城管部门', '其他'
                ),
                'answersNotes' => array()
            ),
            'fault_depts_jobs' => array(
                'type' => 'checkbox',
                'question' => '10. 据您了解，2016年哪些部门的公职人员曾要求您企业或其他企业为他的亲朋好友安排就业岗位？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(
                    '公安部门', '发改委部门', '环境保护部门', '国土资源部门',
                    '卫生部门', '食药监部门', '防疫部门', '交通运输部门',
                    '住建部门', '水利部门', '农业部门', '教育部门',
                    '民政部门', '商务部门', '文化部门', '工信部门',
                    '工商部门', '税务部门', '人社部门', '科学技术部门',
                    '消防部门', '安监部门', '海关部门', '城市规划部门',
                    '法院', '纪检', '城管部门', '其他'
                ),
                'answersNotes' => array()
            ),
            'baffle' => array(
                'type' => 'radio',
                'question' => '11. 2016年，您企业在与政府部门打交道时是否遇到令您为难的事情？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第14题'),
                'answersJumps' => array('否' => 'baffle_event,baffle_depts')
            ),
            'baffle_event' => array(
                'type' => 'checkbox',
                'question' => '12. 2016年，您企业在与政府部门打交道时遇到的最令您为难的事是哪件？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '没有明确适用的政策法规，相关政府部门不给处置意见',
                    '相关政策法规（劳动合同、环境保护、金融等）不符合实际情况，公职人员强行执行',
                    '政策规定有空间，办事人员过严理解政策，增加企业负担',
                    '不同部门的政策规定之间有矛盾，部门之间互相推诿扯皮',
                    '与政策无关，就是办事人员想要好处',
                    '与政策无关，办事人员工作作风拖沓',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'baffle_depts' => array(
                'type' => 'checkbox',
                'question' => '13. 2016年，最令您为难的事涉及哪些政府部门？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '公安部门', '发改委部门', '环境保护部门', '国土资源部门',
                    '卫生部门', '食药监部门', '防疫部门', '交通运输部门',
                    '住建部门', '水利部门', '农业部门', '教育部门',
                    '民政部门', '商务部门', '文化部门', '工信部门',
                    '工商部门', '税务部门', '人社部门', '科学技术部门',
                    '消防部门', '安监部门', '海关部门', '城市规划部门',
                    '法院', '纪检', '城管部门', '其他'
                ),
                'answersNotes' => array()
            ),
            'policysupport' => array(
                'type' => 'radio',
                'question' => '14. 2016年，您企业是否获得过正当的政策性倾斜？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('申请的都获得了', '申请多项多次，很少成功', '申请过，都没有成功', '从未申请过'),
                'answersNotes' => array(
                    '申请的都获得了' => '17题不答',
                    '从未申请过' => '若选此项，请跳答17题'
                ),
                'answersJumps' => array(
                    '申请的都获得了' => 'policysupport_failcause',
                    '从未申请过' => 'policysupport_benefit,policysupport_depts'
                )
            ),
            'policysupport_benefit' => array(
                'type' => 'radio',
                'question' => '15. 2016年，您企业为争取正当的政策性倾斜是否需要给公职人员“好处”？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('没有给好处', '有些给好处，有些没给', '都给了好处'),
                'answersNotes' => array('没有给好处' => '如选此项，请跳答第18题'),
                'answersJumps' => array('没有给好处' => 'policysupport_depts')
            ),
            'policysupport_depts' => array(
                'type' => 'checkbox',
                'question' => '16. 2016年，为获得正当的政策性倾斜，您企业曾经给哪些政府部门公职人员“好处”？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '公安部门', '发改委部门', '环境保护部门', '国土资源部门',
                    '卫生部门', '食药监部门', '防疫部门', '交通运输部门',
                    '住建部门', '水利部门', '农业部门', '教育部门',
                    '民政部门', '商务部门', '文化部门', '工信部门',
                    '工商部门', '税务部门', '人社部门', '科学技术部门',
                    '消防部门', '安监部门', '海关部门', '城市规划部门',
                    '法院', '纪检', '城管部门', '其他'
                ),
                'answersNotes' => array()
            ),
            'policysupport_failcause' => array(
                'type' => 'checkbox',
                'question' => '17. 您企业没有获得政策性倾斜的原因是什么？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '不需要政策支持，没有申请',
                    '政府部门没有熟人，没有申请',
                    '不知道有什么政策性倾斜',
                    '政策搞不懂，中介费又太高，没有申请',
                    '申请过，好处给少了，没有批准',
                    '申请过，不符合条件，没有批准',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'gift' => array(
                'type' => 'radio',
                'question' => '18. 2016年，您企业逢年过节时，是否给公职人员赠送礼品礼金？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第21题'),
                'answersJumps' => array('否' => 'gift_officers,gift_officers_change')
            ),
            'gift_officers' => array(
                'type' => 'radio',
                'question' => '19. 2016年，您企业逢年过节时，给多少位公职人员赠送了礼品礼金？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('20人以下', '20-50人', '50-100人', '100-200人', '200人以上'),
                'answersNotes' => array()
            ),
            'gift_officers_change' => array(
                'type' => 'radio',
                'question' => '20. 相比2015年，您企业2016年赠送礼品礼金的公职人员数量有没有变化？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('没有变化', '人数减少了', '人数增加了'),
                'answersNotes' => array()
            ),
            'gift_need' => array(
                'type' => 'radio',
                'question' => '21. 您企业2016年在办理企业经营关键事务时是否需要赠送公职人员礼品礼金？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第23题'),
                'answersJumps' => array('否' => 'gift_includes')
            ),
            'gift_includes' => array(
                'type' => 'checkbox',
                'question' => '22. 2016年，需要赠送公职人员礼品礼金才能办好的关键事务，包括哪些？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '涉及行业准入许可',
                    '涉及土地使用权',
                    '涉及环保达标事务',
                    '涉及企业资金事务',
                    '涉及质检和技术标准事务',
                    '涉及出入关事务',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'situation' => array(
                'type' => 'radio',
                'question' => '23. 您企业2016年在办理各类审批和申报手续时遇到的情形是哪种？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '都很顺利 ',
                    '企业符合条件，但有熟人关系的部门办理顺利，没有熟人的部门不顺利',
                    '有的手续因政策限制，即使在有熟人关系的部门也没有办成'
                ),
                'answersNotes' => array()
            ),
            'conduct' => array(
                'type' => 'checkbox',
                'question' => '24. 据您了解，在2016年，公职人员的哪些行为，导致企业去政府部门办事难？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '公职人员故意为难，索要好处',
                    '公职人员不敢要好处，找各种借口拖延，消极怠工',
                    '没有清晰的政策依据，公职人员不愿担责，推动问题的解决',
                    '公职人员与企业对政策的理解有分歧',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'check_condition' => array(
                'type' => 'checkbox',
                'question' => '25. 2016年，除了企业自身出现事故之外，在什么情况下公职人员会上门检查您企业？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '政府出台新政策时，检查新政策执行情况',
                    '某些部门（包括税收、消防、环保、质检等）定期常规性检查',
                    '本行业有别的企业发生重大事故时，对行业进行普查',
                    '企业自身没有发生事故但有关于企业的投诉时',
                    '公职人员以检查为名索要好处',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'check_frequency' => array(
                'type' => 'radio',
                'question' => '26. 您的企业2016年在一个月内最多曾接待多少批次公职人员的检查？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('零批次', '5批次以下', '5-10批次', '11-20批次', '21-30批次', '30批次以上'),
                'answersNotes' => array('零批次' => '若选此项，请跳答第29题'),
                'answersJumps' => array('零批次' => 'check_depts,check_gift_case')
            ),
            'check_depts' => array(
                'type' => 'checkbox',
                'question' => '27. 2016年，经常来企业上门检查的是哪些政府部门的人员？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '公安部门', '发改委部门', '环境保护部门', '国土资源部门',
                    '卫生部门', '食药监部门', '防疫部门', '交通运输部门',
                    '住建部门', '水利部门', '农业部门', '教育部门',
                    '民政部门', '商务部门', '文化部门', '工信部门',
                    '工商部门', '税务部门', '人社部门', '科学技术部门',
                    '消防部门', '安监部门', '海关部门', '城市规划部门'
                ),
                'answersNotes' => array()
            ),
            'check_gift_case' => array(
                'type' => 'checkbox',
                'question' => '28. 2016年，公职人员上门检查时，您企业赠送礼品礼金的情况是什么？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '给第一次上门的人员送见面礼',
                    '来检查人员的级别较高时送人情礼',
                    '逢年过节时送过节礼',
                    '视检查内容而定',
                    '只要来检查，就要送点，不能让人空手回',
                    '没有赠送过',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'punish_reason' => array(
                'type' => 'checkbox',
                'question' => '29. 您企业和您了解的其他企业，2016年，公职人员检查后，如要处罚企业，最常见的原由和情况是什么？',
                'questionNote' => '，最多选三题',
                'questionRequired' => true,
                'answers' => array(
                    '企业管理不严，存在违规问题',
                    '相关政策法规和技术标准，不符合实际情况',
                    '政策规定有空间，公职人员过严理解和执行政策',
                    '企业无过错，公职人员偏袒另一相关方',
                    '企业无过错，就是公职人员想要好处',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'punish_way' => array(
                'type' => 'checkbox',
                'question' => '30. 您企业和您了解的其他企业，2016年，被查出问题后想整改过关，最常采用的方式是什么？',
                'questionNote' => '，最多选三题',
                'questionRequired' => true,
                'answers' => array(
                    '企业依照政策规定自我纠正，再次检查通过',
                    '赠送相关公职人员礼品礼金',
                    '缴纳罚款',
                    '购买公职人员推荐的仪器、设备、材料等',
                    '为公职人员亲属朋友安排就业岗位',
                    '请党政法等部门的官员帮助协调',
                    '关门了事，重新注册企业',
                    '赠送干股（含间接赠送）',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'disturb' => array(
                'type' => 'radio',
                'question' => '31. 2016年，您企业所在的社区或村（含他们主办的企业园区）的工作人员，是否有干扰企业经营的不当行为？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第33题'),
                'answersJumps' => array('否' => 'disturb_reason,disturb_solution')
            ),
            'disturb_reason' => array(
                'type' => 'checkbox',
                'question' => '32. 社区或村（含他们主办的企业园区）给企业运行造成困难的不当行为中，最常见的原由和情形包括？',
                'questionNote' => '，最多选三题',
                'questionRequired' => true,
                'answers' => array(
                    '想大幅提高房租、管理费、垃圾处理费等费用',
                    '想要企业安排就业岗位',
                    '想要企业资助各类社会活动',
                    '想索要礼品礼金',
                    '想引进新企业而挤走老企业',
                    '换届后新班子想要重新订立合同',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'disturb_solution' => array(
                'type' => 'checkbox',
                'question' => '33. 您企业一般是采用哪些方式解决了社区或村（含他们主办的企业园区）给企业运行造成的困难的？',
                'questionNote' => '，最多选三题',
                'questionRequired' => true,
                'answers' => array(
                    '给社区或村交钱',
                    '赠送主管人员和具体工作人员礼品礼金',
                    '找党政法部门高职位官员打招呼协调',
                    '聘任社区或村有影响力的人担任高管',
                    '给他们的亲属或村民安排一般就业岗位',
                    '重新订立合同',
                    '企业搬迁，更换地址',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'feedback' => array(
                'type' => 'radio',
                'question' => '34. 2016年，您是否曾经向政府有关部门（包括人大、党委、政府、政协、纪检监察等部门）反映过公职人员的不当行为？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('是', '否'),
                'answersNotes' => array('否' => '若选此项，请跳答第37题'),
                'answersJumps' => array('否' => 'feedback_effect,feedback_result'),
                'answersRequireds' => array('否' => 'feedback_opposite')
            ),
            'feedback_effect' => array(
                'type' => 'radio',
                'question' => '35. 您的反映行为产生了什么样的效果？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('石沉大海，没有任何效果', '有关部门已经受理，目前还没有明确反馈', '本人和企业受到了一定的打击报复', '已经产生积极效果'),
                'answersNotes' => array('已经产生积极效果' => '若选此项，请续答第36题'),
                'answersJumps' => array(
                    '石沉大海，没有任何效果' => 'feedback_result',
                    '有关部门已经受理，目前还没有明确反馈' => 'feedback_result',
                    '本人和企业受到了一定的打击报复' => 'feedback_result'
                )
            ),
            'feedback_result' => array(
                'type' => 'checkbox',
                'question' => '36. 您的反映行为所产生的积极效果主要包括哪些？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '促进了问题的解决',
                    '促进了本企业所在行业相同问题的解决',
                    '促进了有关政策的改进',
                    '促进有关部门公职人员作风转变',
                    '有关公职人员的问题得到了处置',
                    '更多的企业经营者敢于向政府有关部门如实反映问题',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'feedback_opposite' => array(
                'type' => 'checkbox',
                'question' => '37. 您为什么没有向有关政府部门反映公职人员的不当行为？',
                'questionNote' => '',
                'questionRequired' => false,
                'answers' => array(
                    '没有时间去反映',
                    '不知道通过什么渠道反映',
                    '觉得反映了也没用',
                    '觉得这些问题对企业影响不大',
                    '担心遭到报复',
                    '没有发现或不存在不当行为，不用反映',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'tax_care' => array(
                'type' => 'radio',
                'question' => '38. 据您了解，周边企业是否普遍存在避税和争取税务人员“关照”的现象？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('普遍存在', '大多数存在', '半数存在', '少数存在', '不存在'),
                'answersNotes' => array('不存在' => '若选此项，请跳答第40题'),
                'answersJumps' => array('不存在' => 'tax_care_reason')
            ),
            'tax_care_reason' => array(
                'type' => 'checkbox',
                'question' => '39. 您认为，企业避税和争取税务人员“关照”的原因是什么？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array(
                    '税种过多，总体税负太高',
                    '政府税收目标不合理，只增不降，应该随经济形势波动',
                    '企业主的纳税意识差',
                    '税务人员工作作风差，普遍索要好处',
                    '其他'
                ),
                'answersNotes' => array()
            ),
            'tax_upper_limit' => array(
                'type' => 'radio',
                'question' => '40. 您认为，您企业可以承受多高的增值税税率，不会给经营造成困难？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('17%', '13%', '11%', '6%', '免税', '其他'),
                'answersNotes' => array()
            ),
            'association' => array(
                'type' => 'radio',
                'question' => '41. 您所属行业在当地是否成立了行业协会，您是否加入了协会？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('不知道有没有成立', '没有成立', '成立了，但我没加入', '成立了，我已加入'),
                'answersNotes' => array()
            ),
            'association_useful' => array(
                'type' => 'radio',
                'question' => '42. 您认为加入行业协会，对您经营企业是否有用？',
                'questionNote' => '',
                'questionRequired' => true,
                'answers' => array('没用', '有用'),
                'answersNotes' => array()
            ),
            'association_aspect' => array(
                'type' => 'checkbox',
                'question' => '43. 您认为行业协会应该在哪些方面更好地发挥作用？',
                'questionNote' => '，最多选三题',
                'questionRequired' => true,
                'answers' => array(
                    '为会员提技术、信息等服务',
                    '为会员提供政策咨询',
                    '加强行业与政府的沟通',
                    '加强行业内部监督和自律建设',
                    '维护行业内部公正',
                    '协调行业内部企业之间关系',
                    '其他'
                ),
                'answersNotes' => array()
            ),
        );
        return $options;
    }

}
