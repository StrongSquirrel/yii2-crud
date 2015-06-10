<?php

namespace strong_squirrel\actions;

use yii\db\ActiveRecord;

/**
 * Class UpdateAction
 *
 * @package strong_squirrel\actions
 */
class UpdateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = ActiveRecord::SCENARIO_DEFAULT;

    /**
     * @var string the name of the view action.
     */
    public $view = 'update';

    /**
     * @var callable
     * The signature of the callable should be:
     *
     * ```php
     * function ($model) {
     *     // $model is the requested model instance.
     *     return $this->redirect(['my-action', 'id' => $model->getPrimaryKey()]);
     * }
     * ```
     */
    public $afterUpdate;

    /**
     * @param string $id
     *
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        /** @var ActiveRecord $model */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $afterUpdate = $this->afterUpdate;
            if (empty($afterUpdate)) {
                $afterUpdate = function (ActiveRecord $model) {
                    return $this->controller->redirect(['view', 'id' => $model->getPrimaryKey()]);
                };
            }

            return call_user_func($afterUpdate, $model);
        }

        return $this->controller->render($this->view, ['model' => $model]);
    }
}
