<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to Our Store</h1>
                <p class="text-xl mb-8">Discover amazing products at unbeatable prices</p>
                <Link :href="route('catalog.index')" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Shop Now
                </Link>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <Link 
                    v-for="category in categories" 
                    :key="category.id"
                    :href="route('catalog.index', { category_id: category.id })"
                    class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition"
                >
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="font-semibold text-gray-800">{{ category.name }}</h3>
                </Link>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Featured Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <ProductCard 
                        v-for="product in featuredProducts" 
                        :key="product.id"
                        :product="product"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductCard from '@/Components/ProductCard.vue';

defineProps({
    user: Object,
    featuredProducts: Array,
    categories: Array,
    locale: String,
    locales: Array,
});
</script>

