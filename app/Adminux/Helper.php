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

    static function getEnabledSoftwareName()
    {
        return (new \App\Adminux\Software\Models\Software)->query()
        ->join('services', 'software.id', '=', 'services.software_id')
        ->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('software')->keys()->toArray();
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
        return (new \App\Adminux\Service\Models\Plan)->query()->select('services_plans.id')
        ->join('services', 'services.id', '=', 'services_plans.service_id')
        ->whereIn('partner_id', self::getEnabledPartnersKeys())->get()->keyBy('id')->keys()->toArray();
    }

    // Validates if the admin is allowed to manipulate the selected account with the selected service (must be same partner):
    static function validateAccountWithService($account_id = 0, $plan_id = 0)
    {
        $account = \App\Adminux\Account\Models\Account::find($account_id);
        $plan = \App\Adminux\Service\Models\Plan::find($plan_id);
        $service = \App\Adminux\Service\Models\Service::find($plan->service_id);

        abort_if($account->partner_id != $service->partner_id, 403);
    }

    // Get module config:
    static function getConfig($path = '')
    {
        $config = config('adminux.base.default.menu');
        foreach($config as $arr) {
            foreach($arr as $arr2) {
                foreach($arr2['items'] as $arr3) {
                    if($arr3['dir'] == $path && !empty($arr3['module_config']))  return $arr3['module_config'];
                }
            }
        }

        return [];
    }

    // Build route resource:
    static function buildRouteResource($model = '', $uri_prefix = '')
    {
        $pieces = preg_split('/(?=[A-Z])/', lcfirst($model));
        \Route::resource($uri_prefix.Str::plural(strtolower($model)), ucfirst($pieces[0]).'\Controllers\\'.$model.'Controller');
    }

    static function getPrefix()
    {
        return explode('/', ltrim(request()->route()->getPrefix(), '/'))[0];
    }

    // Asset with filemtime like style.95123123.css:
    static function getVersionedAsset($file, $enabled = true)
    {
        if($enabled !== true) return asset($file);
        return asset(preg_replace('{\\.([^./]+)$}', '.'.filemtime(public_path($file)).'.$1', $file));
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
