<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryOrdinanceSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="regulator-ordinance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'ordinance_res_no') ?>
            <?= $form->field($model, 'title') ?>
        </div><!-- /.col-md-6 -->
        <div class="col-md-6">
            <?= $form->field($model, 'eff_date_pass')->textInput(['data-mask' => '0000/00/00']) ?>   
            <div class="form-group mt-3 float-right">
                <?= Html::submitButton('<i class=" mdi mdi-magnify mr-1"></i> Search', ['class' => 'mb-1 btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'mb-1 btn btn-secondary']) ?>
            </div><!-- /.form-group -->                  
        </div><!-- /.col-md-6 -->
    </div><!-- /.row -->

    <hr class="mt-4">

    <?php ActiveForm::end(); ?>

</div><!-- /.record-search -->
