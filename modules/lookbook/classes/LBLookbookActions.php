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
class LBLookbookActions implements LookbookGenMethod
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
			case 'getLookbookImage':
				return $this->getLookbookImage($params);
			break;
			case 'template':
				return $this->template($params);
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
					
		$sql = sprintf($sql,_DB_PREFIX_,$params['lookbook']);
		
		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when activate/desactivate lookbook!'))));

		$lookbookSummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookSummary.tpl');

		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => 'lookbookStatus',
			'output' => 'html',
			'view' => 'lookbook',
			'viewContent' => $lookbookSummary,
			'lines' => array('0' => Lookbook::$oModule->l('State of lookbook successfully changed!')),
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
		$sql = '	SELECT l.*,ll.*
					FROM `%1$slookbook` AS l
					LEFT JOIN `%1$slookbook_lang` ll ON (l.id_lookbook = ll.id_lookbook)
					WHERE l.id_lookbook = %2$d';
							
		$sql = sprintf($sql,_DB_PREFIX_,$params['lookbook']);

		if(!$result = Db::getInstance()->ExecuteS($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when get DB Data!'))));
			
		foreach($result as $key => $r)
			$resultValues[$r['id_lang']] = $r;

		$GLOBALS['smarty']->assign(array(
				'update' => true,
				'lookbookValues' => $resultValues,
			)
		);
		
		$lookbookForm = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookForm.tpl');
		
		return array(
			'output' => 'html',
			'view' => 'lookbookForm',
			'viewContent' => $lookbookForm,
			'lines' => array('0' => Lookbook::$oModule->l('Lookbook loaded successfully!')),
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
		
		
		$sql = '	DELETE FROM `%1$slookbook`,`%1$slookbook_lang`,`%1$slookbooks_products`
					USING `%1$slookbook`
		    		LEFT JOIN `%1$slookbook_lang` USING(id_lookbook) 
		    		LEFT JOIN `%1$slookbooks_products` USING(id_lookbook) 
					WHERE `%1$slookbook`.id_lookbook = %2$d';
		
		$sql = sprintf($sql,_DB_PREFIX_,(int)$params['lookbook']);

		$image = Lookbook::$oModule->getLookbookImages($params['lookbook']);


		foreach(Lookbook::$oModule->getLookbookImages($params['lookbook']) as $image)
		{
			if(strlen($image['image_url']) > 0)
			{
				if(file_exists(_PS_MODULE_DIR_.Lookbook::$oModule->name.'/uploads/'.$image['image_url']))
					unlink(_PS_MODULE_DIR_.Lookbook::$oModule->name.'/uploads/'.$image['image_url']);
				if(file_exists(_PS_MODULE_DIR_.Lookbook::$oModule->name.'/uploads/thumbs/'.$image['image_url']))
					unlink(_PS_MODULE_DIR_.Lookbook::$oModule->name.'/uploads/thumbs/'.$image['image_url']);
			}
		}

		if(!Db::getInstance()->Execute($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when deleting lookbook!'))));
		
		$lookbookSummary = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookSummary.tpl');

		return array(
			'class' => 'infomsg',
			'type' => 'info',
			'msg' => 'lookbookDelete',
			'output' => 'html',
			'view' => 'lookbook',
			'viewContent' => $lookbookSummary,
			'lines' => array('0' => Lookbook::$oModule->l('This lookbook has been successufully deleted!')),
		);
		
	}
	
	/**
	 * getLookbookImages function
	 *
	 * @param string $params 
	 * @return array
	 *
	 */
	public function getLookbookImage($params)
	{
		$sql = '	SELECT l.*,ll.*
					FROM `%1$slookbook` AS l
					LEFT JOIN `%1$slookbook_lang` ll ON (l.id_lookbook = ll.id_lookbook)
					WHERE l.id_lookbook = %2$d
					AND ll.id_lang = %3$d';

		$sql = sprintf($sql,_DB_PREFIX_,$params['lookbook'],$params['lang']);

		if(!$result = Db::getInstance()->ExecuteS($sql))
			throw new Exception(serialize(array(Lookbook::$oModule->l('Error when get DB Data!'))));
		$result = $result[0];

		if(strlen($result['image_url']) > 0)
		{	
			if(file_exists(_PS_MODULE_DIR_.'lookbook/uploads/'.$result['image_url']) && file_exists(_PS_MODULE_DIR_.'lookbook/uploads/thumbs/'.$result['image_url']))
			{
				$image_url = $result['image_url'];
			}
		}

		if(!empty($image_url))
			$GLOBALS['smarty']->assign('image',$image_url);
		else
			$GLOBALS['smarty']->assign('image','');
					
		$lookbookImage = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookImage.tpl');
	
		return array(
			'output' => 'html',
			'view' => 'current_lookbook_image',
			'viewContent' => $lookbookImage,
			'lines' => array('0' => Lookbook::$oModule->l('Lookbook template loaded successfully!')),
		);
	}
	
	
	/**
	 * template function
	 *
	 * @param string $value 
	 * @return void
	 *
	 */
	public function template()
	{

		$GLOBALS['smarty']->assign('update', false);
		
		$lookbookForm = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/lookbookForm.tpl');
		
		return array(
			'output' => 'html',
			'view' => 'lookbookForm',
			'viewContent' => $lookbookForm,
			'lines' => array('0' => Lookbook::$oModule->l('Lookbook template loaded successfully!')),
		);
		
	}
	
}