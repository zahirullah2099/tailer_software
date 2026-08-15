<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('dashboard.settings.index', [
            'settings' => [
                'shop_name' => Setting::get('shop_name', ''),
                'shop_phone' => Setting::get('shop_phone', ''),
                'shop_email' => Setting::get('shop_email', ''),
                'shop_address' => Setting::get('shop_address', ''),
                'shop_description' => Setting::get('shop_description', ''),
                'shop_logo' => Setting::get('shop_logo'),
            ],
        ]);
    }

    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('shop_logo')) {
            $oldLogo = Setting::get('shop_logo');
            if ($oldLogo) {
                \Storage::disk('public')->delete($oldLogo);
            }

            $data['shop_logo'] = $request->file('shop_logo')->store('logo', 'public');
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully.',
            'shop_name' => Setting::get('shop_name'),
            'shop_logo_url' => Setting::get('shop_logo') ? asset('storage/' . Setting::get('shop_logo')) : null,
        ]);
    }
}
