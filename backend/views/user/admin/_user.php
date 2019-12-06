<?php

use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;

/**
 * @var yii\widgets\ActiveForm 		$form
 * @var niksko12\user\models\User 	$user
 */
$this->registerJs($this->render('../../js/admin-registration.js'));
?>

<h4>User Details</h4>
                <div class='row'>
                    <div class='col-md-6'>
                        <?php
                        if(!Yii::$app->controller->module->generalApp){
                        ?>
                        <?= $form->field($user, 'EMP_N')->textInput(['placeholder'=>'Employee ID No.']); ?>
                        <?php 
                            $designationsurl = \yii\helpers\Url::to(['designation/designation-list']);
                            $servicesurl = \yii\helpers\Url::to(['service/service-list-office']);
                            $divisionsurl = \yii\helpers\Url::to(['division/division-list-office']);
                            $sectionurl = \yii\helpers\Url::to(['section/section-list-office']);

                            echo $form->field($userinfo, 'OFFICE_C')->widget(Select2::classname(), [
                                'data' => $offices,
                                'options' => ['placeholder' => 'Office','multiple' => false,],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'pluginEvents'=>[
                                    'select2:select'=>'
                                        function(){
                                            var vals = this.value;
                                            $.ajax({
                                                url: "'.$designationsurl.'",
                                                data: {office:vals},
                                                beforeSend: function() {
                                                    $(".designation-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                                                  },
                                                
                                            }).done(function(result) {
                                                $(".designation-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Designation", allowClear: true});
                                                $(".designation-select").select2("val","");
                                            });
                                            $.ajax({
                                                url: "'.$servicesurl.'",
                                                data: {office:vals},
                                                beforeSend: function() {
                                                    $(".service-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                                                  },
                                                
                                            }).done(function(result) {
                                                $(".service-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Service", allowClear: true,});
                                                $(".service-select").select2("val","");
                                            });
                                            $.ajax({
                                                url: "'.$divisionsurl.'",
                                                data: {office:vals},
                                                beforeSend: function() {
                                                    $(".division-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                                                  },
                                                
                                            }).done(function(result) {
                                                var h;
                                                $(".division-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Division", allowClear: true,});
                                                $(".division-select").select2("val","");
                                            });
                                            $.ajax({
                                                url: "'.$sectionurl.'",
                                                data: {office:vals},
                                                beforeSend: function() {
                                                    $(".section-select").html("").select2({ theme:"krajee", width:"100%",placeholder:"Loading..."});
                                                  },
                                                
                                            }).done(function(result) {
                                                var h;
                                                $(".section-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Section", allowClear: true,});
                                                $(".section-select").select2("val","");
                                            });
                                        }'

                                ]
                            ])->label(false);
                        }
                        ?>

                        <?php 
                        $provincesurl = \yii\helpers\Url::to(['province/province-list']);
                        echo $form->field($userinfo, 'REGION_C')->widget(Select2::classname(), [
                            'data' => $regions,
                            'options' => ['placeholder' => 'Region','multiple' => false,'class'=>'region-select'],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                            'pluginEvents'=>[
                                'select2:select'=>'
                                    function(){
                                        var vals = this.value;
                                        $.ajax({
                                            url: "'.$provincesurl.'",
                                            data: {region:vals}
                                            
                                        }).done(function(result) {
                                            var h;
                                            $(".province-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Province",
   allowClear: true,});
                                            $(".province-select").select2("val","");
                                        });
                                    }'

                            ]
                        ]);

                      
                        $citymunsurl = \yii\helpers\Url::to(['citymun/citymun-list']);
                        echo $form->field($userinfo, 'PROVINCE_C')->widget(Select2::classname(), [
                            'data' => $provinces,
                            'options' => ['placeholder' => 'Province','multiple' => false,'class'=>'province-select'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'pluginEvents'=>[
                                'select2:select'=>'
                                    function(){
                                        var vals = this.value;
                                        $.ajax({
                                            url: "'.$citymunsurl.'",
                                            data: {province:vals}
                                            
                                        }).done(function(result) {
                                            var h;
                                            $(".citymun-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"City/Municipality",
   allowClear: true,});
                                            $(".citymun-select").select2("val","");
                                        });
                                    }'

                            ]
                        ]);

                        


                        $barangaysurl = \yii\helpers\Url::to(['barangay/barangay-list']);
                        echo $form->field($userinfo, 'CITYMUN_C')->widget(Select2::classname(), [
                            'data' => $citymuns,
                            'options' => ['placeholder' => 'City/Municipality','multiple' => false,'class'=>'citymun-select'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'pluginEvents'=>[
                                'select2:select'=>'
                                    function(){
                                        var vals = this.value;
                                        var prov = $(".province-select").val();
                                        $.ajax({
                                            url: "'.$barangaysurl.'",
                                            data: {province:prov, citymun:vals}
                                            
                                        }).done(function(result) {
                                            var h;
                                            $(".barangay-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Barangay",
   allowClear: true,});
                                            $(".barangay-select").select2("val","");
                                        });
                                    }'

                            ]
                        ])->label(false);

                        echo $form->field($userinfo, 'BARANGAY_C')->widget(Select2::classname(), [
                            'data' => $barangays,
                            'options' => ['placeholder' => 'Barangay','multiple' => false,'class'=>'barangay-select'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);

                        ?>

                        <?php
							if(Yii::$app->getModule('user')->intranetMode == true){						
								echo $form->field($userinfo, 'PARENT_ID')->widget(Select2::classname(), [
									'data' => $users,
									'options' => ['placeholder' => 'Parent Account','multiple' => false],
									'pluginOptions' => [
										'allowClear' => true
									]
								]);
							}
                        ?>
                    </div>
                    <div class='col-md-6'>
                        <?= $form->field($userinfo, 'FIRST_M')->textInput(['placeholder'=>'First Name']); ?>
                        <?= $form->field($userinfo, 'MIDDLE_M')->textInput(['placeholder'=>'Middle Name']); ?>
                        <?= $form->field($userinfo, 'LAST_M')->textInput(['placeholder'=>'Last Name']); ?>
                        <?= $form->field($userinfo, 'SUFFIX')->textInput(['placeholder'=>'Suffix']); ?>
                        <?= $form->field($userinfo, 'BIRTH_D')->widget(
                                DatePicker::className(), [
                                    // inline too, not bad
                                    // 'inline' => true, 
                                    // modify template for custom rendering
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                    ]);?>
                        <?=
                            $form->field($userinfo, 'SEX_C')->widget(Select2::classname(), [
                                'data' => ['Male'=>'Male','Female'=>'Female'],
                                'options' => ['placeholder' => 'Sex','multiple' => false],
                                'pluginOptions' => [
                                    'allowClear' => false
                                ]
                            ]);
                        ?>
                        <?= $form->field($userinfo, 'MOBILEPHONE')->textInput(['placeholder'=>'Mobile No']); ?>
                    </div>
                </div>
                <?php
                if(!Yii::$app->controller->module->generalApp){
                ?>
                <hr>
                <div class="row ">
                    
                <div class='col-md-6 <?= Yii::$app->controller->action->id == 'update' ? 'hidden' : '' ?>'>
                <?= $form->field($designationhistory, 'DESIGNATION_C')->widget(Select2::classname(), [
                        'data' => $designations,
                        'options' => ['placeholder' => 'Designation','multiple' => false,'class'=>'designation-select'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                <?php 
                $divisionsurl = \yii\helpers\Url::to(['division/division-list']);
                echo $form->field($servicehistory, 'SERVICE_C')->widget(Select2::classname(), [
                    'data' => $services,
                    'options' => ['placeholder' => 'Service','multiple' => false,'class'=>'service-select'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var vals = this.value;
                                $.ajax({
                                    url: "'.$divisionsurl.'",
                                    data: {service:vals}
                                    
                                }).done(function(result) {
                                    var h;
                                    $(".division-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Division", allowClear: true,});
                                    $(".division-select").select2("val","");
                                });
                            }'

                    ]
                ]);
                ?>

                <?php 
                    $sectionsurl = \yii\helpers\Url::to(['section/section-list']);
                    echo $form->field($divisionhistory, 'DIVISION_C')->widget(Select2::classname(), [
                        'data' => $divisions,
                        'options' => ['placeholder' => 'Division','multiple' => false,'class'=>'division-select'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                        'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    var vals = this.value;
                                    $.ajax({
                                        url: "'.$sectionsurl.'",
                                        data: {division:vals}
                                        
                                    }).done(function(result) {
                                        var h;
                                        $(".section-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Section", allowClear: true,});
                                        $(".section-select").select2("val","");
                                    });
                                }'
                        ]
                    ]);
                    ?>
                
                </div>

                <div class='col-md-6'>
                <div class="<?= Yii::$app->controller->action->id == 'update' ? 'hidden' : '' ?>">
                <?php 
                    echo $form->field($sectionhistory, 'SECTION_C')->widget(Select2::classname(), [
                        'data' => $sections,
                        'options' => ['placeholder' => 'Section','multiple' => false,'class'=>'section-select'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                ?>
                </div>
                
                <?php
                    echo $form->field($userinfo, 'EMP_STATUS')->widget(Select2::classname(), [
                            'data' => $emp_status,
                            'options' => ['placeholder' => 'Employment status','multiple' => false,'class'=>'emp=status-select'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);
                ?>

                <div id="position-div" class="<?= Yii::$app->controller->action->id == 'update' ? 'hidden' : '' ?>">
                <?php
                    echo $form->field($positionhistory, 'POSITION_C')->widget(Select2::classname(), [
                        'data' => $positions,
                        'options' => ['placeholder' => 'Position','multiple' => false,'class'=>'position-select'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                    
                </div>
                </div>
                <?php } ?>
                <hr>
                <h4>Account Details</h4>
                <div class="row">
                
                    <div class="col-md-12">
                        <?= $form->field($user, 'email')->textInput(['placeholder'=>'Email']); ?>

                        <?= $form->field($user, 'username')->textInput(['placeholder'=>'Username', 'disabled'=>(Yii::$app->getModule('user')->intranetMode == true) ? false : true]); ?>

                        <?= $form->field($user, 'password')->passwordInput() ?>
                    </div>
                </div>


