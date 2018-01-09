<?php

namespace shop\entities\shop\category;

use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\Meta;
use shop\entities\shop\queries\CategoryQuery;


class Category extends \yii\db\ActiveRecord
{

    public $meta;

    public static function create($name, $slug, $title, $description, Meta $meta): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $title, $description, Meta $meta): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->meta = $meta;
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_categories';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'slug' => 'Синоним',
            'title' => 'Заголовок раздела',
            'description' => 'Содержимое',
            'status' => 'Статус',
            'meta_json' => 'Мета теги',
            //'lft' => 'Lft',
            //'rgt' => 'Rgt',
            //'depth' => 'Depth',
        ];
    }/**/


    public function behaviors() {
        return [
            NestedSetsBehavior::className(),
            MetaBehavior::className(),
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }


}
