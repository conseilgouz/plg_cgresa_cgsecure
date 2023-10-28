<?php
/**
* CG Resa CG Secure Plugin  - Joomla 4.x/5.x plugin
* Version			: 3.0.0
* Package			: CG Resa CGSecure Plugin
* copyright 		: Copyright (C) 2023 ConseilGouz. All rights reserved.
* license    		: https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
*/

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use ConseilGouz\Plugin\Cgresa\Cgsecure\Extension\Cgsecure;

return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.3.0
     */
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
				$dispatcher = $container->get(DispatcherInterface::class);
                $plugin     = new Cgsecure(
                    $dispatcher,
                    (array) PluginHelper::getPlugin('cgresa', 'cgsecure')
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};
