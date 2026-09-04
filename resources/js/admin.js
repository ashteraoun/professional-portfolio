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
