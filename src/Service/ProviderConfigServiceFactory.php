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
use Jgut\Zf\Maintenance\Provider\ConfigProvider;

/**
 * Factory responsible of instantiating {@see Jgut\Zf\Maintenance\Provider\ConfigProvider}
 */
class ProviderConfigServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ConfigProvider
     * @throws \InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('ZfMaintenanceOptions');
        $providers = $options->getProviders();

        if (!isset($providers['ZfMaintenanceConfigProvider'])) {
            throw new \InvalidArgumentException('Config for "Jgut\Zf\Maintenance\Provider\ConfigProvider" not set');
        }

        $provider = new ConfigProvider();

        $provider->setBlock($options->isBlocked());

        $providerConfig = $providers['ZfMaintenanceConfigProvider'];

        if (isset($providerConfig['message'])) {
            $provider->setMessage($providerConfig['message']);
        }

        if (isset($providerConfig['active'])) {
            $provider->setActive($providerConfig['active']);
        }

        return $provider;
    }
}
