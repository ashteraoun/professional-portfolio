import React, { useEffect, useState } from 'react';
import { Link, router, useForm, usePage } from '@inertiajs/react';
import { Field, Pagination, PortfolioLayout, SectionHeading } from '../Components';
import '../../css/app.css';

const dateLabel = (value, options = { year: 'numeric', month: 'short' }) => value
    ? new Intl.DateTimeFormat(undefined, options).format(new Date(value))
    : '';
const storageUrl = (path) => !path ? null : (/^https?:\/\//.test(path) ? path : `/storage/${path}`);
const queryLink = (path, values) => {
    const params = new URLSearchParams();
    Object.entries(values).forEach(([key, value]) => { if (value) params.set(key, value); });
    return `${path}${params.size ? `?${params}` : ''}`;
};
const cardImage = (project) => project.preview?.image ?? project.thumbnail ?? project.hero_image ?? project.image ?? null;

function ProjectCard({ project }) {
    const image = cardImage(project);
    const tech = project.technologies ?? [];
    return <Link href={`/projects/${project.slug}`} className="project-card glow-card group block">
        <div className="relative aspect-[16/10] overflow-hidden bg-ink-soft">
            {image ? <img src={storageUrl(image)} alt={project.title} loading="lazy" className="project-card-image h-full w-full object-cover" />
                : <div className="flex h-full items-center justify-center" style={{ background: 'var(--gradient-brand-soft)' }}><span className="gradient-text font-display text-4xl font-bold">{project.title?.slice(0, 1)}</span></div>}
            <div className="absolute inset-0 bg-gradient-to-t from-ink via-ink/10 to-transparent opacity-70" />
            {project.live_url && <span className="absolute top-4 right-4 rounded-full px-3 py-1 text-[10px] font-semibold uppercase text-white" style={{ background: 'var(--gradient-cta)' }}>Live</span>}
        </div>
        <div className="p-6 md:p-8">
            <div className="mb-3 flex items-center gap-3 text-xs text-muted">
                {project.category?.name && <span className="font-semibold text-accent">{project.category.name}</span>}
                {project.year && <span>{project.year}</span>}
            </div>
            <h3 className="font-display text-xl font-medium transition-all group-hover:gradient-text md:text-2xl">{project.title}</h3>
            {project.excerpt && <p className="mt-3 text-sm text-muted line-clamp-2">{project.excerpt}</p>}
            {!!tech.length && <div className="mt-4 flex flex-wrap gap-2">{tech.slice(0, 4).map((t) => <span key={t.id ?? t.name ?? t} className="tech-tag">{t.name ?? t}</span>)}</div>}
        </div>
    </Link>;
}

function Home({ featuredProjects = [], services = [], skillCategories = [], experiences = [], technologies = [], testimonials = [] }) {
    const { props } = usePage();
    const site = props.site ?? {};
    return <>
        <section className="relative flex min-h-screen items-center overflow-hidden pt-28">
            <div className="hero-grid absolute inset-0" aria-hidden="true" />
            <div className="pointer-events-none absolute top-1/4 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-accent/10 blur-[120px]" aria-hidden="true" />
            <span className="float-slow absolute top-32 right-[8%] hidden text-5xl opacity-70 md:block" aria-hidden="true">✦</span>
            <span className="float-slower absolute bottom-40 left-[6%] hidden text-4xl opacity-60 md:block" aria-hidden="true">◆</span>
            <div className="container-site relative z-10 py-20">
                <div className="max-w-4xl">
                    <h1 className="display-xl mb-8"><span className="gradient-text">{site.hero_headline ?? 'Building Digital Products That Move Ideas Forward.'}</span></h1>
                    <p className="text-lg md:text-xl text-muted max-w-2xl leading-relaxed">{site.hero_subheadline ?? ''}</p>
                    <div className="mt-10 flex flex-wrap gap-4"><Link href="/projects" className="btn-primary">{site.hero_cta_primary ?? 'View Selected Work'}</Link><Link href="/contact" className="btn-secondary">{site.hero_cta_secondary ?? "Let's Talk"}</Link></div>
                    <dl className="mt-16 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        {[['Experience', site.years_experience ?? '5+', ' yrs'], ['Projects', site.projects_delivered ?? '30+', ''], ['Focus', 'Full-Stack', ''], ['Location', site.location ?? 'Remote', '']].map(([label, val, unit]) => <div key={label} className="stat-card"><dt className="label-mono mb-2">{label}</dt><dd className="gradient-number text-2xl font-bold">{val}<span className="text-base font-medium text-muted">{unit}</span></dd></div>)}
                    </dl>
                </div>
            </div>
        </section>
        <div className="marquee-band overflow-hidden border-y border-white/10 py-5">
            <div className="marquee-track flex w-max gap-8 whitespace-nowrap">{[...['FULL-STACK DEVELOPMENT', 'AI ENGINEERING', 'LARAVEL', 'REACT', 'NODE.JS', 'MYSQL', 'REST APIs', 'SAAS', 'PERFORMANCE'], ...['FULL-STACK DEVELOPMENT', 'AI ENGINEERING', 'LARAVEL', 'REACT', 'NODE.JS', 'MYSQL', 'REST APIs', 'SAAS', 'PERFORMANCE']].map((text, i) => <span key={i} className="label-mono">{text} <span className="mx-4 text-accent">✦</span></span>)}</div>
        </div>
        <section className="section-padding"><div className="container-site grid gap-12 lg:grid-cols-2 lg:gap-20 items-start">
            <SectionHeading number="01" label="About" title="Engineering with intention." description={site.about_intro ?? ''} />
            <div className="space-y-6"><p className="text-muted leading-relaxed">{site.about_philosophy ?? ''}</p><Link href="/about" className="text-sm text-accent link-underline">Read my story →</Link></div>
        </div></section>
        <section className="section-padding border-t border-white/10"><div className="container-site">
            <SectionHeading number="02" label="What I Do" title="Services built for real products." description="From architecture to interface — focused capabilities that ship." />
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">{services.map((service, i) => <Link key={service.id ?? service.slug} href={`/services/${service.slug}`} className="glow-card group block p-6 md:p-8"><span className="icon-chip mb-5">{String(i + 1).padStart(2, '0')}</span><h3 className="font-display text-xl font-medium mb-3 group-hover:gradient-text">{service.title}</h3><p className="text-sm text-muted">{service.excerpt}</p><span className="mt-4 inline-flex text-xs font-semibold text-accent">Explore →</span></Link>)}</div>
        </div></section>
        {!!featuredProjects.length && <section className="section-padding border-t border-white/10"><div className="container-site">
            <SectionHeading number="03" label="Selected work" title="Thoughtful work, made real." description="A few projects that bring ambitious ideas into focus." />
            <div className="grid gap-6 md:grid-cols-2">{featuredProjects.map((project) => <ProjectCard key={project.id} project={project} />)}</div>
            <Link href="/projects" className="btn-secondary mt-8 inline-flex">Explore all projects →</Link>
        </div></section>}
        <section className="section-padding border-t border-white/10"><div className="container-site">
            <SectionHeading number="04" label="Technology" title="A focused engineering stack." description="Technologies chosen for reliability, velocity, and long-term maintainability." />
            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">{skillCategories.map((category) => <div key={category.id} className="glow-card p-6"><h3 className="font-display text-lg font-medium mb-4 gradient-underline inline-block">{category.name}</h3><ul className="mt-2 space-y-3">{(category.skills ?? []).map((skill) => <li key={skill.id} className="flex items-center justify-between text-sm"><span>{skill.name}</span><span className="tech-tag !py-0.5 !text-[10px]">{skill.experience_level}</span></li>)}</ul></div>)}</div>
            {!!technologies.length && <div className="mt-8 flex flex-wrap gap-2">{technologies.map((tech) => <span key={tech.id} className="tech-tag">{tech.name}</span>)}</div>}
        </div></section>
        {!!experiences.length && <section className="section-padding border-t border-white/10"><div className="container-site">
            <SectionHeading number="05" label="Experience" title="Professional trajectory." />
            <div className="ml-3 space-y-0 border-l border-white/10">{experiences.map((exp) => <article key={exp.id} className="relative pb-10 pl-8 last:pb-0"><div className="timeline-dot-gradient absolute -left-[7px] top-2 h-3.5 w-3.5 rounded-full" /><p className="label-mono mb-2">{dateLabel(exp.started_at, { year: 'numeric' })} — {exp.is_current ? 'Present' : dateLabel(exp.ended_at, { year: 'numeric' })}</p><h3 className="font-display text-xl font-medium">{exp.role}</h3><p className="gradient-text text-sm font-semibold mt-1">{exp.company}</p><p className="text-sm text-muted mt-3 max-w-xl">{exp.description}</p></article>)}</div>
            <Link href="/experience" className="mt-8 inline-block text-sm text-accent link-underline">Full experience →</Link>
        </div></section>}
        {!!testimonials.length && <section className="section-padding border-t border-white/10"><div className="container-site">
            <SectionHeading number="06" label="Kind words" title="What collaborators say." />
            <div className="grid gap-6 md:grid-cols-3">{testimonials.map((item) => <figure key={item.id} className="glow-card p-6"><blockquote className="text-muted">“{item.content}”</blockquote><figcaption className="mt-5 font-semibold">{item.client_name}<span className="block text-sm font-normal text-muted">{item.company}</span></figcaption></figure>)}</div>
        </div></section>}
    </>;
}

function About({ experiences = [], skillCategories = [] }) {
    const { props } = usePage();
    const site = props.site ?? {};
    return <>
        <section className="section-padding pt-32"><div className="container-site max-w-3xl"><h1 className="display-lg mb-8"><span className="gradient-text">The story behind the engineering.</span></h1><div className="prose-blog space-y-6"><p className="text-lg">{site.about_intro}</p><p>{site.about_philosophy}</p></div></div></section>
        <section className="section-padding border-t border-white/10"><div className="container-site"><SectionHeading title="Career timeline" description="Experience and milestones across my engineering journey." /><div className="ml-3 max-w-3xl space-y-0 border-l border-white/10">{experiences.map((exp) => <article key={exp.id} className="relative pb-12 pl-8 last:pb-0"><div className="timeline-dot-gradient absolute -left-[7px] top-2 h-3.5 w-3.5 rounded-full" /><time className="label-mono">{dateLabel(exp.started_at)} — {exp.is_current ? 'Present' : dateLabel(exp.ended_at)}</time><h2 className="font-display mt-2 text-2xl font-medium">{exp.role}</h2><p className="gradient-text font-semibold">{exp.company}{exp.location ? ` · ${exp.location}` : ''}</p><p className="text-muted mt-4">{exp.description}</p></article>)}</div></div></section>
        <section className="section-padding border-t border-white/10"><div className="container-site"><SectionHeading label="Technology" title="Tools for thoughtful engineering." /><div className="grid gap-6 md:grid-cols-2">{skillCategories.map((cat) => <div key={cat.id} className="glow-card p-6"><h3 className="font-display text-lg mb-4">{cat.name}</h3><div className="flex flex-wrap gap-2">{(cat.skills ?? []).map((skill) => <span className="tech-tag" key={skill.id}>{skill.name}</span>)}</div></div>)}</div></div></section>
    </>;
}

function Experience({ experiences = [] }) {
    return <section className="section-padding pt-32"><div className="container-site max-w-3xl"><SectionHeading label="Experience" title="Professional history." /><div className="ml-3 space-y-0 border-l border-white/10">{experiences.map((exp) => <article key={exp.id} className="relative pb-12 pl-8 last:pb-0"><div className="absolute -left-[5px] top-2 h-2.5 w-2.5 rounded-full bg-accent" /><time className="label-mono">{dateLabel(exp.started_at, { year: 'numeric' })} — {exp.is_current || !exp.ended_at ? 'Present' : dateLabel(exp.ended_at, { year: 'numeric' })}</time><h2 className="font-display mt-2 text-2xl font-medium">{exp.role}</h2><p className="text-accent">{exp.company}</p><p className="text-muted mt-4">{exp.description}</p>{exp.achievements?.length > 0 && <ul className="mt-4 space-y-2 text-sm text-muted">{exp.achievements.map((item) => <li key={item}>→ {item}</li>)}</ul>}</article>)}</div></div></section>;
}

function Packages({ packages = [] }) {
    return <section className="section-padding pt-32"><div className="container-site"><SectionHeading label="Packages" title="Clear engagement models." description="Transparent starting points — every project is scoped individually." centered /><div className="mt-8 grid gap-6 lg:grid-cols-3">{packages.map((item) => <article key={item.id} className={`surface-card flex flex-col p-8 ${item.is_recommended ? 'border-accent/50 ring-1 ring-accent/20' : ''}`}>{item.is_recommended && <span className="label-mono mb-4">Recommended</span>}<h2 className="font-display text-2xl font-medium">{item.name}</h2><p className="text-sm text-muted mt-3 flex-1">{item.description}</p>{item.price && <p className="font-display text-3xl mt-6">${Number(item.price).toLocaleString()}<span className="text-sm text-muted font-body"> / project</span></p>}{item.delivery_time && <p className="text-xs text-muted mt-2">Delivery: {item.delivery_time}</p>}<ul className="mt-6 space-y-2 text-sm">{(item.features ?? []).map((feature) => <li key={feature.id} className="flex gap-2 text-muted"><span className="text-accent">✓</span>{feature.feature}</li>)}</ul><a href={item.cta_url ?? '/contact'} className={`${item.is_recommended ? 'btn-primary' : 'btn-secondary'} mt-8 justify-center`}>{item.cta_text ?? 'Get started'}</a></article>)}</div></div></section>;
}

function Contact() {
    const { props } = usePage();
    const site = props.site ?? {};
    const form = useForm({ project_type: '', name: '', email: '', company: '', budget_range: '', timeline: '', message: '', attachment: null });
    const submit = (event) => {
        event.preventDefault();
        form.post('/contact', { forceFormData: true, onSuccess: () => form.reset() });
    };
    const choices = (values) => [{ value: '', label: 'Select...' }, ...values.map((value) => ({ value, label: value }))];
    return <section className="section-padding pt-32"><div className="container-site"><div className="grid gap-16 lg:grid-cols-2">
        <div><SectionHeading label="Contact" title="What are you building?" description="Tell me about your project. I typically respond within 1–2 business days." /><dl className="space-y-4 text-sm">{site.contact_email && <div><dt className="label-mono mb-1">Email</dt><dd><a href={`mailto:${site.contact_email}`} className="gradient-text font-semibold">{site.contact_email}</a></dd></div>}<div><dt className="label-mono mb-1">Availability</dt><dd className="text-muted">{site.hero_status}</dd></div></dl></div>
        <form onSubmit={submit} encType="multipart/form-data" className="glow-card space-y-5 p-6 md:p-8">
            <Field name="project_type" label="Project Type" form={form} options={choices(['Website', 'SaaS', 'AI Product', 'E-commerce', 'API', 'Other'])} />
            <div className="grid gap-5 sm:grid-cols-2"><Field name="name" label="Name" form={form} required placeholder="Your name" /><Field name="email" label="Email" type="email" form={form} required placeholder="you@company.com" /></div>
            <Field name="company" label="Company" form={form} placeholder="Company name (optional)" />
            <div className="grid gap-5 sm:grid-cols-2"><Field name="budget_range" label="Budget Range" form={form} options={choices(['< $5k', '$5k – $10k', '$10k – $25k', '$25k+'])} /><Field name="timeline" label="Timeline" form={form} options={choices(['ASAP', '1–2 months', '3–6 months', 'Flexible'])} /></div>
            <Field name="message" label="Message" form={form} textarea rows={5} required placeholder="Tell me about your project, goals, and timeline..." />
            <div><label className="label-mono mb-2 block" htmlFor="attachment">Attachment (optional, max 5MB)</label><input id="attachment" type="file" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg" onChange={(event) => form.setData('attachment', event.target.files?.[0] ?? null)} className="w-full text-sm text-muted file:mr-4 file:rounded-full file:border-0 file:bg-accent file:px-4 file:py-2 file:text-white" />{form.errors.attachment && <p className="mt-1 text-xs text-red-400">{form.errors.attachment}</p>}</div>
            {props.flash?.success && <p role="status" className="rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400">{props.flash.success}</p>}
            <button disabled={form.processing} type="submit" className="btn-primary w-full sm:w-auto">{form.processing ? 'Sending…' : 'Send Message'}</button>
        </form>
    </div></div></section>;
}

function Search({ query = '', projects = [], posts = [], services = [] }) {
    const form = useForm({ q: query });
    const submit = (event) => { event.preventDefault(); router.get('/search', { q: form.data.q }, { preserveState: true }); };
    const sections = [['Projects', projects, '/projects'], ['Articles', posts, '/blog'], ['Services', services, '/services']];
    return <section className="section-padding pt-32"><div className="container-site max-w-3xl"><h1 className="display-lg mb-8">Search</h1><form onSubmit={submit} className="mb-12"><input type="search" value={form.data.q} onChange={(e) => form.setData('q', e.target.value)} placeholder="Search projects, articles, services..." className="w-full rounded-xl border border-white/10 bg-transparent px-5 py-4 text-lg outline-none focus:border-accent" /></form>{query && <div className="space-y-12">{sections.map(([title, rows, path]) => rows.length > 0 && <section key={title}><h2 className="label-mono mb-4">{title}</h2><ul className="space-y-2">{rows.map((row) => <li key={row.id}><Link href={`${path}/${row.slug}`} className="hover:text-accent">{row.title}</Link></li>)}</ul></section>)}{sections.every(([, rows]) => !rows.length) && <p className="text-muted">No results for “{query}”.</p>}</div>}</div></section>;
}

function ProjectsIndex({ projects, categories = [], technologies = [], activeCategory, activeTech, spotlightProject }) {
    const list = projects?.data ?? [];
    const [selected, setSelected] = useState(list[0]?.preview ?? spotlightProject ?? null);
    const [previewMode, setPreviewMode] = useState('image');
    useEffect(() => { setSelected(list[0]?.preview ?? spotlightProject ?? null); }, [projects?.current_page, activeCategory, activeTech]);
    const hrefFilter = (values) => queryLink('/projects', values);
    return <section className="section-padding pt-28 md:pt-32"><div className="container-site">
        <div className="mb-12 max-w-3xl"><h1 className="display-lg mb-4"><span className="gradient-text">Selected work.</span><br /><span className="text-muted">Engineered with precision.</span></h1><p className="text-lg text-muted">Explore projects with live previews, case studies, and full galleries.</p></div>
        <div className="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div className="flex flex-wrap gap-2" role="tablist" aria-label="Category filters"><Link href={hrefFilter({ tech: activeTech })} className={`filter-pill ${!activeCategory ? 'is-active' : ''}`}>All</Link>{categories.map((cat) => <Link key={cat.id} href={hrefFilter({ category: cat.slug, tech: activeTech })} className={`filter-pill ${activeCategory === cat.slug ? 'is-active' : ''}`}>{cat.name}</Link>)}</div>
            <div className="flex flex-wrap gap-2" aria-label="Technology filters">{technologies.slice(0, 8).map((tech) => <Link key={tech.id} href={hrefFilter({ tech: tech.slug, category: activeCategory })} className={`filter-pill filter-pill-sm ${activeTech === tech.slug ? 'is-active' : ''}`}>{tech.name}</Link>)}</div>
        </div>
        {!list.length ? <div className="glow-card p-12 text-center"><p className="text-muted">No projects match this filter.</p><Link href="/projects" className="btn-secondary mt-6 inline-flex">Clear filters</Link></div>
            : <div className="grid gap-10 lg:grid-cols-[1fr_420px] xl:grid-cols-[1fr_480px] lg:gap-12">
                <div className="space-y-4">{list.map((project, i) => {
                    const preview = project.preview;
                    return <button key={project.id} type="button" onFocus={() => setSelected(preview)} onMouseEnter={() => setSelected(preview)} onClick={() => setSelected(preview)} className={`project-list-item group w-full text-left transition-all duration-500 ${selected?.id === project.id ? 'is-active' : ''}`} aria-pressed={selected?.id === project.id}>
                        <div className={`flex items-start gap-5 rounded-2xl border p-5 transition-all ${selected?.id === project.id ? 'border-accent/40 bg-accent-soft/30' : 'border-white/10 bg-white/[0.02] hover:border-white/20'}`}>
                            <span className="gradient-number mt-1 shrink-0 text-sm font-bold">{String(i + 1).padStart(2, '0')}</span>
                            <span className="min-w-0 flex-1"><span className="mb-2 flex flex-wrap gap-2 text-xs">{project.category?.name && <span className="text-accent">{project.category.name}</span>}{project.year && <span className="text-muted">{project.year}</span>}{project.live_url && <span className="text-accent">Live</span>}</span><span className="project-list-item-title block font-display text-xl font-medium md:text-2xl">{project.title}</span>{project.excerpt && <span className="mt-2 block text-sm text-muted line-clamp-2">{project.excerpt}</span>}{project.technologies?.length > 0 && <span className="mt-3 flex flex-wrap gap-1.5">{project.technologies.slice(0, 5).map((tech) => <span key={tech.id} className="rounded-full border border-white/10 px-2 py-0.5 text-[10px] text-muted">{tech.name}</span>)}</span>}</span><span className="mt-2 text-muted">→</span>
                        </div>
                    </button>;
                })}</div>
                <aside className="hidden lg:block lg:sticky lg:top-28 self-start"><div className="surface-card overflow-hidden">
                    <div className="relative aspect-[16/10] overflow-hidden bg-ink-soft">{previewMode === 'live' && selected?.live_url ? <iframe title={`${selected.title} live preview`} src={selected.live_url} loading="lazy" sandbox="allow-scripts allow-same-origin allow-forms allow-popups" className="absolute inset-0 h-full w-full border-0" /> : selected?.image || selected?.cover ? <img src={selected.image ?? selected.cover} alt={selected.title} className="h-full w-full object-cover" /> : <div className="flex h-full items-center justify-center text-6xl text-accent/20">P</div>}
                        {selected?.live_url && <div className="absolute right-3 top-3 flex gap-1 rounded-full border border-white/10 bg-ink/80 p-1"><button type="button" onClick={() => setPreviewMode('image')} className={`preview-mode-btn rounded-full px-3 py-1.5 text-[10px] uppercase ${previewMode === 'image' ? 'is-active' : ''}`}>Screenshot</button><button type="button" onClick={() => setPreviewMode('live')} className={`preview-mode-btn rounded-full px-3 py-1.5 text-[10px] uppercase ${previewMode === 'live' ? 'is-active' : ''}`}>Live</button></div>}
                    </div>
                    <div className="p-6 md:p-8"><p className="label-mono mb-3">{[selected?.category, selected?.year].filter(Boolean).join(' · ')}</p><h2 className="font-display text-2xl font-medium md:text-3xl">{selected?.title}</h2><p className="mt-2 text-sm text-muted">{selected?.subtitle ?? selected?.role}</p><p className="mt-4 text-sm leading-relaxed text-muted">{selected?.excerpt}</p><div className="mt-5 flex flex-wrap gap-2">{(selected?.technologies ?? []).map((tech) => <span key={tech}>{tech}</span>)}</div><div className="mt-6 flex flex-wrap gap-3"><Link href={`/projects/${selected?.slug ?? ''}`} className="btn-primary text-sm">View Case Study</Link>{selected?.live_url && <a href={selected.live_url} target="_blank" rel="noopener noreferrer" className="btn-secondary text-sm">Open Live Site</a>}{selected?.github_url && <a href={selected.github_url} target="_blank" rel="noopener noreferrer" className="btn-secondary text-sm">GitHub</a>}</div></div>
                </div></aside>
            </div>}
        <Pagination paginator={projects} />
    </div></section>;
}

function ProjectShow({ project, heroImage, galleryItems = [], relatedProjects = [] }) {
    const [galleryIndex, setGalleryIndex] = useState(null);
    useEffect(() => {
        if (galleryIndex === null) return;
        const keyHandler = (event) => {
            if (event.key === 'Escape') setGalleryIndex(null);
            if (event.key === 'ArrowLeft') setGalleryIndex((index) => (index + galleryItems.length - 1) % galleryItems.length);
            if (event.key === 'ArrowRight') setGalleryIndex((index) => (index + 1) % galleryItems.length);
        };
        window.addEventListener('keydown', keyHandler);
        return () => window.removeEventListener('keydown', keyHandler);
    }, [galleryIndex, galleryItems.length]);
    const fields = [['Overview', project.problem], ['Challenge', project.challenge], ['Solution', project.solution], ['Lessons Learned', project.lessons_learned]].filter(([, text]) => text);
    return <>
        <section className="relative pt-24 md:pt-28"><div className="container-site">
            <div className="mb-8 max-w-4xl">{project.category && <p className="label-mono mb-4">{project.category.name} · {project.year}</p>}<h1 className="display-lg mb-4"><span className="gradient-text">{project.title}</span></h1>{project.subtitle && <p className="text-xl text-muted">{project.subtitle}</p>}</div>
            <div className="relative mb-12 overflow-hidden rounded-2xl border border-white/10">{project.video_url ? <div className="aspect-[21/9] bg-ink-soft"><iframe src={project.video_url} className="h-full w-full" allowFullScreen loading="lazy" title={`${project.title} demo`} /></div> : heroImage ? <div className="relative aspect-[21/9]"><img src={heroImage} alt={project.title} className="h-full w-full object-cover" /><div className="absolute inset-0 bg-gradient-to-t from-ink/60 to-transparent" /></div> : <div className="aspect-[21/9] bg-gradient-to-br from-accent/10 via-ink-soft to-purple-500/5" />}<div className="absolute bottom-6 left-6 flex flex-wrap gap-3">{project.live_url && <a href={project.live_url} target="_blank" rel="noopener noreferrer" className="btn-primary text-sm">Open Live Site</a>}{project.github_url && <a href={project.github_url} target="_blank" rel="noopener noreferrer" className="btn-secondary text-sm">View on GitHub</a>}</div></div>
            {!!project.technologies?.length && <div className="mb-12 flex flex-wrap gap-2">{project.technologies.map((tech) => <span key={tech.id} className="tech-tag">{tech.name}</span>)}</div>}
        </div></section>
        {project.live_url && <section className="section-padding border-t border-white/10 !py-12 md:!py-16"><div className="container-site"><div className="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between"><div><p className="label-mono mb-2">Live Preview</p><h2 className="font-display text-2xl font-medium">Experience the product</h2></div><a href={project.live_url} target="_blank" rel="noopener noreferrer" className="text-sm text-accent link-underline">Open in new tab →</a></div><div className="overflow-hidden rounded-2xl border border-white/10 bg-ink-soft"><div className="relative aspect-[16/10]"><iframe src={project.live_url} className="absolute inset-0 h-full w-full border-0" loading="lazy" title={`${project.title} live preview`} sandbox="allow-scripts allow-same-origin allow-forms allow-popups" /></div></div></div></section>}
        {!!galleryItems.length && <section className="section-padding pt-10"><div className="container-site"><div className="mb-8 flex items-end justify-between"><div><p className="label-mono mb-2">Gallery</p><h2 className="font-display text-2xl font-medium">Project visuals</h2></div><p className="text-sm text-muted">{galleryItems.length} images</p></div><div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">{galleryItems.map((item, i) => <button type="button" key={item.id} onClick={() => setGalleryIndex(i)} className={`gallery-item group relative aspect-[4/3] overflow-hidden rounded-xl border border-white/10 bg-ink-soft ${i === 0 ? 'sm:col-span-2 sm:row-span-2 sm:aspect-[16/10]' : ''}`}>{item.type === 'video' ? <video src={item.url} className="h-full w-full object-cover" muted loop playsInline /> : <img src={item.url} alt={item.alt ?? 'Project image'} loading="lazy" className="h-full w-full object-cover transition duration-700 group-hover:scale-105" />}</button>)}</div></div></section>}
        {galleryIndex !== null && <div className="fixed inset-0 z-[200] flex items-center justify-center bg-ink/95 p-8 backdrop-blur-xl" role="dialog" aria-modal="true" aria-label="Image gallery" onClick={() => setGalleryIndex(null)}><button type="button" className="absolute right-6 top-6 z-10 p-3 text-muted" aria-label="Close gallery" onClick={() => setGalleryIndex(null)}>✕</button><button type="button" className="absolute left-4 z-10 p-3" aria-label="Previous image" onClick={(e) => { e.stopPropagation(); setGalleryIndex((galleryIndex + galleryItems.length - 1) % galleryItems.length); }}>←</button><figure className="relative z-[1] max-h-[85vh] max-w-5xl" onClick={(e) => e.stopPropagation()}>{galleryItems[galleryIndex].type === 'video' ? <video src={galleryItems[galleryIndex].url} controls autoPlay className="max-h-[80vh] max-w-full rounded-xl" /> : <img src={galleryItems[galleryIndex].url} alt={galleryItems[galleryIndex].alt ?? ''} className="max-h-[80vh] max-w-full rounded-xl object-contain" />}<figcaption className="mt-4 text-center text-sm text-muted">{galleryItems[galleryIndex].alt}</figcaption></figure><button type="button" className="absolute right-4 z-10 p-3" aria-label="Next image" onClick={(e) => { e.stopPropagation(); setGalleryIndex((galleryIndex + 1) % galleryItems.length); }}>→</button></div>}
        <section className="section-padding"><div className="container-site"><div className="grid gap-16 lg:grid-cols-3"><div className="space-y-12 lg:col-span-2">{fields.map(([heading, content]) => <section key={heading} className="project-content-block"><h2 className="font-display text-2xl mb-4">{heading}</h2><p className="text-muted leading-relaxed text-lg">{content}</p></section>)}{project.architecture && <section className="project-content-block"><h2 className="font-display text-2xl mb-6">Architecture</h2><dl className="grid gap-4 sm:grid-cols-2">{Object.entries(project.architecture).map(([key, value]) => <div key={key} className="glow-card p-5"><dt className="label-mono mb-2">{key}</dt><dd className="text-sm">{Array.isArray(value) ? value.join(', ') : value}</dd></div>)}</dl></section>}{project.features?.length > 0 && <section className="project-content-block"><h2 className="font-display text-2xl mb-6">Features</h2><ul className="grid gap-3 sm:grid-cols-2">{project.features.map((feature) => <li key={feature} className="rounded-xl border border-white/10 bg-white/[0.02] p-4 text-sm text-muted">→ {feature}</li>)}</ul></section>}{project.results && <section className="project-content-block"><h2 className="font-display text-2xl mb-6">Results</h2><dl className="grid gap-4 sm:grid-cols-2">{Object.entries(project.results).map(([key, value]) => <div key={key} className="glow-card p-5"><dt className="text-xs uppercase tracking-wider text-muted">{key}</dt><dd className="gradient-number mt-1 text-2xl font-bold">{value}</dd></div>)}</dl></section>}</div>
            <aside><div className="glow-card sticky top-28 p-6 md:p-8"><h3 className="label-mono mb-6">Project Details</h3><dl className="space-y-4 text-sm">{project.role && <div><dt className="text-muted">Role</dt><dd className="mt-1 font-medium">{project.role}</dd></div>}{project.year && <div><dt className="text-muted">Year</dt><dd className="mt-1 font-medium">{project.year}</dd></div>}{project.category && <div><dt className="text-muted">Category</dt><dd className="mt-1 font-medium">{project.category.name}</dd></div>}</dl><div className="mt-8 flex flex-col gap-3">{project.live_url && <a href={project.live_url} target="_blank" rel="noopener noreferrer" className="btn-primary text-center text-sm">Live Demo</a>}{project.github_url && <a href={project.github_url} target="_blank" rel="noopener noreferrer" className="btn-secondary text-center text-sm">GitHub</a>}<Link href="/contact" className="btn-secondary text-center text-sm">Start Similar Project</Link></div></div></aside>
        </div>{!!relatedProjects.length && <section className="mt-24 border-t border-white/10 pt-16"><h2 className="font-display text-2xl mb-8">Related Projects</h2><div className="grid gap-6 md:grid-cols-3">{relatedProjects.map((item) => <ProjectCard key={item.id} project={item} />)}</div></section>}</div></section>
    </>;
}

function ServicesIndex({ services = [] }) {
    return <section className="section-padding pt-32"><div className="container-site"><SectionHeading label="Services" title="What I build." description="Focused capabilities for ambitious digital products." /><div className="grid gap-6 lg:grid-cols-2">{services.map((service, i) => <article key={service.id} className="glow-card p-8"><span className="icon-chip mb-5">{String(i + 1).padStart(2, '0')}</span><h2 className="font-display text-2xl font-medium mb-3"><Link href={`/services/${service.slug}`} className="hover:gradient-text">{service.title}</Link></h2><p className="text-muted mb-6">{service.excerpt}</p><Link href={`/services/${service.slug}`} className="gradient-text text-sm font-semibold link-underline">Learn more →</Link></article>)}</div></div></section>;
}

function ServiceShow({ service }) {
    return <>
        <section className="relative overflow-hidden pt-32 pb-20 md:pt-40 md:pb-28"><div className="absolute inset-0 hero-grid opacity-50" /><div className="container-site relative"><div className="max-w-4xl"><p className="label-mono mb-6">Service {service.icon && ` · ${service.icon}`}</p><h1 className="display-xl mb-6"><span className="gradient-text">{service.title}</span></h1><p className="text-xl text-muted max-w-2xl">{service.excerpt}</p><div className="mt-8 flex flex-wrap gap-4"><Link href="/contact" className="btn-primary">Start a Project</Link><Link href="/services" className="btn-secondary">View All Services</Link></div></div></div></section>
        {service.description && <section className="pb-20"><div className="container-site max-w-4xl"><div className="glow-card p-8 md:p-12"><h2 className="font-display text-2xl font-medium mb-4">Overview</h2><p className="prose-blog text-lg text-muted">{service.description}</p></div></div></section>}
        {(service.problem || service.solution) && <section className="pb-20"><div className="container-site grid gap-6 md:grid-cols-2">{service.problem && <div className="glow-card p-8"><h3 className="font-display text-xl mb-3">The Challenge</h3><p className="text-muted">{service.problem}</p></div>}{service.solution && <div className="glow-card p-8"><h3 className="font-display text-xl mb-3">The Solution</h3><p className="text-muted">{service.solution}</p></div>}</div></section>}
        {service.features?.length > 0 && <section className="pb-20"><div className="container-site"><h2 className="font-display text-3xl mb-8">Key Features</h2><div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">{service.features.map((feature) => <div key={feature} className="glow-card p-6"><span className="icon-chip mb-4">✓</span><h3 className="font-display text-lg">{feature}</h3></div>)}</div></div></section>}
        {service.process?.length > 0 && <section className="pb-20"><div className="container-site max-w-4xl"><h2 className="font-display text-3xl mb-8">Our Process</h2><div className="space-y-6">{service.process.map((step, i) => <div key={step} className="glow-card flex gap-6 p-6 md:p-8"><span className="icon-chip !h-12 !w-12 !rounded-full">{i + 1}</span><h3 className="font-display text-xl">{step}</h3></div>)}</div></div></section>}
        {service.technologies?.length > 0 && <section className="pb-20"><div className="container-site"><h2 className="font-display text-3xl mb-6">Technologies We Use</h2><div className="flex flex-wrap gap-3">{service.technologies.map((tech) => <span key={tech} className="tech-tag !px-4 !py-2 !text-sm">{tech}</span>)}</div></div></section>}
        {service.deliverables?.length > 0 && <section className="pb-20"><div className="container-site max-w-4xl"><div className="glow-card p-8 md:p-12"><h2 className="font-display text-2xl mb-6">What You'll Get</h2><ul className="space-y-4">{service.deliverables.map((item) => <li key={item} className="text-muted">✓ {item}</li>)}</ul></div></div></section>}
        <section className="pb-32"><div className="container-site"><div className="glow-card p-8 text-center md:p-12" style={{ background: 'var(--gradient-brand-soft)' }}><h2 className="font-display text-3xl mb-4"><span className="gradient-text">Ready to Get Started?</span></h2><p className="text-lg text-muted mb-8">Let's discuss how this service can help transform your business.</p><Link href="/contact" className="btn-primary">Start Your Project</Link></div></div></section>
    </>;
}

function BlogIndex({ posts, categories = [], featuredPosts = [], hasFilters, activeCategory, activeTag, searchQuery = '' }) {
    const data = posts?.data ?? [];
    const [q, setQ] = useState(searchQuery);
    const lead = featuredPosts[0];
    const submit = (event) => {
        event.preventDefault();
        router.get('/blog', { ...(activeCategory ? { category: activeCategory } : {}), ...(activeTag ? { tag: activeTag } : {}), ...(q ? { q } : {}) }, { preserveState: true });
    };
    const topicUrl = (category) => queryLink('/blog', { category, tag: activeTag, q: searchQuery });
    return <section className="section-padding pt-28 md:pt-32"><div className="container-site">
        <header className="blog-index-hero relative mb-12 overflow-hidden rounded-[2rem] border border-white/10 bg-surface/70 px-6 py-10 shadow-2xl sm:px-10 md:mb-16 md:px-14 md:py-14">
            <div className="pointer-events-none absolute -right-20 -top-28 h-80 w-80 rounded-full bg-fuchsia-500/15 blur-[90px]" /><div className="relative grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end"><div className="max-w-3xl"><p className="label-mono mb-5">✦ The journal</p><h1 className="display-lg mb-5"><span className="gradient-text">Engineering,</span><br />thoughtfully explained.</h1><p className="max-w-2xl text-lg leading-relaxed text-muted">Field notes on building reliable software, thoughtful products, and systems that scale.</p></div><div className="hidden min-w-44 border-l border-white/10 pl-6 lg:block"><p className="label-mono mb-2">Ideas in progress</p><p className="font-display text-4xl font-semibold">{(posts?.total ?? 0) + (!hasFilters ? featuredPosts.length : 0)}<span className="ml-2 text-sm font-normal text-muted">articles</span></p></div></div>
            <div className="relative mt-9 flex flex-wrap items-center gap-3 border-t border-white/10 pt-6"><span className="mr-1 text-xs uppercase text-muted">Explore</span><Link href={topicUrl(null)} className={`filter-pill ${!activeCategory ? 'is-active' : ''}`}>All topics</Link>{categories.map((category) => <Link key={category.id} href={topicUrl(category.slug)} className={`filter-pill ${activeCategory === category.slug ? 'is-active' : ''}`}>{category.name}</Link>)}</div>
        </header>
        <div className="mb-12 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between"><div><p className="label-mono mb-2">{hasFilters ? 'Your selection' : lead ? 'From the notebook' : 'The journal'}</p><h2 className="font-display text-2xl font-medium sm:text-3xl">{hasFilters ? 'Articles for you.' : lead ? 'Featured writing.' : 'Latest articles.'}</h2></div>
            <form onSubmit={submit} role="search" className="flex w-full max-w-md items-center gap-2 rounded-full border border-white/10 bg-surface/70 p-1.5 sm:w-auto"><input type="search" value={q} onChange={(e) => setQ(e.target.value)} placeholder="Search the journal..." className="min-w-0 flex-1 border-0 bg-transparent px-4 py-2 text-sm outline-none" /><button className="btn-primary !px-5 !py-2.5 text-sm">Search</button></form>
        </div>
        {!hasFilters && lead && <Link href={`/blog/${lead.slug}`} className="glow-card group mb-6 grid overflow-hidden md:min-h-[22rem] md:grid-cols-2"><div className="relative flex min-h-64 flex-col justify-between overflow-hidden bg-gradient-to-br from-violet-950 via-purple-900 to-fuchsia-900 p-7 sm:p-10">{lead.featured_image && <img src={storageUrl(lead.featured_image)} alt="" className="absolute inset-0 h-full w-full object-cover" />}<span className="relative rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] uppercase text-white">Editor's pick</span><span className="relative mt-12 font-display text-6xl font-bold text-white/90 sm:text-8xl">Aa</span></div><div className="flex flex-col justify-center p-7 sm:p-10 md:p-12"><div className="mb-5 flex flex-wrap gap-3 text-xs uppercase text-muted">{lead.category?.name && <span className="text-accent">{lead.category.name}</span>}<span>{dateLabel(lead.published_at, { month: 'short', day: '2-digit', year: 'numeric' })}</span>{lead.reading_time && <span>{lead.reading_time} min read</span>}</div><h2 className="font-display text-3xl font-medium leading-tight group-hover:gradient-text sm:text-4xl">{lead.title}</h2><p className="mt-4 line-clamp-3 leading-relaxed text-muted">{lead.excerpt}</p><span className="mt-8 text-sm font-semibold text-accent">Read the story →</span></div></Link>}
        <div className="mb-6 flex items-end justify-between"><div><p className="label-mono mb-2">{hasFilters ? 'Journal results' : 'Keep exploring'}</p><h2 className="font-display text-2xl font-medium sm:text-3xl">{hasFilters ? 'Matching articles.' : 'Latest articles.'}</h2></div>{posts?.total > 0 && <span className="text-sm text-muted">{posts.total} articles</span>}</div>
        <div className="grid gap-5 md:grid-cols-2 lg:grid-cols-3">{data.length ? data.map((post) => <article key={post.id} className="glow-card group flex min-h-64 flex-col p-6 sm:p-7"><div className="mb-6 flex items-center justify-between gap-3">{post.category ? <Link href={queryLink('/blog', { category: post.category.slug })} className="rounded-full border border-accent/20 bg-accent/10 px-3 py-1 text-xs text-accent">{post.category.name}</Link> : <span className="text-xs text-muted">Article</span>}<span className="font-mono text-[10px] uppercase text-muted">{dateLabel(post.published_at, { month: 'short', day: '2-digit', year: 'numeric' })}</span></div><h3 className="font-display text-xl font-medium leading-snug group-hover:gradient-text sm:text-2xl"><Link href={`/blog/${post.slug}`}>{post.title}</Link></h3><p className="mt-3 line-clamp-3 text-sm leading-relaxed text-muted">{post.excerpt}</p><div className="mt-auto flex items-center justify-between border-t border-white/10 pt-5 mt-6"><span className="text-xs text-muted">{post.reading_time ? `${post.reading_time} min read` : 'Article'}</span><Link href={`/blog/${post.slug}`} className="text-sm font-medium text-accent">Read →</Link></div></article>)
            : <div className="glow-card col-span-full p-10 text-center sm:p-14"><h3 className="font-display text-xl">{hasFilters ? 'No articles found.' : 'The journal is just getting started.'}</h3><p className="mx-auto mt-2 max-w-md text-sm text-muted">{hasFilters ? 'Try another phrase or clear the filters.' : 'New engineering notes and ideas will appear here soon.'}</p>{hasFilters && <Link href="/blog" className="btn-secondary mt-6 inline-flex">Clear filters</Link>}</div>}</div>
        <Pagination paginator={posts} />
    </div></section>;
}

function BlogShow({ post, contentHtml, relatedPosts = [] }) {
    return <article className="section-padding pt-32"><div className="container-site max-w-3xl"><header className="mb-12">{post.category && <p className="label-mono mb-4">{post.category.name}</p>}<h1 className="display-lg mb-4"><span className="gradient-text">{post.title}</span></h1><p className="text-muted">{dateLabel(post.published_at, { month: 'long', day: 'numeric', year: 'numeric' })} · {post.reading_time} min read · {post.author?.name}</p></header><div className="prose-blog" dangerouslySetInnerHTML={{ __html: contentHtml }} />{post.tags?.length > 0 && <div className="mt-12 flex flex-wrap gap-2">{post.tags.map((tag) => <span key={tag.id} className="tech-tag">{tag.name}</span>)}</div>}{relatedPosts.length > 0 && <section className="mt-16 border-t border-white/10 pt-12"><h2 className="font-display text-xl mb-6 gradient-underline inline-block">Related Articles</h2><div className="mt-2 space-y-4">{relatedPosts.map((item) => <Link key={item.id} href={`/blog/${item.slug}`} className="block text-muted hover:gradient-text">{item.title}</Link>)}</div></section>}</div></article>;
}

function Resume({ experiences = [], projects = [], skillCategories = [] }) {
    const { props } = usePage();
    const site = props.site ?? {};
    return <section className="section-padding pt-32"><div className="container-site max-w-3xl"><header className="mb-12"><p className="label-mono mb-4">Resume</p><h1 className="display-lg mb-2">{site.site_name}</h1><p className="text-xl text-muted">{site.site_tagline}</p><p className="text-muted mt-6">{site.about_intro}</p></header><section className="mb-12"><h2 className="font-display text-xl mb-6 border-b border-white/10 pb-3">Experience</h2>{experiences.map((exp) => <div key={exp.id} className="mb-8"><h3 className="font-medium">{exp.role} — {exp.company}</h3><p className="text-sm text-muted">{dateLabel(exp.started_at)} — {exp.is_current ? 'Present' : dateLabel(exp.ended_at)}</p><p className="text-sm text-muted mt-2">{exp.description}</p></div>)}</section><section className="mb-12"><h2 className="font-display text-xl mb-6 border-b border-white/10 pb-3">Skills</h2><div className="grid gap-6 sm:grid-cols-2">{skillCategories.map((cat) => <div key={cat.id}><h3 className="text-sm font-medium mb-2">{cat.name}</h3><p className="text-sm text-muted">{(cat.skills ?? []).map((skill) => skill.name).join(', ')}</p></div>)}</div></section><section><h2 className="font-display text-xl mb-6 border-b border-white/10 pb-3">Selected Projects</h2><ul className="space-y-3">{projects.map((project) => <li key={project.id}><Link href={`/projects/${project.slug}`} className="text-accent hover:underline">{project.title}</Link> — <span className="text-muted text-sm">{project.excerpt}</span></li>)}</ul></section><Link href="/contact" className="btn-primary mt-12 inline-flex">Download CV / Contact</Link></div></section>;
}

export default function Portfolio(pageProps) {
    const { props } = usePage();
    const { page, ...data } = pageProps;
    const site = props.site ?? {};
    let content;
    let title = site.site_name;
    if (page === 'home') { title = site.seo_default_title ?? site.site_name; content = <Home {...data} />; }
    else if (page === 'about') { title = 'About'; content = <About {...data} />; }
    else if (page === 'experience') { title = 'Experience'; content = <Experience {...data} />; }
    else if (page === 'packages') { title = 'Packages'; content = <Packages {...data} />; }
    else if (page === 'contact') { title = 'Contact'; content = <Contact />; }
    else if (page === 'search') { title = 'Search'; content = <Search {...data} />; }
    else if (page === 'projects-index') { title = 'Projects'; content = <ProjectsIndex {...data} />; }
    else if (page === 'project-show') { title = data.project?.seo_title ?? data.project?.title; content = <ProjectShow {...data} />; }
    else if (page === 'services-index') { title = 'Services'; content = <ServicesIndex {...data} />; }
    else if (page === 'service-show') { title = data.service?.title; content = <ServiceShow {...data} />; }
    else if (page === 'blog-index') { title = 'Journal'; content = <BlogIndex {...data} />; }
    else if (page === 'blog-show') { title = data.post?.seo_title ?? data.post?.title; content = <BlogShow {...data} />; }
    else if (page === 'resume') { title = 'Resume'; content = <Resume {...data} />; }
    else content = <section className="section-padding pt-32"><div className="container-site"><h1 className="display-lg">Page not found</h1></div></section>;
    return <PortfolioLayout title={title} description={data.project?.seo_description ?? data.post?.seo_description ?? data.project?.excerpt ?? data.post?.excerpt}>{content}</PortfolioLayout>;
}
