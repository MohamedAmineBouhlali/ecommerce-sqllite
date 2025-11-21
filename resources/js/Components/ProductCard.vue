<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <Link :href="route('products.show', product.slug)" class="block">
            <div class="relative">
                <img 
                    :src="product.images && product.images[0] ? product.images[0] : '/placeholder-image.jpg'" 
                    :alt="product.name"
                    class="w-full h-48 object-cover"
                />
                <span v-if="product.is_featured" class="absolute top-2 right-2 bg-yellow-400 text-white px-2 py-1 rounded text-xs font-semibold">
                    Featured
                </span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">{{ product.name }}</h3>
                <p v-if="product.short_description" class="text-sm text-gray-600 mb-3 line-clamp-2">
                    {{ product.short_description }}
                </p>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-indigo-600">${{ product.price }}</span>
                        <span v-if="product.compare_price" class="text-sm text-gray-500 line-through ml-2">
                            ${{ product.compare_price }}
                        </span>
                    </div>
                    <div v-if="product.average_rating" class="flex items-center">
                        <span class="text-yellow-400">★</span>
                        <span class="text-sm text-gray-600 ml-1">{{ product.average_rating.toFixed(1) }}</span>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    product: Object,
});
</script>

