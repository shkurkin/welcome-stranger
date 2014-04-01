<?php

/*
 * Interface
 */
require_once(dirname(__FILE__).'/LookbookGenMethod.php');

/**
 * LBAssignmentsActions class
 *
 * @package default
 * @author Business Tech (www.businesstech.fr) - Contact: modules@businesstech.fr
 **/
/**
* 
*/
class LBViewActions implements LookbookGenMethod
{
	private $error = array();
	private $languages;
	private $view;
	
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
		parse_str($this->params,$params);
		switch($params['operation'])
		{
			case 'getCategoryView':
				$this->view = 'tabs-1';
				return $this->renderTemplate('categoryView');
			break;
			case 'getLookbookView':
				$this->view = 'tabs-2';
				return $this->renderTemplate('lookbookView');
			break;
			case 'getAssignmentView':
				$this->view = 'tabs-3';
				return $this->renderTemplate('assignmentView');
			break;
			case 'getImageView':
				$this->view = 'tabs-4';
				return $this->renderTemplate('imageView');
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
	 */
	public function renderTemplate($template,$msg = false)
	{
		${$template} = $GLOBALS['smarty']->fetch(dirname(__FILE__).'/../views/templates/admin/'.$template.'.tpl');

		if (!$msg) {
			$template = array(
				'output' => 'html',
				'view' => $this->view,
				'viewContent' => ${$template},
				'lines' => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
			);
		}
		else {
			$template = array(
				'class' => 'infomsg',
				'type' => 'info',
				'msg' => $msg,
				'output' => 'html',
				'view' => $this->view,
				'viewContent' => ${$template},
				'lines' => array('0' => Lookbook::$oModule->l('Entry successfully inserted in database!')),
			);
		}

		return $template;
	}
}