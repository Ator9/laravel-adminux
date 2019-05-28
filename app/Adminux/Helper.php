<?php

namespace App\Adminux;

class Helper
{
    static function getNavLeft()
    {
        $data = [];

        foreach(\File::directories(__DIR__) as $dir) {
            $module = basename($dir);

            $config = self::getConfig($module);
            if(empty($config) || empty($config['navigation']['enabled'])) continue;

            $row = $config['navigation'];
            $row['dir'] = $module;

            $data[] = $row;
        }

        return $data;
    }

    static function getNavTop($path = '')
    {
        $data = [];

        $array = explode('/', $path);
        if($array[1] == 'dashboard') $data = [ 'dashboard' => 'Dashboard' ];
        else {
            $class = explode('_', next($array));

            $config = self::getConfig(ucfirst($class[0]));
            if(!empty($config['navigation'])) {
                $row = $config['navigation'];

                $data = [ $class[0] => $row['name'] ];
                if(!empty($row['submenu'])) $data = $data + $row['submenu'];
            }
        }

        return $data;
    }

    // Get module config:
    static function getConfig($path = '')
    {
        $config = [];

        if(is_file($file = __DIR__.'/'.$path.'/config.php')) require $file;
        elseif(is_file($file = __DIR__.'/'.$path.'/config.default.php')) require $file;

        return $config;
    }
}
