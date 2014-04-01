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
class LBCreateCategory implements LookbookGenMethod
{
	private $error = array();
	private $languages;
	
	private $_fields = array(
		'list' => array(
			'id_category' => array(
				'required'			=> false,
				'decl'				=> false,
				'value'				=> '',
				'regexValidation'	=> '#^[0-9]+$',
				'realName'			=> 'id_category'
			),
			'category_name'	=> array(
				'required'			=>	true,
				'decl'				=>	true,
				'value'				=>	'',
				'regexValidation'	=>	'#^[&\(\)\+_a-zA-ZĄĆĘŁŃÓŚŹŻąćęłńóśźÁÅÃÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿąłęó\-\ ]+$#',
				'realName'			=>	'Category Name'
			),
			'category_desc'	=> array(
				'required'			=>	false,
				'decl'				=>	true,
				'value'				=>	'',
				'regexValidation'	=>	'#^.*$#',
				'realName'			=>	'Category Description'
			),
			'active' => array(
				'required'			=>	true,
				'decl'				=>	false,
				'value'				=>	'',
				'regexValidation'	=>	'#^(on|off)$#',
				'realName'			=>	'Category Active'
			),
		)
	);
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
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
	 * @author
	 **/
	public function init()
	{

	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	public function send()
	{
		return true;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	public function getFieldsList()
	{
		return true;
	}
	
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	public function getResult()
	{
		if(!$this->insertIntoDb())
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error in MySQL INSERT'))));

		$categorySummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/categorySummary.tpl');

		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => $this->_message,
			'output' => 'html',
			'view' => 'category',
			'viewContent' => $categorySummary,
			'lines' => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
		);

	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function insertIntoDb()
	{
		parse_str($this->params,$params);
		if (!$this->checkValues($params))
			throw new Exception(serialize($this->error));
			
		if (empty($params['id_category']))
			$sql = sprintf('INSERT INTO `'._DB_PREFIX_.'lookbook_category` (active) VALUES (%s)',($params['active'] == 'true' || $params['active'] == 'checked') ? '1' : '0');
		else
			$sql = sprintf('UPDATE `'._DB_PREFIX_.'lookbook_category` SET active = %d WHERE `id_category` = %d',($params['active'] == 'true' || $params['active'] == 'checked') ? '1' : '0',(int)$params['id_category']);
		if (!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error in SQL Query : ') . "<br/>". $sql)));
		$id_category = Db::getInstance()->Insert_ID();
		foreach ($this->languages as $language)
		{
			if (empty($params['id_category']))
				$sql = sprintf('INSERT INTO `'._DB_PREFIX_.'lookbook_category_lang` (`id_category`,`id_lang`,`name`,`link`,`description`) VALUES (%d,%d,"%s","%s","%s")',$id_category,$language['id_lang'],pSQL($params['category_name_'.$language['id_lang']]),Lookbook::$oModule->stringToURLString($params['category_name_'.$language['id_lang']]),pSQL($params['category_desc_'.$language['id_lang']]));
			else
				$sql = sprintf('UPDATE `'._DB_PREFIX_.'lookbook_category_lang` SET `id_category`= %5$d,`id_lang` = %1$d,`name` = "%2$s",`link` = "%3$s",`description` = "%4$s" WHERE `id_category` = %5$d AND `id_lang` = %1$d',$language['id_lang'],$params['category_name_'.$language['id_lang']],Lookbook::$oModule->stringToURLString($params['category_name_'.$language['id_lang']]),pSQL($params['category_desc_'.$language['id_lang']]),(int)$params['id_category']);
			if(!Db::getInstance()->Execute($sql))
				throw new Exception(serialize(array(Lookbook::$oModule->l('Error in SQL Query : ') . "<br/>". $sql)));
		}
		
		$this->_message = (empty($params['id_category'])) ? 'categoryAdded' : 'categoryUpdated';
		
		return true;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author
	 **/
	function checkValues($params)
	{
		foreach($this->_fields['list'] as $fKey => $f)
		{
			foreach($this->languages as $lang)
			{
				if($f['decl'])
				{
					if($f['required'])
					{
						if(empty($params[$fKey.'_'.$lang['id_lang']]) OR !preg_match($f['regexValidation'],$params[$fKey.'_'.$lang['id_lang']]))
							$this->error[] = Lookbook::$oModule->l('An error or empty value is present in field: ') . $f['realName'] . " " . $lang['name'];
					}
					else
					{
						if(!preg_match($f['regexValidation'],$params[$fKey.'_'.$lang['id_lang']]))
							$this->error[] = Lookbook::$oModule->l('An error is present in field: ') . $f['realName']  . " " . $lang['name'];
					}
				}
			}
		}
		
		if(count($this->error))
		{
			$error = array(
				'class' => 'errormsg',
				'type' => 'error',
				'output' => 'html',
				'lines' => $this->error,
			);
			$this->error = $error;
			return false;
		}
		return true;
	}
}
?>