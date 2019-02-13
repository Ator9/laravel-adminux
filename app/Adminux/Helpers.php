<?php

namespace App\Adminux;

class Helpers
{
    static function getNavLeft()
    {
        $data = [];

        foreach(\File::directories(__DIR__) as $dir)
        {
            $module    = basename($dir);
            $className = 'App\Adminux\\'.$module.'\Controllers\\' . $module.'Controller';

            $row = (new $className())->adminConfig;
            $row['dir'] = $module;
            
            $data[] = $row;
        }

        return $data;
    }
}
