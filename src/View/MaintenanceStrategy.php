<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\View;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use JgutZfMaintenance\Provider\ProviderInterface;
use JgutZfMaintenance\Exclusion\ExclusionInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

class MaintenanceStrategy implements ListenerAggregateInterface
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @param string $template name of the template to use on unauthorized requests
     */
    public function __construct($template)
    {
        $this->template = (string) $template;
    }

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
     * Modifies the response object with maintenance content.
     *
     * @param MvcEvent $event
     * @return void
     */
    public function onRoute(MvcEvent $event)
    {
        // Do nothing if no route matched (404)
        if (!$event->getRouteMatch() instanceof RouteMatch) {
            return;
        }

        if (!$this->isInMaintenance($event)) {
            return;
        }
        if ($this->isExcluded($event)) {
            return;
        }

        $result   = $event->getResult();
        $response = $event->getResponse();

        $model    = new ViewModel();
        $response = $response ?: new Response();

        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(Response::STATUS_CODE_503);
        $response->getHeaders()->addHeaderLine('Retry-After', 3600);
        $event->setResponse($response);
    }

    /**
     * Check if in namintenance mode.
     *
     * @param MvcEvent $event
     * @return boolean
     */
    private function isInMaintenance(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
        $options        = $serviceManager->get('zf-maintenance-options');

        $inMaintenance   = false;
        foreach (array_keys($options->getProviders()) as $providerName) {
            if ($serviceManager->has($providerName)) {
                $provider = $serviceManager->get($providerName);
                if ($provider instanceof ProviderInterface && $provider->isActive()) {
                    $inMaintenance = true;
                    break;
                }
            }
        }

        return $inMaintenance;
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

        $isExcluded = false;
        foreach (array_keys($options->getExclusions()) as $exclusionName) {
            if ($serviceManager->has($exclusionName)) {
                $exclusion = $serviceManager->get($exclusionName);
                if ($exclusion instanceof ExclusionInterface && $exclusion->inExcluded()) {
                    $isExcluded = true;
                    break;
                }
            }
        }

        return $isExcluded;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
