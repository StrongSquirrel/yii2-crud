<?php

namespace strongsquirrel\crud;

/**
 * Class ViewAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
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
