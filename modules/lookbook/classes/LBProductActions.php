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
class LBProductActions implements LookbookGenMethod
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
			case 'toggle':
				$this->toggle($params);
			break;
			case 'delete':
				$this->delete($params);
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
		$sql = '	UPDATE `%1$slookbook`
					SET active = active XOR 1
					WHERE id_lookbook = %2$d';
					
		$sql = sprintf($sql,_DB_PREFIX_,$params['lb']);
		
		if(!Db::getInstance()->ExecuteS($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when activate/desactivate lookbook!'))));
		return true;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function edit($params)
	{
		return false;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
	 **/
	public function delete($params)
	{
		$sql = '	DELETE FROM `%1$slookbook`,`%1$slookbook_lang`
					USING `%1$slookbook` INNER JOIN `%1$slookbook_lang`
					WHERE `%1$slookbook`.id_lookbook = %2$d AND `%1$slookbook`.id_lookbook = `%1$slookbook_lang`.id_lookbook';

		$sql = sprintf($sql,_DB_PREFIX_,$params['lb']);

		if(!Db::getInstance()->ExecuteS($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when deleting lookbook!'))));
		return true;
	}
}