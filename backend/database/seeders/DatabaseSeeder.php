<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Subscriber;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@pulsetrade.com'],
            [
                'name' => 'PulseTrade Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1234567890',
                'address' => 'PulseTrade HQ, Tech City',
            ]
        );

        // 2. Seed Demo User (for /login demo credentials)
        User::updateOrCreate(
            ['email' => 'user@pulsetrade.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+15551234567',
                'address' => '456 Demo Lane, User City',
            ]
        );

        // 3. Seed Customer Users
        $customer = User::updateOrCreate(
            ['email' => 'customer@pulsetrade.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+1987654321',
                'address' => '123 Main Street, Apt 4B, Metropolis',
            ]
        );

        $customers = [
            User::updateOrCreate(['email' => 'sarah@example.com'], [
                'name' => 'Sarah Mitchell', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002001', 'address' => '45 Oak Avenue, Springfield',
            ]),
            User::updateOrCreate(['email' => 'james@example.com'], [
                'name' => 'James Wilson', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002002', 'address' => '78 Pine Road, Portland',
            ]),
            User::updateOrCreate(['email' => 'emma@example.com'], [
                'name' => 'Emma Garcia', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002003', 'address' => '12 Elm Street, Austin',
            ]),
            User::updateOrCreate(['email' => 'michael@example.com'], [
                'name' => 'Michael Chen', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002004', 'address' => '321 Maple Drive, Seattle',
            ]),
            User::updateOrCreate(['email' => 'olivia@example.com'], [
                'name' => 'Olivia Brown', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002005', 'address' => '56 Cedar Lane, Denver',
            ]),
            User::updateOrCreate(['email' => 'david@example.com'], [
                'name' => 'David Kim', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002006', 'address' => '89 Birch Way, Boston',
            ]),
            User::updateOrCreate(['email' => 'sophia@example.com'], [
                'name' => 'Sophia Martinez', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002007', 'address' => '14 Walnut Ct, Miami',
            ]),
            User::updateOrCreate(['email' => 'alex@example.com'], [
                'name' => 'Alex Turner', 'password' => Hash::make('password'),
                'role' => 'customer', 'phone' => '+15551002008', 'address' => '27 Spruce Blvd, Chicago',
            ]),
        ];

        $allCustomers = collect([$customer])->merge($customers);

        // 4. Seed Categories
        $categories = [
            ['name' => 'Laptops & Computers', 'description' => 'High performance workhorses and sleek notebooks for creators and professionals.'],
            ['name' => 'Smartphones & Tablets', 'description' => 'Latest mobile devices and tablets with cutting edge features.'],
            ['name' => 'Audio & Headphones', 'description' => 'Immersive sound experience with premium noise cancelling gear.'],
            ['name' => 'Smart Wearables', 'description' => 'Fitness trackers, smartwatches, and lifestyle wearables.'],
            ['name' => 'Accessories', 'description' => 'Essential accessories, chargers, cases, and cables.'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'description' => $cat['description']]
            );
        }

        // 5. Seed Products via dedicated ProductSeeder
        $this->call(ProductSeeder::class);

        // 6. Seed Orders with items
        $allProducts = Product::all();
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $payments = ['pending', 'paid', 'paid', 'paid', 'failed'];
        $methods = ['cod', 'stripe', 'stripe'];

        if (Order::count() === 0) {
            for ($i = 0; $i < 20; $i++) {
                $cust = $allCustomers->random();
                $status = $statuses[array_rand($statuses)];
                $payStatus = $payments[array_rand($payments)];
                $numItems = rand(1, 4);
                $orderItems = $allProducts->random($numItems);
                $total = 0;

                $order = Order::create([
                    'user_id' => $cust->id,
                    'order_number' => 'PT-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                    'status' => $status,
                    'total_amount' => 0,
                    'shipping_address' => $cust->address ?? '123 Default St',
                    'shipping_phone' => $cust->phone ?? '+1000000000',
                    'payment_method' => $methods[array_rand($methods)],
                    'payment_status' => $payStatus,
                ]);

                foreach ($orderItems as $item) {
                    $qty = rand(1, 3);
                    $lineTotal = $item->final_price * $qty;
                    $total += $lineTotal;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->id,
                        'quantity' => $qty,
                        'price' => $item->final_price,
                    ]);
                }

                $order->update(['total_amount' => $total]);
            }
        }

        // 7. Seed Coupons
        $coupons = [
            ['code' => 'WELCOME10', 'type' => 'percentage', 'value' => 10, 'min_order' => 50, 'usage_limit' => 100, 'used_count' => 34, 'is_active' => true, 'expires_at' => now()->addMonths(6)],
            ['code' => 'SAVE50', 'type' => 'fixed', 'value' => 50, 'min_order' => 200, 'usage_limit' => 50, 'used_count' => 12, 'is_active' => true, 'expires_at' => now()->addMonths(3)],
            ['code' => 'SUMMER20', 'type' => 'percentage', 'value' => 20, 'min_order' => 100, 'usage_limit' => 200, 'used_count' => 87, 'is_active' => true, 'expires_at' => now()->addMonths(2)],
            ['code' => 'FLASH15', 'type' => 'percentage', 'value' => 15, 'min_order' => 75, 'usage_limit' => 30, 'used_count' => 30, 'is_active' => false, 'expires_at' => now()->subDays(5)],
            ['code' => 'FREESHIP', 'type' => 'fixed', 'value' => 9.99, 'min_order' => 25, 'usage_limit' => null, 'used_count' => 156, 'is_active' => true, 'expires_at' => null],
            ['code' => 'VIP30', 'type' => 'percentage', 'value' => 30, 'min_order' => 500, 'usage_limit' => 10, 'used_count' => 4, 'is_active' => true, 'expires_at' => now()->addYear()],
            ['code' => 'NEWYEAR', 'type' => 'percentage', 'value' => 25, 'min_order' => 150, 'usage_limit' => 100, 'used_count' => 0, 'is_active' => false, 'expires_at' => now()->subMonths(6)],
        ];

        foreach ($coupons as $c) {
            Coupon::updateOrCreate(['code' => $c['code']], $c);
        }

        // 8. Seed Subscribers
        $subscribers = [
            ['email' => 'sarah@example.com', 'name' => 'Sarah Mitchell', 'is_active' => true, 'subscribed_at' => now()->subMonths(4)],
            ['email' => 'james@example.com', 'name' => 'James Wilson', 'is_active' => true, 'subscribed_at' => now()->subMonths(3)],
            ['email' => 'emma@example.com', 'name' => 'Emma Garcia', 'is_active' => true, 'subscribed_at' => now()->subMonths(2)],
            ['email' => 'michael@example.com', 'name' => 'Michael Chen', 'is_active' => true, 'subscribed_at' => now()->subMonth()],
            ['email' => 'olivia@example.com', 'name' => 'Olivia Brown', 'is_active' => true, 'subscribed_at' => now()->subWeeks(3)],
            ['email' => 'david@example.com', 'name' => 'David Kim', 'is_active' => false, 'subscribed_at' => now()->subMonths(5)],
            ['email' => 'sophia@example.com', 'name' => 'Sophia Martinez', 'is_active' => true, 'subscribed_at' => now()->subDays(10)],
            ['email' => 'alex@example.com', 'name' => 'Alex Turner', 'is_active' => true, 'subscribed_at' => now()->subDays(5)],
            ['email' => 'newsletter_fan@example.com', 'name' => 'Chris Lee', 'is_active' => true, 'subscribed_at' => now()->subDays(2)],
            ['email' => 'tech_lover@example.com', 'name' => 'Jordan Patel', 'is_active' => true, 'subscribed_at' => now()->subDay()],
        ];

        foreach ($subscribers as $s) {
            Subscriber::updateOrCreate(['email' => $s['email']], $s);
        }

        // 9. Seed Settings
        $settings = [
            ['key' => 'store_name', 'value' => 'PulseTrade', 'group' => 'store'],
            ['key' => 'store_email', 'value' => 'hello@pulsetrade.com', 'group' => 'store'],
            ['key' => 'store_phone', 'value' => '+18005559876', 'group' => 'store'],
            ['key' => 'store_address', 'value' => '100 Tech Park Blvd, San Francisco, CA 94105', 'group' => 'store'],
            ['key' => 'store_currency', 'value' => 'USD', 'group' => 'store'],
            ['key' => 'meta_title', 'value' => 'PulseTrade - Premium Tech Electronics', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Shop the latest in premium tech electronics. Laptops, phones, audio gear, wearables, and accessories from PulseTrade.', 'group' => 'seo'],
            ['key' => 'free_shipping_threshold', 'value' => '100', 'group' => 'shipping'],
            ['key' => 'shipping_cost', 'value' => '9.99', 'group' => 'shipping'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
