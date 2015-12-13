<?php

namespace strongsquirrel\crud;

/**
 * Trait CrudTrait
 *
 * @package strongsquirrel\crud
 */
trait CrudTrait
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => $this->modelClass,
            ],
            'view' => [
                'class' => ViewAction::className(),
                'modelClass' => $this->modelClass,
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => $this->modelClass,
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => $this->modelClass,
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => $this->modelClass,
            ],
            'search' => [
                'class' => SearchAction::className(),
                'modelClass' => $this->modelClass,
            ],
        ];
    }
}
