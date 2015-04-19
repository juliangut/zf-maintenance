<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\Collector\MaintenanceCollector;

class MaintenanceCollectorServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Collector\MaintenanceCollector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('ZfMaintenanceOptions');

        return new MaintenanceCollector($options->getProviders());
    }
}
