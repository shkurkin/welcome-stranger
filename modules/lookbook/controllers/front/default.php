<?php
/**
* 
*/
class LookbookDefaultModuleFrontController extends ModuleFrontController
{
	
	/**
     * init() method init module front controller
     *
     * @category module front controller
     * @see
     */
    public function init()
    {
        // exec parent
        parent::init();

    }//init


	public function initContent()
	{
		parent::initContent();

		$lookbook = new Lookbook;

		if (Configuration::get('PS_REWRITING_SETTINGS') == 1)
		{
			if (preg_match('/modules/',$_SERVER['REQUEST_URI']))
			{
				$_languages = $lookbook->getLanguagesOrdered();
				$_currentLanguage = $lookbook->getDefaultLang();
				$_langIsoCode = $_languages[$_currentLanguage]['iso_code'];
				$url = parse_url($_SERVER['REQUEST_URI']);
				parse_str($url['query'],$output);
				$output['category'] = $lookbook->getCategoryLinkNameFromLang($output['category']);

				if (!empty($output['lookbook']))
					$output['lookbook'] = '/' . $lookbook->getLookbookLinkNameFromLang($output['lookbook']);	
				$location = 'Location: /'.$_langIsoCode.'/lookbook/'.$output['category'].$output['lookbook'];
				header($location);
				exit(0);
			}
		}


		$link = Context::getContext()->link;

		$oController = Context::getContext()->controller;

		global $smarty;


		$smarty->assign('lookbookObj', $lookbook);
		$display = $lookbook->getConfigurationValue('LOOKBOOK_DISPLAY_PREFERENCES');
		$category = Lookbook::getCategoryFromLink(Tools::getValue('category'));

		if (is_array($category))
			$lookbooks = $lookbook->getAssignedLookbooks($category['id_category']);


		if (isset($lookbooks) && count($lookbooks))
		{
			if (Tools::getValue('lookbook'))
			{
				$selectedLookbook = Lookbook::getLookbookFromLink(Tools::getValue('lookbook'));
			}
			else
			{
				$selectedLookbook = $lookbooks[0];
			}

			$smarty->assign(
				array(
					'lookbookObj' => $lookbook,
					'display' => $display,
					'link' => $link,
					'category' => $category,
					'lookbooks' => $lookbooks,
					'selectedLookbook' => $selectedLookbook,
					'imageWidth' => $lookbook->getConfigurationValue('LOOKBOOK_IMG_DIMENSIONS'),
					'thImageWidth' => $lookbook->getConfigurationValue('LOOKBOOK_IMG_TH_DIMENSIONS'),
				)
			);


			$p = $lookbook->getAssignedProducts($selectedLookbook['id_lookbook']);
			$products = array();
			foreach ($p as $kProduct => $product)
			{
				$_p = new Product($product['id_product'],true,Lookbook::$_defaultLang);

				if($_p->active == 1)
				{
					$image = Image::getCover($product['id_product']);
					
					$products[$kProduct] = Lookbook::objectToArray($_p);
					$products[$kProduct]['id_product'] = $product['id_product'];
					$products[$kProduct]['link'] = $_p->getLink();
					$products[$kProduct]['id_image'] = $image['id_image'];
					$products[$kProduct] = $_p->getProductProperties(Lookbook::$_defaultLang,$products[$kProduct]);
					$products[$kProduct]['attributes'] = $lookbook->combineCombinations($_p, $_p->getAttributesGroups(Lookbook::$_defaultLang));

					$products[$kProduct]['attributes']['allow_oosp'] = Product::isAvailableWhenOutOfStock($_p->out_of_stock);
					$products[$kProduct]['attributes']['tax_enabled'] = Configuration::get('PS_TAX');
					$products[$kProduct]['attributes']['last_qties'] = (int)Configuration::get('PS_LAST_QTIES');
					$products[$kProduct]['attributes']['display_qties'] = (int)Configuration::get('PS_DISPLAY_QTIES');
					$products[$kProduct]['attributes']['priceDisplay'] = Product::getTaxCalculationMethod();
					$products[$kProduct]['pObj'] = $_p;
				}
			}
			$attributes = array();
			foreach ($products as $key => $p)
			{
				$attributes[$key] = $p['attributes'];
			}

			$smarty->assign(
				array(
					'products' => $products,
					'jsonAttributes' => json_encode($attributes),
					'bVersion15' => (version_compare(_PS_VERSION_, '1.5', '>')? true : false)
				)
			);

			//print_r($products); die();
			
			$this->setTemplate('../../../views/templates/front/lookbook.tpl');
		}
		else
		{
			echo $lookbook->l('There is no lookbook for this category!', 'show-lookbook');
		}


			
	}

}