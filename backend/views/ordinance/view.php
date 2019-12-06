<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ordinance */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $model->ordinance_res_no ];
\yii\web\YiiAsset::register($this)
?>
<div class="ordinance-view">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between"> 
            <div class="card-title-header text-nowrap text-truncate"><h4><?= Html::encode($this->title) ?></h4></div>
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    
                    'ordinance_res_no',
                    'title',
                    'eff_date_pass',
                    'description:ntext',
                ],
            ]) ?>
        </div> <!-- /.card-body -->
    </div>  <!-- /.card-default -->
</div> <!-- /.ordinance-view -->