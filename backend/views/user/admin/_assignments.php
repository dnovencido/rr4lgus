<?php



use niksko12\rbac\widgets\Assignments;

/**
 * @var yii\web\View 				$this
 * @var niksko12\user\models\User 	$user
 */

?>

<?php $this->beginContent('@niksko12/user/views/admin/update.php', ['user' => $user]) ?>

<?= yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert-info',
    ],
    'body' => Yii::t('user', 'You can assign multiple roles or permissions to user by using the form below'),
]) ?>

<?= Assignments::widget(['userId' => $user->id]) ?>

<?php $this->endContent() ?>
