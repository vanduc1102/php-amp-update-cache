<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3619b8aae9eb6a2533c80d6142a9bdc9
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3619b8aae9eb6a2533c80d6142a9bdc9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3619b8aae9eb6a2533c80d6142a9bdc9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}