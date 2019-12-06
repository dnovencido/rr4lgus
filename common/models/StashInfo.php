<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stash_info".
 *
 * @property int $id
 * @property string $filename
 * @property string $date_created
 *
 * @property Stash[] $stashes
 */
class StashInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stash_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filename'], 'required'],
            [['id'], 'integer'],
            [['date_created'], 'safe'],
            [['filename'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStashes()
    {
        return $this->hasMany(Stash::className(), ['stash_info_id' => 'id']);
    }
}
