<?php

namespace common\models;

use niksko12\user\models\Region;
use niksko12\user\models\Province;
use niksko12\user\models\Citymun;

use Yii;

/**
 * This is the model class for table "{{%record}}".
 *
 * @property int $id
 * @property int $type_id
 * @property int $ref_id
 * @property int $infomation_id
 * @property int $pr_option_id
 * @property string $rationale
 * @property string $date_created
 *
 * @property Infomation $infomation
 * @property Issuance $ref
 * @property Ordinance $ref0
 * @property Policy $prOption
 * @property Type $type
 */
class Record extends \yii\db\ActiveRecord
{

    /**
     * Global
     */

    // Reference from information;
    public $department_office, $date_sub;

    //Reference from ordinance;
    public $ordinance_res_no, $eff_date_pass, $title, $description;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%record}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_office', 'date_sub', 'ordinance_res_no', 'eff_date_pass', 'title'], 'required'],
            [['type_id', 'ref_id', 'information_id', 'pr_option_id'], 'integer'],
            [['rationale', 'ordinance_res_no', 'title', 'description'], 'string'],
            [['date_created', 'eff_date_pass', 'date_sub'], 'safe'],
            [['information_id'], 'exist', 'skipOnError' => true, 'targetClass' => Information::className(), 'targetAttribute' => ['information_id' => 'id']],
            [['ref_id'], 'exist', 'skipOnError' => true, 'targetClass' => Issuance::className(), 'targetAttribute' => ['ref_id' => 'id']],
            [['ref_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordinance::className(), 'targetAttribute' => ['ref_id' => 'id']],
            [['pr_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::className(), 'targetAttribute' => ['pr_option_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'ref_id' => 'Ref ID',
            'infomation_id' => 'Infomation ID',
            'pr_option_id' => 'Pr Option ID',
            'rationale' => 'Rationale',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfomation()
    {
        return $this->hasOne(Infomation::className(), ['id' => 'infomation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRef()
    {
        return $this->hasOne(Issuance::className(), ['id' => 'ref_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRef0()
    {
        return $this->hasOne(Ordinance::className(), ['id' => 'ref_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrOption()
    {
        return $this->hasOne(Policy::className(), ['id' => 'pr_option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
  
}
