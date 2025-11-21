# Inertia White Screen Troubleshooting

## Issue: White screen with "@routes" text visible

This indicates the Blade template is rendering but JavaScript isn't executing.

## Solutions Applied:

1. ✅ Installed `@vitejs/plugin-vue` for Vue file processing
2. ✅ Installed `ziggy-js` npm package
3. ✅ Configured Ziggy routes in `app.js`
4. ✅ Added error handling in Inertia setup
5. ✅ Cleared all Laravel caches

## Next Steps to Debug:

1. **Check Browser Console**: Open DevTools (F12) and check for JavaScript errors
2. **Verify Vite Dev Server**: Make sure `npm run dev` is running
3. **Check Network Tab**: Verify that `app.js` and CSS files are loading (status 200)
4. **Verify Root Element**: Check if `<div id="app">` exists in the rendered HTML

## Quick Fixes to Try:

### Option 1: Use Built Assets
```bash
npm run build
php artisan serve
```

### Option 2: Use Dev Server
```bash
npm run dev
# In another terminal:
php artisan serve
```

### Option 3: Check if @routes is working
The `@routes` directive should output a `<script>` tag. If you see plain text "@routes", it means:
- Blade isn't processing the directive
- Or JavaScript isn't executing

### Option 4: Manual Root Element (if needed)
If `@inertia` isn't creating the root element, you can manually add it:

```blade
<body class="font-sans antialiased">
    <div id="app" data-page="{{ json_encode($page ?? []) }}"></div>
</body>
```

And update `app.js` to explicitly target it:
```js
createInertiaApp({
    // ... other config
    setup({ el, App, props, plugin }) {
        const rootElement = document.getElementById('app') || el;
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(rootElement);
    },
});
```

