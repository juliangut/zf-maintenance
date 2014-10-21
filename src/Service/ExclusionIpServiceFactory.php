<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JgutZfMaintenance\Exclusion\IpExclusion;
use Zend\Http\PhpEnvironment\RemoteAddress;

class ExclusionIpServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return \JgutZfMaintenance\Exclusion\IpExclusion
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options    = $serviceLocator->get('zf-maintenance-options');
        $exclusions = $options->getExclusions();

        if (!isset($exclusions['JgutZfMaintenance\Exclusion\IpExclusion'])) {
            throw new \InvalidArgumentException(
                'Config for "JgutZfMaintenance\Exclusion\IpExclusion" not set'
            );
        }

        $ips = $exclusions['JgutZfMaintenance\Exclusion\IpExclusion'];
        return new IpExclusion($ips, new RemoteAddress());
    }
}
