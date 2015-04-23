<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

use Zend\Mvc\MvcEvent;

/**
 * Maintenance provider interface
 */
interface ProviderInterface
{
    /**
     * Marker for invalid route errors
     */
    const ERROR = 'error-maintenance-mode-on';

    /**
     * Get maintenance mode active.
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Verifies maintenance mode.
     *
     * @param  MvcEvent $event
     */
    public function onRoute(MvcEvent $event);
}
