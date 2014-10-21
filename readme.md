[![Build Status](https://travis-ci.org/juliangut/zf-maintenance.svg?branch=develop)](https://travis-ci.org/juliangut/zf-maintenance)

ZF Maintenance
==============

Maintenance module for Zend Framework 2.


Installation
------------

1. Install the module via composer by running:

    ```sh
    php composer.phar require juliangut/zf-maintenance
    ```

    or download it directly from github and place it in your application's `module/` directory.

2. Add the `JgutZfMaintenance` module to the module section of your `config/application.config.php`

3. Copy `config\zf-maintenance.global.php.dist` to your `config` directory and rename it `zf-maintenance.global.php`

4. Install zend-developer-tools (optional)

    ```sh
    php composer.phar require zendframework/zend-developer-tools
    ```


Configuration
-------------

Configuration example can be found in `config\zf-maintenance.global.php.dist`

Annotated example:
```php
return [
    'zf-maintenance' => [
        /* Strategy service to be used on maintenance
         * Will return 503 (service unavailable) error code when maintenance mode is on
         */
        'maintenance_strategy' => 'JgutZfMaintenance\View\MaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',

        /* Maintenance providers
         * Different means to activate maintenance mod.
         * Two manual providers comes bundled with the module:
         *   ConfigProvider, the simplest possible
         *   TimeProvider, sets a time span, start - end strings as accepted by \DateTime
         * Any provider implementing JgutZfMaintenance\Provider\ScheduledProviderInterface will be used to determine
         * future maintenance situations and used on view helper as well as in zend-developer-tools
         */
        'providers' => array(
            'JgutZfMaintenance\Provider\ConfigProvider' => array(
                'active' => false,
            ),
        ),

        /* Exceptions to maintenance mode
         * Provides a way to bypass maintenance mode by fulfilling any of the conditions provided:
         *   IpExclusion, sets a list of IPs from which access is granted
         *   RouteExclusion, sets routes not affected by maintenance mode
         */
        'exclusions' => array(
            'JgutZfMaintenance\Exclusion\IpExclusion'    => array(
                '127.0.0.1',
            ),
            'JgutZfMaintenance\Exclusion\RouteExclusion' => array(
                'home',
            ),
        ),
    ],
]
```


View helper
-----------

A view helper `scheduledMaintenance` is bundled with the module that will return an array with the next scheduled
maintenance time period

```php
array(
    'start' => \DateTime,
    'end'   => \DateTime, //null if no end time
);
```


ZendDeveloperTools integration
------------------------------

A collector `zf-mainenance-collector` is present for ZendDeveloperTools showing current maintenance status and future
scheduled maintenance period times


License
-------

###Release under BSD-2-Clause License.

See file [LICENSE](https://github.com/juliangut/zf-maintenance/blob/develop/LICENSE) included with the source code for a copy of the license terms
