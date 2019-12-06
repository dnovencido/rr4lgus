<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegulatoryIssuanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issuances';
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-issuance-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2><?= $this->title ?> </h2>
            <div class="float-right">
                <?= Html::a('Add issuance', ['create'], ['class' => 'btn btn-success']) ?>
            </div>            
        </div> <!-- /.card-header --> 
        <div class="card-body">
            <div class="search-issuances">
                <h5> Search Issuances</h5> 
                <hr>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="list-issuances mt-5">
                <h5> List of Issuances </h5> 
                <hr>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'issuanceNo',
                        [
                            'attribute' => 'issuanceTitle',
                            'format' => 'raw',
                            'value' => function($data){
                                return '<div class="ellipsis-title">'.$data->issuanceTitle.'</div>';
                            }
                        ], 
                        'levelMap',
                        'policyOptName',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Actions',
                            'template' => '{view} {update} {delete}',
                            'buttons'  => [
                                'view'   => function ($url, $model) {
                        
                                    return Html::a('<button type="button" class="mb-1 btn btn-sm btn-outline-primary"><i class=" mdi mdi-eye-outline mr-1"></i>View</button>', $url, ['view' => $model->id]);
                                },
                                'update' => function ($url, $model) {
        
                                    return Html::a('<button type="button" class="mb-1 btn btn-sm btn-outline-info"><i class=" mdi mdi-lead-pencil mr-1"></i> Edit</button>', $url, ['title' => 'update']);
                                },
                                'delete' => function ($url, $model) {
                                
                                    return Html::a('<button type="button" class="mb-1 btn btn-sm btn-outline-danger"><i class=" mdi mdi-trash-can mr-1"></i> Delete</button>', $url, [
                                        'title'        => 'delete',
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method'  => 'post',
                                    ]);
                                },
                            ]
                        ]
                    ],
                ]); ?>            
            </div>
        </div>
    </div> <!-- /.card-body -->
</div><!-- /.regulatory-issuance-index -->
