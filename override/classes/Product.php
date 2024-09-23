<?php

class Product extends ProductCore
{
    /* *
     * Récupère la sous-catégorie la plus spécifique pour le produit.
     */
   /*  public function getSubCategory()
    {
        // Obtenir toutes les catégories associées au produit
        $categories = Product::getProductCategoriesFull($this->id);

        error_log(print_r($categories, true));

        // Valider que des catégories sont récupérées
        if (empty($categories)) {
            return 'Aucune catégorie trouvée';
        }

        // Trouver la sous-catégorie la plus profonde
        $lowestCategory = null;
        $maxLevelDepth = -1;

        foreach ($categories as $category) {
            // Assurez-vous que les clés nécessaires existent
            if (isset($category['level_depth']) && $category['level_depth'] > $maxLevelDepth) {
                $lowestCategory = $category;
                $maxLevelDepth = $category['level_depth'];
            }
        }

        // Vérifiez si nous avons trouvé une catégorie et retournez son nom
        if (isset($lowestCategory)) {
            // Obtenez le nom de la catégorie depuis ps_category_lang
            $id_category = (int)$lowestCategory['id_category'];
            $categoryLang = Db::getInstance()->executeS('
                SELECT cl.name
                FROM '._DB_PREFIX_.'category_lang cl
                WHERE cl.id_category = '.(int)$id_category.'
                AND cl.id_lang = '.(int)$this->context->language->id
            );

            if (!empty($categoryLang)) {
                return $categoryLang[0]['name'];
            }
        }

        return 'Aucune catégorie trouvée';
    } */
}
