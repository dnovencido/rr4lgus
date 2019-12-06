<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regulatory Reform Technical Report for Ordinances';
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];

?>
<div class="record-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2><?= $this->title ?> </h2>
            <div class="float-right">
                <?= Html::a('Add ordinance', ['create'], ['class' => 'btn btn-success']) ?>
            </div>            
        </div>    

        <div class="card-body">
            <?= $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'type_id',
                    'ref_id',
                    'infomation_id',
                    'pr_option_id',


                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>
