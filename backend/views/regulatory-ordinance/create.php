<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinance */

$this->title = 'Create Regulatory Ordinance';
$this->params['breadcrumbs'][] = ['label' => 'Regulatory Ordinances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['template' => "<li class='breadcrumb-item'>{link}</li>", 'label' => $this->title ];
?>
<div class="regulatory-ordinance-create">
    <div class="card card-default">
        <div class="card-header card-header-border-bottom"> 
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'policyOptions' => $policyOptions
            ]) ?>
        </div>
    </div> <!--/.card -->
</div> <!--/.regulatory-ordinance-create -->
