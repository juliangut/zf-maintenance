<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Jgut\Zf\Maintenance\Exception\MaintenanceException;

abstract class AbstractProvider implements ProviderInterface, ListenerAggregateInterface
{
    /**
     * Maintenance description.
     *
     * @var string
     */
    protected $maintenanceDescription = 'Maintenance mode active on Jgut\Zf\Maintenance\Provider\ProviderInterface';

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'), -10000);
    }

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function onRoute(MvcEvent $event)
    {
        if (!$this->isActive()) {
            return;
        }

        // Do nothing if no route matched (404)
        if (!$event->getRouteMatch() instanceof RouteMatch) {
            return;
        }

        if ($this->isExcluded($event)) {
            return;
        }

        $event->setError(static::ERROR);

        $event->setParam('exception', new MaintenanceException($this->maintenanceDescription));

        $application = $event->getApplication();
        $application->getEventManager()->trigger(MvcEvent::EVENT_DISPATCH_ERROR, $event);
    }

    /**
     * Check if eclusion is applied.
     *
     * @param MvcEvent $event
     * @return boolean
     */
    protected function isExcluded(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
        $options        = $serviceManager->get('zf-maintenance-options');

        foreach (array_keys($options->getExclusions()) as $exclusionName) {
            if ($serviceManager->has($exclusionName)) {
                $exclusion = $serviceManager->get($exclusionName);
                if ($exclusion->isExcluded()) {
                    return true;
                }
            }
        }

        return false;
    }
}
