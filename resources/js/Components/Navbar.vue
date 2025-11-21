<template>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">
                            E-Commerce
                        </Link>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <Link :href="route('home')" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </Link>
                        <Link :href="route('catalog.index')" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Catalog
                        </Link>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <LanguageSwitcher :locale="locale" :locales="locales" />
                    <Link :href="route('cart.index')" class="relative text-gray-700 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span v-if="cartCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ cartCount }}
                        </span>
                    </Link>
                    <template v-if="user">
                        <Link :href="route('wishlist.index')" class="text-gray-700 hover:text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </Link>
                        <Link :href="route('orders.index')" class="text-gray-700 hover:text-indigo-600">
                            Orders
                        </Link>
                        <Link v-if="user.is_admin" :href="route('admin.dashboard')" class="text-gray-700 hover:text-indigo-600">
                            Admin
                        </Link>
                        <Link :href="route('logout')" method="post" class="text-gray-700 hover:text-indigo-600">
                            Logout
                        </Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="text-gray-700 hover:text-indigo-600">
                            Login
                        </Link>
                        <Link :href="route('register')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import LanguageSwitcher from './LanguageSwitcher.vue';

const props = defineProps({
    user: Object,
    locale: String,
    locales: Array,
});

const cartCount = ref(0);

onMounted(() => {
    loadCartCount();
});

const loadCartCount = async () => {
    try {
        const response = await axios.get(route('cart.count'));
        cartCount.value = response.data.count;
    } catch (error) {
        console.error('Failed to load cart count');
    }
};
</script>

