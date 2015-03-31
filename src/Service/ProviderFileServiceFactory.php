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
use Jgut\Zf\Maintenance\Provider\FileProvider;

class ProviderFileServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Provider\FileProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('zf-maintenance-options');
        $providers = $options->getProviders();

        if (!isset($providers['Jgut\Zf\Maintenance\Provider\FileProvider'])) {
            throw new \InvalidArgumentException('Config for "Jgut\Zf\Maintenance\Provider\FileProvider" not set');
        }

        $provider = new FileProvider();

        $providerConfig = $providers['Jgut\Zf\Maintenance\Provider\FileProvider'];

        if (isset($providerConfig['file'])) {
            $provider->setFile($providerConfig['file']);
        }

        return $provider;
    }
}
