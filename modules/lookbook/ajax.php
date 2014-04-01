<?php
/**
 * 
 */
/**
 * undocumented 
 *
 * @author
 */
$method = Tools::getValue('method');
$params = array();
$result = array();

//var_dump($method, $params);

switch($method)
{
	case 'LBCreateCategory':
	case 'LBCreateLookbook':
	case 'LBCategoryActions':
	case 'LBLookbookActions':
	case 'LBProductActions':
	case 'LBAssignmentsActions':
	case 'LBViewActions':
		require(dirname(__FILE__) . '/classes/' . $method . '.php');

		$params = Tools::getValue('params');
		break;
	default:
		break;
}

// Try to instantiate the method object name and call the mandatory method
try 
{
	if (class_exists($method, false))
	{
		$obj = new $method($params);
		// Verify that the class implement correctly the interface
		// Else use a Management class to do some ajax stuff
		if (($obj instanceof LookbookGenMethod))
		{
			$obj->send();
			$result = $obj->getResult();
		}
		unset($obj);
	}
	else
	{
		throw new Exception('Method Class : '.$method.' can\'t be found');
	}
	unset($management);
}
catch(Exception $e)
{
	$message = unserialize($e->getMessage());
	if (isset($message['output']) && $message['output'] == 'html')
	{
		global $smarty;
		$smarty->assign('lines', $message['lines']);
		$outputTemplate = $smarty->fetch(dirname(__FILE__) . '/views/templates/admin/message.tpl');
		$message['outputTemplate'] = $outputTemplate;
	 	echo LookBook::jsonEncode($message);
	}
	else
	{
		echo LookBook::jsonEncode(array('error' => $message));
	}
	exit(-1);
}
echo Lookbook::jsonEncode($result);
exit(0);
?>