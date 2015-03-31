<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'Jgut\Zf\Maintenance\Options'
                => 'Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory',
            'Jgut\Zf\Maintenance\Provider\ConfigProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory',
            'Jgut\Zf\Maintenance\Provider\FileProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderFileServiceFactory',
            'Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory',
            'Jgut\Zf\Maintenance\Exclusion\IpExclusion'
                => 'Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory',
            'Jgut\Zf\Maintenance\Exclusion\RouteExclusion'
                => 'Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory',
            'Jgut\Zf\Maintenance\View\MaintenanceStrategy'
                => 'Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory',
            'Jgut\Zf\Maintenance\Collector\MaintenanceCollector'
                => 'Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory',
        ),
        'aliases' => array(
            'zf-maintenance-options' => 'Jgut\Zf\Maintenance\Options',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
            'scheduledMaintenance' => 'Jgut\Zf\Maintenance\Service\ViewScheduledMaintenanceServiceFactory',
        )
    ),

    'view_manager' => array(
        'template_map'             => array(
            'zf-maintenance/maintenance' => __DIR__ . '/../view/zf-maintenance/maintenance.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'zf-maintenance' => array(
        // Strategy service to be used on maintenance
        'maintenance_strategy' => 'Jgut\Zf\Maintenance\View\MaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',

        // Maintenance providers
        'providers' => array(),

        // Exceptions to maintenance mode
        'exclusions' => array(),
    ),

    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'jgut-zf-maintenance-collector' => 'Jgut\Zf\Maintenance\Collector\MaintenanceCollector',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'jgut-zf-maintenance-collector' => 'zend-developer-tools/toolbar/jgut-zf-maintenance',
            ),
        ),
    ),
);
