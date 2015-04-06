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
use Jgut\Zf\Maintenance\Provider\EnvironmentProvider;

class ProviderEnvironmentServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Provider\EnvironmentProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('ZfMaintenanceOptions');
        $providers = $options->getProviders();

        if (!isset($providers['ZfMaintenanceEnvironmentProvider'])) {
            throw new \InvalidArgumentException(
                'Config for "Jgut\Zf\Maintenance\Provider\EnvironmentProvider" not set'
            );
        }

        $provider = new EnvironmentProvider();

        $provider->setBlock($options->getBlock());

        $providerConfig = $providers['ZfMaintenanceEnvironmentProvider'];

        if (isset($providerConfig['message'])) {
            $provider->setMessage($providerConfig['message']);
        }

        if (!isset($providerConfig['variable'])) {
            throw new \InvalidArgumentException(
                'Environment variable for "Jgut\Zf\Maintenance\Provider\EnvironmentProvider" not set'
            );
        }

        $provider->setVar($providerConfig['variable']);

        if (isset($providerConfig['value'])) {
            $provider->setValue($providerConfig['value']);
        }

        return $provider;
    }
}
