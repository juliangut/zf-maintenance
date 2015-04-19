<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use Jgut\Zf\Maintenance\Provider\ScheduledProviderInterface;
use Jgut\Zf\Maintenance\Provider\ProviderInterface;
use \DateTime;

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
     * @param array $providers
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

                if ($provider instanceof ProviderInterface) {
                    $this->active = $this->active || $provider->isActive();
                }

                if ($provider instanceof ScheduledProviderInterface
                    && $provider->isScheduled() && !$provider->isActive()
                ) {
                    $this->scheduleTimes[] = $provider->getScheduleTimes();
                }
            }
        }

        if (count($this->scheduleTimes)) {
            usort($this->scheduleTimes, array($this, 'sortTimes'));
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

    /**
     * Sort by start time
     *
     * @param array $aTime
     * @param array $bTime
     */
    protected function sortTimes(array $aTime, array $bTime)
    {
        if ($aTime['start'] === $bTime['start']) {
            return 0;
        }

        return ($aTime['start'] < $bTime['start']) ? -1 : 1;
    }
}
