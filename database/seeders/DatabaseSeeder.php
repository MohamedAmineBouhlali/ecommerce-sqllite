<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create categories
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic devices and gadgets',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashionable clothing for all occasions',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'is_active' => true,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books for all interests',
                'is_active' => true,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $categoryData) {
            $categoryModels[] = Category::create($categoryData);
        }

        // Create products
        $products = [
            // Electronics
            [
                'category_id' => $categoryModels[0]->id,
                'name' => 'Smartphone Pro Max',
                'slug' => 'smartphone-pro-max',
                'description' => 'Latest smartphone with advanced features, high-resolution camera, and long battery life.',
                'short_description' => 'Advanced smartphone with premium features',
                'price' => 899.99,
                'compare_price' => 1099.99,
                'stock' => 50,
                'sku' => 'ELEC-001',
                'images' => ['https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[0]->id,
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'Premium wireless headphones with noise cancellation and 30-hour battery life.',
                'short_description' => 'Premium wireless headphones',
                'price' => 199.99,
                'compare_price' => 249.99,
                'stock' => 75,
                'sku' => 'ELEC-002',
                'images' => ['https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[0]->id,
                'name' => 'Laptop Ultra',
                'slug' => 'laptop-ultra',
                'description' => 'High-performance laptop with latest processor and stunning display.',
                'short_description' => 'High-performance laptop',
                'price' => 1299.99,
                'compare_price' => 1499.99,
                'stock' => 30,
                'sku' => 'ELEC-003',
                'images' => ['https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500'],
                'is_active' => true,
                'is_featured' => false,
            ],
            // Clothing
            [
                'category_id' => $categoryModels[1]->id,
                'name' => 'Classic Denim Jacket',
                'slug' => 'classic-denim-jacket',
                'description' => 'Timeless denim jacket perfect for any season. Made from premium denim.',
                'short_description' => 'Timeless denim jacket',
                'price' => 79.99,
                'compare_price' => 99.99,
                'stock' => 100,
                'sku' => 'CLOTH-001',
                'images' => ['https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[1]->id,
                'name' => 'Cotton T-Shirt',
                'slug' => 'cotton-t-shirt',
                'description' => 'Comfortable cotton t-shirt available in multiple colors.',
                'short_description' => 'Comfortable cotton t-shirt',
                'price' => 24.99,
                'compare_price' => 29.99,
                'stock' => 200,
                'sku' => 'CLOTH-002',
                'images' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
                'is_active' => true,
                'is_featured' => false,
            ],
            // Home & Garden
            [
                'category_id' => $categoryModels[2]->id,
                'name' => 'Indoor Plant Set',
                'slug' => 'indoor-plant-set',
                'description' => 'Beautiful set of indoor plants perfect for home decoration.',
                'short_description' => 'Beautiful indoor plants',
                'price' => 49.99,
                'compare_price' => 59.99,
                'stock' => 60,
                'sku' => 'HOME-001',
                'images' => ['https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[2]->id,
                'name' => 'Modern Table Lamp',
                'slug' => 'modern-table-lamp',
                'description' => 'Elegant modern table lamp with adjustable brightness.',
                'short_description' => 'Elegant modern lamp',
                'price' => 89.99,
                'compare_price' => 119.99,
                'stock' => 40,
                'sku' => 'HOME-002',
                'images' => ['https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500'],
                'is_active' => true,
                'is_featured' => false,
            ],
            // Sports & Outdoors
            [
                'category_id' => $categoryModels[3]->id,
                'name' => 'Running Shoes',
                'slug' => 'running-shoes',
                'description' => 'Professional running shoes with advanced cushioning technology.',
                'short_description' => 'Professional running shoes',
                'price' => 129.99,
                'compare_price' => 159.99,
                'stock' => 80,
                'sku' => 'SPORT-001',
                'images' => ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[3]->id,
                'name' => 'Yoga Mat',
                'slug' => 'yoga-mat',
                'description' => 'Premium yoga mat with non-slip surface and carrying strap.',
                'short_description' => 'Premium yoga mat',
                'price' => 39.99,
                'compare_price' => 49.99,
                'stock' => 120,
                'sku' => 'SPORT-002',
                'images' => ['https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=500'],
                'is_active' => true,
                'is_featured' => false,
            ],
            // Books
            [
                'category_id' => $categoryModels[4]->id,
                'name' => 'The Art of Programming',
                'slug' => 'art-of-programming',
                'description' => 'Comprehensive guide to programming concepts and best practices.',
                'short_description' => 'Programming guide',
                'price' => 49.99,
                'compare_price' => 59.99,
                'stock' => 150,
                'sku' => 'BOOK-001',
                'images' => ['https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500'],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryModels[4]->id,
                'name' => 'Design Patterns Explained',
                'slug' => 'design-patterns-explained',
                'description' => 'Learn design patterns with practical examples and real-world applications.',
                'short_description' => 'Design patterns guide',
                'price' => 34.99,
                'compare_price' => 44.99,
                'stock' => 90,
                'sku' => 'BOOK-002',
                'images' => ['https://images.unsplash.com/photo-1532012193307-3298d7d1e0f4?w=500'],
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create coupons
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'minimum_amount' => 50,
            'usage_limit' => 100,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE20',
            'type' => 'percentage',
            'value' => 20,
            'minimum_amount' => 100,
            'usage_limit' => 50,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLAT50',
            'type' => 'fixed',
            'value' => 50,
            'minimum_amount' => 200,
            'usage_limit' => 25,
            'used_count' => 0,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(2),
            'is_active' => true,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@example.com / password');
        $this->command->info('User credentials: john@example.com / password');
    }
}
