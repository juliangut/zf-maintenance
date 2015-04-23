<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

return array(
    'Jgut\Zf\Maintenance\Module'
        => __DIR__ . '/src/Module.php',

    'Jgut\Zf\Maintenance\Exception\MaintenanceException'
        => __DIR__ . '/src/Exception/MaintenanceException.php',

    'Jgut\Zf\Maintenance\Options\ModuleOptions'
        => __DIR__ . '/src/Options/ModuleOptions.php',

    'Jgut\Zf\Maintenance\Collector\MaintenanceCollector'
        => __DIR__ . '/src/Collector/MaintenanceCollector.php',

    'Jgut\Zf\Maintenance\Exclusion\ExclusionInterface'
        => __DIR__ . '/src/Exclusion/ExclusionInterface.php',
    'Jgut\Zf\Maintenance\Exclusion\IpExclusion'
        => __DIR__ . '/src/Exclusion/IpExclusion.php',
    'Jgut\Zf\Maintenance\Exclusion\RouteExclusion'
        => __DIR__ . '/src/Exclusion/RouteExclusion.php',

    'Jgut\Zf\Maintenance\Provider\AbstractProvider'
        => __DIR__ . '/src/Provider/AbstractProvider.php',
    'Jgut\Zf\Maintenance\Provider\ConfigProvider'
        => __DIR__ . '/src/Provider/ConfigProvider.php',
    'Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider'
        => __DIR__ . '/src/Provider/ConfigScheduledProvider.php',
    'Jgut\Zf\Maintenance\Provider\CrontabProvider'
        => __DIR__ . '/src/Provider/CrontabProvider.php',
    'Jgut\Zf\Maintenance\Provider\EnvironmentProvider'
        => __DIR__ . '/src/Provider/EnvironmentProvider.php',
    'Jgut\Zf\Maintenance\Provider\FileProvider'
        => __DIR__ . '/src/Provider/FileProvider.php',
    'Jgut\Zf\Maintenance\Provider\ProviderInterface'
        => __DIR__ . '/src/Provider/ProviderInterface.php',
    'Jgut\Zf\Maintenance\Provider\ScheduledProviderInterface'
        => __DIR__ . '/src/Provider/ScheduledProviderInterface.php',

    'Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory'
        => __DIR__ . '/src/Service/ExclusionIpServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory'
        => __DIR__ . '/src/Service/ExclusionRouteServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory'
        => __DIR__ . '/src/Service/MaintenanceCollectorServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory'
        => __DIR__ . '/src/Service/MaintenanceStrategyServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory'
        => __DIR__ . '/src/Service/ModuleOptionsServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory'
        => __DIR__ . '/src/Service/ProviderConfigScheduledServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory'
        => __DIR__ . '/src/Service/ProviderConfigServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ProviderCrontabServiceFactory'
        => __DIR__ . '/src/Service/ProviderCrontabServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory'
        => __DIR__ . '/src/Service/ProviderEnvironmentServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ProviderFileServiceFactory'
        => __DIR__ . '/src/Service/ProviderFileServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ViewMaintenanceMessageServiceFactory'
        => __DIR__ . '/src/Service/ViewMaintenanceMessageServiceFactory.php',
    'Jgut\Zf\Maintenance\Service\ViewScheduledMaintenanceServiceFactory'
        => __DIR__ . '/src/Service/ViewScheduledMaintenanceServiceFactory.php',

    'Jgut\Zf\Maintenance\View\MaintenanceStrategy'
        => __DIR__ . '/src/View/MaintenanceStrategy.php',
    'Jgut\Zf\Maintenance\View\Helper\AbstractHelper'
        => __DIR__ . '/src/View/Helper/AbstractHelper.php',
    'Jgut\Zf\Maintenance\View\Helper\MaintenanceMessage'
        => __DIR__ . '/src/View/Helper/MaintenanceMessage.php',
    'Jgut\Zf\Maintenance\View\Helper\ScheduledMaintenance'
        => __DIR__ . '/src/View/Helper/ScheduledMaintenance.php',
);
