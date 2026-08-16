<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private array $imageMap = [
        'laptop' => [
            'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=600&q=80',
        ],
        'desktop' => [
            'https://images.unsplash.com/photo-1660855551740-4474188debdb?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1660855551740-4474188debdb?auto=format&fit=crop&w=600&q=80',
        ],
        'phone' => [
            'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1592432678016-e910b452f9a2?auto=format&fit=crop&w=600&q=80',
        ],
        'tablet' => [
            'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1527698266440-12104e498b76?auto=format&fit=crop&w=600&q=80',
        ],
        'earbuds' => [
            'https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?auto=format&fit=crop&w=600&q=80',
        ],
        'headphones' => [
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80',
        ],
        'speaker' => [
            'https://images.unsplash.com/photo-1558089687-f282ffcbc126?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
        ],
        'watch' => [
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?auto=format&fit=crop&w=600&q=80',
        ],
        'band' => [
            'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
        ],
        'charger' => [
            'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
        ],
        'hub' => [
            'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80',
        ],
    ];

    private function imagesFor(string $name): array
    {
        $keyword = match (true) {
            str_contains($name, 'Book') || str_contains($name, 'Laptop') => 'laptop',
            str_contains($name, 'Desk') || str_contains($name, 'Mini') => 'desktop',
            str_contains($name, 'Phone') => 'phone',
            str_contains($name, 'Tab') || str_contains($name, 'Pad') => 'tablet',
            str_contains($name, 'Buds') => 'earbuds',
            str_contains($name, 'Max') || str_contains($name, 'Headphone') => 'headphones',
            str_contains($name, 'Sound') || str_contains($name, 'Bar') => 'speaker',
            str_contains($name, 'Watch') => 'watch',
            str_contains($name, 'Band') => 'band',
            str_contains($name, 'Charg') => 'charger',
            str_contains($name, 'Hub') => 'hub',
            default => 'headphones',
        };

        $images = $this->imageMap[$keyword];

        return [
            'main' => $images[0],
            'gallery' => $images,
        ];
    }

    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@pulsetrade.com')->first();
        $customers = \App\Models\User::where('role', 'customer')->get();

        $categoryNames = [
            'Laptops & Computers',
            'Smartphones & Tablets',
            'Audio & Headphones',
            'Smart Wearables',
            'Accessories',
        ];
        $categories = [];
        foreach ($categoryNames as $name) {
            $cat = Category::where('name', $name)->first();
            if ($cat) {
                $categories[] = $cat;
            }
        }

        $productData = [
            ['category_index' => 0, 'name' => 'PulseBook Pro 16', 'description' => 'The ultimate notebook for professionals. M3-equivalent octa-core processor, 32GB unified memory, and 1TB SSD. 16-inch Liquid Retina XDR display with 1600 nits brightness. Six-speaker sound system and 22-hour battery.', 'price' => 2499.00, 'sale_price' => 2299.00, 'stock' => 15, 'is_featured' => true],
            ['category_index' => 0, 'name' => 'PulseBook Air 13', 'description' => 'Superlight. Supercharged. 13.6-inch Liquid Retina display, fanless design, 18-hour battery. Perfect for students and developers.', 'price' => 1099.00, 'sale_price' => null, 'stock' => 30, 'is_featured' => false],
            ['category_index' => 1, 'name' => 'PulsePhone 15 Ultra', 'description' => 'Aerospace-grade titanium. A17 Pro-equivalent chip, customizable Action button, powerful zoom camera system. Super Retina XDR with ProMotion 120Hz.', 'price' => 1199.00, 'sale_price' => 1099.00, 'stock' => 25, 'is_featured' => true],
            ['category_index' => 1, 'name' => 'PulseTab Pro 11', 'description' => 'Next-gen performance, ultra-thin. Tandem OLED display, ultra-wide Center Stage camera, 5G. Supports precision digital stylus.', 'price' => 899.00, 'sale_price' => null, 'stock' => 20, 'is_featured' => false],
            ['category_index' => 2, 'name' => 'PulseBuds Pro 2', 'description' => 'Richer audio, 2x Active Noise Cancellation. Adaptive Audio, Spatial Audio for deeply personal immersion.', 'price' => 249.00, 'sale_price' => 219.00, 'stock' => 100, 'is_featured' => true],
            ['category_index' => 2, 'name' => 'PulseMax Studio Wireless', 'description' => 'Over-ear headphones reimagined. Uncompromising fit, optimal acoustic seal, high-fidelity custom drivers.', 'price' => 549.00, 'sale_price' => 499.00, 'stock' => 12, 'is_featured' => true],
            ['category_index' => 3, 'name' => 'PulseWatch Active 4', 'description' => 'Health companion. Blood oxygen, ECG, precision GPS, always-on OLED, aluminum casing, contactless payment.', 'price' => 399.00, 'sale_price' => null, 'stock' => 45, 'is_featured' => false],
            ['category_index' => 0, 'name' => 'PulseBook Studio 14', 'description' => 'Built for creators. 14-inch mini-LED display with P3 wide color, M3 Pro chip, 18GB memory. Up to 17 hours battery. MagSafe charging, six-speaker system with spatial audio.', 'price' => 1999.00, 'sale_price' => 1799.00, 'stock' => 18, 'is_featured' => true],
            ['category_index' => 0, 'name' => 'PulseDesk Mini', 'description' => 'M3 chip desktop powerhouse in a compact design. 16GB unified memory, 512GB SSD, Wi-Fi 6E. Connect up to two displays. Perfect for home office setups.', 'price' => 799.00, 'sale_price' => null, 'stock' => 40, 'is_featured' => false],
            ['category_index' => 1, 'name' => 'PulsePhone 15', 'description' => 'The standard redefined. A17 chip, 48MP main camera, Ceramic Shield front. 6.1-inch Super Retina XDR display. All-day battery life and 5G.', 'price' => 899.00, 'sale_price' => 799.00, 'stock' => 35, 'is_featured' => true],
            ['category_index' => 1, 'name' => 'PulsePad Air', 'description' => 'Lightweight powerhouse. 10.9-inch Liquid Retina display, M2 chip, Touch ID. Wi-Fi 6 and 5G optional. Works with Apple Pencil and Magic Keyboard.', 'price' => 649.00, 'sale_price' => null, 'stock' => 28, 'is_featured' => false],
            ['category_index' => 2, 'name' => 'PulseBuds 3', 'description' => 'Everyday earbuds elevated. Active Noise Cancellation, Transparency mode, personalized spatial audio. 6-hour listening time, 30 hours with case.', 'price' => 179.00, 'sale_price' => 159.00, 'stock' => 80, 'is_featured' => false],
            ['category_index' => 2, 'name' => 'PulseSound Bar', 'description' => 'Cinematic sound for your living room. Dolby Atmos, room-filling sound with seven drivers. Works with all your devices via HDMI eARC, Wi-Fi, Bluetooth.', 'price' => 699.00, 'sale_price' => 599.00, 'stock' => 15, 'is_featured' => true],
            ['category_index' => 3, 'name' => 'PulseWatch Ultra 2', 'description' => 'The most rugged and capable smartwatch. 49mm titanium case, 2000-nit display, precision dual-frequency GPS. Depth gauge, water temperature, 36-hour battery.', 'price' => 799.00, 'sale_price' => null, 'stock' => 20, 'is_featured' => true],
            ['category_index' => 3, 'name' => 'PulseBand SE', 'description' => 'Fitness meets affordability. Heart rate monitoring, sleep tracking, 18 types of workouts. Water resistant to 50m. 15-day battery life.', 'price' => 149.00, 'sale_price' => 129.00, 'stock' => 60, 'is_featured' => false],
            ['category_index' => 4, 'name' => 'PulseChargPro 140W', 'description' => 'Charge everything at once. 140W GaN charger with 4 ports (2 USB-C, 2 USB-A). Compact design, foldable prongs. Charges MacBook Pro, iPhone, and iPad simultaneously.', 'price' => 89.00, 'sale_price' => 69.00, 'stock' => 120, 'is_featured' => false],
            ['category_index' => 4, 'name' => 'PulseHub Ultra', 'description' => '11-in-1 USB-C hub. Dual HDMI 4K@60Hz, Ethernet, SD card, USB-A 3.0 ports, 100W passthrough charging. Aluminum body with built-in cable.', 'price' => 129.00, 'sale_price' => null, 'stock' => 65, 'is_featured' => false],
        ];

        foreach ($productData as $prod) {
            $slug = Str::slug($prod['name']);
            $images = $this->imagesFor($prod['name']);

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categories[$prod['category_index']]->id,
                    'name' => $prod['name'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'sale_price' => $prod['sale_price'],
                    'stock' => $prod['stock'],
                    'image' => $images['main'],
                    'images' => $images['gallery'],
                    'is_featured' => $prod['is_featured'],
                ]
            );

            if ($prod['is_featured'] && $admin && $customers->isNotEmpty()) {
                Review::updateOrCreate(
                    ['user_id' => $admin->id, 'product_id' => $product->id],
                    ['rating' => 5, 'comment' => 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.']
                );
                Review::updateOrCreate(
                    ['user_id' => $customers->first()->id, 'product_id' => $product->id],
                    ['rating' => 4, 'comment' => 'Very good value, although shipping took a bit longer than expected.']
                );
            }
        }
    }
}
