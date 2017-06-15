<?php

namespace ogheo\morepager\assets;

use yii\web\AssetBundle;

/**
 * Class PagerAsset
 * @package ogheo\morepager
 */
class PagerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ogheo/yii2-morepager/src/assets/sources/';

    public $css = [
        'css/morepager.css',
    ];

    public $js = [
        'js/morepager.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
