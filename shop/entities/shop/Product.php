<?php

namespace shop\entities\shop;


use shop\entities\Meta;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public $meta;

    public function create($name, $title, $slug, $description, Meta $meta, $price, $category_id): self
    {
        $product = new static();
        $product->name = $name;
        $product->title = $title;
        $product->slug = $slug;
        $product->description = $description;
        $product->meta = $meta;
        $product->price = $price;
        $product->category_id = $category_id;

        return $product;
    }

    public function edit($name, $title, $slug, $description, Meta $meta, $price, $category_id): void
    {
        $this->name = $name;
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->meta = $meta;
        $this->price = $price;
        $this->category_id = $category_id;
    }


    public static function tableName(): string
    {
        return '{{%shop_products}}';
    }

}