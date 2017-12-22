<?php
namespace shop\services\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\category\Category;
use shop\forms\manage\shop\CategoryForm;
use shop\repositories\shop\CategoryRepository;

class CategoryManageService
{

    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }


    public function create(CategoryForm $form): Category
    {

        $parent = $this->categories->get($form->parentId);
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->robots
            )
        );
        $category->appendTo($parent);
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form): void
    {

        //print_r($form->meta);die();

        $category = $this->categories->get($id);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->robots
            )
        );
        if ($form->parentId != $category->parent->id){
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }
        $this->categories->save($category);
    }

}