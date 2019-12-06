<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Stash */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stash-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'regulatory_id')->textInput() ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
