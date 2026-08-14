<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'shop_name' => 'My Tailor Shop',
            'shop_phone' => '03001234567',
            'shop_email' => 'info@mytailorshop.com',
            'shop_address' => '123 Tailor Street, City',
            'shop_description' => 'A beautiful tailor shop offering custom clothing services.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
