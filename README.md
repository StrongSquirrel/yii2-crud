# Yii2 CRUD

CRUD extension for Yii2.

## Installation

Run the [Composer](http://getcomposer.org/download/) command to install the latest stable version:

```
composer require strongsquirrel/yii2-crud @stable
```

The extension has a base functional for creating CRUD with the following actions:

* `index`: list of models
* `create`: create a model
* `update`: update a model
* `delete`: delete a model
* `view`: view a model
* `search`: search models

## Usage

### Simple way

Just create controller and change a parent to `strongsquirrel\crud\CrudController` or use a special trait:

```php
class AwesomeController extends YourController
{
   use strongsquirrel\crud\CrudTrait;
}
```

### IndexAction

Declare the following in your controller:

```php
use strongsquirrel\crud\IndexAction;

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

View file `index.php`:

```php
echo GridView::widget([
    'dataProvider' => $dataProvider,
]);
```

### CreateAction

Declare the following in your controller:

```php
use strongsquirrel\crud\CreateAction

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

View file `create.php`:

```php
$form = ActiveForm::begin();
echo $form->field($model, 'title');
ActiveForm::end();
```

### UpdateAction

Declare the following in your controller:

```php
use strongsquirrel\crud\UpdateAction

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

View file `update.php`:

```php
$form = ActiveForm::begin();
echo $form->field($model, 'title');
ActiveForm::end();
```

### DeleteAction

Declare the following in your controller:

```php
use strongsquirrel\crud\DeleteAction

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

Declare the following in your controller:

```php
use strongsquirrel\crud\ViewAction

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

View file `view.php`:

```php
echo DetailView::widget([
    'model' => $model,
]);
```

### SearchAction

Declare the following in your controller:

```php
use strongsquirrel\crud\SearchAction

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

Add search method to your class model:

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

View file `search.php`:

```php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
]);
```

## License

The MIT License (MIT).
See [LICENSE.md](https://github.com/StrongSquirrel/yii2-crud/blob/master/LICENSE.md) for more information.
