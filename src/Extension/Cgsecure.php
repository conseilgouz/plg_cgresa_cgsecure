<?php
/**
 * @component     Plugin CG Resa CG Secure
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 * @copyright (c) 2025 ConseilGouz. All Rights Reserved.
 * @author ConseilGouz 
**/
namespace ConseilGouz\Plugin\Cgresa\Cgsecure\Extension; 
// No direct access.
defined('_JEXEC') or die();
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use ConseilGouz\CGSecure\Cgipcheck;

class Cgsecure extends CMSPlugin
{
    public $myname='CGResaCGSecure';
	public $mymessage='CG Resa : wrong country/spammer...';
	public $errtype = 'w'; // warning : no access
	public $cgsecure_params;

	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->cgsecure_params = Cgipcheck::getParams();
		
	}
	
	public function onResaFormPrepare($credentials, $options, &$response)
	{
		$prefixe = $_SERVER['SERVER_NAME'];
		$prefixe = substr(str_replace('www.','',$prefixe),0,2);
		$this->mymessage = $prefixe.$this->errtype.'-'.$this->mymessage;
		Cgipcheck::check_ip($this,$this->myname.' : onResaFormPrepare');
	}
}
