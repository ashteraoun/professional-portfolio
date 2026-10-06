import React, { useEffect, useState } from 'react';
import { Head, Link, usePage } from '@inertiajs/react';

const navLinks = [
    ['Home', '/'],
    ['About', '/about'],
    ['Projects', '/projects'],
    ['Experience', '/experience'],
    ['Blog', '/blog'],
    ['Packages', '/packages'],
    ['Contact', '/contact'],
];

export function PortfolioLayout({ title, description, children }) {
    const { props, url } = usePage();
    const site = props.site ?? {};
    const socialLinks = props.socialLinks ?? [];
    const [menuOpen, setMenuOpen] = useState(false);
    const [paletteOpen, setPaletteOpen] = useState(false);
    const [paletteQuery, setPaletteQuery] = useState('');
    const [theme, setTheme] = useState(() => document.documentElement.classList.contains('dark'));

    useEffect(() => {
        document.documentElement.classList.remove('admin-root', 'admin-dark');
        const storedTheme = localStorage.getItem('theme');
        const isDark = storedTheme ? storedTheme === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.toggle('dark', isDark);
        setTheme(isDark);
    }, []);

    useEffect(() => {
        document.documentElement.classList.add('motion-ready');
        const elements = document.querySelectorAll('.reveal');
        if (!('IntersectionObserver' in window)) {
            elements.forEach((element) => element.classList.add('is-visible'));
            return;
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -8% 0px' });
        elements.forEach((element) => observer.observe(element));
        return () => observer.disconnect();
    }, [url]);

    useEffect(() => {
        const onKeyDown = (event) => {
            if ((event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                setPaletteOpen((open) => !open);
            } else if (event.key === 'Escape') {
                setPaletteOpen(false);
            }
        };
        window.addEventListener('keydown', onKeyDown);
        return () => window.removeEventListener('keydown', onKeyDown);
    }, []);

    const toggleTheme = () => {
        const next = !document.documentElement.classList.contains('dark');
        document.documentElement.classList.toggle('dark', next);
        localStorage.setItem('theme', next ? 'dark' : 'light');
        setTheme(next);
    };

    const commands = [
        ...navLinks.map(([label, href]) => ({ label: `Go to ${label}`, href, group: 'Pages' })),
        { label: 'Services', href: '/services', group: 'Pages' },
        { label: 'Resume', href: '/resume', group: 'Pages' },
        { label: 'Toggle theme', action: true, group: 'Commands' },
        ...(site.github_url ? [{ label: 'GitHub', href: site.github_url, group: 'External' }] : []),
        ...(site.linkedin_url ? [{ label: 'LinkedIn', href: site.linkedin_url, group: 'External' }] : []),
    ].filter((command) => command.label.toLowerCase().includes(paletteQuery.toLowerCase()));

    const activePath = url.split('?')[0];

    return (
        <>
            <Head title={title ?? site.seo_default_title ?? site.site_name ?? 'Portfolio'}>
                {description && <meta head-key="description" name="description" content={description} />}
                {description && <meta head-key="og-description" property="og:description" content={description} />}
                {title && <meta head-key="og-title" property="og:title" content={title} />}
                {site.favicon_path && <link head-key="favicon" rel="icon" href={`/storage/${site.favicon_path}`} />}
            </Head>
            <a href="#main-content" className="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[200] focus:rounded-md focus:bg-accent focus:px-4 focus:py-2 focus:text-ink">Skip to content</a>
            <div className="grain-overlay fixed inset-0 z-[1]" aria-hidden="true" />
            <div className="fixed inset-0 -z-10 overflow-hidden" aria-hidden="true">
                <div className="blob blob-violet float-slow" style={{ width: 520, height: 520, top: '-10%', left: '-10%' }} />
                <div className="blob blob-pink float-slower" style={{ width: 460, height: 460, top: '20%', right: '-12%' }} />
                <div className="blob blob-orange float-slow" style={{ width: 400, height: 400, bottom: '-10%', left: '15%' }} />
                <div className="blob blob-cyan float-slower" style={{ width: 380, height: 380, bottom: '5%', right: '10%' }} />
            </div>

            <header id="site-nav" className="fixed top-0 left-0 right-0 z-50 px-3 pt-3 transition-all duration-500 sm:px-5 sm:pt-4">
                <div className="container-site">
                    <div className="pill-nav flex h-16 items-center justify-between px-4 shadow-lg shadow-black/10 sm:px-5">
                        <Link href="/" className="flex items-center gap-2 font-display text-lg font-bold tracking-tight">
                            {site.logo_path
                                ? <img src={`/storage/${site.logo_path}`} alt="" className="h-9 w-9 rounded-lg object-contain" />
                                : <span className="icon-chip !h-9 !w-9 text-sm">{(site.site_name ?? 'P').slice(0, 1).toUpperCase()}</span>}
                            <span className="gradient-text">{site.site_name ?? 'Portfolio'}</span>
                        </Link>
                        <nav className="hidden items-center gap-1 lg:flex" aria-label="Primary">
                            {navLinks.map(([label, href]) => (
                                <Link key={href} href={href} aria-current={activePath === href ? 'page' : undefined}
                                    className={`relative rounded-full px-3 py-2 text-sm font-medium text-muted transition hover:text-accent ${activePath === href ? 'gradient-text font-semibold' : ''}`}>
                                    {label}
                                </Link>
                            ))}
                            <Link href="/services" className={`rounded-full px-3 py-2 text-sm font-medium text-muted transition hover:text-accent ${activePath.startsWith('/services') ? 'gradient-text font-semibold' : ''}`}>Services</Link>
                        </nav>
                        <div className="flex items-center gap-2">
                            <button type="button" onClick={toggleTheme} className="rounded-full p-2 text-muted transition hover:text-accent" aria-label={`Switch to ${theme ? 'light' : 'dark'} mode`}>
                                <span aria-hidden="true">{theme ? '☼' : '☾'}</span>
                            </button>
                            <button type="button" onClick={() => setPaletteOpen(true)} className="hidden rounded-full border px-3 py-1.5 text-xs text-muted transition hover:border-accent hover:text-accent sm:inline-flex items-center gap-2" aria-label="Open command palette">
                                <span>Search</span><kbd className="rounded bg-white/5 px-1.5 py-0.5 font-mono text-[10px]">⌘K</kbd>
                            </button>
                            <Link href="/contact" className="btn-primary hidden !py-2.5 sm:inline-flex">Let's Work Together</Link>
                            <button type="button" className="rounded-md p-2 text-muted lg:hidden" aria-expanded={menuOpen} aria-controls="mobile-menu" aria-label="Toggle menu" onClick={() => setMenuOpen(!menuOpen)}>☰</button>
                        </div>
                    </div>
                    {menuOpen && <div id="mobile-menu" className="pill-nav mt-2 overflow-hidden lg:hidden">
                        <nav className="flex flex-col gap-1 p-3" aria-label="Mobile">
                            {[...navLinks, ['Services', '/services'], ['Resume', '/resume']].map(([label, href]) => (
                                <Link key={href} href={href} onClick={() => setMenuOpen(false)} className="rounded-lg px-3 py-3 text-sm text-muted">{label}</Link>
                            ))}
                            <Link href="/contact" className="btn-primary mt-2 justify-center">Let's Work Together</Link>
                        </nav>
                    </div>}
                </div>
            </header>

            <main id="main-content" className="relative z-10">{children}</main>

            <footer className="relative z-10 overflow-hidden border-t border-white/10 section-padding">
                <div className="container-site">
                    <div className="glow-card mb-16 max-w-3xl p-8 md:p-12">
                        <p className="label-mono mb-4">✦ Next Step</p>
                        <h2 className="display-lg mb-6">{site.footer_statement ?? 'Have an idea worth building?'}</h2>
                        <Link href="/contact" className="btn-primary">{site.footer_cta ?? 'Start a Conversation'}</Link>
                    </div>
                    <div className="grid gap-10 border-t border-white/10 pt-10 md:grid-cols-4">
                        <div>
                            <p className="font-display text-lg font-semibold">{site.site_name ?? 'Portfolio'}</p>
                            <p className="mt-2 text-sm text-muted">{site.site_tagline ?? ''}</p>
                            <p className="mt-4 text-sm text-muted">{site.hero_status ?? ''}</p>
                        </div>
                        <div><p className="label-mono mb-4">Navigate</p><ul className="space-y-2 text-sm text-muted">
                            {[['About', '/about'], ['Projects', '/projects'], ['Services', '/services'], ['Blog', '/blog'], ['Resume', '/resume']].map(([label, href]) => <li key={href}><Link href={href} className="link-underline hover:text-accent">{label}</Link></li>)}
                        </ul></div>
                        <div><p className="label-mono mb-4">Connect</p><ul className="space-y-2 text-sm text-muted">
                            {socialLinks.map((item) => <li key={item.url}><a href={item.url} target="_blank" rel="noopener noreferrer" className="link-underline hover:text-accent">{item.platform}</a></li>)}
                            {site.contact_email && <li><a href={`mailto:${site.contact_email}`} className="link-underline hover:text-accent">{site.contact_email}</a></li>}
                        </ul></div>
                        <div><p className="label-mono mb-4">Availability</p><p className="text-sm text-muted">{site.location ?? 'Remote'}</p><p className="mt-2 text-sm text-accent">{site.hero_status ?? ''}</p></div>
                    </div>
                    <div className="mt-12 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-muted sm:flex-row sm:items-center sm:justify-between">
                        <p>© {new Date().getFullYear()} {site.site_name ?? 'Portfolio'}. All rights reserved.</p><p>Engineered with Laravel &amp; React.</p>
                    </div>
                </div>
            </footer>

            {paletteOpen && <div className="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm" role="dialog" aria-modal="true" aria-label="Command palette" onMouseDown={(event) => { if (event.target === event.currentTarget) setPaletteOpen(false); }}>
                <div className="command-palette">
                    <div className="border-b border-white/10 p-4"><input autoFocus type="search" value={paletteQuery} onChange={(event) => setPaletteQuery(event.target.value)} placeholder="Search pages..." className="w-full bg-transparent text-sm outline-none" /></div>
                    <ul className="max-h-80 overflow-y-auto p-2 text-sm">{commands.map((command) => <li key={command.label}>
                        {command.action ? <button type="button" className="command-item w-full rounded-lg px-3 py-2 text-left hover:bg-accent-soft" onClick={() => { toggleTheme(); setPaletteOpen(false); }}>{command.label}</button>
                            : command.href.startsWith('/') ? <Link href={command.href} onClick={() => setPaletteOpen(false)} className="command-item block w-full rounded-lg px-3 py-2 hover:bg-accent-soft">{command.label}<span className="float-right text-xs text-muted">{command.group}</span></Link>
                                : <a href={command.href} target="_blank" rel="noopener noreferrer" className="command-item block w-full rounded-lg px-3 py-2 hover:bg-accent-soft">{command.label}<span className="float-right text-xs text-muted">{command.group}</span></a>}
                    </li>)}</ul>
                    <div className="border-t border-white/10 px-4 py-2 text-xs text-muted">Ctrl/⌘K to search · Esc to close</div>
                </div>
            </div>}
        </>
    );
}

export function SectionHeading({ number, label, title, description, centered = false }) {
    return <header className={`mb-10 ${centered ? 'mx-auto text-center' : ''}`}>
        {number && <span className="label-mono mr-3">{number}</span>}
        {label && <span className="label-mono">{label}</span>}
        <h2 className="display-lg mt-3">{title}</h2>
        {description && <p className={`mt-4 max-w-2xl text-muted ${centered ? 'mx-auto' : ''}`}>{description}</p>}
    </header>;
}

export function Pagination({ paginator }) {
    if (!paginator?.links) return null;
    return <nav className="mt-8 flex flex-wrap gap-2" aria-label="Pagination">
        {paginator.links.map((link, index) => link.url
            ? <Link key={`${index}-${link.label}`} href={link.url} preserveScroll className={`rounded-lg border px-3 py-2 text-sm ${link.active ? 'border-accent bg-accent text-white' : 'border-white/10 text-muted hover:border-accent'}`} dangerouslySetInnerHTML={{ __html: link.label }} />
            : <span key={`${index}-${link.label}`} className="rounded-lg border border-white/10 px-3 py-2 text-sm text-muted/50" dangerouslySetInnerHTML={{ __html: link.label }} />)}
    </nav>;
}

export function Feedback({ errors = {}, status }) {
    const firstError = Object.values(errors).flat()[0];
    return <>
        {status && <p role="status" className="rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400">{status}</p>}
        {firstError && <p role="alert" className="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">{firstError}</p>}
    </>;
}

export function Field({ label, name, form, type = 'text', textarea = false, options, required = false, rows = 4, ...rest }) {
    const value = form.data[name] ?? '';
    const error = form.errors[name];
    const classes = `form-field ${textarea ? 'resize-y' : ''}`;
    return <div>
        <label htmlFor={name} className="label-mono mb-2 block">{label}{required ? ' *' : ''}</label>
        {options ? <select id={name} name={name} value={value} onChange={(event) => form.setData(name, event.target.value)} className="form-field form-select" required={required} {...rest}>
            {options.map((option) => <option key={option.value} value={option.value}>{option.label}</option>)}
        </select> : textarea ? <textarea id={name} name={name} rows={rows} value={value} onChange={(event) => form.setData(name, event.target.value)} className={classes} required={required} {...rest} />
            : <input id={name} name={name} type={type} value={value} onChange={(event) => form.setData(name, event.target.value)} className={classes} required={required} {...rest} />}
        {error && <p className="mt-1 text-xs text-red-400">{error}</p>}
    </div>;
}
