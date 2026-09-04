import './bootstrap';
import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Theme
const html = document.documentElement;
const storedTheme = localStorage.getItem('theme');

if (storedTheme === 'light') {
    html.classList.remove('dark');
} else if (storedTheme === 'dark') {
    html.classList.add('dark');
} else if (!window.matchMedia('(prefers-color-scheme: dark)').matches) {
    html.classList.remove('dark');
}

function toggleTheme() {
    html.classList.toggle('dark');
    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
}

document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);

// Smooth scroll
let lenis;
if (!prefersReducedMotion) {
    lenis = new Lenis({ duration: 1.1, smoothWheel: true });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);
}

// Navigation scroll state
const nav = document.getElementById('site-nav');
if (nav) {
    const onScroll = () => nav.classList.toggle('nav-scrolled', window.scrollY > 40);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

// Mobile menu
const mobileToggle = document.getElementById('mobile-menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');
mobileToggle?.addEventListener('click', () => {
    const open = mobileMenu.classList.toggle('hidden') === false;
    mobileToggle.setAttribute('aria-expanded', String(open));
    mobileMenu.setAttribute('aria-hidden', String(!open));
});

// Reveal animations
if (!prefersReducedMotion) {
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach((el) => observer.observe(el));
} else {
    document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-visible'));
}

// Marquee pause on hover / reduced motion
document.querySelectorAll('[data-marquee]').forEach((track) => {
    if (prefersReducedMotion) track.classList.add('paused');
    track.addEventListener('mouseenter', () => track.classList.add('paused'));
    track.addEventListener('mouseleave', () => !prefersReducedMotion && track.classList.remove('paused'));
});

// Hero glow follow (desktop only)
if (!prefersReducedMotion && window.matchMedia('(pointer: fine)').matches) {
    const glow = document.getElementById('hero-glow');
    if (glow) {
        window.addEventListener('mousemove', (e) => {
            gsap.to(glow, { x: e.clientX - window.innerWidth / 2, y: e.clientY - window.innerHeight / 3, duration: 1.2, ease: 'power2.out' });
        }, { passive: true });
    }
}

// Custom cursor (desktop)
if (!prefersReducedMotion && window.matchMedia('(pointer: fine)').matches) {
    const cursor = document.getElementById('custom-cursor');
    const dot = cursor?.querySelector('.custom-cursor-dot');
    if (cursor && dot) {
        let x = 0, y = 0;
        window.addEventListener('mousemove', (e) => {
            x = e.clientX; y = e.clientY;
            gsap.to(cursor, { x: x - 4, y: y - 4, duration: 0.15 });
        }, { passive: true });
        document.querySelectorAll('a, button, [data-cursor]').forEach((el) => {
            el.addEventListener('mouseenter', () => cursor.classList.add('is-link'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('is-link'));
        });
    }
}

// Magnetic buttons
if (!prefersReducedMotion) {
    document.querySelectorAll('.magnetic-btn').forEach((btn) => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(btn, { x: x * 0.15, y: y * 0.15, duration: 0.3 });
        });
        btn.addEventListener('mouseleave', () => gsap.to(btn, { x: 0, y: 0, duration: 0.4 }));
    });
}

// Command palette
const commandRoot = document.getElementById('command-palette-root');
const commandInput = document.getElementById('command-input');
const commandResults = document.getElementById('command-results');
const commandDataEl = document.getElementById('command-data');
let commandItems = [];

if (commandDataEl) {
    try { commandItems = JSON.parse(commandDataEl.textContent); } catch {}
}

function openCommandPalette() {
    commandRoot?.classList.remove('hidden');
    commandInput?.focus();
    renderCommandResults('');
}

function closeCommandPalette() {
    commandRoot?.classList.add('hidden');
    if (commandInput) commandInput.value = '';
}

function renderCommandResults(query) {
    if (!commandResults) return;
    const q = query.toLowerCase();
    const filtered = commandItems.filter((item) => item.label.toLowerCase().includes(q));
    commandResults.innerHTML = filtered.map((item, i) =>
        `<li><button type="button" class="command-item w-full rounded-lg px-3 py-2 text-left hover:bg-accent-soft ${i === 0 ? 'bg-accent-soft' : ''}" data-index="${i}">${item.label}<span class="float-right text-xs text-muted">${item.group}</span></button></li>`
    ).join('');

    commandResults.querySelectorAll('.command-item').forEach((btn) => {
        btn.addEventListener('click', () => executeCommand(filtered[Number(btn.dataset.index)]));
    });
}

function executeCommand(item) {
    if (!item) return;
    closeCommandPalette();
    if (item.action === 'toggle-theme') toggleTheme();
    else if (item.url) window.location.href = item.url;
}

document.getElementById('command-trigger')?.addEventListener('click', openCommandPalette);
commandRoot?.querySelector('[data-command-close]')?.addEventListener('click', closeCommandPalette);
commandInput?.addEventListener('input', (e) => renderCommandResults(e.target.value));

document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        commandRoot?.classList.contains('hidden') ? openCommandPalette() : closeCommandPalette();
    }
    if (e.key === 'Escape') closeCommandPalette();
});

// View transitions
if (!prefersReducedMotion && document.startViewTransition) {
    document.querySelectorAll('a[href]').forEach((link) => {
        if (link.origin !== location.origin || link.target === '_blank') return;
        link.addEventListener('click', (e) => {
            const url = link.href;
            if (e.metaKey || e.ctrlKey || url === location.href) return;
            e.preventDefault();
            document.startViewTransition(() => { window.location.href = url; });
        });
    });
}

// Expose for command palette
window.toggleTheme = toggleTheme;
