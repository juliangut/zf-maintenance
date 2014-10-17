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
use Zend\Stdlib\ResponseInterface;
use Zend\Http\Response;
use JgutZfMaintenance\Exception\MaintenanceException;
use Zend\View\Model\ViewModel;

class UnauthorizedStrategy implements ListenerAggregateInterface
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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -5000);
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

    /**
     * Modifies the response object with maintenance content.
     *
     * @param MvcEvent $event
     * @return void
     */
    public function onDispatchError(MvcEvent $event)
    {
        // Do nothing if no route matched (404)
        $match = $event->getRouteMatch();
        if (!$match instanceof RouteMatch) {
            return;
        }

        // Do nothing if the result is a response object
        $result   = $event->getResult();
        $response = $event->getResponse();

        if ($result instanceof ResponseInterface || ($response && ! $response instanceof Response)) {
            return;
        }

        $error = $event->getError();
        if ($error !== Application::ERROR_EXCEPTION
            || !($event->getParam('exception') instanceof MaintenanceException)
        ) {
            return;
        }

        $model    = new ViewModel();
        $response = $response ?: new Response();

        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(Response::STATUS_CODE_503);
        $response->getHeaders()->addHeaderLine('Retry-After', 3600);
        $event->setResponse($response);
    }
}
