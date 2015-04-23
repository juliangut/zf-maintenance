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
use Jgut\Zf\Maintenance\View\MaintenanceStrategy;

/**
 * Factory responsible of instantiating {@see Jgut\Zf\Maintenance\View\MaintenanceStrategy}
 */
class MaintenanceStrategyServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return MaintenanceStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('ZfMaintenanceOptions');

        return new MaintenanceStrategy($options->getTemplate());
    }
}
