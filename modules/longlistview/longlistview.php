<?php

if (!defined('_PS_VERSION_'))
    exit;

class LongListView extends Module
{

    private $catMap;

    public function __construct()
    {
        $this->name = 'longlistview';
        $this->tab = 'front_office_features';
        $this->version = '1.0';
        $this->author = 'Firstname Lastname';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.7');

        parent::__construct();

        $this->displayName = $this->l('Long List View');
        $this->description = $this->l('Display all products in one long list');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install()
    {
        if (parent::install() == false)
            return false;

        return parent::install() &&
            $this->registerHook('displayHome') &&
            $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall() && Configuration::deleteByName('MYMODULE_NAME');
    }

    public function hookDisplayHome($params)
    {
        $this->loadAllProducts();
        $this->smarty->assign('categoryMap', $this->catMap);
        return $this->display(__FILE__, 'longlistview.tpl');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/longlistview.css', 'all');
    }

    private function loadAllProducts(){
        $shopId = implode(', ', Shop::getContextListShopID());
        $link = new Link();
        //Grab all the products
        $sql = 'SELECT prod.id_product, cat.name, cat.id_category, cat.link_rewrite as catLink, prodlang.link_rewrite, prodlang.name as prodName, prod.price, img.id_image
        FROM '
                ._DB_PREFIX_.'product prod, '
                ._DB_PREFIX_.'category_lang cat, '
                ._DB_PREFIX_.'product_lang prodlang, '
                ._DB_PREFIX_.'product_shop product_shop, '
                ._DB_PREFIX_.'image img
        WHERE prodlang.id_product = prod.id_product 
        AND prod.id_category_default = cat.id_category
        AND product_shop.id_product = prod.id_product
        AND img.id_product = prod.id_product
        AND product_shop.id_shop IN ('.$shopId.') 
        ORDER BY prod.id_category_default ASC';
        
        $sql = 'SELECT DISTINCT prod.id_product, cat.name, cat.id_category, cat.link_rewrite as catLink, prodlang.link_rewrite, prodlang.name as prodName, prod.price, img.id_image, manf.name as manufacturerName
        FROM '._DB_PREFIX_.'product prod  
        INNER JOIN '._DB_PREFIX_.'category_lang cat 
            ON prod.id_category_default = cat.id_category
        INNER JOIN  '._DB_PREFIX_.'product_lang prodlang 
            ON prodlang.id_product = prod.id_product
        INNER JOIN  '._DB_PREFIX_.'manufacturer manf 
            ON manf.id_manufacturer = manf.id_manufacturer 
        INNER JOIN '._DB_PREFIX_.'image img
            ON img.id_product = prod.id_product
        INNER JOIN '._DB_PREFIX_.'category_shop catOrder
            ON cat.id_category = catOrder.id_category
        '.Shop::addSqlAssociation('product', 'prod').' 
        WHERE prod.active=1
        AND catOrder.id_shop IN ('.$shopId.') 
        ORDER BY catOrder.position ASC, prod.id_category_default ASC';
        
        $results = Db::getInstance()->executeS($sql);
        $counter = 0;
        $usedVal = array();
        //Save them all in an internal map
        foreach($results as $result){
            if(isset($usedVal[$result['id_product']])){
                continue;
            }
            $usedVal[$result['id_product']] = 1;
            $this->catMap[$result['name']][$counter]['imgLink'] = $this->context->link->getImageLink($result['link_rewrite'], $result['id_image'], 'home_default');
            $this->catMap[$result['name']][$counter]['prodLink'] = $this->context->link->getProductLink($result['id_product'], $result['link_rewrite']);
            $this->catMap[$result['name']][$counter]['name'] = $result['prodName'];
            $this->catMap[$result['name']][$counter]['price'] = number_format($result['price'], 2);
            $this->catMap[$result['name']][$counter]['manufacturerName'] = $result['manufacturerName'];
            $this->catMap[$result['name']][$counter]['catLink'] = $this->context->link->getCatImageLink($result['catLink'], $result['id_category'], 'category_default');
            
            $counter++;
        }
    }


}
