<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $stashInfo->filename;
$this->params['breadcrumbs'][] = ['label' => 'Stocktaking Tool', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Upload', 'url' => ['upload']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-map-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <div>
                <h2><i class="mdi mdi-google-spreadsheet"></i> <?= $stashInfo->filename ?></h2>
            
                <p class="mt-2">
                    <b>Date uploaded :</b> 
                    <?= $stashInfo->date_created ?>
                </p>        
            </div>
        </div><!-- .card-header -->    
        <div class="card-body">

            <div class="toolbar">
                <h4>Toolbar</h4>
                <div class="btn-group btn-toolbar mt-3">
                    <button id="set-label" class="btn btn-light btn-md btn-toolbar disabled" data-original-title="Label - Ctrl+L" value="VF"><i class="mdi mdi-verified toolbar-menu"></i> Mark as Verified </button>
                    <button id="check-all-selection" class="btn btn-light btn-md btn-toolbar" data-original-title="CheckAll - Ctrl+A"><i class="mdi mdi-check-all toolbar-menu"></i> Check all</button>
                    <button id="uncheck-all-selection" class="btn btn-light btn-md btn-toolbar" data-original-title="Delete - Ctrl+D"><i class="mdi mdi-window-close toolbar-menu"></i> Uncheck</button>
                    <button id="delete-selection" class="btn btn-light btn-md btn-toolbar disabled" data-original-title="Delete - Ctrl+D"><i class="mdi mdi-trash-can-outline toolbar-menu"></i> Delete</button>
                </div>                
            </div>

            <hr class="mt-4">
            
            <div class="list-stash mt-4">
                <?php Pjax::begin(['id' => 'uploaded-file-content']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'class' => 'table-responsive',
                        ],                   
                        'columns' => [
                            [
                                'header' => false,   
                                'class' => 'yii\grid\CheckboxColumn',
                                'checkboxOptions' => function($model, $key, $index, $column) {
                                    return ['value' => $model->regulatory_id];
                                },
                            ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'regulatoryOrdPolicyCodeNo',
                            ],                    
                            [
                                'attribute' => 'regulatoryTitle',
                                'format' => 'raw',
                                'value' => function($data){
                                    return '<div class="ellipsis-title">'.$data->regulatoryTitle.'</div>';
                                }
                            ],                             
                            'date_created',
                            'regulatoryType',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Actions',
                                'template' => '{update}',
                                'buttons'  => [
                                    'update'   => function ($url, $model) {
                                        return Html::a('<button type="button" class="mb-1 btn btn-sm btn-outline-primary btn-update-file-content" value='.Url::to(['update-file-content', 'id'=> $model->regulatory_id]).'><i class=" mdi mdi-eye-outline mr-1"></i>Edit</button>', '#', ['update' => '#']);
                                    }     
                                ]
                            ]                      
                        ],
                        
                    ]); ?>         
                <?php Pjax::end() ?>   
            </div><!-- .list-stash -->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal-st"></div>
</div>
