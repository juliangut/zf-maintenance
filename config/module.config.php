<?php
/**
 * Juliangut Zend Framework Maintenance Module Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://github.com/juliangut/zf-maintenance/blob/master/LICENSE
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'ZfMaintenanceOptions'
                => 'Jgut\Zf\Maintenance\Service\ModuleOptionsServiceFactory',

            'ZfMaintenanceConfigProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderConfigServiceFactory',
            'ZfMaintenanceFileProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderFileServiceFactory',
            'ZfMaintenanceEnvironmentProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderEnvironmentServiceFactory',
            'ZfMaintenanceConfigScheduledProvider'
                => 'Jgut\Zf\Maintenance\Service\ProviderConfigScheduledServiceFactory',

            'ZfMaintenanceIpExclusion'
                => 'Jgut\Zf\Maintenance\Service\ExclusionIpServiceFactory',
            'ZfMaintenanceRouteExclusion'
                => 'Jgut\Zf\Maintenance\Service\ExclusionRouteServiceFactory',

            'ZfMaintenanceStrategy'
                => 'Jgut\Zf\Maintenance\Service\MaintenanceStrategyServiceFactory',
            'ZfMaintenanceDeveloperToolsCollector'
                => 'Jgut\Zf\Maintenance\Service\MaintenanceCollectorServiceFactory',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
            'scheduledMaintenance' => 'Jgut\Zf\Maintenance\Service\ViewScheduledMaintenanceServiceFactory',
            'maintenanceMessage'   => 'Jgut\Zf\Maintenance\Service\ViewMaintenanceMessageServiceFactory',
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
        'strategy' => 'ZfMaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',

        // Maintenance blocks access to application
        'block' => true,

        // Maintenance providers
        'providers' => array(),

        // Exceptions to maintenance mode
        'exclusions' => array(),
    ),

    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'jgut-zf-maintenance-collector' => 'ZfMaintenanceDeveloperToolsCollector',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'jgut-zf-maintenance-collector' => 'zend-developer-tools/toolbar/jgut-zf-maintenance',
            ),
        ),
    ),
);
