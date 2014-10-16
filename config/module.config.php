<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

return array(
    'service_manager' => array(
        'invokables' => array(
            'JgutZfMaintenance\Options' =>
                'JgutZfMaintenance\Service\ModuleOptionsServiceFactory',
            'JgutZfMaintenance\View\MaintenanceStrategy' =>
                'JgutZfMaintenance\Service\MaintenanceStrategyServiceFactory',
        ),
        'aliases' => array(
            'zf-maintenance-options' => 'JgutZfMaintenance\Options',
        ),
    ),

    'zf-maintenance' => array(
        // Strategy service to be used on maintenance
        'maintenance_strategy' => 'JgutZfMaintenance\View\MaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',
    ),
);
