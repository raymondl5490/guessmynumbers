<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Return all result texts
     * 
     * @return JsonResponse
     */
    public function resultTexts()
    {
        $resultTexts = Setting::where('key', 'like', 'result_text_%')->get(['key', 'value']);
        return response()->json($resultTexts);
    }

    /**
     * Setting value of the key
     * 
     * @param string $key
     * @return JsonResponse
     */
    public function value($key)
    {
        $setting = Setting::where('key', $key)->first();
        return response()->json($setting->value);
    }

    /**
     * Setting value of the key
     * 
     * @param string $key
     * @param Request
     * @return JsonResponse
     */
    public function update(Request $request, $key): JsonResponse
    {
        $setting = Setting::where('key', $key)->first();
        $setting->value = $request->input();
        $setting->save();
        return response()->json($setting);
    }
}
