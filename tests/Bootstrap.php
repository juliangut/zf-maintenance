<?php
/**
 * JgutZfMaintenance Module (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/zf-maintenance for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/zf-maintenance/master/LICENSE
 */

$dir = __DIR__;
$previousDir = '.';
while (!is_dir($dir . '/vendor')) {
    $dir = dirname($dir);
    if ($previousDir === $dir) {
        break;
    }
    $previousDir = $dir;
}
$vendorPath = $dir . '/vendor';

if (is_readable($vendorPath . '/autoload.php')) {
    include $vendorPath . '/autoload.php';
} elseif (is_readable(dirname($vendorPath) . '/autoload.php')) {
    include dirname($vendorPath) . '/autoload.php';
} else {
    throw new \RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}
