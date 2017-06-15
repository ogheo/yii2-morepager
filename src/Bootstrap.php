<?php

namespace ogheo\morepager;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

/**
 * Class Bootstrap registers translations and needed application components.
 * @package ogheo\comments
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            // register module translations
            if (!isset($app->get('i18n')->translations['morepager*'])) {
                $app->get('i18n')->translations['morepager*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en'
                ];
            }
        }
    }
}
