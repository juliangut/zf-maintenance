<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Exclusion;

interface ExclusionInterface
{
    /**
     * Determines if is excluded from maintenance mode.
     *
     * @return boolean
     */
    public function isExcluded();
}
