<?php
/**
 * Juliangut Zend Framework Maintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance;

use Zend\Mvc\MvcEvent;

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
}
