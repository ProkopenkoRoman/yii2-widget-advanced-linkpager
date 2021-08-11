<?php

namespace long399\pager;

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Dropdown;

/**
 * Advanced LinkPager widget.
 * Widget includes blocks: [pageButtons], [pageList], [pageSize], [pageJump].
 * You can set the required blocks in [template] property.
 * @author r_prokopenko
 */
class AdvancedLinkPager extends LinkPager
{
    /**
     *  @var string template of widget. 
     *  @example {pageButtons}{pageList}{pageSize}{pageJump}
     */
    public $template = '{pageButtons}{pageJump}';

    /** @var array pageSize items list. */
    public $pageSizeItems = [1, 10, 25];

    /** @var string pageSize label string. */
    public $pageSizeLabel = 'Size';

    /** @var string pageList label string. */
    public $pageListLabel = 'Page';

    /** @var string the CSS class for the pageList. */
    public $pageListCssClass = 'form-control';

    /** @var string the CSS class for the pageSize. */
    public $pageSizeCssClass = 'form-control';

    /**
     * {@inheritDoc}
     * @see \yii\widgets\LinkPager::run()
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        echo Html::beginTag('div', ['class' => 'row']);
            echo Html::beginTag('div', ['class' => 'col-sm-12']);
                echo $this->renderPageContent();
            echo Html::endTag('div');
        echo Html::endTag('div');
    }

    /**
     * Render content according to the template.
     * @return mixed
     */
    protected function renderPageContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            switch ($name) {
                case 'pageJump':    return $this->renderPageJump();
                case 'pageButtons': return $this->renderPageButtons();
                case 'pageSize':    return $this->renderPageSize();
                case 'pageList':    return $this->renderPageList();
                default:            return '';
            }
        }, $this->template);
    }

    /**
     * Render pageList block.
     * @return string
     */
    protected function renderPageList()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $html = Html::beginTag('div', ['class' => 'btn-group dropup', 'style' => 'margin-left: 20px; margin-top: -5px;']);
        $html .= Html::button(
            $this->pageListLabel.' '.Html::tag('span', '', ['class' => 'fa fa-caret-down']),
            ['class' => $this->pageListCssClass, 'data-toggle' => 'dropdown', 'aria-expanded' => false]
        );
        $html .= Dropdown::widget([
            'items' => $this->configurePageListItems(),
            'encodeLabels' => false,
            'options' => [
                'style' => 'height: auto; max-height: 200px; overflow-x: hidden;'
            ]
        ]);
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Render pageSize block.
     * @return string
     */
    protected function renderPageSize()
    {
        $html = Html::beginTag('div', ['class' => 'btn-group dropup', 'style' => 'margin-left: 20px; margin-top: -5px;']);
        $html .= Html::button(
            $this->pageSizeLabel.' '.Html::tag('span', '', ['class' => 'fa fa-caret-down']),
            ['class' => $this->pageSizeCssClass, 'data-toggle' => 'dropdown', 'aria-expanded' => false]
        );
        $html .= Dropdown::widget([
            'items' => $this->configurePageSizeItems(),
            'encodeLabels' => false,
            'options' => [
                'style' => 'height: auto; max-height: 200px; overflow-x: hidden;'
            ]
        ]);
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Render pageJump block.
     * @return string
     */
    protected function renderPageJump()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $html = Html::beginTag('div', ['class' => 'btn-group', 'style' => 'margin-left: 20px; margin-top: -5px;']);
        $html .= Html::textInput(
            'page',
            '',
            [
                'class' => 'form-control',
                'data-toggle' => 'tooltip',
                'title' => 'Введите номер страницы и нажмите Enter',
                'placeholder' => 'Страница',
                'style' => 'height: 30px; width: 85px;'
            ]
        );
        $html .= Html::endTag('div');

        $this->registerJs();

        return $html;
    }

    /**
     * {@inheritDoc}
     * @see \yii\widgets\LinkPager::renderPageButtons()
     */
    protected function renderPageButtons()
    {
        $html = Html::beginTag('div', ['class' => 'btn-group']);
            $html .= parent::renderPageButtons();
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Creates a configuration array for pageList Dropdown items.
     * Refer to description for \yii\bootstrap\Dropdown::$items property.
     * @return array
     */
    protected function configurePageListItems()
    {
        $items = [];
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return $items;
        }
        $currentPage = $this->pagination->getPage();
        // first page
        if ($this->firstPageLabel !== false) {
            $items[] = $this->createPageListItem($this->firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }
        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $items[] = $this->createPageListItem($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }
        // internal pages
        list($beginPage, $endPage) = [0, $this->pagination->getPageCount()-1];
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $items[] = $this->createPageListItem($i + 1, $i, null, false, $i == $currentPage);
        }
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $items[] = $this->createPageListItem($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        // last page
        if ($this->lastPageLabel !== false) {
            $items[] = $this->createPageListItem($this->lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        return $items;
    }

    /**
     * Configure pageList item.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return array
     */
    protected function createPageListItem($label, $page, $class, $disabled, $active)
    {
        $item = ['label' => $label];
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $item['options'] = $options;
            return $item;
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $item['options']     = $options;
        $item['linkOptions'] = $linkOptions;
        $item['url']         = $this->pagination->createUrl($page);
        return $item;
    }

    /**
     * Creates a configuration array for pageSize Dropdown items.
     * Refer to description for \yii\bootstrap\Dropdown::$items property.
     * @return array
     */
    protected function configurePageSizeItems(){
        $items = [];
        $currentPageSize = $this->pagination->getPageSize();
        foreach ($this->pageSizeItems as $item) {
            $items[] = $this->createPageSizeItem($item, $item, null, false, $currentPageSize == $item);
        }
        return $items;
    }

    /**
     * Configure pageSize item.
     * @param string $label the text label for the button
     * @param integer $page the page number
     * @param string $class the CSS class for the page button.
     * @param boolean $disabled whether this page button is disabled
     * @param boolean $active whether this page button is active
     * @return array
     */
    protected function createPageSizeItem($label, $pageSize, $class, $disabled, $active)
    {
        $item = ['label' => $label];
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $item['options'] = $options;
            return $item;
        }
        $linkOptions = $this->linkOptions;
        $item['options']     = $options;
        $item['linkOptions'] = $linkOptions;
        $item['url']         = $this->pagination->createUrl($this->pagination->getPage(),$pageSize);
        return $item;
    }

    /**
     * Register JS-code for pageJump block.
     */
    private function registerJs()
    {
        $url = $this->pagination->createUrl($this->pagination->getPage());
        $jumpToJs = <<<JS
        $('input[name="page"]').on('keydown', function (evt) {
            if (evt.which == 13) {
                var url = "$url";
                var targetPage =  $(this).val();
                var newUrl = url.replace(/([?&]page=)\d{1,}/, "$1"+targetPage);
                window.location.href = newUrl;
            }
        });
JS;
        $this->getView()->registerJs($jumpToJs);
    }
}
