<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%policy}}".
 *
 * @property int $id
 * @property string $name
 * @property string $date_created
 *
 * @property Record[] $records
 */
class Policy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%policy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date_created'], 'required'],
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
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['pr_option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */    
    public static function findByCode($code=null) {

        $type = self::find()->where(["code" => $code])->one();

        return (count($type)) ? $type : null;

    }      
}
