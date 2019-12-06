<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulatory-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="status-ordinance-issuance">
        
        <h5> 1. Status of existing ordinances/issuances</h5> 
        <hr>

        <div class="row mt-4">
            <div class="col-md-4">
                <?= $form->field($model, 'policy_code_no')->textInput() ?>
            </div> 
            <div class="col-md-4">
                <?= $form->field($model, 'date_of_approval')->widget(
                    DatePicker::className(), [
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'options'=>['placeholder'=>' Select date of approval'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'endDate' => "0d"
                        ]
                    ]);
                ?> 
            </div>      
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'title')->textArea(['rows' => 3]) ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
                        'data' => $selection_list['types'],
                        'options' => ['placeholder' => 'Select type...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>        
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'legal_bases')->textArea(['rows' => 3]) ?>
            </div>
        </div>  
        <div class="row mt-3">
            <div class="col-md-4">
                <?= $form->field($model, 'sector_id')->widget(Select2::classname(), [
                        'data' => $selection_list['sectors'],
                        'options' => ['placeholder' => 'Select sector...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>               
    </div>

    <div class="impact-to-stakeholder mt-4">

        <h5> 2. Impact to Stakeholder </h5> 
        <hr>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'coverage_id')->widget(Select2::classname(), [
                        'data' => $selection_list['coverages'],
                        'options' => ['placeholder' => 'Select coverage...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'measure_id')->widget(Select2::classname(), [
                        'data' => $selection_list['measures'],
                        'options' => ['placeholder' => 'Select measure...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>

    <div class="status-of-regulations mt-4">

        <h5> 3. Status of Regulations for Repeal/Amend/Consolidate </h5> 
        <hr>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'policy_id')->widget(Select2::classname(), [
                        'data' => $selection_list['policies'],
                        'options' => ['placeholder' => 'Select policy option...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>          
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'reasfpol')->textArea(['rows' => 3]) ?>
            </div>        
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'new_polissce')->textArea(['rows' => 3]) ?>
            </div>        
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?= $form->field($model, 'remarks')->textArea(['rows' => 3]) ?>
            </div>        
        </div>                
    </div>

    <div class="form-group mt-3 float-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
