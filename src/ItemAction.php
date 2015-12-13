<?php

namespace strongsquirrel\crud;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

/**
 * Class ItemAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
abstract class ItemAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @var callable
     * The signature of the callable should be:
     *
     * ```php
     * function ($id, $action) {
     *     // $id is the primary key value.
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the model found, or throw an exception if not found.
     */
    public $findModel;

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->modelClass === null && $this->findModel === null) {
            $className = get_class($this);
            throw new InvalidConfigException("$className::\$modelClass or $className::\$findModel must be set.");
        }

        parent::init();
    }

    /**
     * @param string $id
     *
     * @return ActiveRecordInterface
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if ($this->findModel !== null) {
            $model = call_user_func($this->findModel, $id, $this);
        } else {
            /** @var ActiveRecordInterface $modelClass */
            $modelClass = $this->modelClass;
            $model = $modelClass::findOne($id);
        }

        if (empty($model)) {
            throw new NotFoundHttpException('Object not found.');
        }

        return $model;
    }
}
