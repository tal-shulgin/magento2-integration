<?php
use Magento\Framework\Component\ComponentRegistrar;

$path = __DIR__;
$ds = DIRECTORY_SEPARATOR;
if (strpos($path, 'app' . $ds . 'code' . $ds . 'Flashy') === false) {
    $basePath = dirname(__DIR__, 3);
} else {
    $basePath = dirname(__DIR__, 4);
}
$registration = $basePath . $ds . 'vendor' . $ds . 'flashy' . $ds . 'module-integration' . $ds . 'src' . $ds . 'Integration' . $ds . 'registration.php';
if (file_exists($registration)) {
    // NOTE: the module has been already installed.
    return;
}

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Flashy_Integration',
    __DIR__
);
