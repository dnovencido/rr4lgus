<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%information}}".
 *
 * @property int $id
 * @property int $region_c
 * @property int $province_c
 * @property int $citymun_c
 * @property string $department_office
 * @property string $date_created
 * @property string $date_sub
 *
 * @property Record[] $records
 */
class Information extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%information}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'citymun_c'], 'integer'],
            [['date_created', 'date_sub'], 'safe'],
            [['department_office'], 'string', 'max' => 155],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'department_office' => 'Department Office',
            'date_created' => 'Date Created',
            'date_sub' => 'Date Sub',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['infomation_id' => 'id']);
    }
}
