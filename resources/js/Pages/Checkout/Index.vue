<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>
            
            <form @submit.prevent="submitOrder" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input 
                                    v-model="form.customer_name"
                                    type="text" 
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input 
                                    v-model="form.customer_email"
                                    type="email" 
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input 
                                    v-model="form.customer_phone"
                                    type="tel" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Address *</label>
                                <textarea 
                                    v-model="form.shipping_address"
                                    required
                                    rows="3"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                ></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                                <select 
                                    v-model="form.payment_method"
                                    required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                >
                                    <option value="cash">Cash on Delivery</option>
                                    <option value="card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                                <input 
                                    v-model="form.coupon_code"
                                    type="text" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                />
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
                                <span>${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>${{ tax.toFixed(2) }}</span>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-semibold text-lg">
                                <span>Total</span>
                                <span>${{ total.toFixed(2) }}</span>
                            </div>
                        </div>
                        <button 
                            type="submit"
                            class="block w-full bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition"
                        >
                            Place Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    user: Object,
    cartItems: Array,
    subtotal: Number,
    tax: Number,
    total: Number,
    locale: String,
    locales: Array,
});

const form = ref({
    customer_name: props.user?.name || '',
    customer_email: props.user?.email || '',
    customer_phone: '',
    shipping_address: '',
    billing_address: '',
    payment_method: 'cash',
    coupon_code: '',
    notes: '',
});

const submitOrder = () => {
    router.post(route('checkout.store'), form.value);
};
</script>

