<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Exclusion;

class IpExclusion implements ExclusionInterface
{
    /**
     * @var array
     */
    protected $ips;

    /**
     * @var Object
     */
    protected $ipProvider;

    /**
     * @param array $ips
     * @param Object $ipProvider
     */
    public function __construct(array $ips, $ipProvider)
    {
        $this->ips = $ips;
        $this->ipProvider = $ipProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function isExcluded()
    {
        $userIp = $this->ipProvider->getIpAddress();

        foreach ($this->ips as $ip) {
            if ($ip == $userIp) {
                return true;
            }
        }

        return false;
    }
}
