import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

export function initProjectsIndex() {
    const list = document.getElementById('project-list');
    if (!list) return;

    const items = list.querySelectorAll('.project-list-item');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const previewCategory = document.getElementById('preview-category');
    const previewTitle = document.getElementById('preview-title');
    const previewSubtitle = document.getElementById('preview-subtitle');
    const previewExcerpt = document.getElementById('preview-excerpt');
    const previewTech = document.getElementById('preview-tech');
    const previewCaseStudy = document.getElementById('preview-case-study');
    const previewLiveLink = document.getElementById('preview-live-link');
    const previewGithubLink = document.getElementById('preview-github-link');
    const previewModeToggle = document.getElementById('preview-mode-toggle');
    const previewLiveFrameWrap = document.getElementById('preview-live-frame-wrap');
    const previewLiveFrame = document.getElementById('preview-live-frame');
    const mobilePreview = document.getElementById('mobile-project-preview');

    let currentData = null;
    let previewMode = 'image';

    const defaultEl = document.getElementById('projects-default-preview');
    if (defaultEl) {
        try { currentData = JSON.parse(defaultEl.textContent); } catch {}
    }

    function setActiveItem(el) {
        items.forEach((item) => {
            item.classList.toggle('is-active', item === el);
            item.setAttribute('aria-pressed', item === el ? 'true' : 'false');
        });
    }

    function renderTech(tags) {
        if (!previewTech) return;
        previewTech.innerHTML = (tags || []).map((t) =>
            `<span class="rounded-full border border-white/10 px-2.5 py-1 text-[10px] text-muted">${t}</span>`
        ).join('');
    }

    function updatePreviewVisual() {
        if (!currentData || !previewImage) return;

        const hasLive = !!currentData.live_url;
        previewModeToggle?.classList.toggle('hidden', !hasLive);

        if (previewMode === 'live' && hasLive) {
            previewImage.classList.add('opacity-0');
            previewPlaceholder?.classList.add('hidden');
            previewLiveFrameWrap?.classList.remove('hidden');
            if (previewLiveFrame && previewLiveFrame.src !== currentData.live_url) {
                previewLiveFrame.src = currentData.live_url;
            }
        } else {
            previewLiveFrameWrap?.classList.add('hidden');
            if (previewLiveFrame) previewLiveFrame.src = 'about:blank';

            if (currentData.image || currentData.cover) {
                previewPlaceholder?.classList.add('hidden');
                previewImage.src = currentData.image || currentData.cover;
                previewImage.alt = currentData.title;
                previewImage.classList.remove('opacity-0');
                if (!reduced) gsap.fromTo(previewImage, { scale: 1.05 }, { scale: 1, duration: 0.8, ease: 'power2.out' });
            } else {
                previewImage.classList.add('opacity-0');
                previewPlaceholder?.classList.remove('hidden');
            }
        }
    }

    function applyPreview(data) {
        currentData = data;
        if (!data) return;

        if (previewCategory) previewCategory.textContent = [data.category, data.year].filter(Boolean).join(' · ');
        if (previewTitle) previewTitle.textContent = data.title;
        if (previewSubtitle) previewSubtitle.textContent = data.subtitle || data.role || '';
        if (previewExcerpt) previewExcerpt.textContent = data.excerpt || '';
        if (previewCaseStudy) previewCaseStudy.href = data.url;

        if (previewLiveLink) {
            previewLiveLink.classList.toggle('hidden', !data.live_url);
            if (data.live_url) previewLiveLink.href = data.live_url;
        }
        if (previewGithubLink) {
            previewGithubLink.classList.toggle('hidden', !data.github_url);
            if (data.github_url) previewGithubLink.href = data.github_url;
        }

        renderTech(data.technologies);
        updatePreviewVisual();

        if (mobilePreview) {
            mobilePreview.innerHTML = `
                <div class="aspect-[16/10] overflow-hidden bg-ink-soft">
                    ${data.image ? `<img src="${data.image}" alt="${data.title}" class="h-full w-full object-cover">` : ''}
                </div>
                <div class="p-5">
                    <p class="label-mono mb-2">${[data.category, data.year].filter(Boolean).join(' · ')}</p>
                    <h3 class="font-display text-xl font-medium">${data.title}</h3>
                    <p class="mt-2 text-sm text-muted">${data.excerpt || ''}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="${data.url}" class="btn-primary text-sm">Case Study</a>
                        ${data.live_url ? `<a href="${data.live_url}" target="_blank" rel="noopener" class="btn-secondary text-sm">Live</a>` : ''}
                    </div>
                </div>`;
        }
    }

    items.forEach((item) => {
        const activate = () => {
            setActiveItem(item);
            try { applyPreview(JSON.parse(item.dataset.projectPreview)); } catch {}
        };
        item.addEventListener('mouseenter', activate);
        item.addEventListener('focus', activate);
        item.addEventListener('click', activate);
    });

    previewModeToggle?.querySelectorAll('[data-preview-mode]').forEach((btn) => {
        btn.addEventListener('click', () => {
            previewMode = btn.dataset.previewMode;
            previewModeToggle.querySelectorAll('.preview-mode-btn').forEach((b) => b.classList.toggle('is-active', b === btn));
            updatePreviewVisual();
        });
    });

    if (currentData) applyPreview(currentData);
    else if (items[0]) items[0].click();
}

export function initGalleryLightbox() {
    const gallery = document.querySelector('[data-gallery]');
    const lightbox = document.getElementById('lightbox');
    if (!gallery || !lightbox) return;

    const items = [...gallery.querySelectorAll('.gallery-item')];
    const img = document.getElementById('lightbox-image');
    const caption = document.getElementById('lightbox-caption');
    let index = 0;

    function open(i) {
        index = i;
        const el = items[index];
        if (!el || !img) return;
        img.src = el.dataset.gallerySrc;
        img.alt = el.dataset.galleryAlt || '';
        if (caption) caption.textContent = el.dataset.galleryAlt || '';
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function nav(dir) {
        index = (index + dir + items.length) % items.length;
        open(index);
    }

    items.forEach((el, i) => el.addEventListener('click', () => open(i)));
    lightbox.querySelectorAll('[data-lightbox-close]').forEach((el) => el.addEventListener('click', close));
    lightbox.querySelector('[data-lightbox-prev]')?.addEventListener('click', () => nav(-1));
    lightbox.querySelector('[data-lightbox-next]')?.addEventListener('click', () => nav(1));

    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') nav(-1);
        if (e.key === 'ArrowRight') nav(1);
    });
}

export function initProjectShowAnimations() {
    if (reduced) return;
    gsap.utils.toArray('.project-content-block').forEach((block, i) => {
        gsap.from(block, {
            scrollTrigger: { trigger: block, start: 'top 85%' },
            y: 40,
            opacity: 0,
            duration: 0.8,
            delay: i * 0.05,
            ease: 'power2.out',
        });
    });
}
