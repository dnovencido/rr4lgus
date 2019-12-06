<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */

$this->title = 'Upload';
$this->params['breadcrumbs'][] = ['label' => 'Stocktaking Tool', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-map-upload">

    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="card-body">
            <?= $this->render('_form-upload') ?>
            <div class="uploaded-entries mt-4">
                <h4>Recently uploaded files. </h4>
                <div class="uploaded-entries-list mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <?php Pjax::begin(['id' => 'uploaded_regulatoy_reforms']) ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'tableOptions' => ['class' => 'table table-responsive'],
                                    'layout' => '{items}{pager}',
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'filename',
                                        'date_created',
                                        [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Actions',
                                            'template' => '{file} {update} {delete}',
                                            'buttons'  => [
                                                'file'   => function ($url, $model) {
                                                    return Html::a('<button type="button" class="mb-1 btn btn-sm btn-outline-primary"><i class=" mdi mdi-eye-outline mr-1"></i>View</button>', $url , ['file' => $model->id]);
                                                },
                                            ]
                                        ]                                
                                    ],
                                ]); ?>  
                            <?php Pjax::end() ?>                         
                        </div>
                    </div>                 
                </div>           
            </div>             
        </div>
    </div> <!--/.card -->
    <div class="modal micromodal-slide" id="modal-search" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container modal-container-sm" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <main class="modal__content" id="modal-1-content">
                    <div class="preview-form-regulatory-map">
                    </div>      
                </main>
                <footer class="modal__footer">
                </footer>
            </div>
        </div>
    </div> <!--/.modal --> 
</div>
