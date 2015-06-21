<?php

namespace strongsquirrel\actions;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

/**
 * Class Action
 *
 * @package strongsquirrel\actions
 */
abstract class Action extends \yii\base\Action
{
    /**
     * @var string class name of the model which will be handled by this action.
     * The model class must implement [[ActiveRecordInterface]].
     * This property must be set.
     */
    public $modelClass;

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
     * @var callable
     * The signature of the callable should be as follows,
     *
     * ```php
     * function ($action, $model = null) {
     *     // $model is the requested model instance.
     *     // If null, it means no specific model (e.g. IndexAction)
     * }
     * ```
     */
    public $checkAccess;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
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
