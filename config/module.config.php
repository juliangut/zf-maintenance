<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'JgutZfMaintenance\Options'                  => 'JgutZfMaintenance\Service\ModuleOptionsServiceFactory',
            'JgutZfMaintenance\Provider\ConfigProvider'  => 'JgutZfMaintenance\Service\ProviderConfigServiceFactory',
            'JgutZfMaintenance\Provider\TimeProvider'    => 'JgutZfMaintenance\Service\ProviderTimeServiceFactory',
            'JgutZfMaintenance\Exclusion\IpExclusion'    => 'JgutZfMaintenance\Service\ExclusionIpServiceFactory',
            'JgutZfMaintenance\Exclusion\RouteExclusion' => 'JgutZfMaintenance\Service\ExclusionRouteServiceFactory',
            'JgutZfMaintenance\View\MaintenanceStrategy' =>
                'JgutZfMaintenance\Service\MaintenanceStrategyServiceFactory',
        ),
        'aliases' => array(
            'zf-maintenance-options' => 'JgutZfMaintenance\Options',
        ),
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
        'maintenance_strategy' => 'JgutZfMaintenance\View\MaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',

        // Maintenance providers
        'providers' => array(),

        // Exceptions to maintenance mode
        'exclusions' => array(),
    ),
);
