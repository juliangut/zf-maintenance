<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance;

class ViewScheduledMaintenanceServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance
     */
    public function createService(ServiceLocatorInterface $helperPluginManager)
    {
        $serviceLocator = $helperPluginManager->getServiceLocator();
        $options        = $serviceLocator->get('zf-maintenance-options');

        return new ScheduledMaintenance($options->getProviders());
    }
}
