<?php

namespace strongsquirrel\crud;

use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Class SearchAction
 *
 * @author Ivan Kudinov <i.kudinov@frostealth.ru>
 * @package strongsquirrel\crud
 */
class SearchAction extends Action
{
    const FORM_METHOD_GET = 'get';
    const FORM_METHOD_POST = 'post';

    /**
     * @var string
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * @var string the name of the view action.
     */
    public $view = 'search';

    /**
     * @var string
     */
    public $formMethod = self::FORM_METHOD_GET;

    /**
     * The method should return an instance of [[DataProviderInterface]].
     *
     * @var string
     */
    public $searchMethod = 'search';

    /**
     * @var array
     */
    public $searchOptions = [];

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->modelClass === null) {
            $className = get_class($this);
            throw new InvalidConfigException("$className::\$modelClass must be set.");
        }

        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->checkAccess();

        list($dataProvider, $filterModel) = $this->prepare();
        $params = $this->resolveParams([
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
        ]);

        return $this->controller->render($this->view, $params);
    }

    /**
     * @return array [$dataProvider, $filterModel]
     */
    protected function prepare()
    {
        /** @var Model $model */
        $model = new $this->modelClass(['scenario' => $this->scenario]);
        $model->load($this->getData());

        return [call_user_func([$model, $this->searchMethod], $this->searchOptions), $model];
    }

    /**
     * @return array|null
     * @throws InvalidConfigException
     */
    protected function getData()
    {
        $request = \Yii::$app->request;
        switch ($this->formMethod) {
            case self::FORM_METHOD_GET:
                $data = $request->get();
                break;
            case self::FORM_METHOD_POST:
                $data = $request->post();
                break;
            default:
                throw new InvalidConfigException('Unsupported method "' . $this->formMethod . '".');
        }

        return $data;
    }
}
