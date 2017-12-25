<?php

namespace shop\entities\shop\product;


use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public $meta;
    public $image;

    public static function create($name, $title, $slug, $code, $description, $price, $available, $category_id, Meta $meta): self
    {
        $product = new static();
        $product->name = $name;
        $product->title = $title;
        $product->slug = $slug;
        $product->code = $code;
        $product->description = $description;
        $product->meta = $meta;
        $product->price = $price;
        $product->available = $available;
        $product->category_id = $category_id;
        $product->status = 10;
        $product->created_at = time();
        $product->updated_at = time();

        return $product;
    }

    public function edit($name, $title, $slug, $code, $description, $price, $available, $category_id, $status, Meta $meta): void
    {
        $this->name = $name;
        $this->title = $title;
        $this->code = $code;
        $this->slug = $slug;
        $this->description = $description;
        $this->meta = $meta;
        $this->price = $price;
        $this->available = $available;
        $this->category_id = $category_id;
        $this->status = $status;
        $this->updated_at = time();
    }


    public static function tableName(): string
    {
        return '{{%shop_products}}';
    }


    public function behaviors() {
        return [
            MetaBehavior::className(),
            [
                'class' => '\yiidreamteam\upload\ImageUploadBehavior',
                'attribute' => 'imageUpload',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'height' => 300],
                ],
                'filePath' => '@webroot/images/[[pk]].[[extension]]',
                'fileUrl' => '/images/[[pk]].[[extension]]',
                'thumbPath' => '@webroot/images/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '/images/[[profile]]_[[pk]].[[extension]]',
            ],
        ];
    }


}