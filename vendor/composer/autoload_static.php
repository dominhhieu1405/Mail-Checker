<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1737a36bda6707242cec3f6275712f7
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpImap\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpImap\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-imap/php-imap/src/PhpImap',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita1737a36bda6707242cec3f6275712f7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1737a36bda6707242cec3f6275712f7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita1737a36bda6707242cec3f6275712f7::$classMap;

        }, null, ClassLoader::class);
    }
}