<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita664237a9288384b1b5d0ddaa1a9ff04
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '42e3dc2cf7383276e8c418f14b63f194' => __DIR__ . '/../..' . '/config/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'h' => 
        array (
            'hypergo\\' => 8,
        ),
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'hypergo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/libs/src',
        ),
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita664237a9288384b1b5d0ddaa1a9ff04::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita664237a9288384b1b5d0ddaa1a9ff04::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita664237a9288384b1b5d0ddaa1a9ff04::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
