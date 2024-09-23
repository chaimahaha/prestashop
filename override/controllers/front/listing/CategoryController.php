<?php

class CategoryController extends CategoryControllerCore
{
    public function initContent()
    {
        parent::initContent();
        
        // Récupérer l'ID de la catégorie courante
        $idCategory = (int) Tools::getValue('id_category');
        
        // Créer un objet Category avec l'ID de la catégorie courante
        $category = new Category($idCategory, $this->context->language->id);
        
        // Récupérer les produits de la catégorie
        $products = $category->getProducts($this->context->language->id, 0, 100); // Vous pouvez ajuster les limites (0, 100)
        
        $finalProducts = array();

        // Parcourir les produits pour récupérer les combinaisons de couleurs
        foreach ($products as $product) {
            $prod = new Product($product['id_product']);
            $combinations = $prod->getAttributeCombinations($this->context->language->id);

            // Filtrer pour les combinaisons de couleurs
            foreach ($combinations as $combination) {
                if ($combination['group_name'] == 'Color') {
                    $productCopy = $product;
                    $productCopy['color_name'] = $combination['attribute_name'];
                    $productCopy['id_combination'] = $combination['id_product_attribute'];
                    $productCopy['id_image'] = $combination['id_image'];

                    // Ajouter cette combinaison comme un produit distinct
                    $finalProducts[] = $productCopy;
                }
            }
        }

        // Assigner la nouvelle liste de produits au template
        $this->context->smarty->assign('products', $finalProducts);
    }
}
