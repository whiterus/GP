<?php
namespace shop\forms\manage\shop;

use shop\entities\shop\Category;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use yii\helpers\ArrayHelper;


class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $status;
    public $meta_json;
    public $parentId;


    public function __construct(Category $category = null, array $config = [])
    {
        if ($category){
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->status = $category->status;
            $this->parentId = $category->parent->id ? $category->parent->id : 1;
            $this->meta = new MetaForm($category->meta);
        } else {
            $this->meta = new MetaForm();
        }

        parent::__construct($config);
    }


    public function rules()
    {
        return [
            //[['name', 'slug', 'meta_json', 'lft', 'rgt', 'depth'], 'required'],
            [['name', 'slug'], 'required'],
            [['description', 'meta_json'], 'string'],
            [['status', 'parentId'], 'integer'],
            //[['status', 'lft', 'rgt', 'depth'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            //[['slug'], 'unique'],
        ];
    }


    public function internalForms(): array
    {
        return ['meta'];
    }

    public function parentCategoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('--', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

}