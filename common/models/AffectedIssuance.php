<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "affected_issuance".
 *
 * @property int $id
 * @property int $regulatory_issuance_id
 * @property int $issuance_id
 *
 * @property Ordinance $ordinance
 */
class AffectedIssuance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'affected_issuance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regulatory_issuance_id', 'issuance_id'], 'required'],
            [['regulatory_issuance_id', 'issuance_id'], 'integer'],
            [['issuance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordinance::className(), 'targetAttribute' => ['issuance_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regulatory_issuance_id' => 'Regulatory Issuance ID',
            'issuance_id' => 'Ordinance ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinance()
    {
        return $this->hasOne(Ordinance::className(), ['id' => 'issuance_id']);
    }
}
