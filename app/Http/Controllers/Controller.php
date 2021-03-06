<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\HijriMonth;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getSettingProperty($key)
    {
        SettingResource::withoutWrapping();

        $setting = Setting::query()
            ->property($key)
            ->first();

        if($setting) {
            $setting->value = $setting->value ?? $setting->dummy;
        }

        return new SettingResource($setting);
    }

    protected function getCurrentSession()
    {
        return "43-44";
    }

    public function getHijriDate($date = null)
    {
        $date = $date ?? date("d-m-Y");

        $api_base_url = env('API_BASE_URL', "https://api.aladhan.com");

        $response = Http::get("{$api_base_url}/v1/gToH?date={$date}");

        $response = $response->object();
        
        $current_weekday = $response->data->gregorian->weekday->en;

        $current_day = $response->data->hijri->day;

        $current_month = $response->data->hijri->month;

        $current_month->bn = HijriMonth::find($current_month->number)->bengali ?? $current_month->en;

        $current_year = $response->data->hijri->year;

        return "{$current_day} - $current_month->bn - {$current_year}";
    }

    public function imageUploadGetLink()
    {
        // return $request;

        $image_path = "";
        $model_instance = "";

        $type = (int) (request()->type ?? 1);

        if (request()->hasFile('image')) {
            $image_path = request()->file('image')->store('image', 'public');
        }
        
        if(request()->option == 'student') {
            $model_instance = Student::find(request()->id);
        }
        
        if(request()->option == 'staff') {
            $model_instance = Staff::find(request()->id);
        }

        if($model_instance && $image_path) {
            $this->imageUpdateOrCreate($model_instance, $image_path, $type);
        }

        return $image_path;
    }

    protected function imageUpdateOrCreate($model_instance, $image_path, $type = 1)
    {
        $model_instance = $model_instance->image()->updateOrCreate(
            [
                'type'      => $type,
            ],
            [
                'url'       => "/" . "storage" . "/" . $image_path,
                'user_id'   => Auth::id(),
            ]
        );

        // if($type == 1) {
        //     if($model_instance->image && $model_instance->image->url) {
        //         Storage::delete(str_replace("storage", "public", $model_instance->image->url));
        //     }
        // }

        // if($type == 2) {
        //     if($model_instance->signature && $model_instance->signature->url) {
        //         Storage::delete(str_replace("storage", "public", $model_instance->signature->url));
        //     }
        // }
    }

    public function callArtisan($password, $command, $parameters = []) {
        if($password === 'msi313@mszannat') {
            Artisan::call($command, $parameters);
        }
    }
}
