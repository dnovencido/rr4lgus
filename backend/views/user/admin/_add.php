<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;

/**
 * @var yii\web\View 					$this
 * @var niksko12\user\models\User 		$user
 * @var niksko12\user\models\Profile 	$profile
 */

?>
<?php $this->beginContent('@niksko12/user/views/admin/update.php', ['user' => $user]) ?>
<?php $form = ActiveForm::begin(); ?>
  <h4>Create Additional Information</h4>
  <div class="row">
    <div class="col-md-6">
      <?php
      $divisionsurl = \yii\helpers\Url::to(['division/division-list']);
      echo $form->field($newServiceModel, 'SERVICE_C')->widget(Select2::classname(), [
          'disabled' => $user->userinfo->OFFICE_C != 5 ? true : false,
          'data' => $services,
          'options' => ['placeholder' => 'Service','multiple' => false,'id' => 'new-service-select','options' => [!empty($userService->SERVICE_C) ? $userService->SERVICE_C : '' => ['disabled' => true]]],
          'pluginOptions' => [
              'allowClear' => true,
          ],
          'pluginEvents'=>[
                  'select2:select'=>'
                      function(){
                          var vals = this.value;
                          $.ajax({
                              url: "'.$divisionsurl.'",
                              data: {service:vals},
                              beforeSend: function() {
                                $(".new-division-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                              },
                              
                          }).done(function(result) {
                              var h;
                              $(".new-division-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Division", allowClear: true,});
                              $(".new-division-select").select2("val","");
                          });
                      }'

              ]
      ])->label(false);?>
    </div>

    <div class="col-md-6">
      <?= $form->field($newServiceModel, 'START_DATE')->widget(
          DatePicker::className(), [
              'options'=>['placeholder'=>'Start Date'],
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ]
      ])->label(false);?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
        <?php
        $sectionsurl = \yii\helpers\Url::to(['section/section-list']);
        echo $form->field($newDivisionModel, 'DIVISION_C')->widget(Select2::classname(), [
            'disabled' => $user->userinfo->OFFICE_C != 2 ? false : true,
            'data' => $divisions,
            'options' => ['placeholder' => 'Division','multiple' => false,'class'=>'new-division-select', 'id' => 'new-division-select','options' => [!empty($userDivision->DIVISION_C) ? $userDivision->DIVISION_C : '' => ['disabled' => true]]],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            var vals = this.value;
                            $.ajax({
                                url: "'.$sectionsurl.'",
                                data: {division:vals},
                                beforeSend: function() {
                                $(".new-section-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                              },
                                
                            }).done(function(result) {
                                var h;
                                $(".new-section-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Section", allowClear: true,});
                                $(".new-section-select").select2("val","");
                            });
                        }'
                ]
        ])->label(false);?>
    </div>

    <div class="col-md-6">
      <?= $form->field($newDivisionModel, 'START_DATE')->widget(
          DatePicker::className(), [
              'options'=>['placeholder'=>'Start Date'],
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ]
      ])->label(false);?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($newSectionModel, 'SECTION_C')->widget(Select2::classname(), [
          'disabled' => $user->userinfo->OFFICE_C == '5' || $user->userinfo->OFFICE_C == '2' || $user->userinfo->OFFICE_C == '1' ? false : true,
          'data' => $sections,
          'options' => ['placeholder' => 'Section','multiple' => false,'class'=>'new-section-select','options' => [!empty($userSection->SECTION_C) ? $userSection->SECTION_C : '' => ['disabled' => true]]],
          'pluginOptions' => [
              'allowClear' => true,
          ],
      ])->label(false);?>
    </div>

    <div class="col-md-6">
      <?= $form->field($newSectionModel, 'START_DATE')->widget(
          DatePicker::className(), [
              'options'=>['placeholder'=>'Start Date',],
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ]
      ])->label(false);?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($newDesignationModel, 'DESIGNATION_C')->widget(Select2::classname(), [
          'data' => $designations,
          'options' => ['placeholder' => 'Designation','multiple' => false,'class'=>'new-designation-select', 'id' => 'new-designation-select','options' => [!empty($userDesignation->DESIGNATION_C) ? $userDesignation->DESIGNATION_C : '' => ['disabled' => true]]],
          'pluginOptions' => [
              'allowClear' => true,
          ],
      ])->label(false);?>
    </div>

    <div class="col-md-6">
      <?= $form->field($newDesignationModel, 'START_DATE')->widget(
          DatePicker::className(), [
              'options'=>['placeholder'=>'Start Date'],
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ]
      ])->label(false);?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($newPositionModel, 'POSITION_C')->widget(Select2::classname(), [
          'data' => $positions,
          'options' => ['placeholder' => 'Position','multiple' => false,'class'=>'new-position-select', 'id' => 'new-position-select','options' => [!empty($userPosition->POSITION_C) ? $userPosition->POSITION_C : ''  => ['disabled' => true]]],
          'pluginOptions' => [
              'allowClear' => true,
          ],
      ])->label(false);?>     
    </div>

    <div class="col-md-6">
      <?= $form->field($newPositionModel, 'START_DATE')->widget(
          DatePicker::className(), [
              'options'=>['placeholder'=>'Start Date'],
              'clientOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
              ]
      ])->label(false);?>
    </div>
  </div>

  <div class="form-group" style="text-align: right;">
        <?= Html::submitButton($newServiceModel->isNewRecord ? 'Create' : 'Update', ['class' => $newServiceModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data' => [
                        'confirm' => 'Are you sure you want to save?',
                    ],]) ?>
  </div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
<?php
    $this->registerJs(
        '$("document").ready(function(){  
            $("#modalView").removeAttr("tabindex")

            $("#new-service-select").on("change", function(e) {
                if(this.value != ""){
                    $("#serviceuserhistory-start_date").prop("required",true);
                }
            })


            $("#new-division-select").on("change", function(e) {
                if(this.value != ""){
                    $("#divisionuserhistory-start_date").prop("required",true);
                }
            })

            $("#sectionuserhistory-section_c").on("change", function(e) {
                if(this.value != ""){
                    $("#sectionuserhistory-start_date").prop("required",true);
                }
            })

            $("#new-designation-select").on("change", function(e) {
                if(this.value != ""){
                    $("#designationuserhistory-start_date").prop("required",true);
                }
            })

            $("#new-position-select").on("change", function(e) {
                if(this.value != ""){
                    $("#positionuserhistory-start_date").prop("required",true);
                }
            })



        });'
    );

?>