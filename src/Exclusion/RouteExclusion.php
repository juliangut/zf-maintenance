<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Exclusion;

use Zend\Mvc\Router\RouteMatch;

class RouteExclusion implements ExclusionInterface
{
    /**
     * @var array
     */
    protected $routes;

    /**
     * @var \Zend\Mvc\Router\RouteMatch
     */
    protected $routeMatch;

    /**
     * @param array $routes
     * @param \Zend\Mvc\Router\RouteMatch $routeMatch
     */
    public function __construct(array $routes, RouteMatch $routeMatch)
    {
        $this->routes     = $routes;
        $this->routeMatch = $routeMatch;
    }

    /**
     * {@inheritDoc}
     */
    public function isExcluded()
    {
        $matchedRouteName   = $this->routeMatch->getMatchedRouteName();
        $matchedRouteParams = $this->routeMatch->getParams();

        foreach ($this->routes as $route) {
            if (is_string($route) && $route == $matchedRouteName) {
                return true;
            } elseif (is_array($route)) {
                if ($route['controller'] == $matchedRouteParams['controller'] && !isset($route['action'])) {
                    return true;
                } elseif ($route['controller'] == $matchedRouteParams['controller']
                    && $route['action'] == $matchedRouteParams['action']
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
