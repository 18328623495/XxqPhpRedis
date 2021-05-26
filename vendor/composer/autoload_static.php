<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf2ac9fdcfe3faca6cc4e6607a966fb83
{
    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'XxqRedis\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'XxqRedis\\' =>
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf2ac9fdcfe3faca6cc4e6607a966fb83::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf2ac9fdcfe3faca6cc4e6607a966fb83::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
