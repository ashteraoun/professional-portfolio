// Minimal admin scripts — no portfolio theme/dark mode
document.querySelectorAll('[data-file-preview]').forEach((input) => {
    input.addEventListener('change', (e) => {
        const zone = input.closest('[data-file-zone]');
        const preview = zone?.querySelector('[data-file-name]');
        const file = e.target.files?.[0];
        if (preview && file) {
            preview.textContent = file.name;
            zone.classList.add('border-indigo-400', 'bg-indigo-50/50');
        }
    });
});

document.querySelectorAll('[data-gallery-input]').forEach((input) => {
    input.addEventListener('change', (e) => {
        const count = e.target.files?.length ?? 0;
        const label = input.closest('[data-file-zone]')?.querySelector('[data-file-count]');
        if (label) label.textContent = count ? `${count} file(s) selected` : 'Drop images or click to browse';
    });
});
