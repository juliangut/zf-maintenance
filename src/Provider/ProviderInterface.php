<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

use Zend\Mvc\MvcEvent;

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
     * @return void
     */
    public function onRoute(MvcEvent $event);
}
