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

class ProviderConfigServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Provider\ConfigProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('zf-maintenance-options');
        $providers = $options->getProviders();

        if (!isset($providers['Jgut\Zf\Maintenance\Provider\ConfigProvider'])) {
            throw new \InvalidArgumentException('Config for "Jgut\Zf\Maintenance\Provider\ConfigProvider" not set');
        }

        $provider = new ConfigProvider();

        $providerConfig = $providers['Jgut\Zf\Maintenance\Provider\ConfigProvider'];

        if (isset($providerConfig['active'])) {
            $provider->setActive($providerConfig['active']);
        }

        return $provider;
    }
}
