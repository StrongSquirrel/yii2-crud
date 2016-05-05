<?php

namespace strongsquirrel\crud;

use yii\db\BaseActiveRecord;

/**
 * Class UpdateAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
class UpdateAction extends ItemAction
{
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
        /** @var BaseActiveRecord $model */
        $model = $this->findModel($id);
        $this->checkAccess($model);
        $model->setScenario($this->scenario);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $afterUpdate = $this->afterUpdate;
            if (empty($afterUpdate)) {
                $afterUpdate = function (BaseActiveRecord $model) {
                    return $this->controller->redirect(['view', 'id' => $model->getPrimaryKey()]);
                };
            }

            return call_user_func($afterUpdate, $model);
        }

        $params = $this->resolveParams(['model' => $model]);

        return $this->controller->render($this->view, $params);
    }
}
