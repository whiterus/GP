<?php

namespace shop\entities\shop\product;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\entities\shop\Tag;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property ProductPhoto photos
 */
class Product extends ActiveRecord
{
    public $meta;

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

    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = ProductPhoto::create($file);
        //$this->updatePhotos($photos);
        //$this->photos = $photos;
        //$this->updatePhotos($photos);
    }

    public function assignTag($id)
    {
        $related = $this->tagRelation;
        foreach ($related as $related_item) {
            if ($related_item->isForTag($id)) {
                return;
            }
        }
        $related[] = ProductTags::create($id);
        $this->tagRelation = $related;
    }

    public function revokeTags()
    {
        $this->tagRelation = [];
    }

    private function updatePhotos(array $photos): void
    {
        /*
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }
        */
        //$this->photos = $photos;
        //$this->populateRelation('mainPhoto', reset($photos));
    }


    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(ProductPhoto::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getTagRelation(): ActiveQuery
    {
        return $this->hasMany(ProductTags::class, ['product_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        //return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagRelation');
    }




    public function behaviors(): array
    {
        return [
            MetaBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                //'relations' => ['categoryAssignments', 'tagAssignments', 'relatedAssignments', 'modifications', 'values', 'photos', 'reviews'],
                'relations' => ['tagRelation'],
            ],
        ];
    }

    public static function tableName(): string
    {
        return '{{%shop_products}}';
    }

}