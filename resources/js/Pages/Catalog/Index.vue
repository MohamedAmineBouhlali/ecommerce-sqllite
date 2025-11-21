<template>
    <div>
        <Navbar :user="user" :locale="locale" :locales="locales" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="w-full md:w-64">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Filters</h3>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input 
                                v-model="searchQuery"
                                @input="applyFilters"
                                type="text" 
                                placeholder="Search products..."
                                class="w-full border border-gray-300 rounded-md px-3 py-2"
                            />
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select 
                                v-model="selectedCategory"
                                @change="applyFilters"
                                class="w-full border border-gray-300 rounded-md px-3 py-2"
                            >
                                <option value="">All Categories</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                            <select 
                                v-model="sortBy"
                                @change="applyFilters"
                                class="w-full border border-gray-300 rounded-md px-3 py-2"
                            >
                                <option value="created_at">Newest</option>
                                <option value="price">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="name">Name: A-Z</option>
                            </select>
                        </div>
                    </div>
                </aside>

                <!-- Products Grid -->
                <main class="flex-1">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">Products</h1>
                        <p class="text-gray-600 mt-2">{{ products.total }} products found</p>
                    </div>

                    <div v-if="products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <ProductCard 
                            v-for="product in products.data" 
                            :key="product.id"
                            :product="product"
                        />
                    </div>

                    <div v-else class="text-center py-12">
                        <p class="text-gray-600 text-lg">No products found.</p>
                    </div>

                    <!-- Pagination -->
                    <div v-if="products.links" class="mt-8 flex justify-center">
                        <div v-for="link in products.links" :key="link.label">
                            <Link 
                                v-if="link.url"
                                :href="link.url"
                                v-html="link.label"
                                :class="[
                                    'px-4 py-2 mx-1 rounded-md',
                                    link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'
                                ]"
                            />
                            <span 
                                v-else
                                v-html="link.label"
                                class="px-4 py-2 mx-1 rounded-md bg-gray-200 text-gray-500"
                            />
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import ProductCard from '@/Components/ProductCard.vue';

const props = defineProps({
    user: Object,
    products: Object,
    categories: Array,
    filters: Object,
    locale: String,
    locales: Array,
});

const searchQuery = ref(props.filters?.search || '');
const selectedCategory = ref(props.filters?.category_id || '');
const sortBy = ref(props.filters?.sort_by || 'created_at');

const applyFilters = () => {
    router.get(route('catalog.index'), {
        search: searchQuery.value,
        category_id: selectedCategory.value,
        sort_by: sortBy.value,
    }, {
        preserveState: true,
        replace: true,
    });
};
</script>

