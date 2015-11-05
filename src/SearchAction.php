<?php

namespace strongsquirrel\actions;

use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Class SearchAction
 *
 * @package strongsquirrel\actions
 */
class SearchAction extends Action
{
    const HTTP_METHOD_GET = 'get';
    const HTTP_METHOD_POST = 'post';

    /**
     * @var string
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @var string the name of the view action.
     */
    public $view = 'search';

    /**
     * @var string
     */
    public $httpMethod = self::HTTP_METHOD_POST;

    /**
     * The method should return an instance of [[DataProviderInterface]].
     *
     * @var string
     */
    public $searchMethod = 'search';

    /**
     * @var array
     */
    public $searchOptions = [];

    /**
     * @var string class name of the model which will be handled by this action.
     */
    public $modelClass;

    /**
     * @var callable
     * The signature of the callable should be as follows,
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     */
    public $checkAccess;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->modelClass === null) {
            $className = get_class($this);
            throw new InvalidConfigException("$className::\$modelClass must be set.");
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        list($dataProvider, $filterModel) = $this->prepare();

        return $this->controller->render($this->view, [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
        ]);
    }

    /**
     * @return array [$dataProvider, $filterModel]
     */
    protected function prepare()
    {
        /** @var Model $model */
        $model = new $this->modelClass(['scenario' => $this->scenario]);

        $data = call_user_func([\Yii::$app->request, $this->httpMethod]);
        $model->load($data);

        return [call_user_func([$model, $this->searchMethod], $this->searchOptions), $model];
    }
}
