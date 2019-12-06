<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use niksko12\user\widgets\Connect;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Request new confirmation message';

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
                    <h4 class="text-dark mb-5"><?= $this->title ?></h4>
                    <div class="row">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin([
                                'id'                     => 'resend-form',
                                'enableAjaxValidation'   => true,
                                'enableClientValidation' => false,
                            ]); ?>

                            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                'captchaAction' => '/user/registration/captcha',
                                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9"><div class="ml-5">{input}</div></div></div>',
                            ]) ?>

                                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-lg btn-primary btn-block mt-5']) ?><br>

                            <?php ActiveForm::end(); ?>                         
                        </div>                   
                    </div>
                </div><!-- /.card-body p-5 -->
            </div><!-- /.card -->
        </div><!-- /.col-xl-5 col-lg-6 col-md-10 -->
    </div><!-- /.row -->
</div><!-- /.container -->