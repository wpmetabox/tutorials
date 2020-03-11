<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c4c1e383108d0c55aae2c9108bf70e6
{
    public static $files = array (
        'f1d056c50ac6d45dc7ebebcf304ff403' => __DIR__ . '/..' . '/meta-box/mb-blocks/src/functions.php',
        '1830d329ce66311bd18eefa9b7b43041' => __DIR__ . '/..' . '/meta-box/meta-box-builder/src/helpers.php',
        'a5f882d89ab791a139cd2d37e50cdd80' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MBUP\\' => 5,
            'MBUM\\' => 5,
            'MBTM\\' => 5,
            'MBSP\\' => 5,
            'MBFS\\' => 5,
            'MBEI\\' => 5,
            'MBBlocks\\' => 9,
            'MBB\\' => 4,
            'MBBTI\\' => 6,
            'MBAIO\\' => 6,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MBUP\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-user-profile/src',
        ),
        'MBUM\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-user-meta/src',
        ),
        'MBTM\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-term-meta/src',
        ),
        'MBSP\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-settings-page/src',
        ),
        'MBFS\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-frontend-submission/src',
        ),
        'MBEI\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-elementor-integrator/src',
        ),
        'MBBlocks\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/mb-blocks/src',
        ),
        'MBB\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/meta-box-builder/src',
        ),
        'MBBTI\\' => 
        array (
            0 => __DIR__ . '/..' . '/meta-box/meta-box-beaver-themer-integrator/src',
        ),
        'MBAIO\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
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

    public static $classMap = array (
        'Gamajo_Template_Loader' => __DIR__ . '/..' . '/gamajo/template-loader/class-gamajo-template-loader.php',
        'RWMB_Backup_Field' => __DIR__ . '/..' . '/meta-box/mb-settings-page/src/BackupField.php',
        'RWMB_Term_Storage' => __DIR__ . '/..' . '/meta-box/mb-term-meta/src/Storage.php',
        'RWMB_User_Storage' => __DIR__ . '/..' . '/meta-box/mb-user-meta/src/Storage.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c4c1e383108d0c55aae2c9108bf70e6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c4c1e383108d0c55aae2c9108bf70e6::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit4c4c1e383108d0c55aae2c9108bf70e6::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit4c4c1e383108d0c55aae2c9108bf70e6::$classMap;

        }, null, ClassLoader::class);
    }
}
