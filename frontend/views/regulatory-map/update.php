<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */

$this->title = 'Update Regulatory Map: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="regulatory-map-update">
    <div class="card card-default">

        <div class="card-header card-header-border-bottom"> 
            <h2><?= Html::encode($this->title) ?></h2>
        </div><!--/.card-header -->
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'selection_list' => $selection_list
            ]) ?>
        </div><!--/.card-body -->
    </div><!--/.card -->
</div>
