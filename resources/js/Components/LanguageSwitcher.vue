<template>
    <div class="relative" ref="dropdownRef">
        <button
            @click="showDropdown = !showDropdown"
            class="flex items-center space-x-2 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 transition"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
            </svg>
            <span class="uppercase font-semibold">{{ currentLocale }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            v-if="showDropdown"
            class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-50"
        >
            <Link
                v-for="locale in locales"
                :key="locale"
                :href="route('locale.switch', locale)"
                :class="[
                    'block px-4 py-2 text-sm hover:bg-gray-100',
                    currentLocale === locale ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-700'
                ]"
            >
                {{ getLocaleName(locale) }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    locale: String,
    locales: Array,
});

const showDropdown = ref(false);
const dropdownRef = ref(null);

const currentLocale = computed(() => props.locale || 'en');

const getLocaleName = (locale) => {
    const names = {
        en: 'English',
        fr: 'Français',
        ar: 'العربية',
    };
    return names[locale] || locale.toUpperCase();
};

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

