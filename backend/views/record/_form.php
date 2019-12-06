<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Record */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="lgu-info">  
        <h5> 1. LGU Information </h5> 
        <hr>
        <div class="row mt-4">
            <div class="col-md-4">
                <?= $form->field($model, 'department_office')->textInput() ?>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <?= $form->field($model, 'date_sub')->textInput() ?>
            </div> <!-- /.col-md-4 -->
        </div> <!-- /.row  -->
    </div> <!-- /.lgu-info -->
    <div class="ordinance-info mt-4"> 
        <h5> 2. List of Governing Ordinance that need to be repealed, amended and consolidated</h5> 
        <hr class="separator" />
        <div class="row mt-4">
            <div class="col-md-4">
                <?= $form->field($model, 'ordinance_res_no')->textInput() ?>
            </div> <!-- /.col-md-4 -->
            <div class="col-md-4">
                <?= $form->field($model, 'eff_date_pass')->textInput() ?>
            </div> <!-- /.col-md-4 -->                
        </div> <!-- /.row  -->        
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'title')->textArea(['rows' => 6]) ?>
            </div> <!-- /.col-md-4 -->             
        </div> <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'description')->textArea(['rows' => 6]) ?>
            </div> <!-- /.col-md-4 -->             
        </div> <!-- /.row -->            
    </div> <!-- /.ordinance-info -->
    <div class="policy-opt-info mt-4"> 
        <h5> 2. Policy option adopted</h5>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'pr_option_id')->radioList($policyOptions)->label(false); ?>
            </div> <!-- /.col-md-4 -->             
        </div> <!-- /.row -->
    </div> <!-- /.policy-opt-info -->
    <div class="rationale-info mt-4"> 
        <h5> 2. Policy option adopted</h5>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'rationale')->textArea(['rows' => 6]) ?>
            </div> <!-- /.col-md-4 -->             
        </div> <!-- /.row -->
    </div> <!-- /.rationale-->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'mt-5 btn btn-md btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
