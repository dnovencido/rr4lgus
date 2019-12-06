<?php



use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label'   => Yii::t('user', 'Users'),
            'url'     => ['/user/admin/index'],
        ],
        [
            'label'   => Yii::t('user', 'Roles'),
            'url'     => ['/rbac/role/index'],
            'visible' => (isset(Yii::$app->extensions['niksko12/yii2-rbac']) && (!\Yii::$app->user->can('RegionalAdministrator'))),
        ],
        [
            'label' => Yii::t('user', 'Permissions'),
            'url'   => ['/rbac/permission/index'],
            'visible' => (isset(Yii::$app->extensions['niksko12/yii2-rbac']) && (!\Yii::$app->user->can('RegionalAdministrator'))),
        ],
        [
            'label' => Yii::t('user', 'Create'),
            'items' => [
                [
                    'label'   => Yii::t('user', 'New user'),
                    'url'     => ['/user/admin/create'],
                ],
                [
                    'label' => Yii::t('user', 'New role'),
                    'url'   => ['/rbac/role/create'],
					'visible' => (isset(Yii::$app->extensions['niksko12/yii2-rbac']) && (!\Yii::$app->user->can('RegionalAdministrator'))),
                ],
                [
                    'label' => Yii::t('user', 'New permission'),
                    'url'   => ['/rbac/permission/create'],
					'visible' => (isset(Yii::$app->extensions['niksko12/yii2-rbac']) && (!\Yii::$app->user->can('RegionalAdministrator'))),
                ],
            ],
        ],
        [
            'label' => Yii::t('user', 'Other Settings'),
            'items' => [
                [
                    'label'   => Yii::t('user', 'Service'),
                    'url'     => ['/user/service/index'],
                ],
                [
                    'label' => Yii::t('user', 'Division'),
                    'url'   => ['/user/division/index'],
                ],
                [
                    'label' => Yii::t('user', 'Section'),
                    'url'   => ['/user/section/index'],
                ],
                [
                    'label' => Yii::t('user', 'Designation'),
                    'url'   => ['/user/designation/index'],
                ],
                [
                    'label' => Yii::t('user', 'Position'),
                    'url'   => ['/user/position/index'],
                ],
                [
                    'label' => Yii::t('user', 'Cluster'),
                    'url'   => ['/user/cluster/index'],
                ],
                [
                    'label' => Yii::t('user', 'Assign Cluster'),
                    'url'   => ['/user/cluster-level/index'],
                ],
            ],
        ],
    ],
]) ?>
