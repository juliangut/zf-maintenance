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
use JgutZfMaintenance\Provider\ConfigProvider;

class ProviderConfigServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \JgutZfMaintenance\Provider\ConfigProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('zf-maintenance-options');
        $providers = $options->getProviders();

        if (!isset($providers['JgutZfMaintenance\Provider\ConfigProvider'])) {
            throw new \InvalidArgumentException(
                'Config for "JgutZfMaintenance\Provider\ConfigProvider" not set'
            );
        }

        $provider = new ConfigProvider();

        $providerConfig = $providers['JgutZfMaintenance\Provider\ConfigProvider'];

        if (isset($providerConfig['active'])) {
            $provider->setActive($providerConfig['active']);
        }

        return $provider;
    }
}
