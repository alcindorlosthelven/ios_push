<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc4fff5fa6106608141d66b7b06c1020b
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/',
    );

    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/../..' . '/',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInitc4fff5fa6106608141d66b7b06c1020b::$fallbackDirsPsr4;
            $loader->fallbackDirsPsr0 = ComposerStaticInitc4fff5fa6106608141d66b7b06c1020b::$fallbackDirsPsr0;

        }, null, ClassLoader::class);
    }
}
