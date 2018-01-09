<?php
namespace shop\repositories\shop;


use shop\entities\shop\Tag;
use yii\web\NotFoundHttpException;

class TagRepository
{
    public function get($id): ?Tag
    {
        if (!$tag = Tag::findOne($id)){
            throw new NotFoundHttpException('Tag not found.');
        }
        return $tag;
    }

    public function save(Tag $tag): void
    {
        if (!$tag->save()){
            throw new \RuntimeException('Tag saving error');
        }
    }

    public function remove(Tag $tag): void
    {
        if (!$tag->delete()){
            throw new \RuntimeException('Tag delete error');
        }
    }

}