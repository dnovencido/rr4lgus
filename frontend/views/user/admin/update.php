<?php



use niksko12\user\models\User;
use yii\bootstrap\Nav;
use yii\web\View;

/**
 * @var View 	$this
 * @var User 	$user
 * @var string 	$content
 */

$this->title = Yii::t('user', 'Update user account: '.$user->userinfo->fullName);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

<?= $this->render('_menu') ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/update', 'id' => $user->id]],
                        ['label' => Yii::t('user', 'Profile details'), 'url' => ['/user/admin/update-profile', 'id' => $user->id]],
                        ['label' => Yii::t('user', 'Information'), 'url' => ['/user/admin/info', 'id' => $user->id]],
                        [
                            'label' => Yii::t('user', 'Assignments'),
                            'url' => ['/user/admin/assignments', 'id' => $user->id],
                            'visible' => (isset(Yii::$app->extensions['niksko12/yii2-rbac']) && !Yii::$app->user->can('RegionalAdministrator')) ? true : false,
                        ],
                        [
                            'label' => Yii::t('user-management', 'Single Sign On'),
                            'url' => ['/user-management/user/update-plugin', 'id' => $user->id],
                            'visible' => isset(Yii::$app->modules['user-management']),
                        ],
                        [
                            'label' => Yii::t('user-management', 'HRIS Profile Link'),
                            'url' => ['/user-management/user/link-plugin', 'id' => $user->id],
                            'visible' => isset(Yii::$app->modules['user-management']),
                        ],
                        '<hr>',
                        ['label' => Yii::t('user', 'Office/Position/Designation History'), 'url' => ['/user/admin/update-user-history', 'id' => $user->id]],

                        '<hr>',
                        [
                            'label' => Yii::t('user', 'Confirm'),
                            'url'   => ['/user/admin/confirm', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('user', 'Resend Confirmation'),
                            'url'   => ['/user/admin/resend-confirmation', 'id' => $user->id],
                            'visible' => !$user->isConfirmed,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Resending confirmation email. Continue?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('user', 'Block'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => !$user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('user', 'Unblock'),
                            'url'   => ['/user/admin/block', 'id' => $user->id],
                            'visible' => $user->isBlocked,
                            'linkOptions' => [
                                'class' => 'text-success',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                            ],
                        ],
                        [
                            'label' => Yii::t('user', 'Delete'),
                            'url'   => ['/user/admin/delete', 'id' => $user->id],
                            'linkOptions' => [
                                'class' => 'text-danger',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('user', 'Are you sure you want to delete this user?'),
                            ],
							'visible' => false
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
