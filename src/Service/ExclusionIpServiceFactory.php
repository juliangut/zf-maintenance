<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Jgut\Zf\Maintenance\Exclusion\IpExclusion;
use Zend\Http\PhpEnvironment\RemoteAddress;

class ExclusionIpServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \Jgut\Zf\Maintenance\Exclusion\IpExclusion
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options    = $serviceLocator->get('ZfMaintenanceOptions');
        $exclusions = $options->getExclusions();

        if (!isset($exclusions['ZfMaintenanceIpExclusion'])) {
            throw new \InvalidArgumentException('Config for "Jgut\Zf\Maintenance\Exclusion\IpExclusion" not set');
        }

        $ipProvider = new RemoteAddress();
        $ipProvider->setUseProxy(true);

        $ips = $exclusions['ZfMaintenanceIpExclusion'];
        return new IpExclusion($ips, $ipProvider);
    }
}
