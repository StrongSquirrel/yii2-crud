<?php

namespace strongsquirrel\crud;

use yii\db\BaseActiveRecord;

/**
 * Class CreateAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
class CreateAction extends ItemAction
{
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
        $this->checkAccess();

        /** @var BaseActiveRecord $model */
        $model = \Yii::createObject($this->modelClass);
        $model->setScenario($this->scenario);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $afterSave = $this->afterSave;
            if (empty($afterSave)) {
                $afterSave = function (BaseActiveRecord $model) {
                    return $this->controller->redirect(['view', 'id' => $model->getPrimaryKey()]);
                };
            }

            return call_user_func($afterSave, $model);
        }

        $params = $this->resolveParams(['model' => $model]);

        return $this->controller->render($this->view, $params);
    }
}
