<?php

/*
 * Interface
 */
require_once(dirname(__FILE__).'/LookbookGenMethod.php');

/**
 * undocumented class
 *
 * @package default
 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
 **/
/**
* 
*/
class LBCategoryActions implements LookbookGenMethod
{
	private $error = array();
	private $languages;
	
	
	/**
	 * undocumented function
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
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function __destruct()
	{

	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function send()
	{
		return true;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function getFieldsList()
	{
		return true;
	}
	
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function getResult()
	{
		parse_str($this->params,$params);
		switch($params['operation'])
		{
			case 'edit':
				return $this->edit($params);
			break;
			case 'toggle':
				return $this->toggle($params);
			break;
			case 'delete':
				return $this->delete($params);
			break;
			case 'template':
				return $this->template();
			break;
			default:
				return false;
			break;
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function toggle($params)
	{
		
		$sql = '	UPDATE `%1$slookbook_category`
					SET active = active XOR 1
					WHERE id_category = %2$d';
		
		$sql = sprintf($sql,_DB_PREFIX_,$params['category']);
		
		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when activate/desactivate category!'))));
		
		$categorySummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/categorySummary.tpl');

		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => 'categoryStatus',
			'output' => 'html',
			'view' => 'category',
			'viewContent' => $categorySummary,
			'lines' => array('0' => Lookbook::$oModule->l('State of category successfully changed!')),
		);
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function edit($params)
	{
		$sql = '	SELECT c.*,cl.*
					FROM `%1$slookbook_category` AS c
					LEFT JOIN `%1$slookbook_category_lang` cl ON (c.id_category = cl.id_category)
					WHERE c.id_category = %2$d';
							
		$sql = sprintf($sql,_DB_PREFIX_,$params['category']);

		if(!$result = Db::getInstance()->ExecuteS($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when get DB Data!'))));

		foreach($result as $key => $r)
			$resultValues[$r['id_lang']] = $r;

		$GLOBALS['smarty']->assign(array(
			'update' => true,
			'categoryValues' => $resultValues,
		));
		
		$categoryForm = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/categoryForm.tpl');
		
		return array(
			'output' => 'html',
			'view' => 'categoryForm',
			'viewContent' => $categoryForm,
			'lines' => array('0' => Lookbook::$oModule->l('Category loaded successfully!')),
		);
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function delete($params)
	{

		$sql = '	DELETE FROM `%1$slookbook_category`,`%1$slookbook_category_lang`,`%1$slookbooks_categories`
					USING `%1$slookbook_category`
		    		LEFT JOIN `%1$slookbook_category_lang` USING(id_category) 
		    		LEFT JOIN `%1$slookbooks_categories` USING(id_category) 
					WHERE `%1$slookbook_category`.id_category = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,$params['category']);

		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when deleting category!'))));

		$categorySummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/categorySummary.tpl');

		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => 'categoryDelete',
			'output' => 'html',
			'view' => 'category',
			'viewContent' => $categorySummary,
			'lines' => array('0' => Lookbook::$oModule->l('This category has been successufully deleted!')),
		);
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $value 
	 * @return void
	 *
	 */
	public function template()
	{
		$GLOBALS['smarty']->assign('update', false);
		
		$categoryForm = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/categoryForm.tpl');
		
		return array(
			'output' => 'html',
			'view' => 'categoryForm',
			'viewContent' => $categoryForm,
			'lines' => array('0' => Lookbook::$oModule->l('Category template loaded successfully!')),
		);
		
	}
	
}