<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Exclusion;

/**
 * Maintenance exclusions interface
 */
interface ExclusionInterface
{
    /**
     * Determines if is excluded from maintenance mode.
     *
     * @return boolean
     */
    public function isExcluded();
}
