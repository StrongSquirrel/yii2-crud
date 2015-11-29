<?php

namespace strongsquirrel\actions;

use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

/**
 * Class IndexAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\actions
 */
class IndexAction extends Action
{
    /**
     * @var string the name of the view action.
     */
    public $view = 'index';

    /**
     * @var string class name of the model which will be handled by this action.
     * The model class must implement [[ActiveRecordInterface]].
     */
    public $modelClass;

    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     * should return a collection of the models. If not set, [[prepareDataProvider()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return an instance of [[ActiveDataProvider]].
     */
    public $prepareDataProvider;

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
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        if ($this->modelClass === null && $this->prepareDataProvider === null) {
            $className = get_class($this);
            throw new InvalidConfigException("$className::\$modelClass or $className::\$prepareDataProvider must be set.");
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

        return $this->controller->render($this->view, [
            'dataProvider' => $this->prepareDataProvider(),
        ]);
    }

    /**
     * @return ActiveDataProvider
     */
    protected function prepareDataProvider()
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this);
        }

        /** @var \yii\db\ActiveRecordInterface $modelClass */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find(),
        ]);
    }
}
