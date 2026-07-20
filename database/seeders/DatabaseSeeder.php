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

        // 2. Seed Customer Users
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

        // 3. Seed Categories
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

        // 4. Seed Products (7 original + 10 new = 17 total)
        $products = [
            // --- Original 7 ---
            [
                'category_index' => 0, 'name' => 'PulseBook Pro 16',
                'description' => 'The ultimate notebook for professionals. M3-equivalent octa-core processor, 32GB unified memory, and 1TB SSD. 16-inch Liquid Retina XDR display with 1600 nits brightness. Six-speaker sound system and 22-hour battery.',
                'price' => 2499.00, 'sale_price' => 2299.00, 'stock' => 15, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 0, 'name' => 'PulseBook Air 13',
                'description' => 'Superlight. Supercharged. 13.6-inch Liquid Retina display, fanless design, 18-hour battery. Perfect for students and developers.',
                'price' => 1099.00, 'sale_price' => null, 'stock' => 30, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 1, 'name' => 'PulsePhone 15 Ultra',
                'description' => 'Aerospace-grade titanium. A17 Pro-equivalent chip, customizable Action button, powerful zoom camera system. Super Retina XDR with ProMotion 120Hz.',
                'price' => 1199.00, 'sale_price' => 1099.00, 'stock' => 25, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 1, 'name' => 'PulseTab Pro 11',
                'description' => 'Next-gen performance, ultra-thin. Tandem OLED display, ultra-wide Center Stage camera, 5G. Supports precision digital stylus.',
                'price' => 899.00, 'sale_price' => null, 'stock' => 20, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 2, 'name' => 'PulseBuds Pro 2',
                'description' => 'Richer audio, 2x Active Noise Cancellation. Adaptive Audio, Spatial Audio for deeply personal immersion.',
                'price' => 249.00, 'sale_price' => 219.00, 'stock' => 100, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1572569979132-b4f10c9ec185?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 2, 'name' => 'PulseMax Studio Wireless',
                'description' => 'Over-ear headphones reimagined. Uncompromising fit, optimal acoustic seal, high-fidelity custom drivers.',
                'price' => 549.00, 'sale_price' => 499.00, 'stock' => 12, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1495107334309-fcf20504a5ab?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 3, 'name' => 'PulseWatch Active 4',
                'description' => 'Health companion. Blood oxygen, ECG, precision GPS, always-on OLED, aluminum casing, contactless payment.',
                'price' => 399.00, 'sale_price' => null, 'stock' => 45, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1723622555972-37af178c623a?auto=format&fit=crop&w=1200&q=80',
            ],
            // --- 10 New Products ---
            [
                'category_index' => 0, 'name' => 'PulseBook Studio 14',
                'description' => 'Built for creators. 14-inch mini-LED display with P3 wide color, M3 Pro chip, 18GB memory. Up to 17 hours battery. MagSafe charging, six-speaker system with spatial audio.',
                'price' => 1999.00, 'sale_price' => 1799.00, 'stock' => 18, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 0, 'name' => 'PulseDesk Mini',
                'description' => 'M3 chip desktop powerhouse in a compact design. 16GB unified memory, 512GB SSD, Wi-Fi 6E. Connect up to two displays. Perfect for home office setups.',
                'price' => 799.00, 'sale_price' => null, 'stock' => 40, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 1, 'name' => 'PulsePhone 15',
                'description' => 'The standard redefined. A17 chip, 48MP main camera, Ceramic Shield front. 6.1-inch Super Retina XDR display. All-day battery life and 5G.',
                'price' => 899.00, 'sale_price' => 799.00, 'stock' => 35, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 1, 'name' => 'PulsePad Air',
                'description' => 'Lightweight powerhouse. 10.9-inch Liquid Retina display, M2 chip, Touch ID. Wi-Fi 6 and 5G optional. Works with Apple Pencil and Magic Keyboard.',
                'price' => 649.00, 'sale_price' => null, 'stock' => 28, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 2, 'name' => 'PulseBuds 3',
                'description' => 'Everyday earbuds elevated. Active Noise Cancellation, Transparency mode, personalized spatial audio. 6-hour listening time, 30 hours with case.',
                'price' => 179.00, 'sale_price' => 159.00, 'stock' => 80, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12f032f55?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 2, 'name' => 'PulseSound Bar',
                'description' => 'Cinematic sound for your living room. Dolby Atmos, room-filling sound with seven drivers. Works with all your devices via HDMI eARC, Wi-Fi, Bluetooth.',
                'price' => 699.00, 'sale_price' => 599.00, 'stock' => 15, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 3, 'name' => 'PulseWatch Ultra 2',
                'description' => 'The most rugged and capable smartwatch. 49mm titanium case, 2000-nit display, precision dual-frequency GPS. Depth gauge, water temperature, 36-hour battery.',
                'price' => 799.00, 'sale_price' => null, 'stock' => 20, 'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 3, 'name' => 'PulseBand SE',
                'description' => 'Fitness meets affordability. Heart rate monitoring, sleep tracking, 18 types of workouts. Water resistant to 50m. 15-day battery life.',
                'price' => 149.00, 'sale_price' => 129.00, 'stock' => 60, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 4, 'name' => 'PulseChargPro 140W',
                'description' => 'Charge everything at once. 140W GaN charger with 4 ports (2 USB-C, 2 USB-A). Compact design, foldable prongs. Charges MacBook Pro, iPhone, and iPad simultaneously.',
                'price' => 89.00, 'sale_price' => 69.00, 'stock' => 120, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'category_index' => 4, 'name' => 'PulseHub Ultra',
                'description' => '11-in-1 USB-C hub. Dual HDMI 4K@60Hz, Ethernet, SD card, USB-A 3.0 ports, 100W passthrough charging. Aluminum body with built-in cable.',
                'price' => 129.00, 'sale_price' => null, 'stock' => 65, 'is_featured' => false,
                'image' => 'https://images.unsplash.com/photo-1625842268584-8f3296236761?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($products as $prod) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                [
                    'category_id' => $categoryModels[$prod['category_index']]->id,
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'sale_price' => $prod['sale_price'],
                    'stock' => $prod['stock'],
                    'image' => $prod['image'],
                    'images' => json_encode([$prod['image']]),
                    'is_featured' => $prod['is_featured'],
                ]
            );

            if ($prod['is_featured']) {
                Review::updateOrCreate(
                    ['user_id' => $customer->id, 'product_id' => $product->id],
                    ['rating' => 5, 'comment' => 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.']
                );
                Review::updateOrCreate(
                    ['user_id' => $customers[0]->id, 'product_id' => $product->id],
                    ['rating' => 4, 'comment' => 'Very good value, although shipping took a bit longer than expected.']
                );
            }
        }

        // 5. Seed Orders with items
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

        // 6. Seed Coupons
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

        // 7. Seed Subscribers
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

        // 8. Seed Settings
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
