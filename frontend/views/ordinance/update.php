<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ordinance */

$this->title = 'Update Issuance: ' . $model->ordinance_res_no;
$this->params['breadcrumbs'][] = ['label' => 'Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ordinance_res_no, 'url' => ['view', 'id' => $model->id]];

?>
<div class="ordinance-update">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h4><?= $this->title ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
