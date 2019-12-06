<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],  
    ],
    'modules' => [
        'user' => [
            'class' => 'niksko12\user\Module',
            'admins' => ['dnovencido'],
            'enableFlashMessages' => false,
            'modelMap' => [
                'User' => [
                    'class' => 'common\models\User',
                ],
            ],            
        ],   
        'rbac' => [
            'class' => 'niksko12\rbac\Module',
        ],    
        'auditlogs' => [
            'class' => 'niksko12\auditlogs\Module',
        ],            
    ]
];
