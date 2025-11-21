<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">My Orders</h1>
            
            <div v-if="orders.data.length > 0" class="space-y-4">
                <div v-for="order in orders.data" :key="order.id" class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Order #{{ order.order_number }}</h3>
                            <p class="text-sm text-gray-600">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                        </div>
                        <div class="text-right">
                            <span :class="[
                                'px-3 py-1 rounded-full text-sm font-semibold',
                                order.status === 'delivered' ? 'bg-green-100 text-green-800' :
                                order.status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                'bg-yellow-100 text-yellow-800'
                            ]">
                                {{ order.status }}
                            </span>
                            <p class="text-lg font-bold mt-2">${{ order.total }}</p>
                        </div>
                    </div>
                    <Link 
                        :href="route('orders.show', order.id)"
                        class="text-indigo-600 hover:text-indigo-800"
                    >
                        View Details →
                    </Link>
                </div>
            </div>

            <div v-else class="text-center py-12">
                <p class="text-gray-600 text-lg">You have no orders yet.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

defineProps({
    user: Object,
    orders: Object,
    locale: String,
    locales: Array,
});
</script>

