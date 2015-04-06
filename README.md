[![Build Status](https://travis-ci.org/juliangut/zf-maintenance.svg?branch=master)](https://travis-ci.org/juliangut/zf-maintenance)
[![Code Climate](https://codeclimate.com/github/juliangut/zf-maintenance/badges/gpa.svg)](https://codeclimate.com/github/juliangut/zf-maintenance)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juliangut/zf-maintenance/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juliangut/zf-maintenance/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/juliangut/zf-maintenance/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/juliangut/zf-maintenance/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/juliangut/zf-maintenance/v/stable.svg)](https://packagist.org/packages/juliangut/zf-maintenance)
[![Total Downloads](https://poser.pugx.org/juliangut/zf-maintenance/downloads.svg)](https://packagist.org/packages/juliangut/zf-maintenance)

# Juliangut Zend Framework Maintenance Module

Maintenance module for Zend Framework 2.

## Installation

1. Best way to install is using [Composer](https://getcomposer.org/):

```
php composer.phar require juliangut/zf-maintenance
```

or download it directly from github and place it in your application's `module/` directory.

2. Add `Jgut\Zf\Maintenance` module to the module section of your `config/application.config.php`

3. Copy `config\zf-maintenance.global.php.dist` to your `config` directory and rename it `zf-maintenance.global.php`

4. Install zend-developer-tools (optional)

```
php composer.phar require zendframework/zend-developer-tools
```

## Configuration

Configuration example can be found in `config\zf-maintenance.global.php.dist`

```php
use DateTime;

return array(
    'zf-maintenance' => array(
        // Strategy service to be used on maintenance
        'strategy' => 'ZfMaintenanceStrategy',

        // Template for the maintenance strategy
        'template' => 'zf-maintenance/maintenance',

        // Maintenance blocks access to application
        'block' => true,

        /*
         * Maintenance providers
         * Different means to activate maintenance mode
         */
        'providers' => array(
            'ZfMaintenanceConfigProvider' => array(
                'active' => false,
            ),
            'ZfMaintenanceConfigScheduledProvider' => array(
                'start'   => '2020-01-01 00:00:00',
                'end'     => new DateTime('2020-01-02 05:00:00'),
                'message' => 'Undergoing scheduled maintenance tasks',
            ),
            'ZfMaintenanceEnvironmentProvider' => array(
                'variable' => 'zf-maintenance',
                'value'    => 'On',
            ),
            'ZfMaintenanceFileProvider' => array(
                'file'    => __DIR__ . '/maintenance',
                'message' => 'We are currently running maintenance proccesses',
            ),
        ),

        /*
         * Exceptions to maintenance mode
         * Provides a way to bypass maintenance mode by fulfilling any of the conditions
         */
        'exclusions' => array(
            'ZfMaintenanceIpExclusion' => array(
                '127.0.0.1',    // Localhost
                '192.168.1.10', // Private network
            ),
            'ZfMaintenanceRouteExclusion' => array(
                'home',
                'admin',
            ),
        ),
    ),
);
```

### Strategy

Custom strategy to handle maintenance mode.

To create your own just extend `Jgut\Zf\Maintenance\View\MaintenanceStrategy`

### Template

Template file for maintenance strategy

### Block

By default maintenance mode prevents application from continuing execution by throwing `Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR` handled by `Jgut\Zf\Maintenance\View\MaintenanceStrategy`

If you don't want maintenance mode to stop execution and show maintenance page then set block to false.

This can be used in case you are performing maintenance tasks that don't need the application to be shut down, like ddbb backup, ...

In this case it is usefull to use `maintenanceMessage` view helper to show maintenance information

### Providers

Maintenance mode providers serve different means to activate maintenance mode

Providers are checked in the order they appear in providers array, when one provider is active the rest of providers are not checked

#### Common attributes

All maintenance providers have a `message` attribute used in maintenance strategy page

```php
$provider = new ConfigProvider();
$provider->setMessage('custom maintenance mode message');
```

#### ConfigProvider

Manual provider, set maintenance mode just by setting `active` attribute

```php
use Jgut\Zf\Maintenance\Provider\ConfigProvider;

$provider = new ConfigProvider();
$provider->setActive(true);
```

#### EnvironmentProvider

Environment variable check provider, checks an environment variable to set maintenance mode

```php
use Jgut\Zf\Maintenance\Provider\EnvironmentProvider;

putenv('zf-maintenance=On');

$provider = new EnvironmentProvider();
$provider->setVar('zf-maintenance');
$provider->setValue('On');
```

#### FileProvider

File provider, verifies the existance of a file to set maintenance mode

```php
use Jgut\Zf\Maintenance\Provider\FileProvider;

$provider = new FileProvider();
$provider->setFile(__DIR__ . '/maintenance_file');
```

#### ConfigScheduledProvider

Manual scheduled maintenance time frame

Maintenance mode will be set on during the time span provided by `start` and `end` attributes (DateTime valid string or object).

If only `start` provided maintenance mode won't stop once started. If only `end` provided maintenance mode will be on from this moment and until end time

```php
use Jgut\Zf\Maintenance\Provider\ConfigScheduledProvider;
use DateTime;

$provider = new ConfigScheduledProvider();
$provider->setStart('2020-01-01 00:00:00');
$provider->setEnd(new DateTime('2020-01-01 05:00:00')),
```

Any provider implementing `Jgut\Zf\Maintenance\Provider\ScheduledProviderInterface` will be used to determine future maintenance situations and used on `scheduledMaintenance` view helper as well as in zend-developer-tools

### Exclusions

Conditions to bypass maintenance mode

Exclusions are checked the same way as providers are, in the order they are located in exclusions array, when one exclusion is active (isExcluded) the rest of exclusions are not checked

#### IpExclusion

Excludes IPs from maintenance mode

```php
use Jgut\Zf\Maintenance\Exclusion\IpExclusion;
use Zend\Http\PhpEnvironment\RemoteAddress;

$excludedIps = array(
    '127.0.0.1',
    '192.168.1.10',
);

$exclusion = new IpExclusion($excludedIps, new RemoteAddress);
```

#### RuteExclusion

Excludes routes from maintenance mode

```php
use Jgut\Zf\Maintenance\Exclusion\RouteExclusion;
use Zend\Mvc\Router\RouteMatch;

$excludedRoutes = array(
    'routeName',
    array(
        'controller' => 'controllerName',
    ),
    array(
        'controller' => 'controllerName',
        'action'     => 'actionName',
    ),
);

$exclusion = new RouteExclusion($excludedRoutes, new RouteMatch);
```

## View helpers

### MaintenanceMessage

`maintenanceMessage` will return the message of current active maintenance provider or empty string if not in maintenance mode

Allows you to show maintenance message when maintenance is in non blocking state or for those users for who exclusions apply

This helper would normally be used on a general template as application header or footer as an informative area. Mind that if in maintenance blocking mode all requests not bound by exclusions will be redirected to maintenance page

```php
$maintenanceMessage = $this->maintenanceMessage();
if ($maintenanceMessage !== '') {
    sprintf('<div class="alert alert-info">%s</div>', $maintenanceMessage);
}
```

### ScheduledMaintenance

`scheduledMaintenance` will return an array with the next scheduled maintenance time period

```php
$maintenance = $this->scheduledMaintenance();
// Start or end can be null if not provided

/*
array(
    'start' => \DateTime,
    'end'   => \DateTime,
);
*/
```

## ZendDeveloperTools integration

A collector `jgut-zf-maintenance-collector` is present for
[ZendDeveloperTools](https://github.com/zendframework/ZendDeveloperTools) showing current maintenance status and future scheduled maintenance period times

## License

### Release under BSD-3-Clause License.

See file [LICENSE](https://github.com/juliangut/zf-maintenance/blob/master/LICENSE) included with the source code for a copy of the license terms
