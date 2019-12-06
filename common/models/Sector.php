<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sector".
 *
 * @property int $id
 * @property string $name
 * @property string $date_created
 */
class Sector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sector';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_created'], 'safe'],
            [['name'], 'string', 'max' => 155],
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
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */    
    public static function findByCode($code=null) {

        $type = self::find()->where(["code" => $code])->one();

        return (count($type)) ? $type : null;

    }   
}
