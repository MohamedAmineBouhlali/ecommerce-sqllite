<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div v-if="order" class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Order #{{ order.order_number }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold mb-2">Shipping Address</h3>
                        <p class="text-gray-600">{{ order.shipping_address }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-2">Order Status</h3>
                        <span :class="[
                            'px-3 py-1 rounded-full text-sm font-semibold',
                            order.status === 'delivered' ? 'bg-green-100 text-green-800' :
                            order.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                            'bg-yellow-100 text-yellow-800'
                        ]">
                            {{ order.status }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-4">Order Items</h3>
                    <div class="space-y-4">
                        <div v-for="item in order.items" :key="item.id" class="flex items-center border-b pb-4">
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ item.product_name }}</h4>
                                <p class="text-sm text-gray-600">SKU: {{ item.product_sku }}</p>
                            </div>
                            <div class="text-right">
                                <p>Qty: {{ item.quantity }}</p>
                                <p class="font-semibold">${{ item.total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6 mt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-2xl font-bold">${{ order.total }}</span>
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
    order: Object,
    locale: String,
    locales: Array,
});
</script>

