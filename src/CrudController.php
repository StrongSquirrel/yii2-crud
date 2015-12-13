<?php

namespace strongsquirrel\crud;

use yii\web\Controller;

/**
 * Class CrudController
 *
 * @package strongsquirrel\crud
 */
class CrudController extends Controller
{
    use CrudTrait;

    /** @var string */
    public $modelClass;
}
