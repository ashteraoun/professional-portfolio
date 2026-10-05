// Minimal admin scripts — no portfolio theme/dark mode

const adminThemeToggle = document.getElementById('admin-theme-toggle');
const adminThemeLabel = adminThemeToggle?.querySelector('[data-admin-theme-label]');

function syncAdminThemeControl() {
    const isDark = document.documentElement.classList.contains('admin-dark');
    if (!adminThemeToggle) return;

    adminThemeToggle.setAttribute('aria-pressed', String(isDark));
    adminThemeToggle.setAttribute('aria-label', `Switch to ${isDark ? 'light' : 'dark'} mode`);
    adminThemeToggle.title = `Switch to ${isDark ? 'light' : 'dark'} mode`;
    if (adminThemeLabel) adminThemeLabel.textContent = isDark ? 'Light mode' : 'Dark mode';
    adminThemeToggle.querySelector('.admin-theme-sun')?.classList.toggle('hidden', !isDark);
    adminThemeToggle.querySelector('.admin-theme-moon')?.classList.toggle('hidden', isDark);
}

syncAdminThemeControl();
adminThemeToggle?.addEventListener('click', () => {
    const isDark = document.documentElement.classList.toggle('admin-dark');
    localStorage.setItem('admin-theme', isDark ? 'dark' : 'light');
    syncAdminThemeControl();
});

const brandingPreviewUrls = new WeakMap();

document.querySelectorAll('[data-branding-preview]').forEach((input) => {
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        const preview = document.querySelector(`[data-branding-preview-target="${input.dataset.brandingPreview}"]`);
        if (!file || !preview) return;

        const previousUrl = brandingPreviewUrls.get(input);
        if (previousUrl) URL.revokeObjectURL(previousUrl);

        const imageUrl = URL.createObjectURL(file);
        brandingPreviewUrls.set(input, imageUrl);

        let image = preview.querySelector('img');
        if (!image) {
            image = document.createElement('img');
            image.alt = '';
            preview.prepend(image);
        }

        image.src = imageUrl;
        image.hidden = false;
        preview.querySelector('[data-branding-placeholder]')?.classList.add('hidden');
    });
});

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

// Gallery image removal (avoids nested forms inside main project form)
document.querySelectorAll('.gallery-remove-btn').forEach((btn) => {
    btn.addEventListener('click', async () => {
        if (!confirm('Remove this image?')) return;

        const url = btn.dataset.removeUrl;
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!url || !token) return;

        btn.disabled = true;
        btn.textContent = 'Removing...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ _method: 'DELETE' }),
            });

            if (response.ok) {
                btn.closest('[data-gallery-id]')?.remove();
            } else {
                alert('Could not remove image. Please try again.');
                btn.disabled = false;
                btn.textContent = 'Remove';
            }
        } catch {
            alert('Could not remove image. Please try again.');
            btn.disabled = false;
            btn.textContent = 'Remove';
        }
    });
});

// Project create/edit form submit feedback
document.querySelectorAll('[data-project-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const btn = form.querySelector('button[type="submit"]');
        if (btn && !btn.disabled) {
            btn.disabled = true;
            btn.innerHTML = '<span>Saving...</span>';
        }
    });
});
