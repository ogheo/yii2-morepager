# yii2-morepager  [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE) [![Scrutinizer](https://img.shields.io/scrutinizer/g/ogheo/yii2-morepager.svg?style=flat-square)](https://scrutinizer-ci.com/g/ogheo/yii2-morepager/)

Pagination widget for yii2 that load and append data via ajax request.

## Install

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

try

```
composer require "ogheo/yii2-morepager:*"
```

or add

```
"ogheo/yii2-morepager": "*"
```

to the require section of your `composer.json` file.

## Configure

Add the following code to the ListView:

```
ListView::widget([
    // ...
    'pager' => [
        'class' => 'ogheo\morepager\Pager',
        'contentSelector' => '#comments-list'
    ],
    // ...
])
```

or use it as a widget:

```
use ogheo\morepager\Pager;

echo Pager::widget([
    'pagination' => $pagination,
    'contentSelector' => '#comments-list',
    'onLoad' => new JsExpression("function () {alert('onLoad');}"),
    'onAfterLoad' => new JsExpression("function () {alert('onAfterLoad');}"),
]);
```

Keep in mind that pager widget should pe placed inside contentSelector tag.

Enjoy ;)


                        
                        