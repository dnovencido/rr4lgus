<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordinances';
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];

?>
<div class="ordinance-index">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">          
            <h2>List of <?= $this->title ?> </h2>
            <div class="float-right">
                <?= Html::a('Add Ordinance', ['create'], ['class' => 'btn btn-success']) ?>
            </div>              
        </div>
        <div class="card-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'ordinance_res_no',
                    'title',
                    'eff_date_pass',


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
        </div> <!-- /.card-body-->
    </div> <!-- /.card card-default -->
</div> <!-- /.ordinance-index -->
