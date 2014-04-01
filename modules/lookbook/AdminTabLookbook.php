<?php
include_once(dirname(__FILE__) . '/lookbook.php');
/**
 * AdminTabLookbook.php file defines admin tab class of module
 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
 * @category admin tab collection
 * @license Business Tech
 * @uses Please read included installation and configuration instructions (PDF format)
 * @see
 * @date 11/05/2012
 */

if (!defined('_CAN_LOAD_FILES_'))
	exit;


/**
 * undocumented class
 *
 * @package default
 * @author
 */
class AdminTabLookbook extends AdminTab
{
    /**
     * @var obj $multishop_context : store multishop context
     */
    public $multishop_context;

    /**
     * @var obj $multishop_context_group : store multishop group context
     */
    public $multishop_context_group;

    /**
	 * @var string $_html : store html
	 */
	private $_html;

	/**
	 * Magic Method __construct assigns few information about module and instantiate parent class
	 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
	 * @category main class
	 * @see
	 */
	function __construct()
	{
		$this->className = 'ClassLookbook';
		$this->module = 'lookbook';
		parent::__construct();

		// use case - get context
		if (version_compare(_PS_VERSION_, '1.5', '>'))
		{
			$cookie = Context::getContext()->cookie;
		}
		else
		{
			global $cookie;
		}

		$this->_cookie = $cookie;
		
		$lookbookObj = new Lookbook();
		$GLOBALS['smarty']->assign('lookbookObj', $lookbookObj);
	}

	/**
	 * Magic Method __destruct
	 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
	 * @category main class
	 * @see
	 */
	public function __destruct()
	{
		unset($this->lookbookObj);
	}
	
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 */
	public function display()
	{
		// If ajax is solicited, clean html output to remove PS header and includes Ajax classes & methods and exit.
		if (Tools::getValue('lbAjax') == 'true')
		{
			ob_clean();
			include_once(_PS_MODULE_DIR_ . $this->module . '/ajax.php');
			exit(0);
		}
        // detect if multshop group or all shop is activated
        $GLOBALS['smarty']->assign('bMultiGroupError', Lookbook::isMultishopConfig());


		$this->_html .= $GLOBALS['smarty']->fetch(_PS_MODULE_DIR_ . $this->module . '/views/templates/admin/mainView.tpl');
		echo $this->_html;
	}
} // END class
?>