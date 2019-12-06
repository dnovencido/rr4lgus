<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "affected_agency_level".
 *
 * @property int $id
 * @property int $regulatory_ordinance_id
 * @property int $ordinance_id
 *
 * @property Ordinance $ordinance
 * @property RegulatoryOrdinance $regulatoryOrdinance
 */
class AffectedAgencyLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'affected_agency_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regulatory_ordinance_id', 'ordinance_id'], 'required'],
            [['regulatory_ordinance_id', 'ordinance_id'], 'integer'],
            [['ordinance_Id'], 'exist', 'skipOnError' => true, 'targetClass' => Ordinance::className(), 'targetAttribute' => ['ordinance_Id' => 'id']],
            [['regulatory_ordinance_id'], 'exist', 'skipOnError' => true, 'targetClass' => RegulatoryOrdinance::className(), 'targetAttribute' => ['regulatory_ordinance_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regulatory_ordinance_id' => 'Regulatory Ordinance ID',
            'ordinance_id' => 'Ordinance ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdinance()
    {
        return $this->hasOne(Ordinance::className(), ['id' => 'ordinance_Id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatoryOrdinance()
    {
        return $this->hasOne(RegulatoryOrdinance::className(), ['id' => 'regulatory_ordinance_id']);
    }
}
