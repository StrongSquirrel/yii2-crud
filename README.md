# Yii2 Actions

CRUD actions extension for Yii2.

## Installation

Run the [Composer](http://getcomposer.org/download/) command to install the latest stable version:

```
composer require strongsquirrel/yii2-actions @stable
```

## Actions

* `IndexAction`
* `CreateAction`
* `UpdateAction`
* `DeleteAction`
* `ViewAction`
* `SearchAction`

## Usage

### IndexAction

Just declare it in your controller:

```php
use strongsquirrel\actions\IndexAction;

public function actions()
{
    return [
        'index' => [
            'class' => IndexAction::className(),
            'modelClass' => MyModel::className(),
            'view' => 'index', // by default
            // 'prepareDataProvider' => [$this, 'prepareDataProvider'],
            // 'checkAccess' => [$this, 'checkAccess'],
        ],
    ];
}
```

View:

```php
echo GridView::widget([
    'dataProvider' => $dataProvider,
]);
```

### CreateAction

Just declare it in your controller:

```php
use strongsquirrel\actions\CreateAction

public function actions()
{
    return [
        'create' => [
            'class' => CreateAction::className(),
            'modelClass' => MyModel::className(),
            'scenario' => MyModel::SCENARIO_DEFAULT, // by default
            'view' => 'create', // by default
            // 'findModel' => [$this, 'findModel'],
            // 'checkAccess' => [$this, 'checkAccess'],
            // 'afterSave' => [$this, 'onAfterSave'],
        ],
    ];
}
```

View:

```php
$form = ActiveForm::begin();
echo $form->field($model, 'title');
ActiveForm::end();
```

### UpdateAction

Just declare it in your controller:

```php
use strongsquirrel\actions\UpdateAction

public function actions()
{
    return [
        'update' => [
            'class' => UpdateAction::className(),
            'modelClass' => MyModel::className(),
            'scenario' => MyModel::SCENARIO_DEFAULT, // by default
            'view' => 'update', // by default
            // 'findModel' => [$this, 'findModel'],
            // 'checkAccess' => [$this, 'checkAccess'],
            // 'afterUpdate' => [$this, 'onAfterSave'],
        ],
    ];
}
```

View:

```php
$form = ActiveForm::begin();
echo $form->field($model, 'title');
ActiveForm::end();
```

### DeleteAction

Just declare it in your controller:

```php
use strongsquirrel\actions\DeleteAction

public function actions()
{
    return [
        'delete' => [
            'class' => DeleteAction::className(),
            'modelClass' => MyModel::className(),
            // 'findModel' => [$this, 'findModel'],
            // 'checkAccess' => [$this, 'checkAccess'],
            // 'afterDelete' => [$this, 'onAfterDelete'],
        ],
    ];
}
```

### ViewAction

Just declare it in your controller:

```php
use strongsquirrel\actions\ViewAction

public function actions()
{
    return [
        'view' => [
            'class' => ViewAction::className(),
            'modelClass' => MyModel::className(),
            'view' => 'view', // by default
            // 'findModel' => [$this, 'findModel'],
            // 'checkAccess' => [$this, 'checkAccess'],
        ],
    ];
}
```

View:

```php
echo DetailView::widget([
    'model' => $model,
]);
```

### SearchAction

Just declare it in your controller:

```php
use strongsquirrel\actions\SearchAction

public function actions()
{
    return [
        'index' => [
            'class' => SearchAction::className(),
            'modelClass' => MySearchModel::className(),
            'scenario' => MySearchModel::SCENARIO_DEFAULT, // by default
            'view' => 'search', // by default
            'formMethod' => SearchAction::FORM_METHOD_GET, // by default
            'searchMethod' => 'search', // by default
            'searchOptions' => [], // by default
            // 'checkAccess' => [$this, 'checkAccess'],
        ],
    ];
}
```

In your search model:

```php
class MySearchModel extends Model
{
    // ...
    
    /**
     * The search method.
     * Should return an instance of [[DataProviderInterface]].
     *
     * @param array $options your search options
     *
     * @return ActiveDataProvider
     */
    public function search(array $options = [])
    {
        $query = MyModel::find();
        if ($this->validate()) {
            $query->filterWhere($this->getAttributes());
        }
        
        if (!empty($options['active'])) {
            $query->andWhere(['status' => MyModel::STATUS_ACTIVE]);
        }
        
        return new ActiveDataProvider(['query' => $query]);
    }
}
```

View:

```php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
]);
```

## License

The MIT License (MIT).
See [LICENSE.md](https://github.com/StrongSquirrel/yii2-actions/blob/master/LICENSE.md) for more information.
