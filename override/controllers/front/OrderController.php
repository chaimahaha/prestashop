<?php

class OrderController  extends OrderControllerCore 
{
    public function initContent()
{
    parent::initContent();

    $products = $this->context->cart->getProducts();
    //var_dump($products);
    foreach ($products as &$product) {
        $productObj = new Product($product['id_product']);
        $subcategory  = $productObj->getSubCategoryForProduct(); 
        $product['subcategory'] = is_string($subcategory) ? $subcategory : '';
       
    }

    $testValue = 'Test value';
    $this->context->smarty->assign('test_value', $testValue);
    $this->context->smarty->assign('products' , $products);
}

}
