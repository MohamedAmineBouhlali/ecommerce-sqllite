<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">My Wishlist</h1>
            
            <div v-if="wishlistItems && wishlistItems.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="item in wishlistItems" :key="item.id" class="relative">
                    <ProductCard :product="item.product" />
                    <button
                        @click="removeFromWishlist(item.product.id)"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div v-else class="text-center py-12">
                <p class="text-gray-600 text-lg mb-4">Your wishlist is empty.</p>
                <Link :href="route('catalog.index')" class="text-indigo-600 hover:text-indigo-800">
                    Continue Shopping
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    user: Object,
    wishlistItems: Array,
    locale: String,
    locales: Array,
});

const removeFromWishlist = (productId) => {
    router.delete(route('wishlist.destroy', productId), {
        preserveScroll: true,
    });
};
</script>

