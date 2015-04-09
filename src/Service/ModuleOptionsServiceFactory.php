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
use Jgut\Zf\Maintenance\Options\ModuleOptions;

class ModuleOptionsServiceFactory implements FactoryInterface
{
    /**
     * Configuration key.
     *
     * @var string
     */
    protected $configKey = 'zf-maintenance';

    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Options\ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config            = $serviceLocator->get('Config');
        $maintenanceConfig = !empty($config[$this->configKey]) ? $config[$this->configKey] : array();

        return new ModuleOptions($maintenanceConfig);
    }
}
