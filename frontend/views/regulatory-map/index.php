<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegulatoryMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stocktaking Tool';
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-map-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2><?= $this->title ?> </h2>
            <div class="float-right">
               
            </div>            
        </div><!-- .card-header -->    
        <div class="card-body">

            <div class="regulatory-map-search">
                <h4><i class="mdi mdi-magnify"></i> Search</h4>
                <div class="mt-3"><?= $this->render('_search', ['model' => $searchModel]); ?></div>
            </div>

            <div class="regulatory-map-tool-bar">
                <h4><i class="mdi mdi-toolbox-outline"></i> Toolbar </h4>
                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                    <?= Html::a('<i class="mdi mdi-plus"></i> Add Ordinance/Resolution', ['create'], ['class' => 'btn btn-light btn-md btn-toolbar']) ?>
                    <?= Html::a('<i class="mdi mdi-refresh"></i> Refresh', ['#'], ['class' => 'btn btn-light btn-md btn-toolbar btn-refresh-reg-map']) ?>
                    <?= Html::a('<i class="mdi mdi-cloud-upload"></i> Upload', ['upload'], ['class' => 'btn btn-light btn-md btn-toolbar']) ?>
                </div>
            </div>
            
            <hr class="mt-4">

            <div class="regulatory-map-list-verified">
                
                <div class="regulatory-map-list-header">
                    <span>
                        <h4><i class="mdi mdi-database"></i> Inventory </h4>
                        <i class="mdi mdi-information-variant"></i> This contains only verified issuances and ordinances.
                    </span>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                        'class' => 'table-responsive mt-4',
                    ],                   
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'policyCodeNo',
                        [
                            'attribute' => 'titleIssOrd',
                            'format' => 'raw',
                            'value' => function($data){
                                return '<div class="ellipsis-title">'.$data->titleIssOrd.'</div>';
                            }
                        ], 
                        // 'regionM',
                        // 'provinceM',
                        // 'cityMunM',
                        'sector_id',
                        'typeName',

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
                    ]
                ]); ?>            
            </div>
        </div>
    </div>
</div>
