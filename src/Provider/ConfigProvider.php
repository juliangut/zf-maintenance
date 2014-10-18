<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Provider;

class ConfigProvider implements ProviderInterface
{
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
     * {@inheritDoc}
     */
    public function isActive()
    {
        return $this->active;
    }
}
