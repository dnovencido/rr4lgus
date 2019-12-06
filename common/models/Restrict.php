<?php

namespace common\models;

use Yii;

/**
 * This is the model class for shared transactions".
 *
 */
class Restrict extends \yii\db\ActiveRecord
{   
    public function owner($searchModel) {

        //Restrict by user and psgc
        // $searchModel->user_id = Yii::$app->user->id;
        $searchModel->level = Yii::$app->user->identity->processType['id'];
        $searchModel->region_c = Yii::$app->user->identity->psgc['region'];
        $searchModel->province_c = Yii::$app->user->identity->psgc['province'];
        $searchModel->citymun_c  = Yii::$app->user->identity->psgc['citymun'];

        return $searchModel->search(Yii::$app->request->queryParams);
    }
}
