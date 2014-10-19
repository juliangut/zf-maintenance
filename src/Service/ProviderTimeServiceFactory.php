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
use JgutZfMaintenance\Provider\TimeProvider;

class ProviderTimeServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \JgutZfMaintenance\Provider\TimeProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('zf-maintenance-options');

        if (!isset($options->getProviders()['JgutZfMaintenance\Provider\TimeProvider'])) {
            throw new InvalidArgumentException(
                'Config for "JgutZfMaintenance\Provider\TimeProvider" not set'
            );
        }

        $provider = new TimeProvider();

        $providerConfig = $options->getProviders()['JgutZfMaintenance\Provider\TimeProvider'];

        if (isset($providerConfig['start'])) {
            $provider->setStart(new \DateTime($providerConfig['start']));
        }

        if (isset($providerConfig['end'])) {
            $provider->setEnd(new \DateTime($providerConfig['end']));
        }

        return $provider;
    }
}
