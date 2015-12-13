<?php

namespace strongsquirrel\crud;

/**
 * Class ViewAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
class ViewAction extends ItemAction
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
        $this->checkAccess($model);

        $params = $this->resolveParams(['model' => $model]);

        return $this->controller->render($this->view, $params);
    }
}
