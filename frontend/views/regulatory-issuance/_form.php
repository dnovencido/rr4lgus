<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryIssuance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulatory-issuance-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="lgu-info">  
            <h5> 1. LGU Information </h5> 
            <hr>
            <div class="row mt-4">
                <div class="col-md-4">
                    <?= $form->field($model, 'department_office')->textInput() ?>
                </div> <!-- /.col-md-4 -->
                <div class="col-md-4">
                    <?= $form->field($model, 'date_sub')->textInput(['data-mask' => '0000/00/00', 'placeholder' => 'YYYY-MM-DD']) ?> 
                </div> <!-- /.col-md-4 -->
            </div> <!-- /.row  -->
        </div> <!-- /.lgu-info -->
        <div class="issuance-info mt-4"> 
            <h5> 2. Issuance Information</h5> 
            <hr class="separator" />
            <div class="row mt-4">
                <div class="col-md-4">
                    <?= $form->field($model, 'issuance_no')->textInput() ?>
                </div> <!-- /.col-md-4 -->
            </div> <!-- /.row  -->     
            <div class="row mt-4">
                <div class="col-md-12">
                    <?= $form->field($model, 'title')->textArea(['rows' => 6]) ?>
                </div> <!-- /.col-md-4 -->             
            </div> <!-- /.row -->               
            <div class="row mt-4">
                <div class="col-md-12">
                    <?= $form->field($model, 'description')->textArea(['rows' => 6]) ?>
                </div> <!-- /.col-md-4 -->             
            </div> <!-- /.row -->
        </div> <!-- /.issuance-info -->
        <div class="policy-opt-info mt-4"> 
            <h5> 3. Policy option adopted</h5>
            <div class="row mt-3">
                <div class="col-md-12">
                    <?= $form->field($model, 'policy_opt_id')->radioList($listMenu['policyOptions'])->label(false); ?>
                </div> <!-- /.col-md-4 -->             
            </div> <!-- /.row -->
        </div> <!-- /.policy-opt-info -->
        <div class="affected_issuances mt-4"> 
            <h5> 3. List of agency-level issuance(s) it affects</h5>
            <div class="affected-issuance toolbar">
                <div class="btn-group mt-3" role="group">
                    <?= Html::a('<i class="mdi mdi-plus"></i> Browse to add issuance', ['create'], ['class' => 'btn btn-light btn-sm btn-toolbar btn-browse-list-agency-issuance', 'value' => Url::to(['issuance/list'])]) ?>
                </div>
            </div>
            <div class="list-agencies-issuances mt-3">
                <table class="table table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Title</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-issuance-values">
                    </tbody>
                </table>
            </div> <!-- /.list-agencies-issuances  -->
        </div> <!-- /.affected_issuances -->     
        <div class="impact-of-issuance mt-3"> 
            <h5> 4. Impact of New Issuance </h5>
            <div class="impact-of-issuance toolbar">
                <div class="btn-group mt-3" role="group">
                    <?= Html::a('<i class="mdi mdi-plus"></i> Add impact', ['#'], ['class' => 'btn btn-light btn-sm btn-toolbar btn-add-impact-issuance']) ?>
                </div>
            </div>
            <div class="list-impact-issuance mt-4">
                <table class="table table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Stakeholder</th>
                            <th scope="col">Nature</th>
                            <th scope="col">Magnitude</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-impact-values">
                    </tbody>
                </table>            
            </div>
        </div> <!-- /.rationale-->
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'mt-5 btn btn-md btn-success float-right']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <!-- Modal -->
    <div class="modal-ri"></div>  

</div>
