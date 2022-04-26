<?php
/**
 * @component     Plugin CG Resa CG Secure
 * Version			: 1.0.1
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2021 ConseilGouz. All Rights Reserved.
 * @author ConseilGouz 
 * Updated on       : November, 2021
**/

// No direct access.
defined('_JEXEC') or die();
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class PlgCGResaCGSecure extends CMSPlugin
{
    public $myname='CGResaCGSecure';
	public $mymessage='CG Resa : wrong country/spammer...';
	public $errtype = 'w'; // warning : no access
	public $cgsecure_params;

	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$helperFile = JPATH_SITE . '/libraries/cgsecure/ipcheck.php';

		if (!class_exists('CGIpCheckHelper') && is_file($helperFile))
		{
			include_once $helperFile;
		}
		if (!class_exists('CGIpCheckHelper')) { // library not found
			$lang = Factory::getLanguage();
			$lang->load('com_cgsecure',JPATH_ADMINISTRATOR);		
			Factory::getApplication()->enqueueMessage(Text::_('CGSECURE_LIB_NOTFOUND'),'error');
			return  true;
		}
		$this->cgsecure_params = \CGIpCheckHelper::getParams();
		
	}
	
	public function onResaFormPrepare($credentials, $options, &$response)
	{
		$prefixe = $_SERVER['SERVER_NAME'];
		$prefixe = substr(str_replace('www.','',$prefixe),0,2);
		$this->mymessage = $prefixe.$this->errtype.'-'.$this->mymessage;
		if (!class_exists('CGIpCheckHelper')) { // library not found
			$lang = Factory::getLanguage();
			$lang->load('com_cgsecure',JPATH_ADMINISTRATOR);		
			Factory::getApplication()->enqueueMessage(Text::_('CGSECURE_LIB_NOTFOUND'),'error');
			return  true;
		}
		\CGIpCheckHelper::check_ip($this,$this->myname.' : onResaFormPrepare');
	}
}
