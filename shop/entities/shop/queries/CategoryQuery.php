<?php
namespace shop\entities\shop\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;

class CategoryQuery extends \yii\db\ActiveQuery
{
    use NestedSetsQueryTrait;
}