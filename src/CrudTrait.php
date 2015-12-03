<?php

namespace strongsquirrel\crud;

trait CrudTrait
{
    public function actionIndex()
    {
        return \Yii::createObject(IndexAction::className(), ['index', $this])->run();
    }

    public function actionView()
    {
        return \Yii::createObject(ViewAction::className(), ['view', $this])->run();
    }

    public function actionCreate()
    {
        return \Yii::createObject(ViewAction::className(), ['create', $this])->run();
    }

    public function actionUpdate()
    {
        return \Yii::createObject(ViewAction::className(), ['update', $this])->run();
    }

    public function actionDelete()
    {
        return \Yii::createObject(ViewAction::className(), ['delete', $this])->run();
    }

    public function actionSearch()
    {
        return \Yii::createObject(ViewAction::className(), ['search', $this])->run();
    }
}
