import React, { useEffect, useState } from 'react';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import '../../css/admin.css';

const navItems = [
    ['Dashboard', '/admin'],
    ['Projects', '/admin/projects'],
    ['Services', '/admin/services'],
    ['Packages', '/admin/packages'],
    ['Experience', '/admin/experience'],
    ['Skills', '/admin/skills'],
    ['Blog', '/admin/blog'],
    ['Testimonials', '/admin/testimonials'],
    ['Messages', '/admin/messages'],
    ['Settings', '/admin/settings'],
];

function AdminLayout({ title, children, createUrl }) {
    const { props, url } = usePage();
    const user = props.auth?.user;
    const [menuOpen, setMenuOpen] = useState(false);
    const [dark, setDark] = useState(() => document.documentElement.classList.contains('admin-dark'));
    useEffect(() => {
        document.documentElement.classList.add('admin-root');
        document.documentElement.classList.remove('dark');
        const isDark = localStorage.getItem('admin-theme') === 'dark';
        document.documentElement.classList.toggle('admin-dark', isDark);
        setDark(isDark);
    }, []);
    const toggleTheme = () => {
        const next = !document.documentElement.classList.contains('admin-dark');
        document.documentElement.classList.toggle('admin-dark', next);
        localStorage.setItem('admin-theme', next ? 'dark' : 'light');
        setDark(next);
    };
    const logout = () => router.post('/logout');

    return <>
        <Head title={`${title} — Admin`} />
        <div className="min-h-screen flex">
            <aside className="admin-sidebar w-64 flex-shrink-0 hidden md:flex md:flex-col md:sticky md:top-0 md:h-screen shadow-xl">
                <div className="px-6 py-6 border-b border-slate-800">
                    <Link href="/admin" className="admin-brand text-white font-bold text-lg tracking-tight">
                        <span className="admin-brand-mark">{(props.site?.site_name ?? 'P').slice(0, 1).toUpperCase()}</span>
                        <span>{props.site?.site_name ?? 'Portfolio'}</span>
                    </Link>
                    <p className="text-xs text-slate-500 mt-1 uppercase tracking-wider">Admin Panel</p>
                </div>
                <nav className="flex-1 min-h-0 px-3 py-5 space-y-1 overflow-y-auto" aria-label="Admin navigation">
                    {navItems.map(([label, href]) => <Link key={href} href={href} className={`admin-sidebar-link ${url.split('?')[0] === href || (href !== '/admin' && url.startsWith(`${href}/`)) ? 'is-active' : ''}`}>{label}</Link>)}
                </nav>
                <div className="px-4 py-5 border-t border-slate-800 flex items-center justify-between gap-2">
                    <div className="min-w-0"><p className="text-sm font-medium text-white truncate">{user?.name}</p><p className="text-xs text-slate-500 truncate">{user?.email}</p></div>
                    <button type="button" onClick={logout} className="text-xs text-slate-400 hover:text-white">Logout</button>
                </div>
            </aside>
            <div className="flex-1 flex flex-col min-w-0">
                <header className="admin-header-bar sticky top-0 z-30 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-6xl mx-auto min-h-16 py-3 flex items-center justify-between gap-4">
                        <div className="min-w-0"><h1 className="admin-page-title">{title}</h1></div>
                        <div className="flex items-center gap-2">
                            {createUrl && <Link href={createUrl} className="admin-btn-primary">New</Link>}
                            <button type="button" onClick={toggleTheme} className="admin-theme-toggle" aria-pressed={dark}>{dark ? 'Light mode' : 'Dark mode'}</button>
                            <button type="button" className="admin-theme-toggle md:hidden" onClick={() => setMenuOpen(!menuOpen)} aria-expanded={menuOpen}>Menu</button>
                        </div>
                    </div>
                </header>
                {menuOpen && <nav className="admin-mobile-nav md:hidden" aria-label="Admin navigation">{navItems.map(([label, href]) => <Link key={href} href={href} onClick={() => setMenuOpen(false)}>{label}</Link>)}</nav>}
                <main className="flex-1 py-8"><div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    {props.flash?.success && <p className="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-800">{props.flash.success}</p>}
                    {props.flash?.error && <p role="alert" className="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">{props.flash.error}</p>}
                    {children}
                </div></main>
            </div>
        </div>
    </>;
}

function Dashboard({ stats = {}, recentMessages = [], popularProjects = [] }) {
    const cards = [['Projects', stats.projects], ['Blog Posts', stats.posts], ['Unread Messages', stats.unread_messages], ['Total Messages', stats.total_messages]];
    return <>
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">{cards.map(([label, value]) => <div key={label} className="admin-card admin-metric-card p-5 sm:p-6"><p className="text-sm font-medium text-slate-500">{label}</p><p className="mt-3 text-3xl font-bold tracking-tight text-slate-900">{value ?? 0}</p></div>)}</div>
        <section className="admin-card mb-8 p-5 sm:p-6"><h2 className="font-semibold text-slate-900">Quick actions</h2><p className="mt-1 text-sm text-slate-500">Jump into the parts of your portfolio you update most.</p><div className="mt-4 grid gap-3 sm:grid-cols-3">{[['New project', '/admin/projects/create'], ['Write an article', '/admin/blog/create'], ['Site settings', '/admin/settings']].map(([label, href]) => <Link key={href} href={href} className="admin-quick-link"><span className="admin-quick-link-icon">+</span><strong>{label}</strong><span className="admin-quick-arrow">→</span></Link>)}</div></section>
        <div className="grid gap-6 lg:grid-cols-2">
            <section className="admin-card"><div className="flex items-center justify-between border-b border-slate-100 px-6 py-4"><h2 className="font-semibold text-slate-900">Recent Messages</h2><Link href="/admin/messages" className="text-sm font-semibold text-indigo-600 hover:text-indigo-800">View all</Link></div><ul className="divide-y divide-slate-100">{recentMessages.length ? recentMessages.map((message) => <li key={message.id} className="px-6 py-4 hover:bg-slate-50 transition"><Link href={`/admin/messages/${message.id}`} className="font-medium text-indigo-600 hover:text-indigo-800">{message.name}</Link><span className="text-sm text-slate-500 block mt-0.5">{message.message}</span></li>) : <li className="px-6 py-4 text-slate-500">No messages yet.</li>}</ul></section>
            <section className="admin-card"><div className="flex items-center justify-between border-b border-slate-100 px-6 py-4"><h2 className="font-semibold text-slate-900">Popular Projects</h2><Link href="/admin/projects" className="text-sm font-semibold text-indigo-600 hover:text-indigo-800">View all</Link></div><ul className="divide-y divide-slate-100">{popularProjects.map((project) => <li key={project.id} className="px-6 py-4 flex justify-between"><span className="font-medium text-slate-800">{project.title}</span><span className="text-sm text-slate-500">{project.view_count} views</span></li>)}</ul></section>
        </div>
    </>;
}

function AdminPagination({ paginator }) {
    if (!paginator?.links) return null;
    return <nav className="mt-4 flex gap-2" aria-label="Pagination">{paginator.links.map((link, i) => link.url
        ? <Link key={i} href={link.url} preserveScroll className={`admin-btn-secondary ${link.active ? '!border-indigo-400 !text-indigo-700' : ''}`} dangerouslySetInnerHTML={{ __html: link.label }} />
        : <span key={i} className="admin-btn-secondary opacity-50" dangerouslySetInnerHTML={{ __html: link.label }} />)}</nav>;
}

const indexRows = {
    projects: { name: (record) => record.title, detail: (record) => `${record.category?.name ?? 'Uncategorized'} · ${record.year ?? ''}`, status: (record) => record.is_published ? 'Published' : 'Draft' },
    blog: { name: (record) => record.title, detail: (record) => record.category?.name ?? 'Article', status: (record) => record.status },
    services: { name: (record) => record.title, detail: (record) => record.excerpt ?? '', status: (record) => record.is_published ? 'Published' : 'Draft' },
    packages: { name: (record) => record.name, detail: (record) => record.price ? `$${record.price}` : record.delivery_time ?? '', status: (record) => record.is_published ? 'Published' : 'Draft' },
    experience: { name: (record) => record.role, detail: (record) => record.company, status: (record) => record.is_published ? 'Published' : 'Draft' },
    testimonials: { name: (record) => record.client_name, detail: (record) => record.company ?? '', status: (record) => record.is_published ? 'Published' : 'Draft' },
};

function ResourceIndex({ resource, title, records, categoriesWithSkills, createUrl }) {
    const config = indexRows[resource];
    const deleteRecord = (id) => {
        if (window.confirm('Are you sure you want to delete this item?')) router.delete(`/admin/${resource}/${id}`);
    };
    if (resource === 'skills') return <div className="space-y-4">{(categoriesWithSkills ?? []).map((category) => <section key={category.id} className="admin-card p-6"><h2 className="font-semibold mb-3">{category.name}</h2><ul className="space-y-2">{category.skills.map((skill) => <li key={skill.id} className="flex justify-between text-sm"><span>{skill.name} <span className="text-slate-500">{skill.experience_level}</span></span><span className="space-x-3"><Link href={`/admin/skills/${skill.id}/edit`} className="text-indigo-600">Edit</Link><button type="button" onClick={() => deleteRecord(skill.id)} className="text-red-600">Delete</button></span></li>)}</ul></section>)}<Link href={createUrl} className="admin-btn-primary inline-flex">New Skill</Link></div>;
    return <div className="admin-card overflow-hidden">
        <div className="overflow-x-auto"><table className="min-w-full divide-y divide-slate-200"><thead className="bg-slate-50"><tr><th className="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">{title}</th><th className="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Details</th><th className="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th><th className="px-6 py-3 text-right text-xs font-semibold uppercase text-slate-500">Actions</th></tr></thead>
            <tbody className="divide-y divide-slate-100 bg-white">{(records?.data ?? []).map((record) => <tr key={record.id} className="hover:bg-slate-50"><td className="px-6 py-4 font-medium text-slate-900">{config.name(record)}</td><td className="px-6 py-4 text-sm text-slate-600">{config.detail(record)}</td><td className="px-6 py-4 text-sm text-slate-600">{config.status(record)}</td><td className="px-6 py-4 text-right whitespace-nowrap"><Link href={`/admin/${resource}/${record.id}/edit`} className="mr-4 text-sm font-semibold text-indigo-600 hover:text-indigo-800">Edit</Link><button type="button" onClick={() => deleteRecord(record.id)} className="text-sm font-semibold text-red-600 hover:text-red-800">Delete</button></td></tr>)}
                {!(records?.data?.length) && <tr><td colSpan="4" className="px-6 py-12 text-center text-slate-500">No {title.toLowerCase()} yet.</td></tr>}
            </tbody></table></div><div className="px-6 pb-4"><AdminPagination paginator={records} /></div>
    </div>;
}

const scalarFields = {
    services: [['title', 'Title', 'text', true], ['excerpt', 'Excerpt', 'textarea'], ['description', 'Description', 'textarea'], ['is_published', 'Published', 'checkbox']],
    packages: [['name', 'Name', 'text', true], ['description', 'Description', 'textarea'], ['price', 'Price', 'number'], ['delivery_time', 'Delivery time', 'text'], ['is_published', 'Published', 'checkbox'], ['is_recommended', 'Recommended', 'checkbox']],
    experience: [['company', 'Company', 'text', true], ['role', 'Role', 'text', true], ['location', 'Location', 'text'], ['started_at', 'Start date', 'date', true], ['ended_at', 'End date', 'date'], ['description', 'Description', 'textarea'], ['is_current', 'Current role', 'checkbox'], ['is_published', 'Published', 'checkbox']],
    testimonials: [['client_name', 'Client name', 'text', true], ['company', 'Company', 'text'], ['content', 'Testimonial', 'textarea', true], ['is_published', 'Published', 'checkbox']],
    blog: [['title', 'Title', 'text', true], ['excerpt', 'Excerpt', 'textarea'], ['content', 'Content (Markdown)', 'textarea', true], ['status', 'Status', 'select', true, ['draft', 'published', 'scheduled']], ['blog_category_id', 'Category', 'category'], ['published_at', 'Publish date', 'datetime-local'], ['reading_time', 'Reading time (minutes)', 'number'], ['is_featured', 'Featured', 'checkbox'], ['seo_title', 'SEO title', 'text'], ['seo_description', 'SEO description', 'textarea']],
    skills: [['skill_category_id', 'Category', 'category', true], ['name', 'Name', 'text', true], ['experience_level', 'Experience level', 'text']],
};

function AdminField({ field, value, setValue, error, options = [] }) {
    const [name, label, type, required, selectOptions] = field;
    if (type === 'checkbox') return <label className="admin-checkbox-label"><input type="checkbox" checked={Boolean(value)} onChange={(event) => setValue(name, event.target.checked ? '1' : '')} className="admin-checkbox" />{label}</label>;
    const inputValue = type === 'date' && typeof value === 'string' ? value.slice(0, 10)
        : type === 'datetime-local' && typeof value === 'string' ? value.slice(0, 16)
            : value ?? '';
    return <div>
        <label htmlFor={name} className="admin-label">{label}{required && ' *'}</label>
        {type === 'textarea' ? <textarea id={name} value={value ?? ''} required={required} rows={name === 'content' ? 12 : 4} onChange={(event) => setValue(name, event.target.value)} className="admin-textarea" />
            : type === 'select' ? <select id={name} value={value ?? 'draft'} onChange={(event) => setValue(name, event.target.value)} className="admin-select">{selectOptions.map((option) => <option key={option} value={option}>{option[0].toUpperCase() + option.slice(1)}</option>)}</select>
                : type === 'category' ? <select id={name} value={value ?? ''} required={required} onChange={(event) => setValue(name, event.target.value)} className="admin-select"><option value="">Select category</option>{options.map((option) => <option key={option.id} value={option.id}>{option.name}</option>)}</select>
                    : <input id={name} type={type} value={inputValue} required={required} step={type === 'number' && name === 'price' ? '0.01' : undefined} onChange={(event) => setValue(name, event.target.value)} className="admin-input" />}
        {error && <p className="admin-field-error">{error}</p>}
    </div>;
}

function ResourceForm({ resource, title, action, indexUrl, project, post, service, package: packageItem, experience, skill, testimonial, categories = [], technologies = [], tags = [] }) {
    const existing = project ?? post ?? service ?? packageItem ?? experience ?? skill ?? testimonial ?? {};
    const initial = {
        ...existing,
        is_published: existing.is_published ?? ['projects', 'services', 'experience'].includes(resource),
        year: existing.year ?? new Date().getFullYear(),
        sort_order: existing.sort_order ?? 0,
        technologies: existing.technologies?.map((item) => String(item.id)) ?? [],
        tags: existing.tags?.map((item) => String(item.id)) ?? [],
    };
    const form = useForm(initial);
    const submit = (event) => {
        event.preventDefault();
        if (existing.id) form.transform((data) => ({ ...data, _method: 'PUT' })).post(action, { forceFormData: true });
        else form.post(action, { forceFormData: true });
    };
    const fields = scalarFields[resource] ?? [];
    return <form onSubmit={submit} className="admin-card max-w-3xl space-y-5 p-6 md:p-8">
        {resource === 'projects' ? <>
            <h2 className="admin-section-title">Basic Information</h2>
            <div className="grid gap-5 md:grid-cols-2"><AdminField field={['title', 'Title', 'text', true]} value={form.data.title} setValue={form.setData} error={form.errors.title} /><AdminField field={['subtitle', 'Subtitle', 'text']} value={form.data.subtitle} setValue={form.setData} error={form.errors.subtitle} /></div>
            <div className="grid gap-5 md:grid-cols-3"><AdminField field={['project_category_id', 'Category', 'category']} options={categories} value={form.data.project_category_id} setValue={form.setData} error={form.errors.project_category_id} /><AdminField field={['year', 'Year', 'number']} value={form.data.year} setValue={form.setData} error={form.errors.year} /><AdminField field={['role', 'Your role', 'text']} value={form.data.role} setValue={form.setData} error={form.errors.role} /></div>
            <AdminField field={['excerpt', 'Short excerpt', 'textarea']} value={form.data.excerpt} setValue={form.setData} error={form.errors.excerpt} />
            <h2 className="admin-section-title pt-4">Case Study Content</h2>
            {['problem', 'challenge', 'solution'].map((name) => <AdminField key={name} field={[name, name[0].toUpperCase() + name.slice(1), 'textarea']} value={form.data[name]} setValue={form.setData} error={form.errors[name]} />)}
            <h2 className="admin-section-title pt-4">Links & Media</h2>
            {['live_url', 'github_url', 'video_url'].map((name) => <AdminField key={name} field={[name, name.replace('_url', ' URL').replace(/^\w/, (c) => c.toUpperCase()), 'url']} value={form.data[name]} setValue={form.setData} error={form.errors[name]} />)}
            <h2 className="admin-section-title pt-4">Technologies</h2><div className="admin-tech-grid">{technologies.map((tech) => <label key={tech.id} className="admin-tech-item"><input className="admin-checkbox" type="checkbox" checked={form.data.technologies?.includes(String(tech.id)) ?? false} onChange={(event) => form.setData('technologies', event.target.checked ? [...form.data.technologies, String(tech.id)] : form.data.technologies.filter((id) => id !== String(tech.id)))} />{tech.name}</label>)}</div>
            <h2 className="admin-section-title pt-4">Project Images</h2>{['thumbnail', 'hero_image', 'mobile_image'].map((name) => <div key={name}><label className="admin-label" htmlFor={name}>{name.replace('_', ' ')}</label>{existing[name] && <img src={`/storage/${existing[name]}`} alt="" className="mb-2 h-20 rounded object-cover" />}<input id={name} type="file" accept="image/*" onChange={(event) => form.setData(name, event.target.files?.[0] ?? null)} className="admin-input !p-2.5" />{form.errors[name] && <p className="admin-field-error">{form.errors[name]}</p>}</div>)}
            <div><label className="admin-label" htmlFor="gallery">Gallery images/videos</label><input id="gallery" type="file" multiple accept="image/*,video/mp4,video/webm" onChange={(event) => form.setData('gallery', Array.from(event.target.files ?? []))} className="admin-input !p-2.5" />{form.errors.gallery && <p className="admin-field-error">{form.errors.gallery}</p>}</div>
            <div className="flex flex-wrap gap-6"><AdminField field={['is_published', 'Published', 'checkbox']} value={form.data.is_published} setValue={form.setData} /><AdminField field={['is_featured', 'Featured', 'checkbox']} value={form.data.is_featured} setValue={form.setData} /><AdminField field={['sort_order', 'Sort order', 'number']} value={form.data.sort_order} setValue={form.setData} /></div>
            {existing.gallery?.length > 0 && <div><h3 className="admin-label">Current gallery</h3><div className="grid grid-cols-2 gap-3 sm:grid-cols-3">{existing.gallery.map((item) => <div key={item.id} className="admin-gallery-thumb"><img src={`/storage/${item.path}`} alt={item.alt ?? ''} className="h-full w-full object-cover" /><button type="button" className="absolute bottom-2 right-2 admin-btn-danger" onClick={() => { if (window.confirm('Remove this image?')) router.delete(`/admin/projects/${existing.id}/gallery/${item.id}`); }}>Remove</button></div>)}</div></div>}
        </> : fields.map((field) => <React.Fragment key={field[0]}>{field[2] === 'category' && field[0] === 'blog_category_id' ? <AdminField field={field} options={categories} value={form.data[field[0]]} setValue={form.setData} error={form.errors[field[0]]} /> : field[2] === 'category' && field[0] === 'skill_category_id' ? <AdminField field={field} options={categories} value={form.data[field[0]]} setValue={form.setData} error={form.errors[field[0]]} /> : <AdminField field={field} value={form.data[field[0]]} setValue={form.setData} error={form.errors[field[0]]} />}</React.Fragment>)}
        {resource === 'blog' && tags.length > 0 && <div><h3 className="admin-label">Tags</h3><div className="admin-tech-grid">{tags.map((tag) => <label key={tag.id} className="admin-tech-item"><input className="admin-checkbox" type="checkbox" checked={form.data.tags?.includes(String(tag.id)) ?? false} onChange={(event) => form.setData('tags', event.target.checked ? [...form.data.tags, String(tag.id)] : form.data.tags.filter((id) => id !== String(tag.id)))} />{tag.name}</label>)}</div></div>}
        <div className="flex gap-3 pt-3"><button disabled={form.processing} className="admin-btn-primary">{form.processing ? 'Saving…' : existing.id ? `Update ${resource}` : `Create ${resource}`}</button><Link href={indexUrl} className="admin-btn-secondary">Cancel</Link></div>
        {Object.keys(form.errors).length > 0 && <p role="alert" className="text-sm text-red-600">Please correct the highlighted fields.</p>}
    </form>;
}

const settingGroups = [
    ['Brand & identity', [['site_name', 'Site name'], ['site_tagline', 'Professional tagline'], ['location', 'Location']]],
    ['Homepage introduction', [['hero_status', 'Availability'], ['hero_headline', 'Headline'], ['hero_subheadline', 'Supporting text', true], ['hero_cta_primary', 'Primary button'], ['hero_cta_secondary', 'Secondary button'], ['years_experience', 'Years of experience'], ['projects_delivered', 'Projects delivered']]],
    ['About section', [['about_intro', 'Introduction', true], ['about_philosophy', 'Working philosophy', true]]],
    ['Contact & social links', [['contact_email', 'Contact email'], ['github_url', 'GitHub URL'], ['linkedin_url', 'LinkedIn URL'], ['resume_url', 'Resume URL']]],
    ['Footer & search preview', [['footer_statement', 'Footer statement'], ['footer_cta', 'Footer button'], ['seo_default_title', 'Default SEO title'], ['seo_default_description', 'Default SEO description', true]]],
];

function SettingsForm({ settings = {}, action }) {
    const form = useForm(settings);
    const [logoPreview, setLogoPreview] = useState(settings.logo_path ? `/storage/${settings.logo_path}` : null);
    const [faviconPreview, setFaviconPreview] = useState(settings.favicon_path ? `/storage/${settings.favicon_path}` : null);
    const setFile = (key, previewSetter) => (event) => {
        const file = event.target.files?.[0] ?? null;
        form.setData(key, file);
        if (file) previewSetter(URL.createObjectURL(file));
    };
    const submit = (event) => {
        event.preventDefault();
        form.transform((data) => ({ ...data, _method: 'PUT' })).post(action, { forceFormData: true });
    };
    return <form onSubmit={submit} className="space-y-6">
        <section className="admin-card overflow-hidden"><div className="admin-settings-section-heading"><div><h2>Logo & favicon</h2><p>Upload the visual identity used in your navigation and browser tab.</p></div></div><div className="grid gap-5 border-t border-slate-100 p-5 sm:p-6 lg:grid-cols-2">
            {[[ 'logo', 'Site logo', logoPreview, setLogoPreview, 'image/png,image/jpeg,image/webp' ], ['favicon', 'Browser favicon', faviconPreview, setFaviconPreview, 'image/png,image/jpeg,image/webp']].map(([name, label, preview, previewSetter, accept]) => <div key={name} className="admin-asset-card"><div className="admin-asset-preview">{preview ? <img src={preview} alt={`Current ${label}`} className="max-h-16 max-w-[70%] object-contain" /> : <span className="admin-logo-fallback">Aa</span>}</div><label htmlFor={name} className="admin-label mt-5">{label}</label><input id={name} type="file" accept={accept} onChange={setFile(name, previewSetter)} className="admin-input !p-2.5" />{form.errors[name] && <p className="admin-field-error">{form.errors[name]}</p>}{settings[`${name}_path`] && <label className="admin-remove-asset"><input type="checkbox" checked={Boolean(form.data[`remove_${name}`])} onChange={(event) => form.setData(`remove_${name}`, event.target.checked ? '1' : '')} />Remove current {name}</label>}</div>)}
        </div></section>
        {settingGroups.map(([group, fields]) => <section key={group} className="admin-card overflow-hidden"><div className="admin-settings-section-heading"><div><h2>{group}</h2></div></div><div className="grid gap-5 border-t border-slate-100 p-5 sm:p-6 md:grid-cols-2">{fields.map(([name, label, textarea]) => <div key={name} className={textarea ? 'md:col-span-2' : ''}><label className="admin-label" htmlFor={name}>{label}</label>{textarea ? <textarea id={name} rows={4} value={form.data[name] ?? ''} onChange={(event) => form.setData(name, event.target.value)} className="admin-textarea" /> : <input id={name} value={form.data[name] ?? ''} onChange={(event) => form.setData(name, event.target.value)} className="admin-input" />}{form.errors[name] && <p className="admin-field-error">{form.errors[name]}</p>}</div>)}</div></section>)}
        <div className="admin-settings-savebar"><p>Changes apply across your portfolio after saving.</p><button disabled={form.processing} className="admin-btn-primary">{form.processing ? 'Saving…' : 'Save settings'}</button></div>
    </form>;
}

function MessageShow({ message }) {
    const form = useForm({ status: message.status });
    const submit = (event) => { event.preventDefault(); form.put(`/admin/messages/${message.id}`); };
    return <section className="admin-card max-w-2xl space-y-4 p-6">
        <p><strong>Email:</strong> {message.email}</p>{message.company && <p><strong>Company:</strong> {message.company}</p>}{message.project_type && <p><strong>Project type:</strong> {message.project_type}</p>}{message.budget_range && <p><strong>Budget:</strong> {message.budget_range}</p>}{message.timeline && <p><strong>Timeline:</strong> {message.timeline}</p>}<div><strong>Message:</strong><p className="mt-2 whitespace-pre-wrap text-slate-700">{message.message}</p></div>
        {message.attachments?.map((file) => <a key={file.id} href={`/admin/messages/${message.id}/attachments/${file.id}`} className="text-indigo-600">{file.original_name}</a>)}
        <form onSubmit={submit} className="flex gap-2 pt-4"><select value={form.data.status} onChange={(event) => form.setData('status', event.target.value)} className="admin-select">{['unread', 'read', 'archived'].map((status) => <option key={status}>{status}</option>)}</select><button className="admin-btn-primary">Update</button></form>
    </section>;
}

export default function Admin(pageProps) {
    const { page, ...data } = pageProps;
    let content;
    let title = data.title ?? (page === 'messages-index' ? 'Messages' : 'Dashboard');
    let createUrl;
    if (page === 'dashboard') content = <Dashboard {...data} />;
    else if (page === 'resource-index' || page === 'messages-index') { createUrl = data.createUrl; content = page === 'messages-index' ? <div className="admin-card overflow-hidden"><div className="overflow-x-auto"><table className="min-w-full divide-y divide-gray-200"><thead className="bg-gray-50"><tr>{['From', 'Type', 'Status', 'Date'].map((heading) => <th key={heading} className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{heading}</th>)}</tr></thead><tbody className="divide-y">{(data.messages?.data ?? []).map((message) => <tr key={message.id} className="hover:bg-gray-50"><td className="px-6 py-4"><Link href={`/admin/messages/${message.id}`} className="text-indigo-600">{message.name}</Link><div className="text-sm text-gray-500">{message.email}</div></td><td className="px-6 py-4 text-sm">{message.project_type ?? '—'}</td><td className="px-6 py-4 text-sm">{message.status}</td><td className="px-6 py-4 text-sm text-gray-500">{new Date(message.created_at).toLocaleDateString()}</td></tr>)}</tbody></table></div><div className="p-4"><AdminPagination paginator={data.messages} /></div></div> : <ResourceIndex {...data} />; }
    else if (page === 'resource-form') content = <ResourceForm {...data} />;
    else if (page === 'settings') content = <SettingsForm {...data} />;
    else if (page === 'message-show') { title = `Message from ${data.message?.name ?? ''}`; content = <MessageShow {...data} />; }
    return <AdminLayout title={title} createUrl={createUrl}>{content}</AdminLayout>;
}
