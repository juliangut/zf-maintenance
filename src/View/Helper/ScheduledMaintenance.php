<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JgutZfMaintenance\Provider\ScheduledProviderInterface;

/**
 * Allows to retrieve scheduled maintenance period times in views.
 */
class ScheduledMaintenance extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var array
     */
    protected $providers;

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @param Authorize $authorizeService
     */
    public function __construct(array $providers = array())
    {
        $this->providers = $providers;
    }

    /**
     * @return boolean|array
     */
    public function __invoke()
    {
        if (!count($this->providers)) {
            return false;
        }

        $helperManager  = $this->getServiceLocator();
        $serviceManager = $helperManager->getServiceLocator();

        foreach (array_keys($this->providers) as $providerName) {
            if ($serviceManager->has($providerName)) {
                $provider = $serviceManager->get($providerName);
                if ($provider instanceof ScheduledProviderInterface && $provider->isScheduled()) {
                    return $provider->getScheduleTimes();
                }
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
