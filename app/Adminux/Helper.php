<?php

namespace App\Adminux;

class Helper
{
    static function getEnabledPartners()
    {
        return auth('adminux')->user()->partners();
    }

    static function getEnabledPartnersKeys()
    {
        return self::getEnabledPartners()->get()->keyBy('id')->keys()->toArray();
    }

    static function getSelectedPartners()
    {
        return in_array(session('partner_id'), self::getEnabledPartnersKeys()) ? [ session('partner_id') ] : self::getEnabledPartnersKeys();
    }

    // Validates if the admin is allowed to manipulate the selected partner:
    static function validatePartner($model)
    {
        abort_if(!in_array($model->partner_id, self::getEnabledPartnersKeys()), 403);
    }

    static function getEnabledProductsKeys()
    {
        return (new \App\Adminux\Product\Models\Product)->query()->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('id')->keys()->toArray();
    }

    static function getSelectedProducts()
    {
        return (new \App\Adminux\Product\Models\Product)->query()->whereIn('partner_id', self::getSelectedPartners())->get()->keyBy('id')->keys()->toArray();
    }

    // Validates if the admin is allowed to manipulate the selected product:
    static function validateProduct($model)
    {
        abort_if(!in_array($model->product_id, self::getEnabledProductsKeys()), 403);
    }

    static function getEnabledAccountsKeys()
    {
        return (new \App\Adminux\Account\Models\Account)->query()->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('id')->keys()->toArray();
    }

    // Validates if the admin is allowed to manipulate the selected account:
    static function validateAccount($model)
    {
        abort_if(!in_array($model->account_id, self::getEnabledAccountsKeys()), 403);
    }

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

    // Build route resource:
    static function buildRouteResource($model = '', $uri_prefix = '')
    {
        $pieces = preg_split('/(?=[A-Z])/', lcfirst($model));
        \Route::resource($uri_prefix.strtolower($model), ucfirst($pieces[0]).'\Controllers\\'.$model.'Controller');
    }
}
