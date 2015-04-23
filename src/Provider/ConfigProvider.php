<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

/**
 * Basic manual maintenance provider
 */
class ConfigProvider extends AbstractProvider
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription =
        'Manual maintenance mode active on Jgut\Zf\Maintenance\Provider\ConfigProvider';

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
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        return $this->active;
    }
}
