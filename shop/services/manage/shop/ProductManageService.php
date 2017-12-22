<?php
namespace shop\services\manage\shop;


use shop\entities\Meta;
use shop\entities\shop\product\Product;
use shop\forms\manage\shop\ProductForm;
use shop\repositories\shop\ProductRepository;

class ProductManageService
{
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }


    public function create(ProductForm $form): Product
    {

        //print_r($form->meta);die();
        //$parent = $this->products->get($form->parentId);

        $product = Product::create(
            $form->name,
            $form->title,
            $form->slug,
            $form->code,
            $form->description,
            $form->price,
            $form->available,
            $form->category_id,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->robots
            )
        );
        //$category->appendTo($parent);
        $this->products->save($product);
        return $product;
    }

    public function edit($id, ProductForm $form): void
    {

        //print_r($form->meta);die();

        $product = $this->products->get($id);
        $product->edit(
            $form->name,
            $form->title,
            $form->slug,
            $form->code,
            $form->description,
            $form->price,
            $form->available,
            $form->category_id,
            $form->status,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->robots
            )
        );
        /*if ($form->parentId != $category->parent->id){
            $parent = $this->categories->get($form->parentId);
            $category->appendTo($parent);
        }*/
        $this->products->save($product);
    }



}