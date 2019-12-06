<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\RegulatoryMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="regulatory-map-form-upload-form">
    <div id="drop_file_zone">
        <div id="drag_upload_file">
            <p>Drop file here</p>
            <p>
                or
            </p>
            <p>
                <input id="select-file" type="button" value="Select File" class="mb-1 btn btn-primary">
            </p>
            <input type="file" id="selectfile">
        </div>
    </div>
</div>
