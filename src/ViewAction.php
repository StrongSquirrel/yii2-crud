<?php

namespace strongsquirrel\actions;

/**
 * Class ViewAction
 *
 * @author Ivan Kudinov <frostealth@gmail.com>
 * @package strongsquirrel\actions
 */
class ViewAction extends Action
{
    /**
     * @var string the name of the view action.
     */
    public $view = 'view';

    /**
     * @param string $id
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        return $this->controller->render($this->view, ['model' => $model]);
    }
}
