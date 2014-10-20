<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

use Zend\Mvc\MvcEvent;

class ConfigProvider extends AbstractProvider
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription = 'Manual maintenance mode active on JgutZfMaintenance\Provider\ConfigProvider';

    /**
     * Maintenance mode active.
     *
     * @var boolean
     */
    protected $active = false;

    /**
     * Set maintenance mode active.
     *
     * @param boolean $active
     * @return void
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
    }

    /**
     * Get maintenance mode active.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * {@inheritDoc}
     */
    public function onRoute(MvcEvent $event)
    {
        if (!$this->active) {
            return;
        }

        parent::onRoute($event);
    }
}
