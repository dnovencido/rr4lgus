<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<?= 
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'header' => false,   
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model, $key, $index, $column) {
                    return ['value' => $model->id];
                },
            ],            
            ['class' => 'yii\grid\SerialColumn'],

            'ordinance_res_no',
            [
                'attribute' => 'title',

                'contentOptions' => ['class' => 'list'],
        
            ],              
            'eff_date_pass',
        ]
    ]); 
?>

