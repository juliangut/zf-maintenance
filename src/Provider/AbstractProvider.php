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
     * Maintenance mode message.
     *
     * @var string
     */
    protected $message = 'Undergoing maintenance tasks';

    /**
     * Whether maintenance mode blocks application execution
     *
     * @var boolean
     */
    protected $block = true;

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
        if (!$this->isBlocked() || !$this->isActive()) {
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
        $event->setParam('message', $this->getMessage());

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
        $options        = $serviceManager->get('ZfMaintenanceOptions');

        foreach (array_keys($options->getExclusions()) as $exclusionName) {
            if (!$serviceManager->has($exclusionName)) {
                continue;
            }

            $exclusion = $serviceManager->get($exclusionName);
            if ($exclusion->isExcluded()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = (string) $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param boolean $block
     */
    public function setBlock($block)
    {
        $this->block = (bool) $block;
    }

    /**
     * @return boolean
     */
    public function isBlocked()
    {
        return $this->block;
    }
}
