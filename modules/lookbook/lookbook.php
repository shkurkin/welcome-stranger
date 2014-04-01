<?php
/**
 * Lookbook Front Office Feature
 *
 * @category front_office_features
 * @authors  / businesstech.fr <modules@businesstech.fr>
 * @copyright Business Tech 2011
 * @version 2.1.3
 *
 *
 **/
if (!defined('_CAN_LOAD_FILES_'))
	exit;

/**
 * undocumented class
 *
 * @package default
 * @author
 **/ 
class Lookbook extends Module
{
	protected $_configuration;
	protected $_html;

	/**
	 * @var int $iShopId : shop id used for 1.5 and for multi shop
	 */
	public static $iShopId = 1;
	public static $oCookie = null;
	public static $_languages;
	public static $_defaultLang;

	/**
	 * @var obj $oModule : obj module itself
	 */
	public static $oModule = null;

	/**
	 * undocumented constant
	 */
	const INSTALL_SQL_FILE = 'install.sql';
	const UNINSTALL_SQL_FILE = 'uninstall.sql';
	const UPDATE_SQL_FILE = 'update.sql';


	/**
	 * Magic Method __construct assigns few information about module and instantiate parent class
	 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
	 * @category main class
	 * @see Warnings class, Configuration class
	 */
	function __construct()
	{
		global $smarty;

		$this->name = 'lookbook';
		$this->tab = 'front_office_features';
		$this->version = '2.1.3';
		$this->module_key = '64d95779338c05ea5817d6d0353476f0';
		$this->author = 'Business Tech';
		parent::__construct();

		$this->page = basename(__FILE__,'.php');
		$this->displayName = $this->l('Lookbook');
		$this->description = $this->l('This module helps you to create lookbooks of assorted products');

		// use case - get context
		if (version_compare(_PS_VERSION_, '1.5', '>')) {
			$cookie = Context::getContext()->cookie;

			self::$iShopId = Context::getContext()->shop->id;
		}
		else {
			global $cookie;
		}

		/* ----------------------------- */
		/* ----- CUSTOM CLASS VARS ----- */
		/* ----------------------------- */
		
		$this->smarty = $smarty;
		self::$oCookie = $cookie;
		$this->_html = '';
		$this->_path = _PS_MODULE_DIR_.$this->name.'/';
		$this->_webpath = _MODULE_DIR_.$this->name.'/';
		$this->_webURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		self::$_languages = Language::getLanguages();
		self::$_defaultLang = $cookie->id_lang;
		self::$oModule = $this;
	}

	/**
	 * install() method installs all mandatory structure (DB or Files) => sql queries and update values and hooks registered
	 *
	 * @category main class
	 * @see Install class
	 *
	 * @return bool
	 */
	public function install()
	{
		if (!parent::install()
		|| !$this->registerHook('leftColumn') 
		|| !Configuration::updateValue('LOOKBOOK_IMG_DIMENSIONS', 555)
		|| !Configuration::updateValue('LOOKBOOK_IMG_TH_DIMENSIONS', 120)
		|| !Configuration::updateValue('LOOKBOOK_MAX_IMG_SIZE', 1280)
		|| !Configuration::updateValue('LOOKBOOK_DISPLAY_PREFERENCES', 'linear')
		|| !$this->installModuleTab('AdminTabLookbook', array('en' => 'Lookbook', 'fr' => 'Lookbook', 'es' => 'Lookbook', 'it' => 'Lookbook', 'de' => 'Lookbook'), 'AdminCatalog')
		|| !$this->installSQLScript(self::INSTALL_SQL_FILE))
			return false;
		return true;
	}

	/**
	 * uninstall() method uninstalls all mandatory structure (DB or Files) => sql queries and update values and hooks registered
	 *
	 * @category main class
	 * @see Install class
	 *
	 * @return bool
	 */
	public function uninstall()
	{
		if (!parent::uninstall()
		|| !Configuration::deleteByName('LOOKBOOK_IMG_DIMENSIONS')
		|| !Configuration::deleteByName('LOOKBOOK_IMG_TH_DIMENSIONS')
		|| !Configuration::deleteByName('LOOKBOOK_MAX_IMG_SIZE')
		|| !Configuration::deleteByName('LOOKBOOK_DISPLAY_PREFERENCES')
		|| !$this->uninstallModuleTab('AdminTabLookbook')
		|| !$this->uninstallSQLScript(self::UNINSTALL_SQL_FILE))
			return false;
		return true;
	}

	/**
	 * installSQLScript() method installs SQL script
	 *
	 * @category main class
	 * @see
	 *
	 * @param string $sSqlFile
	 * @param bool $bUpdate
	 * @return bool
	 */
	public function installSQLScript($sSqlFile, $bUpdate = false)
	{
		$bReturn = false;

		if (file_exists(dirname(__FILE__) . '/' . $sSqlFile))
		{
			// get content
			$sql = file_get_contents(dirname(__FILE__).'/'.$sSqlFile);

			if ($sql)
			{
				$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql); //reading each line of install.sql

				if (_PS_VERSION_ >= 1.4)
				{
					$sql = str_replace('MYSQL_ENGINE', _MYSQL_ENGINE_, $sql);
				}
				else
				{
					$sql = str_replace('MYSQL_ENGINE', 'MyISAM', $sql);
				}

				$sql = preg_split("/;\s*[###]+/", $sql);

				$bReturn = true;

				if ($bUpdate) {
					// set transaction
					Db::getInstance()->Execute('BEGIN');
				}

				foreach($sql as $r => $q)
				{
					// execute each database request.
					if ($q AND sizeof($q) AND !Db::getInstance()->Execute(trim($q)))
					{
						$bReturn = false;
					}
				}
				if ($bUpdate) {
					if ($bReturn)
					{
						// set transaction
						Db::getInstance()->Execute('COMMIT');
					}
					else {
						Db::getInstance()->Execute('ROLLBACK');
					}
				}
			}
		}
		return $bReturn;
	}

	/**
	 * uninstallSQLScript() method uninstalls SQL script
	 *
	 * @category main class
	 * @see
	 *
	 * @param string $sSqlFile
	 * @return bool
	 */
	public function uninstallSQLScript($sSqlFile)
	{
		$bReturn = false;

		if (file_exists(dirname(__FILE__).'/'.$sSqlFile))
		{
			!$sql = file_get_contents(dirname(__FILE__).'/'.$sSqlFile);

			if ($sql) {
				$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql); //reading each line of uninstall.sql
				$sql = preg_split("/;\s*[###]+/", $sql);

				$bReturn = true;

				foreach ($sql as $r => $q)
				{   // execute each database request.
					if ($q AND sizeof($q) AND !Db::getInstance()->Execute(trim($q)))
					{
						$bReturn = false;
					}
				}
			}
		}
		return $bReturn;
	}

	/**
	 * loadConfiguration() method load config
	 *
	 * @category main class
	 * @see
	 *
	 * @return -
	 */
	public function loadConfiguration()
	{
		$this->_configuration = Configuration::getMultiple(array(
			'LOOKBOOK_IMG_DIMENSIONS',
			'LOOKBOOK_IMG_TH_DIMENSIONS',
			'LOOKBOOK_MAX_IMG_SIZE',
			'LOOKBOOK_DISPLAY_PREFERENCES'
		));
	}

	/**
	 * setConfiguration() method set config
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	public function setConfiguration($configurationName,$value)
	{
		if(!preg_match('/^[A-Za-z0-9_\ \-]+$/',$value) OR !preg_match('/^[A-Z\_]+$/',$configurationName))
			return false;
		Configuration::updateValue($configurationName,$value);
		$this->loadConfiguration();
		return true;
	}
	
	/* --------------------- */
	/* ----- ACCESSORS ----- */
	/* --------------------- */

	/**
	 * getCss() method returns CSS
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getCss()
	{
		return ('
			<link type="text/css" rel="stylesheet" href="'.$this->_webpath.'css/lookbook.css" media="screen" />
			<link type="text/css" rel="stylesheet" href="'.$this->_webpath.'css/jquery.fancybox-1.3.4.css" media="screen" />
			<link type="text/css" rel="stylesheet" href="'.$this->_webpath.'css/fileuploader.css" media="screen" />
		');
	}


	/**
	 * getJqueryAndJs() method returns JS
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getJqueryAndJs()
	{	
		return ('
			<script type="text/javascript" src="'.$this->_webpath.'js/jquery-1.6.2.min.js"></script>
			<script type="text/javascript" src="'.$this->_webpath.'js/jquery-ui-1.8.16.custom.min.js"></script>
			<script type="text/javascript" src="'.$this->_webpath.'js/jquery.mousewheel-3.0.4.pack.js"></script>
			<script type="text/javascript" src="'.$this->_webpath.'js/jquery.fancybox-1.3.4.pack.js"></script>
			<script type="text/javascript" src="'.$this->_webpath.'js/lookbook.js"></script>
			<script type:"text/javascript" src="'.$this->_webpath.'js/fileuploader.js"></script>
		');
	}

	/**
	 * getJqueryCompatibility() method returns JS
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getJqueryCompatibility()
	{
		return  ('
			<script type="text/javascript">
				jq12 = jQuery.noConflict(true); 
			</script>'
		);
	}

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getModulePath()
	{
		return $this->_path;
	}

	/**
	 * getWebPath() method returns web path
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getWebPath()
	{
		return $this->_webpath;
	}

	/**
	 * getWebURL() method returns web URL
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getWebURL()
	{
		return $this->_webURL;
	}

	/**
	 * getDefaultLang() method returns default lang
	 *
	 * @category main class
	 * @see
	 *
	 * @return int
	 */
	public function getDefaultLang()
	{
		return self::$_defaultLang;
	}

	/**
	 * getLanguages() method returns languages
	 *
	 * @category main class
	 * @see
	 *
	 * @return array
	 */
	public function getLanguages()
	{
		return self::$_languages;
	}

	/**
	 * getLangDiv() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @param array $ids
	 * @param int $id
	 * @return string
	 */
	public function getLangDiv($ids,$id)
	{
		return $this->displayFlags(Lookbook::$_languages, self::$oCookie->id_lang, $ids, $id, true);
	}
	
	/* --------------------- */
	/* ----- MAIN CORE ----- */
	/* --------------------- */


	/**
	 * getContent() method returns module's content
	 *
	 * @category main class
	 * @see
	 *
	 * @return string
	 */
	public function getContent()
	{
		$this->loadConfiguration(); // Loading all configuration values in an array.
		$this->smarty->assign('lookbook', $this); // Assign current class object to smarty

		// check if updating
		$bUpdate = true;
		$bExist = Db::getInstance()->ExecuteS('SHOW COLUMNS FROM ' .  _DB_PREFIX_ . 'lookbook' . ' LIKE "shop_id"');

		if (empty($bExist)) {
			$bUpdate = $this->installSQLScript(self::UPDATE_SQL_FILE, true);
		}

		if (!$bUpdate) {
			$this->_html = $this->displayError($this->l('SQL Module Update didn\'t work. Please check your SQL user\'s permission'));
		}
		
		// Gestion du post de la configuration.
		if(Tools::isSubmit('submitImageSize'))
		{
			if(Validate::isInt(Tools::getValue('banner_size')) && Tools::getValue('banner_size') < $this->_configuration['LOOKBOOK_MAX_IMG_SIZE'])
				$this->setConfiguration('LOOKBOOK_IMG_DIMENSIONS',(int)(Tools::getValue('banner_size')));
			else
				$this->_html = $this->displayError($this->l('Banner dimension value is not correct.'));
		}
		
		if(Tools::isSubmit('submitImageThumbSize'))
		{
			if(Validate::isInt(Tools::getValue('thumb_size')) && Tools::getValue('thumb_size') < $this->_configuration['LOOKBOOK_MAX_IMG_SIZE'])
				$this->setConfiguration('LOOKBOOK_IMG_TH_DIMENSIONS',(int)(Tools::getValue('thumb_size')));
			else
				$this->_html = $this->displayError($this->l('Thumbnail dimension value is not correct.'));
		}
		
		if(Tools::isSubmit('submitDisplayPreferences'))
		{
			if(Tools::getValue('display_preferences') == 'mosaic' OR Tools::getValue('display_preferences') == 'linear')
				$this->setConfiguration('LOOKBOOK_DISPLAY_PREFERENCES',Tools::getValue('display_preferences'));
			else
				$this->_html = $this->displayError($this->l('The display preference you selected is unknown.'));
		}
		
		// If Prestashop version is under 1.4, override it with new version.
		if (_PS_VERSION_ < '1.4')
			$this->_html .= $this->getjQueryCompatibility();

        // detect if multshop group or all shop is activated
        $GLOBALS['smarty']->assign('bMultiGroupError', Lookbook::isMultishopConfig());

        $GLOBALS['smarty']->assign('modulePath', $this->getModulePath());

		// Affichage des différentes configurations possibles grâce aux templates.
		$this->_html .= $this->display(__FILE__,"views/templates/config/mainView.tpl");

		return $this->_html;
	}

	/**
	 * getCategories() method returns categories
	 *
	 * @category main class
	 * @see
	 *
	 * @param bool $onlyActive
	 * @return array
	 */
	public function getCategories($onlyActive = false)
	{
		$sql =	'SELECT c.*,cl.*
				FROM `%1$slookbook_category` c
				LEFT JOIN `%1$slookbook_category_lang` cl ON (c.id_category = cl.id_category)
				WHERE cl.id_lang = %2$d AND c.shop_id = ' . self::$iShopId;
		
		if ($onlyActive)
			$sql .= ' AND c.active = 1';
		
		$sql = sprintf($sql,_DB_PREFIX_, Lookbook::$_defaultLang);

		$categories = Db::getInstance()->ExecuteS($sql);

		return $categories;
	}

	/**
	 * getLookbooks() method returns lookbooks
	 *
	 * @category main class
	 * @see
	 * @param bool $onlyActive
	 * @return array
	 */
	public function getLookbooks($onlyActive = false)
	{
		$sql =	'SELECT l.*,ll.*
				FROM `%1$slookbook` l
				LEFT JOIN `%1$slookbook_lang` ll ON (l.id_lookbook = ll.id_lookbook AND l.shop_id = %3$d)
				WHERE ll.id_lang = %2$d';
					
		if($onlyActive)
			$sql .= ' AND l.active = 1';

		$sql = sprintf($sql,_DB_PREFIX_,Lookbook::$_defaultLang, self::$iShopId);
		$lookbooks = Db::getInstance()->ExecuteS($sql);

		return $lookbooks;
	}

	/**
	 * getManufacturers() method returns manufacturers
	 *
	 * @category main class
	 * @see
	 *
	 * @return array
	 */
	public function getManufacturers()
	{
		$manufacturers = Manufacturer::getManufacturers(false, 0);
		return $manufacturers;
	}

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @param string $manufacturer
	 * @return array
	 */
	public function getProducts($manufacturer)
	{
		$products = Manufacturer::getProducts($manufacturer, self::$oCookie->id_lang, 0, 1000);
		return $products;
	}

	/**
	 * getProductDetails() method returns product details
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_product
	 * @return array
	 */
	public function getProductDetails($id_product)
	{
		$sql = 'SELECT p.*,pl.*
				FROM `'._DB_PREFIX_.'product` p
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (pl.`id_product` = p.`id_product`  ' . (version_compare(_PS_VERSION_, '1.5', '>') ? Shop::addSqlRestrictionOnLang('pl'):'') . ')
				WHERE p.`id_product` = '.intval($id_product).'
				AND pl.`id_lang` = '.intval(self::$oCookie->id_lang);
		
		return Db::getInstance()->ExecuteS($sql);;
	}


	/**
	 * getProductAttributes() method returns product attributes
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_product
	 * @return array
	 */
	public function getProductAttributes($id_product)
	{
		$sql = 'SELECT agl.`name` AS group_name, a.`id_attribute`, al.`name` AS attribute_name, pa.`quantity`
				FROM `'._DB_PREFIX_.'product_attribute` pa
				LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON pac.`id_product_attribute` = pa.`id_product_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON ag.`id_attribute_group` = a.`id_attribute_group`
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON ag.`id_attribute_group` = agl.`id_attribute_group`
				WHERE pa.`id_product` = '.intval($id_product).'
				AND al.`id_lang` = '.intval(self::$oCookie->id_lang).'
				AND agl.`id_lang` = '.intval(self::$oCookie->id_lang).'
				ORDER BY pa.`id_product_attribute`';

		return Db::getInstance()->ExecuteS($sql);
	}


	/**
	 * getAssignedLookbooks() method returns assigned lookbooks
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_category
	 * @return array
	 */
	public function getAssignedLookbooks($id_category = false)
	{
		$sql =	'SELECT lc.*,lg.*
				FROM `%1$slookbooks_categories` AS lc
				LEFT JOIN `%1$slookbook` AS l ON (l.id_lookbook = lc.id_lookbook)
				LEFT JOIN `%1$slookbook_lang` AS lg ON (lg.id_lookbook = lc.id_lookbook)
				WHERE lg.id_lang = %2$d
				AND l.active = 1';

		$sql = (!$id_category) ? $sql : $sql . ' AND lc.id_category = %3$d';
		$sql = sprintf($sql,_DB_PREFIX_,self::$oCookie->id_lang,$id_category);

		$assignedLookbooks = Db::getInstance()->ExecuteS($sql);

		return $assignedLookbooks;
	}


	/**
	 * getUnAssignedLookbooks() method returns unassigned lookbooks
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_category
	 * @return array
	 */
	public function getUnAssignedLookbooks($id_category = false)
	{
		$sql =	'SELECT *
				FROM `%1$slookbook` AS l
				LEFT JOIN `%1$slookbook_lang` AS ll ON (ll.id_lookbook = l.id_lookbook)
				WHERE l.`id_lookbook` NOT IN (SELECT `id_lookbook` FROM `%1$slookbooks_categories` %3$s)
				AND ll.id_lang = %2$d
				AND l.active = 1';
					
		$id_category = (!$id_category) ? false : ' WHERE `id_category` = ' . (int)$id_category;
		$sql = sprintf($sql,_DB_PREFIX_,self::$oCookie->id_lang,$id_category);
		$unAssignedLookbooks = Db::getInstance()->ExecuteS($sql);
		
		return $unAssignedLookbooks;

	}

	/**
	 * registerLookbookImage() method register lookbook image
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_lookbook
	 * @param int $id_lang
	 * @return bool
	 */
	public function registerLookbookImage($id_lookbook,$id_lang)
	{
		$imageName = $id_lookbook.'-'.$id_lang.".jpg";

		$sql =	'UPDATE `%1$slookbook_lang`
				SET `image_url` = "%4$s"
				WHERE `id_lang` = %3$d
				AND	`id_lookbook` = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,(int)$id_lookbook,(int)$id_lang,$imageName);

		Db::getInstance()->Execute($sql);
					
		return true;
	}

	/**
	 * getLookbookImages() method returns lookbook images
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_lookbook
	 * @return array
	 */
	public function getLookbookImages($id_lookbook)
	{
		$sql =	'SELECT `image_url`
				FROM `%1$slookbook_lang`
				WHERE `id_lookbook` = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,(int)$id_lookbook);

		return Db::getInstance()->ExecuteS($sql);
	}

	/**
	 * getAssignedProducts() method returns assigned products
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_lookbook
	 * @return array
	 */
	public function getAssignedProducts($id_lookbook = false)
	{
		$sql =	'SELECT lp.*,pl.name
				FROM `%1$slookbooks_products` lp
				LEFT JOIN `%1$sproduct_lang` pl ON (lp.id_product = pl.id_product ' . (version_compare(_PS_VERSION_, '1.5', '>') ? Shop::addSqlRestrictionOnLang('pl'):'') . ')
				WHERE pl.id_lang = %2$d';

		$sql = (!$id_lookbook) ? $sql : $sql . ' AND lp.id_lookbook = %3$d';
		$sql = sprintf($sql,_DB_PREFIX_,self::$oCookie->id_lang,$id_lookbook);
		$assignedProducts = Db::getInstance()->ExecuteS($sql);

		return $assignedProducts;
	}

	/**
	 * getUnAssignedProducts() method returns unassigned products
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $id_lookbook
	 * @param int $id_manufacturer
	 * @return array
	 */
	public function getUnAssignedProducts($id_lookbook = false, $id_manufacturer = false)
	{
		$sql =	'SELECT p.*,pl.name
				FROM `%1$sproduct` p
				LEFT JOIN `%1$sproduct_lang` pl ON (p.id_product = pl.id_product ' . (version_compare(_PS_VERSION_, '1.5', '>') ? Shop::addSqlRestrictionOnLang('pl'):'') . ')
				WHERE p.`id_product` NOT IN (SELECT `id_product` FROM `%1$slookbooks_products` %3$s)
				AND p.id_manufacturer <> 0
				AND pl.id_lang = %2$d
				%4$s';

		$id_lookbook = (!$id_lookbook) ? false : ' WHERE `id_lookbook` = ' . (int)$id_lookbook;
		$id_manufacturer = (!$id_manufacturer) ? false : ' AND p.`id_manufacturer` = ' . (int)$id_manufacturer;
		$sql = sprintf($sql,_DB_PREFIX_,self::$oCookie->id_lang,$id_lookbook,$id_manufacturer);

		$unAssignedProducts = Db::getInstance()->ExecuteS($sql);

		return $unAssignedProducts;
	}

	/**
	 * getNbLookbookForThisCategory() method returns lookbook number for a category
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $category
	 * @return int
	 */
	function getNbLookbookForThisCategory($category)
	{
		$sql =	'SELECT count(id_lookbook) AS count
				FROM `%1$slookbooks_categories` lc
				WHERE lc.id_category = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,$category);
		$count = Db::getInstance()->ExecuteS($sql);

		return $count[0]['count'];				
	}

	/**
	 * getNbProductsInLookbook() method returns number of products in lookbook
	 *
	 * @category main class
	 * @see
	 *
	 * @param int $lookbook
	 * @return int
	 */
	public function getNbProductsInLookbook($lookbook)
	{
		$sql = 'SELECT count(id_product) AS count
				FROM `%1$slookbooks_products` lp
				WHERE lp.id_lookbook = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,$lookbook);
		$count = Db::getInstance()->ExecuteS($sql);

		return $count[0]['count'];
	}

    /**
     * isMultishopConfig() method returns if multishop group or all context is activated
     *
     * @category main class
     * @see
     *
     * @param string $result
     * @return bool
     */
    public static function isMultishopConfig()
    {
        // check if 1.5 and multishop active and if group is selected
        if (version_compare(_PS_VERSION_, '1.5', '>')
                &&
            Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE')
                &&
            (
            strpos(self::$oCookie->shopContext, 'g-') !== FALSE
                ||
            empty(self::$oCookie->shopContext)
            )
        ) {
            return true;
        }
        else {
            return false;
        }
    }

	/**
	 * jsonEncode() method returns json encode
	 *
	 * @category main class
	 * @see
	 *
	 * @param string $result
	 * @return string
	 */
	public static function jsonEncode($result)
	{
		return (method_exists('Tools', 'jsonEncode')) ? 
			preg_replace_callback("/\\\\u([a-f0-9]{4})/", function($m){return iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')));},Tools::jsonEncode($result)) : preg_replace_callback("/\\\\u([a-f0-9]{4})/", function($m){return iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')));},json_encode($result));
	}

	/**
	 * getConfigurationValue() method returns config value
	 *
	 * @category main class
	 * @see
	 *
	 * @param string $value
	 * @return bool
	 */
	public function getConfigurationValue($value)
	{
		$this->loadConfiguration();
		if (!preg_match('/^[A-Z\_]+$/',$value))
			return false;
		return $this->_configuration[$value];
	}


	/**
	 * getLanguageIds() method returns language IDs
	 *
	 * @category main class
	 * @see
	 *
	 * @return array
	 */
	public static function getLanguageIds()
	{
		foreach(self::$_languages as $lang)
			$languagesIds[] = $lang['id_lang'];
		return $languagesIds;
	}

	/**
	 * getLanguagesOrdered() method returns languages
	 *
	 * @category main class
	 * @see
	 *
	 * @return array
	 */
	public static function getLanguagesOrdered()
	{
		foreach(self::$_languages as $language)
			$languages[$language['id_lang']] = $language;
		return $languages;
	}
	
	/**
	 * stringToURLString function
	 *
	 * Converts all caracters that are not URL complient
	 * @param string $string 
	 * @return string $string
	 */
	public function stringToURLString($string)
	{
		setlocale (LC_ALL, 'fr_FR.utf8');
		$string = Lookbook::removeAccents($string);
		$string = iconv('utf-8', 'ASCII//TRANSLIT', $string);
		$string = strtolower(preg_replace('/[^a-zA-Z0-9_\-]+/','-',$string));
		return $string;
	}
	
	
	/**
	 * objectToArray function
	 *
	 * Converts an objet to an array.
	 * @param string $object 
	 * @return void
	 */
	static public function objectToArray($object)
	{
		if(!is_object($object) && !is_array($object))
		{
			return $object;
		}
		if(is_object($object))
		{
			$object = get_object_vars($object);
		}

		return array_map(array('LookBook', 'objectToArray'), $object);
	}


	/**
	 * printArray function
	 *
	 * print an array
	 * @param string $object
	 * @return void
	 */
	public static function printArray($array)
	{
		$content = '<pre>';
		$content .= print_r($array,1);
		$content .= '</pre>';
		exit($content);
	}

	/* -------------------- */
	/* ----- FRONTEND ----- */
	/* -------------------- */
	
	
	/**
	 * getCategoryLink function
	 *
	 * Returns the link to access to the correct category in the frontend
	 *
	 * @param string $category 
	 * @return string
	 * @author 
	 */
	static public function getCategoryFromLink($link)
	{
		$sql = 	'SELECT c.*,cl.*
				FROM `%1$slookbook_category_lang` cl
				LEFT JOIN `%1$slookbook_category` AS c ON (c.id_category = cl.id_category)
				WHERE cl.link = "%2$s"
				AND cl.id_lang = %3$d';

		$sql = sprintf($sql,_DB_PREFIX_,$link,(int)Lookbook::$_defaultLang);
		$category = Db::getInstance()->ExecuteS($sql);

		return (count($category)) ? $category[0] : '';
	}


	/**
	 * getLookbookLink function
	 *
	 * Returns the link to access to the correct lookbook in the frontend
	 *
	 * @param string $lookbook 
	 * @return string
	 * @author 
	 */
	static public function getLookbookFromLink($link)
	{
		$sql = 	'SELECT l.*,ll.*
				FROM `%1$slookbook_lang` ll
				LEFT JOIN `%1$slookbook` AS l ON (l.id_lookbook = ll.id_lookbook AND l.shop_id = %4$d)
				WHERE ll.link = "%2$s"
				AND ll.id_lang = %3$d';

		$sql = sprintf($sql,_DB_PREFIX_,$link,(int)Lookbook::$_defaultLang, self::$iShopId);
		$lookbook = Db::getInstance()->ExecuteS($sql);

		return $lookbook[0];
	}

	/**
	 * getCategoryLinkNameFromLang function
	 *
	 * Gets the correct link name from current lang
	 * 
	 * @return void
	 * @author 
	 */
	static public function getCategoryLinkNameFromLang($link)
	{
		$sql = 	'SELECT cl.link
				FROM `%1$slookbook_category_lang` AS cl
				WHERE cl.id_lang = %2$d
				AND cl.id_category IN (SELECT id_category FROM `%1$slookbook_category_lang` WHERE link = "%3$s")';

		$sql = sprintf($sql,_DB_PREFIX_,(int)self::$_defaultLang,$link);
		$linkName = Db::getInstance()->ExecuteS($sql);

		return $linkName[0]['link'];
	}

	/**
	 * getLookbookLinkNameFromLang function
	 *
	 * Gets the correct link name from current lang
	 * 
	 * @return void
	 * @author 
	 */
	static public function getLookbookLinkNameFromLang($link)
	{
		$sql = 	'SELECT ll.link
				FROM `%1$slookbook_lang` AS ll
				WHERE ll.id_lang = %2$d
				AND ll.id_lookbook IN (SELECT id_lookbook FROM `%1$slookbook_lang` WHERE link = "%3$s")';

		$sql = sprintf($sql,_DB_PREFIX_,(int)self::$_defaultLang,$link);
		$linkName = Db::getInstance()->ExecuteS($sql);

		return $linkName[0]['link'];
	}


	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	public function combineCombinations($objectProduct,$attributesGroups)
	{
        // use case - get context
        if (version_compare(_PS_VERSION_, '1.5', '>')) {
            $cart = Context::getContext()->cart;
            $currency = Context::getContext()->currency;
        }
        else {
            global $cart, $currency;
        }

		$id_customer = (isset(self::$oCookie->id_customer) AND self::$oCookie->id_customer) ? (int)(self::$oCookie->id_customer) : 0;
		$id_group = $id_customer ? (int)(Customer::getDefaultGroupId($id_customer)) : _PS_DEFAULT_CUSTOMER_GROUP_;
		$id_country = (int)($id_customer ? Customer::getCurrentCountry($id_customer) : Configuration::get('PS_COUNTRY_DEFAULT'));
			
		$group_reduction = GroupReduction::getValueForProduct($objectProduct->id, $id_group);
		if ($group_reduction == 0)
			$group_reduction = Group::getReduction((int)self::$oCookie->id_customer) / 100;
		
			
		// Tax
		$tax = (float)(Tax::getProductTaxRate((int)($objectProduct->id), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

		$ecotax_rate = (float) Tax::getProductEcotaxRate($cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
		
		$colors = array();
		if (is_array($attributesGroups) AND $attributesGroups)
		{
			$groups = array();
			$combinationImages = $objectProduct->getCombinationImages((int)(self::$_defaultLang));
			foreach ($attributesGroups AS $k => $row)
			{
				/* Color management */
				if (((isset($row['attribute_color']) AND $row['attribute_color']) OR (file_exists(_PS_COL_IMG_DIR_.$row['id_attribute'].'.jpg'))) AND $row['id_attribute_group'] == $objectProduct->id_color_default)
				{
					$colors[$row['id_attribute']]['value'] = $row['attribute_color'];
					$colors[$row['id_attribute']]['name'] = $row['attribute_name'];
					if (!isset($colors[$row['id_attribute']]['attributes_quantity']))
						$colors[$row['id_attribute']]['attributes_quantity'] = 0;
					$colors[$row['id_attribute']]['attributes_quantity'] += (int)($row['quantity']);
				}

				if (!isset($groups[$row['id_attribute_group']]))
				{
					$groups[$row['id_attribute_group']] = array(
						'name'           =>	$row['public_group_name'],
						'is_color_group' =>	$row['is_color_group'],
						'default'        => -1,
					);
				}

				$groups[$row['id_attribute_group']]['attributes'][$row['id_attribute']] = $row['attribute_name'];
				if ($row['default_on'] && $groups[$row['id_attribute_group']]['default'] == -1)
					$groups[$row['id_attribute_group']]['default'] = (int)($row['id_attribute']);
				if (!isset($groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']]))
					$groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] = 0;
				$groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] += (int)($row['quantity']);

				$combinations[$row['id_product_attribute']]['attributes_values'][$row['id_attribute_group']] = $row['attribute_name'];
				$combinations[$row['id_product_attribute']]['attributes'][] = (int)($row['id_attribute']);
				$combinations[$row['id_product_attribute']]['price'] = (float)($row['price']);
				$combinations[$row['id_product_attribute']]['ecotax'] = (float)($row['ecotax']);
				$combinations[$row['id_product_attribute']]['weight'] = (float)($row['weight']);
				$combinations[$row['id_product_attribute']]['quantity'] = (int)($row['quantity']);
				$combinations[$row['id_product_attribute']]['reference'] = $row['reference'];
//				$combinations[$row['id_product_attribute']]['ean13'] = $row['ean13'];
				$combinations[$row['id_product_attribute']]['unit_impact'] = $row['unit_price_impact'];
				$combinations[$row['id_product_attribute']]['minimal_quantity'] = $row['minimal_quantity'];
				$combinations[$row['id_product_attribute']]['id_image'] = isset($combinationImages[$row['id_product_attribute']][0]['id_image']) ? $combinationImages[$row['id_product_attribute']][0]['id_image'] : -1;
                Product::getPriceStatic((int)$objectProduct->id, false, $row['id_product_attribute'], 6, null, false, true, 1, false, null, null, null, $combination_specific_price);

                $combinations[$row['id_product_attribute']]['specific_price'] = $combination_specific_price;
			}
			
			$images = $objectProduct->getImages((int)self::$_defaultLang);
			$productImages = array();
			foreach ($images AS $k => $image)
			{
				if ($image['cover'])
				{
					$cover = $image;
					$cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($objectProduct->id.'-'.$image['id_image']) : $image['id_image']);
					$cover['id_image_only'] = (int)($image['id_image']);
				}
				$productImages[(int)$image['id_image']] = $image;
			}
			if (!isset($cover))
				$cover = array('id_image' => Language::getIsoById((int)$_defaultLang).'-default', 'legend' => 'No picture', 'title' => 'No picture');
			$size = Image::getSize('large');
			
			//wash attributes list (if some attributes are unavailable and if allowed to wash it)
			if (!Product::isAvailableWhenOutOfStock($objectProduct->out_of_stock) && Configuration::get('PS_DISP_UNAVAILABLE_ATTR') == 0)
			{
				foreach ($groups AS &$group)
					foreach ($group['attributes_quantity'] AS $key => &$quantity)
						if (!$quantity)
							unset($group['attributes'][$key]);

				foreach ($colors AS $key => $color)
					if (!$color['attributes_quantity'])
						unset($colors[$key]);
			}

			foreach ($groups AS &$group)
				natcasesort($group['attributes']);
			
			
			foreach ($combinations AS $id_product_attribute => $comb)
			{
				$attributeList = '';
				foreach ($comb['attributes'] AS $id_attribute)
					$attributeList .= (int)($id_attribute). ',';
				$attributeList = rtrim($attributeList, ',');
				$combinations[$id_product_attribute]['list'] = $attributeList;
			}

			return array(
                'combinations' => $combinations,
                'groups' => $groups,
                'colors' => $colors,
                'images' => $images,
                'have_image' => (isset($cover) ? (int)$cover['id_image'] : false),
                'ecotax' => $objectProduct->ecotax > 0 ? Tools::convertPrice((float)($objectProduct->ecotax)) : 0,
                'packItems' => $objectProduct->cache_is_pack ? Pack::getItemTable($objectProduct->id, (int)($_defaultLang), true) : array(),
                'group_reduction' => (1 - $group_reduction),
                'tax_rate' => $tax,
                'ecotaxTax_rate' => $ecotax_rate,
                'currencySign' => $currency->sign,
                'currencyRate' => $currency->conversion_rate,
                'currencyFormat' => $currency->format,
                'currencyBlank' => $currency->blank,
            );
		}
		
		return (
			array (
				'colors' => $colors,
				'have_image' => (isset($cover) ? (int)$cover['id_image'] : false),
				'ecotax' => $objectProduct->ecotax > 0 ? Tools::convertPrice((float)($objectProduct->ecotax)) : 0,
				'packItems' => $objectProduct->cache_is_pack ? Pack::getItemTable($objectProduct->id, (int)($_defaultLang), true) : array(),
				'group_reduction' => $group_reduction,
				'tax_rate' => $tax,
				'ecotaxTax_rate' => $ecotax_rate,
				'currencySign' => $currency->sign,
				'currencyRate' => $currency->conversion_rate,
				'currencyFormat' => $currency->format,
				'currencyBlank' => $currency->blank,
			)
		);
	}


	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	public function getURI($category, $lookbook = false, $prefix = true)
	{
		if (version_compare(_PS_VERSION_, '1.5', '>')) { 

			$link = Context::getContext()->link;

			if ($prefix = true)
				$prefix = $link->getModuleLink('lookbook').'?';
			$uri = (empty($lookbook)) ? ('category=' . $category) : ('category=' . $category . '&lookbook=' . $lookbook);
		} else { 
			if ($prefix = true)
				$prefix = _MODULE_DIR_.$this->name.'/show-lookbook.php?';
			$uri = (empty($lookbook)) ? ('category=' . $category) : ('category=' . $category . '&lookbook=' . $lookbook);
		}

		return $prefix.$uri;
	}


	/* -------------------- */
	/* ----- ADMINTAB ----- */
	/* -------------------- */

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	private function installModuleTab($sAdminClassName, $aTabName, $idTabParent)
	{
		// set variables
		$bReturn = true;
		$aTmpLang = array();

		static $oTab;

		// instantiate
		if (null === $oTab) {
			$oTab = new Tab();
		}

		// get available languages
		$aLangs = Language::getLanguages(true);

		// loop on each admin tab
		foreach ($aLangs as $aLang) {
			$aTmpLang[$aLang['id_lang']] = array_key_exists($aLang['iso_code'], $aTabName)? $aTabName[$aLang['iso_code']] : $aTabName['en'];
		}

		$oTab->name          = $aTmpLang;
		$oTab->class_name    = $sAdminClassName;
		$oTab->module        = $this->name;
		$oTab->id_parent     = Tab::getIdFromClassName($idTabParent);

		// use case - copy icon tab
		if (file_exists(_PS_MODULE_DIR_ . $oTab->module . '/' . $sAdminClassName . '.gif')) {
			@copy(_PS_MODULE_DIR_ . $oTab->module . '/' . $sAdminClassName . '.gif', _PS_IMG_DIR_ . 't/' . $sAdminClassName . '.gif');
		}

		// save admin tab
		if (false == $oTab->save()) {
			$bReturn = false;
		}

		return $bReturn;
	}

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	private function uninstallModuleTab($sAdminClassName)
	{
		// set return execution
		$bReturn = true;

		// get ID
		$iTabId = Tab::getIdFromClassName($sAdminClassName);

		if (!empty($iTabId)) {
			// instantiate
			$oTab = new Tab($iTabId);

			// use case - check delete
			if (false == $oTab->delete()) {
				$bReturn = false;
			}
			else {
				if (!defined('_PS_IMG_DIR')) {
					define('_PS_IMG_DIR', _PS_ROOT_DIR_ . '/img/');
				}
				if (file_exists(_PS_IMG_DIR . 't/' . $sAdminClassName . '.gif')) {
					@unlink(_PS_IMG_DIR . 't/' . $sAdminClassName . '.gif');
				}
			}

			unset($oTab);
		}

		return $bReturn;
	}
	
	
	/* ----------------- */
	/* ----- HOOKS ----- */
	/* ----------------- */

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	public function hookLeftColumn($params)
	{
		$categories = $this->getCategories(true);
		$this->smarty->assign(array(
					'lookbookObj' => $this,
					'categories' => $categories,
					'rewrite_setting' => Configuration::get('PS_REWRITING_SETTINGS'),
					));
		if (version_compare(_PS_VERSION_, '1.5.4', '>'))
		{
			$this->smarty->assign('is154', true);
		} else {
			$this->smarty->assign('is154', false);
		}
		return $this->display(__FILE__,'views/templates/hook/blocklookbook.tpl');
	}

	/**
	 * getModulePath() method returns module's path
	 *
	 * @category main class
	 * @see
	 *
	 * @return bool
	 */
	public function hookRightColumn($params)
	{
		return $this->hookLeftColumn($params);
	}


	public function removeAccents($str) {
		$invalid = array('Ą' => 'O', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'W', 'Ń' => 'N',
		'Ó' => 'O', 'Ś' => 'S', 'Ź' => 'S', 'Ż' => 'S', 'ą' => 'o', 'ć' => 'c',
		'ę' => 'e', 'ł' => 'w', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 's', 'ż' => 's',
		'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z',
		'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
		'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
		'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
		'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
		'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
		'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',  'ë'=>'e', 'ì'=>'i', 'í'=>'i',
		'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
		'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y',  'ý'=>'y', 'þ'=>'b',
		'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', "`" => "'", "´" => "'", "„" => ",", "`" => "'",
		"´" => "'", "“" => "\"", "”" => "\"", "´" => "'", "&acirc;€™" => "'", "{" => "",
		"~" => "", "–" => "-", "’" => "'",);
		 
		$str = str_replace(array_keys($invalid), array_values($invalid), $str);
		 
		return $str;
	 	
	}


} // END class
?>