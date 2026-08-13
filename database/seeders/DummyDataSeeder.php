<?php

namespace Database\Seeders;

use App\Enums\CollarType;
use App\Enums\CuffType;
use App\Enums\DressType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PocketType;
use App\Models\Customer;
use App\Models\Measurement;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            $this->command->error('No user found. Run UserSeeder first.');

            return;
        }

        $names = [
            'Ahmed Raza', 'Bilal Khan', 'Usman Tariq', 'Hassan Ali', 'Zainab Fatima',
            'Sana Malik', 'Imran Sheikh', 'Kamran Yousaf', 'Farhan Iqbal', 'Nadia Aslam',
        ];

        $dressTypes = DressType::cases();
        $statuses = OrderStatus::cases();
        $methods = PaymentMethod::cases();

        foreach ($names as $i => $name) {
            $customer = Customer::create([
                'name' => $name,
                'phone' => '03' . rand(100000000, 999999999),
                'alternate_phone' => null,
                'address' => 'Street ' . rand(1, 50) . ', Rawalpindi',
                'notes' => null,
                'created_by' => $user->id,
            ]);

            $measurement = Measurement::create([
                'customer_id' => $customer->id,
                'taken_by' => $user->id,
                'chest' => rand(36, 44),
                'shoulder' => rand(16, 20),
                'sleeve' => rand(22, 26),
                'neck' => rand(14, 17),
                'shirt_length' => rand(28, 32),
                'waist' => rand(30, 38),
                'hip' => rand(38, 46),
                'shalwar_length' => rand(38, 42),
                'bottom_width' => rand(14, 18),
                'collar' => collect(CollarType::cases())->random(),
                'cuff' => collect(CuffType::cases())->random(),
                'pocket_type' => collect(PocketType::cases())->random(),
                'fitting_notes' => null,
                'is_default' => true,
            ]);

            // 1-3 orders per customer, spread across the last 30 days
            $orderCount = rand(1, 3);

            for ($j = 0; $j < $orderCount; $j++) {
                $orderDate = now()->subDays(rand(0, 29));
                $totalAmount = rand(2000, 8000);
                $status = collect($statuses)->random();

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'measurement_id' => $measurement->id,
                    'created_by' => $user->id,
                    'dress_type' => collect($dressTypes)->random(),
                    'quantity' => rand(1, 3),
                    'total_amount' => $totalAmount,
                    'order_date' => $orderDate,
                    'delivery_date' => $orderDate->copy()->addDays(rand(3, 10)),
                    'status' => $status,
                    'notes' => null,
                ]);

                // Randomly record 0, partial, or full payment
                $paymentChance = rand(1, 100);

                if ($paymentChance <= 70) {
                    $paidAmount = $paymentChance <= 40
                        ? $totalAmount // fully paid
                        : round($totalAmount * (rand(30, 70) / 100)); // partial

                    Payment::create([
                        'order_id' => $order->id,
                        'received_by' => $user->id,
                        'amount' => $paidAmount,
                        'payment_method' => collect($methods)->random(),
                        'remarks' => null,
                        'paid_at' => $orderDate->copy()->addDays(rand(0, 2)),
                    ]);
                }
            }
        }

        $this->command->info('Dummy data seeded: 10 customers, measurements, orders, and payments.');
    }
}
