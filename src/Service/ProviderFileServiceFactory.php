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

/**
 * Factory responsible of instantiating {@see Jgut\Zf\Maintenance\Provider\FileProvider}
 */
class ProviderFileServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return Jgut\Zf\Maintenance\Provider\FileProvider
     * @throws \InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('ZfMaintenanceOptions');
        $providers = $options->getProviders();

        if (!isset($providers['ZfMaintenanceFileProvider'])) {
            throw new \InvalidArgumentException('Config for "Jgut\Zf\Maintenance\Provider\FileProvider" not set');
        }

        $provider = new FileProvider();

        $provider->setBlock($options->isBlocked());

        $providerConfig = $providers['ZfMaintenanceFileProvider'];

        if (isset($providerConfig['message'])) {
            $provider->setMessage($providerConfig['message']);
        }

        if (!isset($providerConfig['file'])) {
            throw new \InvalidArgumentException(
                'File for "Jgut\Zf\Maintenance\Provider\FileProvider" not set'
            );
        }

        if (isset($providerConfig['file'])) {
            $provider->setFile($providerConfig['file']);
        }

        return $provider;
    }
}
