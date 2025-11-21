import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { Ziggy } from './ziggy';
import { route as ziggyRoute } from 'ziggy-js';

// Make route helper available globally
window.route = (name, params, absolute) => ziggyRoute(name, params, absolute, Ziggy);
window.Ziggy = Ziggy;

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        // Fallback to manual element selection if el is not provided
        const rootElement = el || document.getElementById('app');
        
        if (!rootElement) {
            console.error('Inertia root element not found! Looking for element with id="app"');
            console.error('Available elements:', document.body.innerHTML.substring(0, 200));
            return;
        }
        
        console.log('Mounting Inertia app to element:', rootElement);
        
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(rootElement);
    },
    progress: {
        color: '#4B5563',
    },
});
