<?php



use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use yii\captcha\Captcha;
use kartik\icons\FontAwesomeAsset;
FontAwesomeAsset::register($this);
/**
 * @var yii\web\View              $this
 * @var niksko12\user\models\User $user
 * @var niksko12\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs($this->render('../../js/registration.js'));
?>
<div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
        <div class="col-xl-12 col-lg-9 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="app-brand">
                        <a href="/index.html">
                        <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30"
                            height="33" viewBox="0 0 30 33">
                            <g fill="none" fill-rule="evenodd">
                            <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                            <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                            </g>
                        </svg>
                        <span class="brand-name">DILG-ARTA RRIS</span>
                        </a>
                    </div>                        
                </div><!-- /.card-header  -->
                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">Sign Up</h4>
                    <!-- Form -->
                    <?php $form = ActiveForm::begin([
                        'id'                     => 'registration-form',
                        'enableAjaxValidation'   => true,
                        'enableClientValidation' => false,
                    ]); ?>
                        <!-- Personal-info -->
                        <div class="personal-info">
                            <h5>Personal Details</h5>
                            <div class="row mt-3">
                                <div class='col-md-3 mb-3'>
                                    <?= $form->field($model, 'FIRST_M')->textInput(['placeholder'=>'First Name'])->label(false); ?>   
                                </div><!-- /.col-md-4 -->
                                <div class='col-md-3'>
                                    <?= $form->field($model, 'MIDDLE_M')->textInput(['placeholder'=>'Middle Name'])->label(false); ?>
                                </div>
                                <div class='col-md-3'>
                                    <?= $form->field($model, 'LAST_M')->textInput(['placeholder'=>'Last Name'])->label(false); ?>

                                </div>
                                <div class='col-md-3'>
                                    <?= $form->field($model, 'SUFFIX')->textInput(['placeholder'=>'Suffix'])->label(false); ?>
                                </div>                                                 
                            </div><!-- /.row-->
                            <div class='row'>
                                <div class='col-md-3'>
                                        <?= $form->field($model, 'BIRTH_D')->widget(
                                            DatePicker::className(), [
                                                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                                                'options'=>['placeholder'=>'Birth Date'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'format' => 'yyyy-mm-dd',
                                                        'endDate' => "0d"
                                                    ]
                                                ])->label(false);
                                            ?>   
                                </div><!-- /.col-md-3-->             
                                <div class='col-md-3'>
                                    <?=
                                        $form->field($model, 'SEX_C')->widget(Select2::classname(), [
                                            'data' => ['Male'=>'Male','Female'=>'Female'],
                                            'options' => ['placeholder' => 'Sex','multiple' => false, 'class' => 'input-lg'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ]
                                        ])->label(false);
                                    ?>
                                    <?php $form->field($model, 'SEX_C')->dropDownList(['Male'=>'Male','Female'=>'Female'],['prompt'=>'Sex'])->label(false); ?>
                                </div> <!-- /.col-md-3-->  
                                <div class='col-md-3'>
                                    <?= $form->field($model, 'MOBILEPHONE')->textInput(['placeholder'=>'Mobile No'])->label(false); ?>
                                </div><!-- /.col-md-3--> 
                                <?php
                                    if(!Yii::$app->controller->module->generalApp){
                                        ?>
                                        <div class='col-md-3'>
                                            <?= $form->field($model, 'EMP_N')->textInput(['placeholder'=>'Employee ID No.'])->label(false); ?>  
                                        </div>
                                    <?php } ?>                                                                                                          
                            </div><!-- /.row-->                        
                        </div><!-- /.personal-info -->                            

                        <hr>
                        <div class="office-info">
                            <h5>Office Details</h5>
                            <?php if(!Yii::$app->controller->module->generalApp) { ?>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <?php 
                                            $designationsurl = \yii\helpers\Url::to(['designation/designation-list']);
                                            $divisionsurl = \yii\helpers\Url::to(['division/division-list-office']);
                                            $sectionurl = \yii\helpers\Url::to(['section/section-list-office']);

                                            echo $form->field($model, 'OFFICE_C')->widget(Select2::classname(), [
                                                'data' => $offices,
                                                'options' => ['placeholder' => 'Office','multiple' => false,],
                                                'pluginOptions' => [
                                                    'allowClear' => true,

                                                ],
                                                'pluginEvents'=>[
                                                    'select2:select'=>'
                                                        function(){
                                                            var vals = this.value;
                                                            $.ajax({
                                                                url: "'.$designationsurl.'",
                                                                data: {office:vals},
                                                                beforeSend: function() {
                                                                    $(".designation-select").html("").select2({theme:"krajee-bs4", width:"100%",placeholder:"Loading..."});
                                                                },
                                                                
                                                            }).done(function(result) {
                                                                $(".designation-select").html("").select2({theme:"krajee-bs4", data:result, width:"100%",placeholder:"Designation", allowClear: true,});
                                                                $(".designation-select").select2("val","");
                                                            });
                                                            $.ajax({
                                                                url: "'.$divisionsurl.'",
                                                                data: {office:vals},
                                                                beforeSend: function() {
                                                                    $(".division-select").html("").select2({theme:"krajee-bs4", width:"100%",placeholder:"Loading..."});
                                                                },
                                                                
                                                            }).done(function(result) {
                                                                var h;
                                                                $(".division-select").html("").select2({theme:"krajee-bs4", data:result, width:"100%",placeholder:"Division", allowClear: true,});
                                                                $(".division-select").select2("val","");
                                                            });
                                                            $.ajax({
                                                                url: "'.$sectionurl.'",
                                                                data: {office:vals},
                                                                beforeSend: function() {
                                                                    $(".section-select").html("").select2({theme:"krajee-bs4", width:"100%",placeholder:"Loading..."});
                                                                },
                                                                
                                                            }).done(function(result) {
                                                                var h;
                                                                $(".section-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"Section", allowClear: true,});
                                                                $(".section-select").select2("val","");
                                                            });
                                                        }'

                                                ]
                                            ])->label(false);
                                        ?>                                        
                                    </div><!-- /.col-md-3 -->   
                                    <div class='col-md-3'>
                                        <?= $form->field($model, 'DESIGNATION_C')->widget(Select2::classname(), [
                                            'data' => $designations,
                                            'options' => ['placeholder' => 'Designation','multiple' => false,'class'=>'designation-select'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                            ])->label(false);
                                        ?>
                                    </div><!-- /.col-md-3 -->  
                                    <div class='col-md-3' >
                                        <?= $form->field($model, 'EMP_STATUS')->widget(Select2::classname(), [
                                            'data' => $emp_status,
                                            'options' => ['placeholder' => 'Employment status','multiple' => false,'class'=>'emp=status-select'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                            ])->label(false);
                                        ?>
                                    </div><!-- /.col-md-3 -->  
                                    <div class='col-md-3' id="position-div">
                                        <?= $form->field($model, 'POSITION_C')->widget(Select2::classname(), [
                                                'data' => $positions,
                                                'options' => ['placeholder' => 'Position','multiple' => false,'class'=>'position-select'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);
                                        ?>
                                    </div><!-- /.col-md-3 -->                                                                                                         
                                </div><!-- /.row -->   
                                <div class="row mt-3">
                                    <div class='col-md-6'>
                                        <?php 
                                            $divisionsurl = \yii\helpers\Url::to(['division/division-list']);
                                            echo $form->field($model, 'SERVICE_C')->widget(Select2::classname(), [
                                                'data' => $services,
                                                'options' => ['placeholder' => 'Service/Bureau','multiple' => false,'class'=>'service-select'],
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
                                                                    $(".division-select").html("").select2({ theme:"krajee-bs4", width:"100%",placeholder:"Loading..."});
                                                                },
                                                                
                                                            }).done(function(result) {
                                                                var h;
                                                                $(".division-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"Division", allowClear: true,});
                                                                $(".division-select").select2("val","");
                                                            });
                                                        }'

                                                ]
                                            ])->label(false);
                                        ?>
                                    </div><!-- /.col-md-6 -->    
                                    <div class='col-md-3'>
                                        <?php 
                                        $sectionsurl = \yii\helpers\Url::to(['section/section-list']);
                                        echo $form->field($model, 'DIVISION_C')->widget(Select2::classname(), [
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
                                                            data: {division:vals},
                                                            beforeSend: function() {
                                                                $(".section-select").html("").select2({ theme:"krajee-bs4", width:"100%",placeholder:"Loading..."});
                                                            },
                                                            
                                                        }).done(function(result) {
                                                            var h;
                                                            $(".section-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"Section", allowClear: true,});
                                                            $(".section-select").select2("val","");
                                                        });
                                                    }'
                                            ]
                                        ])->label(false);
                                        ?>
                                    </div><!-- /.col-md-3 -->  
                                    <div class='col-md-3'>
                                        <?php 
                                            echo $form->field($model, 'SECTION_C')->widget(Select2::classname(), [
                                                'data' => $sections,
                                                'options' => ['placeholder' => 'Section','multiple' => false,'class'=>'section-select'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);
                                        ?>
                                    </div>                                                                                                   
                                </div><!-- /.row -->
                            <?php } ?><!-- /$generalApp -->  
                            <div class="row mt-3">
                                <div class='col-md-3'>
                                    <?php 
                                    $provincesurl = \yii\helpers\Url::to(['province/province-list']);
                                    echo $form->field($model, 'REGION_C')->widget(Select2::classname(), [
                                        'data' => $regions,
                                        'options' => ['placeholder' => 'Region','multiple' => false,'class'=>'region-select'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            /*'ajax'=>[
                                                        'url'=>$url,
                                                        'dataType' => 'json',
                                                        'data' => new JsExpression('function(params) { alert(params);}')
                                                    ],*/
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

                                                        /*for(var i=0; i<result.length; i++){
                                                            var id = result[i].id;
                                                            var text = result[i].text;
                                                            h+="<option value=\'"+id+"\' >"+text+"</option>";
                                                        }*/
                                                    // 
                                                    // $("#province-select").select2("destroy");
                                                        $(".province-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"Province", allowClear: true,});
                                                        $(".province-select").select2("val","");
                                                    });
                                                }'

                                        ]
                                    ])->label(false);
                                    ?>
                                </div><!-- /.col-md-3 -->
                                <div class='col-md-3'>
                                    <?php 
                                    $citymunsurl = \yii\helpers\Url::to(['citymun/citymun-list']);
                                    echo $form->field($model, 'PROVINCE_C')->widget(Select2::classname(), [
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

                                                        /*for(var i=0; i<result.length; i++){
                                                            var id = result[i].id;
                                                            var text = result[i].text;
                                                            h+="<option value=\'"+id+"\' >"+text+"</option>";
                                                        }*/
                                                    // 
                                                    // $("#province-select").select2("destroy");
                                                        $(".citymun-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"City/Municipality", allowClear: true,});
                                                        $(".citymun-select").select2("val","");
                                                    });
                                                }'

                                        ]
                                    ])->label(false);
                                    ?>
                                </div><!-- /.col-md-3 --> 
                                <div class="col-md-3">
                                    <?php 
                                    $citymunsurl = \yii\helpers\Url::to(['barangay/barangay-list']);
                                    echo $form->field($model, 'CITYMUN_C')->widget(Select2::classname(), [
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
                                                        url: "'.$citymunsurl.'",
                                                        data: {citymun:vals,province:prov}
                                                        
                                                    }).done(function(result) {
                                                        var h;
                                                        $(".barangay-select").html("").select2({ data:result, theme:"krajee-bs4", width:"100%",placeholder:"Barangay", allowClear: true,});
                                                        $(".barangay-select").select2("val","");
                                                    });
                                                }'

                                        ]
                                    ])->label(false);
                                    ?>                               
                                </div><!-- /.col-md-3 -->         
                                <div class='col-md-3'>
                                    <?php 
                                        echo $form->field($model, 'BARANGAY_C')->widget(Select2::classname(), [
                                            'data' => $citymuns,
                                            'options' => ['placeholder' => 'Barangay','multiple' => false,'class'=>'barangay-select'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false);

                                    ?>
                                </div><!-- /.col-md-3 -->                                                                                  
                            </div><!-- /.row -->                                
                        </div><!-- /.office-info -->
                        <hr>
                        <div class="account-info">
                            <h5>Account Details</h5>
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email'])->label(false); ?>
                                </div><!-- /.col-sm-4 -->
                                <div class="col-sm-4">
                                    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'])->label(false); ?>
                                </div><!-- /.col-sm-4 -->       
                                <div class="col-sm-4">
                                    <?php if ($module->enableGeneratingPassword == false): ?>
                                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false) ?>
                                    <?php endif ?>
                                </div><!-- /.col-sm-4 -->                                                               
                            </div><!-- /.row -->
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                        'captchaAction' => '/user/registration/captcha',
                                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9"><div class="ml-5">{input}</div></div></div>',
                                    ]) ?>                                    
                                </div><!-- /.col-sm-4 -->   
                            </div><!-- /.row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-md btn-success mb-4 float-right']) ?>
                                </div><!-- /.col-sm-4 -->   
                            </div><!-- /.row -->
                        </div><!-- /.account-info -->
                    <?php ActiveForm::end(); ?>
                </div><!-- /.card-body -->
            </div><!-- /.card  -->
        </div><!-- /.col-xl-5  -->
    </div><!-- /.row -->
</div><!-- /.container -->
