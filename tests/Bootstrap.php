<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

namespace JgutZfMaintenance;

use Composer\Autoload\ClassLoader;
use Zend\Loader\AutoloaderFactory;

$dir = __DIR__;
$previousDir = '.';
while (!is_dir($dir . '/vendor')) {
    $dir = dirname($dir);
    if ($previousDir === $dir) {
        throw new \RuntimeException(
            'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
        );
    }
    $previousDir = $dir;
}
$vendorPath = $dir . '/vendor';

$loader = null;
if (is_readable($vendorPath . '/autoload.php')) {
    $loader = include $vendorPath . '/autoload.php';
} elseif (is_readable(dirname($vendorPath) . '/autoload.php')) {
    $loader = include dirname($vendorPath) . '/autoload.php';
}

if (!$loader instanceof ClassLoader) {
    throw new \RuntimeException(
        'vendor/autoload.php could not be found. Did you run `php composer.phar install`?'
    );
}
