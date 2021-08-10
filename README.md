# yii2-widget-advanced-linkpager
AdvancedLinkPager widget for Yii Framework 2.0

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
