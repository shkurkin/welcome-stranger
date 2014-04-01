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
class LBCreateLookbook implements LookbookGenMethod
{
	private $error = array();
	private $languages;
	private $_message;
	
	private $_fields = array(
		'list' => array(
			'id_lookbook' => array(
				'required'			=> false,
				'decl'				=> false,
				'value'				=> '',
				'regexValidation'	=> '#^[0-9]+$',
				'realName'			=> 'id_lookbook'
			),
			'lookbook_name' => array(
				'required'			=>	true,
				'decl'				=>	true,
				'value'				=>	'',
				'regexValidation'	=>	'#^[&\(\)\+_a-zA-ZĄĆĘŁŃÓŚŹŻąćęłńóśźÁÅÃÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿąłęó\-\ ]+$#',
				'realName'			=>	'Lookbook Name'
			),
			'lookbook_desc'	=>	array(
				'required'			=>	true,
				'decl'				=>	true,
				'value'				=>	'',
				'regexValidation'	=>	'#^.+$#',
				'realName'			=>	'Lookbook Description'
			),
			'active' =>	array(
				'required'			=>	true,
				'decl'				=>	false,
				'value'				=>	'',
				'regexValidation'	=>	'#^(1|0)$#',
				'realName'			=>	'Lookbook Active'
			)
		)
	);
	
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
	 * @return
	 *
	 **/
	public function getResult()
	{
		if(!$this->insertIntoDb())
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error in MySQL INSERT'))));
		$lookbookSummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookSummary.tpl');
		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => $this->_message,
			'output' => 'html',
			'view' => 'lookbook',
			'viewContent' => $lookbookSummary,
			'lines' => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
		);
	}
	
	/**
	 * undocumented function
	 *
	 * @return
	 *
	 **/
	public function insertIntoDb()
	{
		parse_str($this->params,$params);
		if(!$this->checkValues($params))
			throw new Exception(serialize($this->error));

		if(empty($params['id_lookbook']))
			$sql = sprintf('INSERT INTO `'._DB_PREFIX_.'lookbook` (shop_id, active) VALUES (' . Lookbook::$iShopId . ',%s)',($params['active'] == 'true' || $params['active'] == 'checked') ? '1' : '0');
		else
			$sql = sprintf('UPDATE `'._DB_PREFIX_.'lookbook` SET active = %d WHERE `id_lookbook` = %d',($params['active'] == 'true' || $params['active'] == 'checked') ? '1' : '0',(int)$params['id_lookbook']);

		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error in SQL Query : ') . "<br/>". $sql)));
		$id_lookbook = Db::getInstance()->Insert_ID();
		foreach ($this->languages as $language)
		{
			if(empty($params['id_lookbook']))
				$sql = sprintf('INSERT INTO `'._DB_PREFIX_.'lookbook_lang` (`id_lookbook`,`id_lang`,`name`,`link`,`description`) VALUES (%d,%d,"%s","%s","%s")',$id_lookbook,$language['id_lang'],$params['lookbook_name_'.$language['id_lang']],Lookbook::$oModule->stringToURLString($params['lookbook_name_'.$language['id_lang']]),pSQL($params['lookbook_desc_'.$language['id_lang']]));
			else
				$sql = sprintf('UPDATE `'._DB_PREFIX_.'lookbook_lang` SET `id_lookbook`= %5$d,`id_lang` = %1$d,`name` = "%2$s",`link` = "%3$s",`description` = "%4$s" WHERE `id_lookbook` = %5$d AND `id_lang` = %1$d',$language['id_lang'],$params['lookbook_name_'.$language['id_lang']],Lookbook::$oModule->stringToURLString($params['lookbook_name_'.$language['id_lang']]),pSQL($params['lookbook_desc_'.$language['id_lang']]),(int)$params['id_lookbook']);

			if(!Db::getInstance()->Execute($sql))
				throw new Exception(serialize(array(Lookbook::$oModule->l('Error in SQL Query : ') . "<br/>". $sql)));
		}

		$this->_message = (empty($params['id_lookbook'])) ? 'lookbookAdded' : 'lookbookUpdated';
		return true;
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 *
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

	public function init()
	{
		// TODO: Implement init() method.
	}
}
?>