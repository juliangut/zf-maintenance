<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Maintenance strategy.
     *
     * @var string
     */
    protected $strategy = 'ZfMaintenanceStrategy';

    /**
     * Maintenance page template.
     *
     * @var string
     */
    protected $template = 'zf-maintenance/maintenance';

    /**
     * Maintenance mode blocking status.
     *
     * Whether maintenance blocks access to application.
     *
     * @var boolean
     */
    protected $block = true;

    /**
     * Maintenance providers list.
     *
     * @var array
     **/
    protected $providers = array();

    /**
     * Exclusions to maintenance mode.
     *
     * @var array
     */
    protected $exclusions = array();

    /**
     * {@inheritDoc}
     */
    public function __construct($options = null)
    {
        // Turn off strict options mode
        $this->__strictMode__ = false;

        parent::__construct($options);
    }

    /**
     * Set maintenance strategy.
     *
     * @param string $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = (string) $strategy;
    }

    /**
     * Get maintenance strategy.
     *
     * @return string
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Set maintenance template.
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }

    /**
     * Get maintenance template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set maintenance blocking status.
     *
     * @param boolean $block
     */
    public function setBlock($block)
    {
        $this->block = (bool) $block;
    }

    /**
     * Get maintenance blocking status.
     *
     * @return boolean
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set maintenance providers.
     *
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * Get maintenance providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Set maintenance exclusions.
     *
     * @param array $exclusions
     */
    public function setExclusions(array $exclusions)
    {
        $this->exclusions = $exclusions;
    }

    /**
     * Get maintenance exclusions.
     *
     * @return array
     */
    public function getExclusions()
    {
        return $this->exclusions;
    }
}
