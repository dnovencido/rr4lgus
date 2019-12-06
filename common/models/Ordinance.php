<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Ordinance".
 *
 * @property int $id
 * @property string $ordinance_res_no
 * @property string $title
 * @property string $eff_date_pass
 * @property string $description
 */
class Ordinance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Ordinance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'eff_date_pass', 'description'], 'required'],
            [['eff_date_pass'], 'safe'],
            [['description'], 'string'],
            [['ordinance_res_no'], 'string', 'max' => 50]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ordinance_res_no' => 'Ordinance Res No',
            'title' => 'Title',
            'eff_date_pass' => 'Eff Date Pass',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatoryMap()
    {
        return $this->hasOne(RegulatoryMap::className(), ['ref_id' => 'id']);
    }    
}
