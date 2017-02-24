<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita1bc46762c662fd2f1719773910a3c46
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita1bc46762c662fd2f1719773910a3c46::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita1bc46762c662fd2f1719773910a3c46::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}