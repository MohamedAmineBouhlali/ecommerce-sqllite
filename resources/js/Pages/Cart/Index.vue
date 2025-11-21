<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>
            
            <div v-if="cartItems.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div v-for="item in cartItems" :key="item.id" class="flex items-center border-b pb-6 mb-6 last:border-0">
                            <img 
                                :src="item.product.images && item.product.images[0] ? item.product.images[0] : '/placeholder-image.jpg'"
                                :alt="item.product.name"
                                class="w-24 h-24 object-cover rounded-lg"
                            />
                            <div class="flex-1 ml-4">
                                <Link :href="route('products.show', item.product.slug)" class="text-lg font-semibold text-gray-800 hover:text-indigo-600">
                                    {{ item.product.name }}
                                </Link>
                                <p class="text-gray-600">${{ item.price }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <input 
                                    :value="item.quantity"
                                    @change="updateQuantity(item.id, $event.target.value)"
                                    type="number" 
                                    min="1"
                                    class="w-20 border border-gray-300 rounded-md px-3 py-2"
                                />
                                <span class="text-lg font-semibold w-24 text-right">${{ item.total }}</span>
                                <button 
                                    @click="removeItem(item.id)"
                                    class="text-red-600 hover:text-red-800"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>${{ total.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>${{ (total * 0.1).toFixed(2) }}</span>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-semibold text-lg">
                                <span>Total</span>
                                <span>${{ (total * 1.1).toFixed(2) }}</span>
                            </div>
                        </div>
                        <Link 
                            :href="route('checkout.index')"
                            class="block w-full bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition"
                        >
                            Proceed to Checkout
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12">
                <p class="text-gray-600 text-lg mb-4">Your cart is empty.</p>
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

const props = defineProps({
    user: Object,
    cartItems: Array,
    total: Number,
    count: Number,
    locale: String,
    locales: Array,
});

const updateQuantity = (id, quantity) => {
    router.put(route('cart.update', id), { quantity }, {
        preserveScroll: true,
    });
};

const removeItem = (id) => {
    router.delete(route('cart.destroy', id), {
        preserveScroll: true,
    });
};
</script>

