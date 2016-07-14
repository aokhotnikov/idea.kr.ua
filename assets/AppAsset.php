<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.fancybox.css',
        'css/bootstrap-social.css',
        //'css/bootstrap-editable.css',
        'css/select2.min.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.fancybox.pack.js',
        'js/jquery.mCustomScrollbar.concat.min.js',
        'js/jquery.bxslider.min.js',
        'js/jquery.maskedinput.js',
        'js/jquery.royalslider.min.js',
        //'js/bootstrap-editable.min.js',
        'js/select2.min.js',
        'js/i18n/ru.js',
        'js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
