<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->unique()->numerify('03#########'),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('123456'),
            'status' => true,
            'remember_token' => Str::random(10),
        ];
    }
}
