<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css',
        'https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet',
        'https://fonts.googleapis.com/css?family=Merriweather&display=swap" rel="stylesheet',
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'plugins/toaster/toastr.min.css',
        'plugins/nprogress/nprogress.css',
        'plugins/flag-icons/css/flag-icon.min.css',
        'plugins/jvectormap/jquery-jvectormap-2.0.3.css',
        'plugins/ladda/ladda.min.css',
        // 'plugins/select2/css/select2.min.css',
        // 'plugins/daterangepicker/daterangepicker.css',
        'css/sleek/sleek.css',
        'css/site.css'
    ];
    public $js = [
        'plugins/nprogress/nprogress.js',
        'plugins/toaster/toastr.min.js',
        'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'plugins/slimscrollbar/jquery.slimscroll.min.js',
        'plugins/charts/Chart.min.js',
        'plugins/ladda/spin.min.js',
        'plugins/ladda/ladda.min.js',
        // 'plugins/jquery-mask-input/jquery.mask.min.js',
        // 'plugins/select2/js/select2.min.js',
        'plugins/jvectormap/jquery-jvectormap-2.0.3.min.js',
        'plugins/jvectormap/jquery-jvectormap-world-mill.js',
        'plugins/daterangepicker/moment.min.js',
        // 'plugins/daterangepicker/daterangepicker.js',
        'plugins/jekyll-search.min.js',
        'js/sleek/sleek.js',
        'js/sleek/chart.js',
        'js/sleek/map.js',
        'js/Dashboard.js',
        'js/Events.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
