<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div v-if="product" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <img 
                        :src="product.images && product.images[0] ? product.images[0] : '/placeholder-image.jpg'" 
                        :alt="product.name"
                        class="w-full rounded-lg shadow-lg"
                    />
                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ product.name }}</h1>
                    <div class="flex items-center mb-4">
                        <span class="text-3xl font-bold text-indigo-600">${{ product.price }}</span>
                        <span v-if="product.compare_price" class="text-xl text-gray-500 line-through ml-4">
                            ${{ product.compare_price }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-6">{{ product.description }}</p>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <div class="flex items-center space-x-4">
                            <input 
                                v-model.number="quantity" 
                                type="number" 
                                min="1" 
                                :max="product.stock"
                                class="w-20 border border-gray-300 rounded-md px-3 py-2"
                            />
                            <span class="text-sm text-gray-600">{{ product.stock }} in stock</span>
                        </div>
                    </div>

                    <div class="flex space-x-4 mb-6">
                        <button 
                            @click="addToCart"
                            class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition"
                        >
                            Add to Cart
                        </button>
                        <button 
                            v-if="user"
                            @click="toggleWishlist"
                            class="border border-gray-300 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition"
                        >
                            {{ isInWishlist ? 'Remove from' : 'Add to' }} Wishlist
                        </button>
                    </div>

                    <!-- Reviews Section -->
                    <div v-if="product.approved_reviews && product.approved_reviews.length > 0" class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Reviews</h3>
                        <div v-for="review in product.approved_reviews" :key="review.id" class="mb-4 pb-4 border-b">
                            <div class="flex items-center mb-2">
                                <span class="font-semibold">{{ review.user.name }}</span>
                                <div class="ml-2">
                                    <span v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
                                </div>
                            </div>
                            <p class="text-gray-600">{{ review.comment }}</p>
                        </div>
                    </div>

                    <!-- Add Review Form -->
                    <div v-if="user" class="mt-8">
                        <h3 class="text-xl font-semibold mb-4">Add a Review</h3>
                        <form @submit.prevent="submitReview">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <select v-model="reviewForm.rating" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                    <option value="">Select rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                                <textarea 
                                    v-model="reviewForm.comment"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2"
                                    rows="4"
                                ></textarea>
                            </div>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                                Submit Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <ProductCard 
                        v-for="product in relatedProducts" 
                        :key="product.id"
                        :product="product"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    user: Object,
    product: Object,
    relatedProducts: Array,
    locale: String,
    locales: Array,
});

const quantity = ref(1);
const isInWishlist = ref(false);
const reviewForm = ref({
    rating: '',
    comment: '',
});

const addToCart = () => {
    router.post(route('cart.store'), {
        product_id: props.product.id,
        quantity: quantity.value,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Show success message
        },
    });
};

const toggleWishlist = () => {
    if (isInWishlist.value) {
        router.delete(route('wishlist.destroy', props.product.id));
    } else {
        router.post(route('wishlist.store', props.product.id));
    }
};

const submitReview = () => {
    router.post(route('reviews.store', props.product.id), reviewForm.value, {
        preserveScroll: true,
        onSuccess: () => {
            reviewForm.value = { rating: '', comment: '' };
        },
    });
};
</script>

