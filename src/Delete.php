<?php

namespace strong_squirrel\actions;

use yii\web\ServerErrorHttpException;

/**
 * Class Delete
 *
 * @package strong_squirrel\actions
 */
class Delete extends Action
{
    /**
     * @var callable
     * The signature of the callable should be:
     *
     * ```php
     * function ($model) {
     *     // $model is the requested model instance.
     *     return $this->redirect(['my-action');
     * }
     * ```
     */
    public $afterDelete;

    /**
     * @param string $id
     *
     * @return mixed
     * @throws ServerErrorHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        $afterDelete = $this->afterDelete;
        if (empty($afterDelete)) {
            $afterDelete = function () {
                return $this->controller->redirect(['index']);
            };
        }

        return call_user_func($afterDelete, $model);
    }
}
