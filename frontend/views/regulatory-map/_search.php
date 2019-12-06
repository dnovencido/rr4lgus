<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulatory-map-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ref_id') ?>
            <?= $form->field($model, 'type_id') ?>
        </div><!-- /.col-md-6 -->
    </div><!-- /.row -->

    <hr class="mt-4">

    <?php ActiveForm::end(); ?>
</div>


