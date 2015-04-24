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
use Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage;

/**
 * Factory responsible of instantiating {@see Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage}
 */
class ViewMaintenanceMessageServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return MaintenanceMessage
     */
    public function createService(ServiceLocatorInterface $helperPluginManager)
    {
        $serviceLocator = $helperPluginManager->getServiceLocator();
        $options        = $serviceLocator->get('ZfMaintenanceOptions');

        return new MaintenanceMessage($options->getProviders());
    }
}
