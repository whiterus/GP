<?php
namespace shop\entities\shop\product;

use yii\db\ActiveRecord;

class ProductTags extends ActiveRecord
{
    public static function create($tagId)
    {
        $relation = new static();
        $relation->tag_id = $tagId;
        return $relation;
    }

    public function isForTag($id): bool
    {
        return $this->tag_id == $id;
    }

    public static function tableName()
    {
        return '{{%shop_tag_relations}}';
    }
}