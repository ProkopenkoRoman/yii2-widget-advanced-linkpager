# yii2-widget-advanced-linkpager

[![Total Downloads](http://poser.pugx.org/long399/yii2-widget-advanced-linkpager/downloads)](https://packagist.org/packages/long399/yii2-widget-advanced-linkpager)
[![License](http://poser.pugx.org/long399/yii2-widget-advanced-linkpager/license)](https://packagist.org/packages/long399/yii2-widget-advanced-linkpager)

AdvancedLinkPager widget for Yii Framework 2.0

![Screenshot](https://www.cyberforum.ru/blog_attachment.php?attachmentid=7079&d=1628496193 "Screenshot")

## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run

```
 composer require --prefer-dist long399/yii2-widget-advanced-linkpager
```

or add

```json
"long399/yii2-widget-advanced-linkpager": "~0.1"
```

to the require section of your `composer.json` file.


## Usage
view:
```php
echo GridView::widget([
  ...
  'pager' => [
    'class' => AdvancedLinkPager::class,
    'options' => ['class' => 'pagination'],
    'firstPageLabel' => 'начало',
    'lastPageLabel' => 'конец',
    'hideOnSinglePage' => false,

    'template' => '{pageButtons}{pageList}{pageSize}{pageJump}',
    'pageListLabel' => 'Страница',
    'pageListCssClass' => 'btn btn-warning dropdown-toggle',
    'pageSizeLabel' => 'Размер',
    'pageSizeCssClass' => 'btn btn-primary dropdown-toggle',
    'pageSizeItems' => [1, 10, 25, 50, 100],
  ],
  ...
]);
```
 
searchModel:
```php
public function search($params)
{
  ...
  $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10;
  $dataProvider = new ActiveDataProvider([
    'query' => $query,
      'pagination' =>  [
        'pageSize' => $pageSize
      ],
  ]);
  ...
}
```


## Author
[long399](https://github.com/ProkopenkoRoman/), e-mail: [long399@mail.ru](mailto:long399@mail.ru)
