<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd72cd1de268d896ceb3df0b76e5641ae
{
    public static $files = array (
        'ad155f8f1cf0d418fe49e248db8c661b' => __DIR__ . '/..' . '/react/promise/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'React\\Promise\\' => 14,
        ),
        'P' => 
        array (
            'PagarMe\\Sdk\\' => 12,
            'PagarMe\\Magento\\Test\\' => 21,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Stream\\' => 18,
            'GuzzleHttp\\Ring\\' => 16,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'React\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/promise/src',
        ),
        'PagarMe\\Sdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/pagarme/pagarme-php/lib',
        ),
        'PagarMe\\Magento\\Test\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests/acceptance',
        ),
        'GuzzleHttp\\Stream\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/streams/src',
        ),
        'GuzzleHttp\\Ring\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/ringphp/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd72cd1de268d896ceb3df0b76e5641ae::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd72cd1de268d896ceb3df0b76e5641ae::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}