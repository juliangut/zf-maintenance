<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JgutZfMaintenance\View\MaintenanceStrategy;

/**
 * Factory responsible of instantiating {@see \JgutZfMaintenance\View\MaintenanceStrategy}
 */
class MaintenanceStrategyServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \JgutZfMaintenance\View\MaintenanceStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zf-maintenance-options');

        return new MaintenanceStrategy($options->getTemplate());
    }
}
