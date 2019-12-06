<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ordinance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ordinance-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->field($model, 'ordinance_res_no')->textInput(['maxlength' => true]) ?>
            </div> <!-- /.col-sm-2-->
            <div class="col-sm-4">
                <?= $form->field($model, 'eff_date_pass')->textInput() ?>
            </div> <!-- /.col-sm-2-->
        </div> <!-- /.row -->
        <div class="row mt-3">
            <div class="col-sm-12">
                <?= $form->field($model, 'title')->textArea(['maxlength' => true, 'rows' => '6']) ?>
            </div> <!-- /.col-sm-2-->
        </div> <!-- /.row -->
        <div class="row mt-3">
            <div class="col-sm-12">
                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            </div> <!-- /.col-sm-2-->
        </div> <!-- /.row -->       

        <div class="form-group mt-3">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success float-right']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div> <!-- /.ordinance-form -->       
