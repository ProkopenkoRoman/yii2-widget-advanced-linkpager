# yii2-widget-advanced-linkpager
AdvancedLinkPager widget for Yii Framework 2.0

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).
Either run

```
 composer require --prefer-dist long399/yii2-widget-advanced-linkpager
```

or add

```
"long399/yii2-widget-advanced-linkpager": "dev-main"
```

to the require section of your `composer.json` file.

Usage
-----
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

Author
-----
[long399](https://github.com/ProkopenkoRoman/), e-mail: [long399@mail.ru](mailto:long399@mail.ru)
