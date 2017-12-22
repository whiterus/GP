<?php
namespace shop\repositories\shop;


use shop\entities\shop\Category;

class CategoryRepository
{

    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new \RuntimeException('Category is not found.');
        }
        return $category;
    }

    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}