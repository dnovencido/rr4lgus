<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use niksko12\user\widgets\Connect;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Sign In';

?>

<div class="container d-flex flex-column justify-content-between vh-100">
    <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-10">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="app-brand">
                        <a href="/index.html">
                            <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                                viewBox="0 0 30 33">
                                <g fill="none" fill-rule="evenodd">
                                    <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                                    <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                                </g>
                            </svg>
                            <span class="brand-name">DILG-ARTA RRIS</span>
                        </a><!-- /#index.html -->  
                    </div><!-- /.app-brand -->                  
                </div><!-- /.card-header bg-primary -->
                <div class="card-body p-5">
                    <h4 class="text-dark mb-5">Login as Administrator</h4>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ]) ?>
                        <div class="row">

                            <?= $form->field($model, 'login', ['options' => ['class' => 'form-group col-md-12 mb-2']], ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control input-lg', 'tabindex' => '1', 'autocomplete'=>'off']])->label('Username') ?>

                            <?= $form->field($model, 'password',['options' => ['class' => 'form-group col-md-12']], ['inputOptions' => ['class' => 'form-control input-lg', 'tabindex' => '2']])->passwordInput()->label(Yii::t('user', 'Password') . ($module->enablePasswordRecovery ? ' (' . Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '6']) . ')' : '')) ?>
     
                            <?php if($model->scenario == 'attempt'): ?>
                                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                    'captchaAction' => '/user/security/captcha',
                                    'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>',
                                    'options' => ['class' => 'form-control', 'tabindex' => '3']
                                ])?>
                            <?php endif; ?> <!-- /$if-->

                            <div class="col-md-12">
                                <div class="d-flex my-2 justify-content-between">
                                    <div class="d-inline-block mr-3">
                                        <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4'])->label('Remember me <div class="control-indicator"></div>', ['class' => 'control control-checkbox']) ?>
                                    </div><!-- /.d-inline-block mr-3 --> 
                                </div><!-- /.d-flex my-2 justify-content-between --> 

                                <!-- Submit -->
                                <?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-lg btn-primary btn-block mb-4', 'tabindex' => '5']) ?>

                                <!--Confirmation -->
                                <?php if ($module->enableConfirmation): ?>
                                    <p class="mb-3">
                                        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                                    </p>    
                                <?php endif ?> <!-- /$enableConfirmation -->   
                                
                                <!-- Registration -->
                                <?php if ($module->enableRegistration): ?>
                                    <p class="mb-3">
                                        <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                                    </p>
                                <?php endif ?><!-- /$enableRegistration -->   

                            </div><!-- /.col-md-12 -->                         
                        </div><!-- /.row -->
                        <?php ActiveForm::end(); ?> <!-- /$form -->   
                </div><!-- /.card-body p-5 -->
            </div><!-- /.card -->
        </div><!-- /.col-xl-5 col-lg-6 col-md-10 -->
    </div><!-- /.row -->
</div><!-- /.container -->