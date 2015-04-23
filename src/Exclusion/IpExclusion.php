<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Exclusion;

use Zend\Http\PhpEnvironment\RemoteAddress;

/**
 * Maintenance exclusion by IP
 */
class IpExclusion implements ExclusionInterface
{
    /**
     * List of IP to be excluded
     *
     * @var array
     */
    protected $ips;

    /**
     * IP Address provider
     *
     * @var \Zend\Http\PhpEnvironment\RemoteAddress
     */
    protected $ipProvider;

    /**
     * @param array $ips
     * @param \Zend\Http\PhpEnvironment\RemoteAddress $ipProvider
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
