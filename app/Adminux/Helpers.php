<?php

namespace App\Adminux;

class Helpers
{
    static function getNavLeft()
    {
        $data = [];

        foreach(\File::directories(__DIR__) as $dir) {
            $module    = basename($dir);
            $className = 'App\Adminux\\'.$module.'\Controllers\\' . $module.'Controller';

            $obj = new $className();
            if(!empty($obj->adminConfig)) {
                $row = $obj->adminConfig;
                $row['dir'] = $module;

                $data[] = $row;
            }
        }

        return $data;
    }

    static function getNavTop($path = '')
    {
        $data = [];

        $array = explode('/', $path);
        if(count($array) == 1) $data = [ '' => 'Dashboard' ];
        else {
            $class = explode('_', next($array));

            $className = 'App\Adminux\\'.ucfirst($class[0]).'\Controllers\\'.ucfirst($class[0]).'Controller';

            $obj = new $className();
            if(!empty($obj->adminConfig)) {
                $row = $obj->adminConfig;

                $data = [ $class[0] => $row['name'] ];
                if(!empty($row['submenu'])) $data = $data + $row['submenu'];
            }
        }

        return $data;
    }
}
