<?php
/**
* 2007-2024 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Categoryslider extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'categoryslider';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'ma boutique ';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Category Slider');
        $this->description = $this->l('«slider» in category page (product listing page) that shows all subcategories of the current category with images of each subcategory with the shape of circle and displaying also the names and the number of products in each one like in the screenshot below but with the number of products.');

        $this->confirmUninstall = $this->l('Are you sure to uninstall ?');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => '8.0');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('CATEGORYSLIDER_LIVE_MODE', false);

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayCategoryPage')
            ;
    }

    public function uninstall()
    {
        Configuration::deleteByName('CATEGORYSLIDER_LIVE_MODE');

        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
{
    if (((bool)Tools::isSubmit('submitCategorysliderModule')) == true) {
        $this->postProcess();
    }
    $defaultImagePath = $this->_path . 'views/img/default-category.jpeg';
    $this->context->smarty->assign(array(
        'link' => $this->context->link,
        'module_name' => $this->name,
        'tab' => $this->tab,
        'defaultImagePath', $defaultImagePath
    ));

    return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
}


    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCategorysliderModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Slider Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Slider Width'),
                        'name' => 'CATEGORYSLIDER_WIDTH',
                        'desc' => $this->l('Set the width of the slider (in pixels).'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Slider Height'),
                        'name' => 'CATEGORYSLIDER_HEIGHT',
                        'desc' => $this->l('Set the height of the slider (in pixels).'),
                        'required' => true,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }


    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            /* 'CATEGORYSLIDER_LIVE_MODE' => Configuration::get('CATEGORYSLIDER_LIVE_MODE', true),
            'CATEGORYSLIDER_ACCOUNT_EMAIL' => Configuration::get('CATEGORYSLIDER_ACCOUNT_EMAIL', 'contact@prestashop.com'),
            'CATEGORYSLIDER_ACCOUNT_PASSWORD' => Configuration::get('CATEGORYSLIDER_ACCOUNT_PASSWORD', null), */
            'CATEGORYSLIDER_WIDTH' => Configuration::get('CATEGORYSLIDER_WIDTH', '800'), // Valeur par défaut : 800px
            'CATEGORYSLIDER_HEIGHT' => Configuration::get('CATEGORYSLIDER_HEIGHT', '400'), // Valeur par défaut : 400px
            'CATEGORYSLIDER_ACTIVE' => Configuration::get('CATEGORYSLIDER_ACTIVE', true),  // Par défaut activé
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        /* $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        } */
        Configuration::updateValue('CATEGORYSLIDER_WIDTH', Tools::getValue('CATEGORYSLIDER_WIDTH'));
        Configuration::updateValue('CATEGORYSLIDER_HEIGHT', Tools::getValue('CATEGORYSLIDER_HEIGHT'));
        //Configuration::updateValue('CATEGORYSLIDER_ACTIVE', Tools::getValue('CATEGORYSLIDER_ACTIVE'));
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
       /*  if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        } */
        // Récupérer les sous-catégories de la catégorie actuelle
        $id_category = (int)Tools::getValue('id_category');
        $category = new Category($id_category, $this->context->language->id);
        $subcategories = $category->getSubCategories($this->context->language->id);

        // Assigner les sous-catégories au template
        $this->context->smarty->assign(array(
            'subcategories' => $subcategories
        ));

        // Retourner le template du slider
        return $this->display(__FILE__, 'views/templates/hook/displayCategorySlider.tpl');
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookActionCategoryAdd()
    {
        /* Place your code here. */
    }

    public function hookActionCategoryDelete()
    {
        /* Place your code here. */
    }

    public function hookActionCategoryUpdate()
    {
        /* Place your code here. */
    }

    public function hookActionProductListOverride()
    {
        /* Place your code here. */
    }

    public function hookDisplayCategoryPage($params)
    {
        $category = new Category((int)Tools::getValue('id_category'));

        $subcategories = $category->getSubCategories($this->context->language->id);

        $this->context->smarty->assign(array(
            'subcategories' => $subcategories,
            'module_dir' => $this->_path,
        ));

        return $this->display(__FILE__, 'views/templates/hook/displayCategorySlider.tpl');
    }
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path.'views/css/front.css', 'all');
    }

    public function getCategoryImage($id_category)
    {
        
        $link = $this->context->link;
        $category = new Category($id_category, $this->context->language->id);
        
    
        if ($category->id) {
            $imageUrl = $link->getCatImageLink($category->link_rewrite, $category->id, 'home_default');
        } else {
            
            $imageUrl = $link->getMediaLink($this->_path . 'views/img/default-category.jpeg');
        }
        
        return $imageUrl;
    }


    public function getSubcategories($id_category)
    {
        $default_image_url = $this->_path . 'views/img/default-category.jpeg'; // Chemin vers l'image par défaut
        $sql = 'SELECT c.id_category, cl.name, COUNT(p.id_product) AS product_count, 
        IFNULL(cl.image, \'' . pSQL($default_image_url) . '\') AS image
            FROM '._DB_PREFIX_.'category c
            LEFT JOIN '._DB_PREFIX_.'category_lang cl ON c.id_category = cl.id_category
            LEFT JOIN '._DB_PREFIX_.'product p ON p.id_category_default = c.id_category
            WHERE c.id_parent = '.(int)$id_category.'
            GROUP BY c.id_category';
        return Db::getInstance()->executeS($sql);
    }

    

}
