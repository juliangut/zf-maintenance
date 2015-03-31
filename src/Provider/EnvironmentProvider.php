<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Provider;

/**
 * Environment variable maintenance provider.
 *
 * If environment variable is set (if value provided then set to that value) maintenance mode is considered to be On.
 */
class EnvironmentProvider extends AbstractProvider
{
    /**
     * {@inheritDoc}
     */
    protected $maintenanceDescription =
        'Environment maintenance mode active on Jgut\Zf\Maintenance\Provider\EnvironmentProvider';

    /**
     * Environment variable.
     *
     * @var string
     */
    protected $var;

    /**
     * Environment variable value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * @param string $var
     * @return void
     */
    public function setVar($var)
    {
        $this->var = $var;
    }

    /**
     * @return string
     */
    public function getVar()
    {
        return $this->var;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function isActive()
    {
        if ($this->var === null || getenv($this->var) === false) {
            return false;
        }

        return $this->value === null ? true : getenv($this->var) === $this->value;
    }
}
