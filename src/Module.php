<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance;

use Zend\Mvc\MvcEvent;
use JgutZfMaintenance\Provider\AbstractProvider;
use JgutZfMaintenance\View\Helper\ScheduledMaintenance;

class Module
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application    = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        $eventManager   = $application->getEventManager();
        $options        = $serviceManager->get('zf-maintenance-options');

        foreach (array_keys($options->getProviders()) as $provider) {
            if ($serviceManager->has($provider)) {
                $eventManager->attach($serviceManager->get($provider));
            }
        }

        $strategy = $serviceManager->get($options->getMaintenanceStrategy());
        $eventManager->attach($strategy);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/../autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'scheduledMaintenance' => function (AbstractPluginManager $pluginManager) {
                    $serviceLocator = $pluginManager->getServiceLocator();
                    $options        = $serviceLocator->get('zf-maintenance-options');

                    return new ScheduledMaintenance($options->getProviders());
                }
            ),
        );
    }
}
