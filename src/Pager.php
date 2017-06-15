<?php

namespace ogheo\morepager;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\data\Pagination;
use yii\base\InvalidConfigException;
use ogheo\morepager\assets\PagerAsset;

/**
 * Class MorePager
 * @package ogheo\morepager
 */
class Pager extends Widget
{
    /**
     * @var
     */
    public $id;

    /**
     * @var string
     */
    public $contentSelector;

    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make LinkPager work.
     */
    public $pagination;
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination'];

    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];

    /**
     * @var bool Hide widget when only one page exist.
     */
    public $hideOnSinglePage = true;

    /**
     * JsExpression
     * @var null
     */
    public $onLoad = null;

    /**
     * JsExpression
     * @var null
     */
    public $onAfterLoad = null;

    /**
     * @var array widget client options
     */
    public $clientOptions = [];

    /**
     * Initializes the pager.
     */
    public function init()
    {
        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }

        if (!isset($this->contentSelector)) {
            throw new InvalidConfigException('The "contentSelector" property must be set.');
        }

        if (!isset($this->id)) {
            $this->id = $this->getId();
            $this->options['id'] = $this->id;
        } else {
            $this->options['id'] = $this->id;
        }

        $this->registerAssets();
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        echo $this->renderPageButton();
    }

    /**
     * @return null|string
     */
    public function renderPageButton()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $pageParam = Yii::$app->request->get($this->pagination->pageParam);
        $nextPage = isset($pageParam) && is_scalar($pageParam) ? $pageParam : $this->pagination->getPage() + 1;
        $endPage = $pageCount;
        $url = [];

        if ($nextPage < $endPage) {
            $url[] = $this->pagination->createUrl($nextPage);
            $button = Html::tag(
                'ul', Html::tag(
                    'li', Html::a(
                        Yii::t('morepager', 'Show more'), null, array_merge(
                            $this->linkOptions, [
                                'data-action' => 'load',
                                'data-url' => Json::encode($url),
                                'data-pjax' => 0,
                            ]
                        )
                    )
                ), $this->options
            );
        } else {
            $button = null;
        }

        return $button;
    }

    /**
     * @return string
     */
    protected function getClientOptions()
    {
        $this->clientOptions['onLoad'] = $this->onLoad;
        $this->clientOptions['onAfterLoad'] = $this->onAfterLoad;
        $this->clientOptions['contentSelector'] = $this->contentSelector;

        return Json::encode($this->clientOptions);
    }

    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        PagerAsset::register($view);
        $view->registerJs("jQuery('#{$this->id}').pager({$this->getClientOptions()});");
    }
}
