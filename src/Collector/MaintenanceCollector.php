<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace JgutZfMaintenance\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use JgutZfMaintenance\Provider\ScheduledProviderInterface;
use JgutZfMaintenance\Provider\ProviderInterface;

/**
 * Collects maintenance mode status and values
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class MaintenanceCollector implements CollectorInterface
{
    const NAME     = 'jgut-zf-maintenance-collector';

    const PRIORITY = 150;

    /**
     * Maintenance mode on.
     *
     * @var boolean
     */
    protected $active = false;

    /**
     * @var array
     */
    protected $scheduleTimes = array();

    /**
     * @var array
     */
    protected $providers = array();

    /**
     * @param Authorize $authorizeService
     */
    public function __construct(array $providers = array())
    {
        $this->providers = $providers;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $event)
    {
        if (!count($this->providers)) {
            return;
        }

        $application    = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        foreach (array_keys($this->providers) as $providerName) {
            if ($serviceManager->has($providerName)) {
                $provider = $serviceManager->get($providerName);

                if ($provider instanceof ScheduledProviderInterface
                    && !count($this->scheduleTimes)
                    && $provider->isScheduled()
                ) {
                    $this->scheduleTimes = $provider->getScheduleTimes();
                }

                if ($provider instanceof ProviderInterface && !$this->active) {
                    $this->active = $provider->isActive();
                }
            }

            if ($this->active && count($this->scheduleTimes)) {
                break;
            }
        }
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return array
     */
    public function getScheduleTimes()
    {
        return $this->scheduleTimes;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return static::PRIORITY;
    }
}
