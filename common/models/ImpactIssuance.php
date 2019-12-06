<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "impact_issuance".
 *
 * @property int $id
 * @property int $regulatory_issuance_id
 * @property int $nature_id
 * @property string $stakeholder
 * @property int $magnitude_id
 * @property string $duration
 */
class ImpactIssuance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'impact_issuance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regulatory_issuance_id'], 'required'],
            [['regulatory_issuance_id', 'nature_id', 'magnitude_id'], 'integer'],
            [['stakeholder'], 'string', 'max' => 155],
            [['duration'], 'string', 'max' => 55],
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
            'nature_id' => 'Nature ID',
            'stakeholder' => 'Stakeholder',
            'magnitude_id' => 'Magnitude ID',
            'duration' => 'Duration',
        ];
    }
}
