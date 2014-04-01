<?php

/*
 * Interface
 */
require_once(dirname(__FILE__) . '/LookbookGenMethod.php');

/**
 * LBAssignmentsActions class
 *
 * @package default
 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
 **/
/**
* 
*/
class LBAssignmentsActions implements LookbookGenMethod
{
	private $error = array();
	private $languages;
	private $_lookbook;

	
	/**
	 * __construct function
	 *
	 * @return void
	 *
	 **/
	public function __construct($params)
	{
		$this->params = $params;
		$this->languages = Language::getLanguages();
	}
	
	/**
	 * __destruct function
	 *
	 * @return void
	 *
	 **/
	public function __destruct()
	{

	}
	
	/**
	 * send function
	 *
	 * @return void
	 *
	 **/
	public function send()
	{
		return true;
	}
	
	/**
	 * getFieldsList function
	 *
	 * @return void
	 *
	 **/
	public function getFieldsList()
	{
		return true;
	}
	
	
	/**
	 * getResult function
	 *
	 * @return void
	 *
	 **/
	public function getResult()
	{
		parse_str($this->params, $params);

		switch ($params['operation'])
		{
			case 'getLookbooksForCategory':
				return $this->renderTemplate($params,'lookbookAssignments');
				break;
			case 'getProductsForLookbook':
				return $this->renderTemplate($params,'productAssignmentsAssigned');
				break;
			case 'getUnAssignedProducts':
				return $this->renderTemplate($params,'productAssignmentsUnAssigned');
				break;
			case 'assignLookbooks':
				$this->assignLookbooks($params);
				return $this->renderTemplate($params,'lookbookAssignments','lookbookAssignments');
				break;
			case 'assignProducts':
				$this->assignProducts($params);
				return $this->renderTemplate($params,'productAssignmentsAssigned','productAssignments');
				break;
			case 'unAssignLookbooks':
				$this->unAssignLookbooks($params);
				return $this->renderTemplate($params,'lookbookAssignments','lookbookUnAssignments');
				break;
			case 'unAssignProducts':
				$this->unAssignProducts($params);
				return $this->renderTemplate($params,'productAssignmentsAssigned','productUnAssignments');
				break;
			default:
				return false;
				break;
		}
	}
	
	/**
	 * getAssignedLookbooks function
	 *
	 * @param string $params 
	 * @return mixed
	 *
	 */
	public function getAssignedLookbooks($params)
	{
		return (
			empty($params['category']) ? false : Lookbook::$oModule->getAssignedLookbooks($params['category'])
		);
	}

	/**
	 * getUnAssignedLookbooks function
	 * This method fetch all the unassigned lookbooks for a category.
	 *
	 * @param string $params 
	 * @return mixed
	 *
	 */
	public function getUnAssignedLookbooks($params)
	{
		return (
			empty($params['category']) ? false : Lookbook::$oModule->getUnAssignedLookbooks($params['category'])
		);
	}
	
	
	/**
	 * assignLookbooks function
	 * This method inserts in the db all the lookbooks assigned to one given category. It's called from Assignments tab.
	 *
	 * @param string $params 
	 * @return boolean
	 *
	 */
	public function assignLookbooks($params)
	{
		$lookbooks = explode(',',$params['lookbook']);
		if(count($lookbooks) && empty($lookbooks[0]))
			return true;
		foreach($lookbooks as $l)
		{
			$sql = '	REPLACE INTO `%1$slookbooks_categories` (`id_category`,`id_lookbook`) VALUES (%2$d,%3$d)';
			$sql = sprintf($sql,_DB_PREFIX_,(int)$params['category'],(int)$l);
			if(!Db::getInstance()->Execute($sql))
				throw new Exception(serialize(array(Lookbook::$oModule->l('Something\'s get wrong while inserting in the DB!'))));
		}
		return true;
	}
	
	
	/**
	 * unAssignLookbooks method
	 * This methods unassigns all the lookbooks in the module admin for a given category. It's called from Assignments tab.
	 *
	 * @param string $params 
	 * @return boolean
	 *
	 */
	public function unAssignLookbooks($params)
	{
		$sql = '	DELETE FROM `%1$slookbooks_categories` WHERE `id_lookbook` IN (%2$s) AND `id_category` = %3$d';
		$sql = sprintf ($sql,_DB_PREFIX_,$params['lookbook'],(int)$params['category']);
		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Something\'s get wrong while deleting from the DB!'))));
		return true;
	}
	
	/**
	 * getAssignedProducts function
	 *
	 * @param string $params 
	 * @return array
	 *
	 */
	public function getAssignedProducts($params)
	{
		if($params['lookbook'] < 1 or !isset($params['lookbook']))
			return false;
		$manufacturers = Lookbook::$oModule->getManufacturers();
		$aProducts = Lookbook::$oModule->getAssignedProducts($params['lookbook']);
		$assignedProducts = array();

		foreach($aProducts as $ap)
		{
			$productDetails = Lookbook::$oModule->getProductDetails($ap['id_product']);
			$assignedProducts[$productDetails[0]['id_manufacturer']][] = array(
				'id_product' => $productDetails[0]['id_product'],
				'id_manufacturer' => $productDetails[0]['id_manufacturer'],
				'name' => $productDetails[0]['name'],
			);
		}

		if(!count($assignedProducts))
			return array();
			
		return $assignedProducts;
	}
	
	
	/**
	 * getUnAssignedProducts function
	 *
	 * @param string $params 
	 * @return mixed
	 *
	 */
	public function getUnAssignedProducts($params)
	{
        if(empty($params['lookbook']))
			return false;

		$manufacturers = Lookbook::$oModule->getManufacturers();
		$uProducts = Lookbook::$oModule->getUnAssignedProducts($params['lookbook']);

        $unAssignedProducts = array();
		
		foreach($uProducts as $ap)
		{
			$productDetails = Lookbook::$oModule->getProductDetails($ap['id_product']);
			$unAssignedProducts[$productDetails[0]['id_manufacturer']][] = array(
				'id_product'        => $productDetails[0]['id_product'],
				'id_manufacturer'   => $productDetails[0]['id_manufacturer'],
				'name'              => $productDetails[0]['name'],
			);
		}

		if (!is_array($unAssignedProducts))
			return array();
		return (isset($unAssignedProducts[$params['manufacturer']])) ? $unAssignedProducts[$params['manufacturer']] : array();
	}
	
	/**
	 * assignLookbooks function
	 * This method inserts in the db all the lookbooks assigned to one given category. It's called from Assignments tab.
	 *
	 * @param string $params 
	 * @return boolean
	 *
	 */
	public function assignProducts($params)
	{
		$products = explode(',',$params['product']);

		if (count($products) == 1 && empty($products[0]))
			return true;
		foreach ($products as $p)
		{
			$sql = '	REPLACE INTO `%1$slookbooks_products` (`id_product`,`id_lookbook`) VALUES (%2$d,%3$d)';
			$sql = sprintf($sql,_DB_PREFIX_,(int)$p,(int)$params['lookbook']);
			if (!Db::getInstance()->Execute($sql))
				throw new Exception(serialize(array(Lookbook::$oModule->l('Something\'s get wrong while inserting in the DB!'))));
		}
		return true;
	}
	

	/**
	 * unAssignLookbooks method
	 * This methods unassigns all the lookbooks in the module admin for a given category. It's called from Assignments tab.
	 *
	 * @param string $params 
	 * @return bolean
	 *
	 */
	public function unAssignProducts($params)
	{
		$products = explode(',',$params['product']);
		foreach ($products as $p)
		{
			$sql = 'DELETE FROM `%1$slookbooks_products` WHERE `id_product` IN (%2$s) AND `id_lookbook` = %3$d';
			$sql = sprintf ($sql,_DB_PREFIX_,(int)$p,(int)$params['lookbook']);
			if (!Db::getInstance()->Execute($sql))
				throw new Exception(serialize(array(Lookbook::$oModule->l('Something\'s get wrong while deleting from the DB!'))));
		}	
		return true;
	}

	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 */
	public function renderTemplate($params,$template,$msg = false)
	{
		global $smarty;

		if (isset($params['category']))
		{
			$smarty->assign(
				array(
					'id_category'           => $params['category'],
					'unAssignedLookbooks'   => $this->getUnAssignedLookbooks($params),
					'assignedLookbooks'     => $this->getAssignedLookbooks($params),
				)
			);
		}

		if (isset($params['lookbook']))
		{
			$smarty->assign(
				array(
					'id_lookbook'       => $params['lookbook'],
					'assignedProducts'  => $this->getAssignedProducts($params),
				)
			);
		}

		if (isset($params['manufacturer']))
		{
            $smarty->assign(
				array(
					'id_manufacturer'       => $params['manufacturer'],
					'unAssignedProducts'    => $this->getUnAssignedProducts($params),
				)
			);
        }
		${$template} = $smarty->fetch(dirname(__FILE__) . '/../views/templates/admin/' . $template . '.tpl');

		if (!$msg)
		{
			$template = array(
				'output'        => 'html',
				'view'          => $template,
				'viewContent'   => ${$template},
				'lines'         => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
			);
		}
		else
		{
			$template = array(
				'class' => 'infomsg',
				'type' => 'info',
				'msg' => $msg,
				'output' => 'html',
				'view' => $template,
				'viewContent' => ${$template},
				'lines' => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
			);
		}

		return $template;
	}
}
?>