<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 31/03/2018
 * Time: 19:39
 */

namespace app\DefaultApp;
use systeme\Application\Application;
class DefaultApp extends Application
{
    //---
    public static function base64($data)
    {
        return rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');
    }

}