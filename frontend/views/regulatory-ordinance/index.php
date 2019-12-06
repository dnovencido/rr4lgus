<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RegulatoryOrdinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordinances';
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="record-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom">
            <h2><?= $this->title ?> </h2>
        </div>    
        <div class="card-body">       
            <div class="search-ordinances">
                <h5> Search </h5> 
                <hr>
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="regulatory-ordinance-tool-bar mt-4">
                <h4><i class="mdi mdi-toolbox-outline"></i> Toolbar </h4>
                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                    <?= Html::a('<i class="mdi mdi-plus"></i> Add Ordinance', ['create'], ['class' => 'btn btn-light btn-md btn-toolbar']) ?>
                </div>
            </div>             
            <div class="list-ordinances mt-4">
                <h5> List of Ordinances </h5> 
                <hr>
                <?= GridView::widget([
                    'id' => 'regulatory-ordinance',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'ordinanceResNo',
                        [
                            'attribute' => 'ordinanceTitle',
                            'format' => 'raw',
                            'value' => function($data){
                                return '<div class="ellipsis-title">'.$data->ordinanceTitle.'</div>';
                            }
                        ], 
                        'levelMap',
                        'policyOptionName',
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
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div> <!-- /.record-index -->

