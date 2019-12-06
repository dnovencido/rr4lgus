<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "magnitude".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $date_created
 *
 * @property ImpactIssuance[] $impactIssuances
 */
class Magnitude extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'magnitude';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 155],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImpactIssuances()
    {
        return $this->hasMany(ImpactIssuance::className(), ['magnitude_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */    
    public static function findByCode($code=null) {

        $type = self::find()->where(["code" => $code])->one();

        return (count($type)) ? $type : null;

    }       
}
