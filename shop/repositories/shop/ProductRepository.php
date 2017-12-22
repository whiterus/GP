<?php
namespace shop\repositories\shop;


use shop\entities\shop\product\Product;

class ProductRepository
{

    public function get($id): Product
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }
        return $product;
    }

    public function save(Product $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Product $product): void
    {
        if (!$product->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}