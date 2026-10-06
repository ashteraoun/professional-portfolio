import React from 'react';
import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';

const pages = import.meta.glob('./Pages/**/*.jsx');

createInertiaApp({
    title: (title) => title ? `${title} — Portfolio` : 'Portfolio',
    resolve: (name) => {
        const loadPage = pages[`./Pages/${name}.jsx`];
        if (!loadPage) throw new Error(`Unknown Inertia page: ${name}`);
        return loadPage();
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: {
        color: '#a855f7',
    },
});
