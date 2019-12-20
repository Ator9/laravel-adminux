<?php

namespace App\Adminux;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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

    static function getEnabledServicesKeys()
    {
        return (new \App\Adminux\Service\Models\Service)->query()->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('id')->keys()->toArray();
    }

    static function getSelectedServices()
    {
        return (new \App\Adminux\Service\Models\Service)->query()->whereIn('partner_id', self::getSelectedPartners())->get()->keyBy('id')->keys()->toArray();
    }

    // Validates if the admin is allowed to manipulate the selected service:
    static function validateService($model)
    {
        abort_if(!in_array($model->service_id, self::getEnabledServicesKeys()), 403);
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

    static function getEnabledPlansKeys()
    {
        return (new \App\Adminux\Account\Models\AccountProduct)->query()
        ->join('services_plans', 'services_plans.id', '=', 'accounts_products.plan_id')
        ->join('services', 'services.id', '=', 'services_plans.service_id')
        ->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('plan_id')->keys()->toArray();
    }

    // Validates if the admin is allowed to manipulate the selected account with the selected service (must be same partner):
    static function validateAccountWithService($account_id = 0, $plan_id = 0)
    {
        $account = \App\Adminux\Account\Models\Account::find($account_id);
        $plan = \App\Adminux\Service\Models\Plan::find($plan_id);
        $service = \App\Adminux\Service\Models\Service::find($plan->service_id);

        abort_if($account->partner_id != $service->partner_id, 403);
    }

    static function getNavLeft()
    {
        $data = [];

        foreach(\File::directories(__DIR__) as $dir) {
            $module = basename($dir);

            $config = self::getConfig($module);
            if(empty($config) || empty($config['navigation']['enabled'])) continue;

            $row = $config['navigation'];
            $row['dir'] = Str::plural($module);

            $data[] = $row;
        }

        return $data;
    }

    static function getNavTop($path = '')
    {
        $data = [];

        $array = explode('/', $path);
        if(!empty($array[1]) && $array[1] == 'dashboard') $data = [ 'dashboard' => 'Dashboard' ];
        else {
            $class = explode('_', next($array));

            $config = self::getConfig(ucfirst(Str::singular($class[0])));
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
        else {
            $new_path = current(array_filter(preg_split('/(?=[A-Z])/', $path)));
            if(is_file($file = __DIR__.'/'.$new_path.'/config.php')) require $file;
            elseif(is_file($file = __DIR__.'/'.$new_path.'/config.default.php')) require $file;
        }

        return $config;
    }

    // Build route resource:
    static function buildRouteResource($model = '', $uri_prefix = '')
    {
        $pieces = preg_split('/(?=[A-Z])/', lcfirst($model));
        \Route::resource($uri_prefix.Str::plural(strtolower($model)), ucfirst($pieces[0]).'\Controllers\\'.$model.'Controller');
    }

    static function getUriSingular($uri = '')
    {
        $pieces = explode('_', $uri);
        foreach($pieces as $piece) {
            $data[] = Str::singular($piece);
        }
        return $data;
    }

    public static function exportDt($datatables, $params = [])
    {
        request()->query->remove('start'); request()->query->remove('length');

        $name = (!empty($params['name'])) ? $params['name'] : 'export.csv';

        $array = collect($datatables)['data'];
        if(!empty($array)) $array = array_merge(array(array_keys($array[0])), $array);

        return Excel::download(new \App\Adminux\ExportArray($array), $name);
    }

    public function getFileManager($model, $params = [])
    {
        $dir = (!empty($params['dir'])) ? $params['dir'] : 'public/'.$model->getTable().'/'.$model->id;

        $files = \Storage::files($dir);

        return view('adminux.pages.inc.card_upload')->withModel($model)->withFiles($files);
    }
}
