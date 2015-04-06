<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Exclusion;

use Zend\Http\PhpEnvironment\RemoteAddress;

class IpExclusion implements ExclusionInterface
{
    /**
     * @var array
     */
    protected $ips;

    /**
     * @var \Zend\Http\PhpEnvironment\RemoteAddress
     */
    protected $ipProvider;

    /**
     * @param array $ips
     * @param Object $ipProvider
     */
    public function __construct(array $ips, RemoteAddress $ipProvider)
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
