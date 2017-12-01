<?php

namespace shop\entities\shop;

use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\shop\queries\CategoryQuery;
use Yii;

/**
 * This is the model class for table "shop_categories".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property string $meta_json
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 */
class Category extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            //[['name', 'slug', 'meta_json', 'lft', 'rgt', 'depth'], 'required'],
            [['name', 'slug'], 'required'],
            [['description', 'meta_json'], 'string'],
            [['status', 'lft', 'rgt', 'depth'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'meta_json' => 'Meta Json',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }


    public function behaviors() {
        return [
            [
                'class' => NestedSetsBehavior::className(),
                // 'treeAttribute' => 'tree',
            ],
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
