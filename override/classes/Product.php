<?php

class Product extends ProductCore
{
    public function getSubCategoryForProduct()
    {
        try {
            
            $categories = Product::getProductCategoriesFull($this->id);
           /*  var_dump($categories); // Pour le débogage
            die(); */
        } catch (Exception $e) {
            return $e->getMessage();
        }
    
        
        if (empty($categories)) {
            return 'Aucune catégorie trouvée';
        }
    
        $lowestCategory = null;
    
        
        foreach ($categories as $category) {
            if (isset($category['id_category'])) {
                $lowestCategory = $category; 
            }
        }
    
        if (isset($lowestCategory)) {
           
            $id_category = (int)$lowestCategory['id_category'];
            $categoryLang = Db::getInstance()->executeS('
                SELECT cl.name
                FROM '._DB_PREFIX_.'category_lang cl
                WHERE cl.id_category = '.(int)$id_category.'
                AND cl.id_lang = '.(int)Context::getContext()->language->id
            );
    
            if (!empty($categoryLang)) {
                return $categoryLang[0]['name'];
            }
        }
    
        return 'Aucune catégorie trouvée';
    }
    
}
