<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

namespace Jgut\Zf\Maintenance\View\Helper;

use Jgut\Zf\Maintenance\Provider\ScheduledProviderInterface;

/**
 * Allows to retrieve scheduled maintenance period times in views.
 */
class ScheduledMaintenance extends AbstractHelper
{
    /**
     * @return array
     */
    public function __invoke()
    {
        if (!count($this->providers)) {
            return array();
        }

        $helperManager  = $this->getServiceLocator();
        $serviceManager = $helperManager->getServiceLocator();

        foreach (array_keys($this->providers) as $providerName) {
            if ($serviceManager->has($providerName)) {
                $provider = $serviceManager->get($providerName);
                if ($provider instanceof ScheduledProviderInterface && $provider->isScheduled()) {
                    return $provider->getScheduleTimes();
                }
            }
        }

        return array();
    }
}
