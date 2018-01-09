<?php
namespace shop\services\manage\shop;


use shop\entities\shop\Tag;
use shop\forms\manage\shop\TagForm;
use shop\repositories\shop\TagRepository;

class TagManageService
{

    public $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }


    public function create(TagForm $form): Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug
        );
        $this->tags->save($tag);

        return $tag;
    }

    public function edit($id, TagForm $form): void
    {
        $tag = $this->tags->get($id);
        $tag->name = $form->name;
        $tag->slug = $form->slug;
        $this->tags->save($tag);
    }

}