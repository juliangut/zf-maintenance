<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use DateTime;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;

class ProviderConfigScheduledServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options   = $serviceLocator->get('zf-maintenance-options');
        $providers = $options->getProviders();

        if (!isset($providers['Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider'])) {
            throw new \InvalidArgumentException(
                'Config for "Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider" not set'
            );
        }

        $provider = new ConfigScheduledProvider();

        $providerConfig = $providers['Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider'];

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
