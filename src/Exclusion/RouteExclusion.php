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
        $matchedRoutePath   = $this->getRoutePath($matchedRouteParams);

        foreach ($this->routes as $route) {
            if (is_string($route) && $route == $matchedRouteName) {
                return true;
            } elseif (is_array($route)) {
                if (isset($route['action']) && $this->getRoutePath($route) == $matchedRoutePath) {
                    return true;
                } elseif (!isset($route['action']) && $route['controller'] == $matchedRouteParams['controller']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Canonize route parameters
     *
     * @param  array  $route
     * @return string
     */
    protected function getRoutePath(array $route)
    {
        return $route['controller'] . '/' . (isset($route['action']) ? $route['action'] : '');
    }
}
