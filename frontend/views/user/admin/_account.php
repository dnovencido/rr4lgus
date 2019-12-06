<?php



use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var niksko12\user\models\User $user
 */

?>

<?php $this->beginContent('@niksko12/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableAjaxValidation'   => true,
    'enableClientValidation' => true,
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'wrapper' => 'col-sm-9',
        ],
    ],
]); ?>

<?= $this->render('_user', 
            ['form'         => $form, 
            'user'          => $user, 
            'userinfo'      => $userinfo, 
            'regions'       => $regions,
            'provinces'     => $provinces,
            'citymuns'      => $citymuns,
            'barangays'      => $barangays,
            'offices'       => $offices,
            'servicehistory' => $servicehistory,
            'divisionhistory' => $divisionhistory,
            'sectionhistory' => $sectionhistory,
            'designationhistory' => $designationhistory,
            'positionhistory' => $positionhistory,
            'services'      => $services,
            'divisions'     => $divisions,
            'sections'      => $sections,
            'positions'     => $positions,
            'designations'  => $designations,
            'emp_status'   => $emp_status,
            'users'   => isset($users) ? $users : [],
			
			]) ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
