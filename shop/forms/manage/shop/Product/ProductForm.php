<?php
namespace shop\forms\manage\shop\Product;


use shop\entities\shop\category\Category;
use shop\entities\shop\product\Product;
use shop\forms\CompositeForm;
use shop\forms\manage\MetaForm;
use shop\forms\manage\shop\Product\TagsForm;

/**
 * @property PhotosForm photos
 */
class ProductForm extends CompositeForm
{
    public $name;
    public $title;
    public $code;
    public $slug;
    public $description;
    public $meta_json;
    public $price;
    public $category_id;
    public $available;
    public $status;

    /**
     * ProductForm constructor.
     * @param Product|null $product
     * @param array $config
     */
    public function __construct(Product $product = null, array $config = [])
    {

        if ($product) {
            $this->name = $product->name;
            $this->title = $product->title;
            $this->code = $product->code;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->available = $product->available;
            $this->status = $product->status;
            $this->meta = new MetaForm($product->meta);
            $this->category_id = $product->category_id ? $product->category_id : 1;
            //$this->photos = new PhotosForm($product->photos);
            $this->tags = new TagsForm($product);
        }
        else {
            $this->meta = new MetaForm();
            //$this->photos = new PhotosForm();
            $this->tags = new TagsForm();
        }



        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['name', 'title', 'slug', 'price'], 'required'],
            [['description', 'meta_json', 'code'], 'string'],
            [['price', 'status', 'category_id', 'available'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            //['imageUpload', 'file', 'extensions' => 'jpeg, gif, png'],
            //[['slug'], 'unique'],
        ];
    }


    public function categoriesList(): array
    {
        //$categories = Category::find()->orderBy('id')->asArray()->all();
        $categories = Category::find()->where(['>', 'id', 1])->orderBy('id')->all();

        $arr_categories = [];
        foreach ($categories as $category)
            $arr_categories[$category->id] = $category->name;

        return $arr_categories;
    }


    public function internalForms(): array
    {
        return ['meta', 'photos', 'tags'];
        //return ['meta', 'photos'];
    }


}