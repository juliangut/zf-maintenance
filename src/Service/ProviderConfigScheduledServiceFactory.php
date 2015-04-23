<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use DateTime;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;

/**
 * Factory responsible of instantiating {@see Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider}
 */
class ProviderConfigScheduledServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider
     * @throws \InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('ZfMaintenanceOptions');
        $providers = $options->getProviders();

        if (!isset($providers['ZfMaintenanceConfigScheduledProvider'])) {
            throw new \InvalidArgumentException(
                'Config for "Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider" not set'
            );
        }

        $provider = new ConfigScheduledProvider();

        $provider->setBlock($options->isBlocked());

        $providerConfig = $providers['ZfMaintenanceConfigScheduledProvider'];

        if (isset($providerConfig['message'])) {
            $provider->setMessage($providerConfig['message']);
        }

        if (isset($providerConfig['start'])) {
            $start = $providerConfig['start'];

            $provider->setStart($start instanceof DateTime ? $start : new DateTime($start));
        }

        if (isset($providerConfig['end'])) {
            $end = $providerConfig['end'];

            $provider->setEnd($end instanceof DateTime ? $end : new DateTime($end));
        }

        return $provider;
    }
}
