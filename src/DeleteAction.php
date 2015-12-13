<?php

namespace strongsquirrel\crud;

use yii\web\ServerErrorHttpException;

/**
 * Class DeleteAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
class DeleteAction extends ItemAction
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
        $this->checkAccess($model);

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
