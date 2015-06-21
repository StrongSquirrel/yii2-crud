<?php

namespace strongsquirrel\actions;

use yii\db\ActiveRecord;

/**
 * Class CreateAction
 *
 * @package strongsquirrel\actions
 */
class CreateAction extends Action
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = ActiveRecord::SCENARIO_DEFAULT;

    /**
     * @var string the name of the view action.
     */
    public $view = 'create';

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
    public $afterSave;

    /**
     * @return mixed
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /** @var ActiveRecord $model */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $afterSave = $this->afterSave;
            if (empty($afterSave)) {
                $afterSave = function (ActiveRecord $model) {
                    return $this->controller->redirect(['view', 'id' => $model->getPrimaryKey()]);
                };
            }

            return call_user_func($afterSave, $model);
        }

        return $this->controller->render($this->view, ['model' => $model]);
    }
}
