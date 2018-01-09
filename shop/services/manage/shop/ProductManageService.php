<?php
namespace shop\services\manage\shop;

use shop\entities\Meta;
use shop\entities\shop\product\Product;
use shop\forms\manage\shop\Product\ProductForm;
use shop\repositories\shop\ProductRepository;
use shop\repositories\shop\TagRepository;
use shop\services\TransactionManager;

class ProductManageService
{
    private $products;

    public function __construct(
        ProductRepository $products,
        TagRepository $tags,
        TransactionManager $transaction
    )
    {
        $this->products = $products;
        $this->tags = $tags;
        $this->transaction = $transaction;
    }


    public function create(ProductForm $form): Product
    {

        //print '<pre>'; print_r($form->photos->files); print '</pre>';
        //die();

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


        /*foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }*/


        //$category->appendTo($parent);
        $this->products->save($product);
        return $product;
    }

    public function edit($id, ProductForm $form): void
    {

        //print '<pre>'; print_r($form->tags->existing); print '</pre>'; die();

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


        $this->transaction->wrap(function () use ($product, $form) {

            //$product->revokeCategories();
            $product->revokeTags();
            $this->products->save($product);
/*
            foreach ($form->categories->others as $otherId) {
                $category = $this->categories->get($otherId);
                $product->assignCategory($category->id);
            }

            foreach ($form->values as $value) {
                $product->setValue($value->id, $value->value);
            }
*/
            foreach ($form->tags->existing as $tagId) {
                $tag = $this->tags->get($tagId);
                $product->assignTag($tag->id);
            }
/*
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $product->assignTag($tag->id);
            }
*/
            $this->products->save($product);
        });

        $this->products->save($product);
    }
}