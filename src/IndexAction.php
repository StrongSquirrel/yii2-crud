<?php

namespace strongsquirrel\actions;

use yii\data\ActiveDataProvider;

/**
 * Class IndexAction
 *
 * @package strongsquirrel\actions
 */
class IndexAction extends Action
{
    /**
     * @var string the name of the view action.
     */
    public $view = 'index';

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

        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;

        return new ActiveDataProvider([
            'query' => $modelClass::find(),
        ]);
    }
}
