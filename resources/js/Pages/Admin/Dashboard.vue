<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Admin Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-600 mb-2">Total Orders</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ stats.total_orders }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-600 mb-2">Total Revenue</h3>
                    <p class="text-3xl font-bold text-green-600">${{ stats.total_revenue.toFixed(2) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-gray-600 mb-2">Total Products</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ stats.total_products }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
                    <div class="space-y-4">
                        <div v-for="order in recentOrders" :key="order.id" class="border-b pb-4">
                            <div class="flex justify-between">
                                <span class="font-semibold">#{{ order.order_number }}</span>
                                <span class="text-gray-600">${{ order.total }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ order.status }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Top Products</h2>
                    <div class="space-y-4">
                        <div v-for="product in topProducts" :key="product.id" class="border-b pb-4">
                            <p class="font-semibold">{{ product.name }}</p>
                            <p class="text-sm text-gray-600">{{ product.views }} views</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';

defineProps({
    user: Object,
    stats: Object,
    recentOrders: Array,
    topProducts: Array,
    locale: String,
    locales: Array,
});
</script>

