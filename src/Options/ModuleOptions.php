<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
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
    protected $maintenanceStrategy = 'Jgut\Zf\Maintenance\View\maintenanceStrategy';

    /**
     * Maintenance page template.
     *
     * @var string
     */
    protected $template = 'zf-maintenance/maintenance';

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
     * @param string $maintenanceStrategy
     */
    public function setMaintenanceStrategy($maintenanceStrategy)
    {
        $this->maintenanceStrategy = (string) $maintenanceStrategy;
    }

    /**
     * Get maintenance strategy.
     *
     * @return string
     */
    public function getMaintenanceStrategy()
    {
        return $this->maintenanceStrategy;
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
