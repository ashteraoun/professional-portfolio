import React, { useEffect } from 'react';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import '../../css/app.css';

function AuthLayout({ title, children }) {
    const { props } = usePage();
    const name = props.site?.site_name ?? 'Portfolio';
    useEffect(() => {
        document.body.classList.add('auth-page');
        document.documentElement.classList.remove('admin-root', 'admin-dark');
        return () => document.body.classList.remove('auth-page');
    }, []);
    return <>
        <Head title={title} />
        <main className="auth-layout">
            <section className="auth-aside" aria-label="Portfolio workspace">
                <Link href="/" className="auth-brand"><span className="auth-brand-mark">{name.slice(0, 1).toUpperCase()}</span><span>{name}</span></Link>
                <div className="auth-aside-content"><p className="auth-kicker"><span /> Portfolio workspace</p><h1>Your work,<br />beautifully managed.</h1><p className="auth-aside-copy">A focused space to shape your projects, share your stories, and keep your portfolio up to date.</p>
                    <div className="auth-preview" aria-hidden="true"><div className="auth-preview-top"><span className="auth-preview-dots"><i /><i /><i /></span><span>Workspace</span><span className="auth-preview-avatar">{name.slice(0, 1).toUpperCase()}</span></div><div className="auth-preview-content"><div className="auth-preview-heading"><span>Good to see you</span><span className="auth-preview-sparkle">✦</span></div><div className="auth-preview-cards"><div><span className="auth-preview-icon">↗</span><span>Projects</span></div><div><span className="auth-preview-icon">✎</span><span>Stories</span></div><div><span className="auth-preview-icon">⌑</span><span>Messages</span></div></div><div className="auth-preview-lines"><i /><i /><i /></div></div></div>
                </div><p className="auth-aside-footer">© {new Date().getFullYear()} {name}. All rights reserved.</p>
            </section>
            <section className="auth-main"><div className="auth-main-top"><Link href="/" className="auth-back-link"><span aria-hidden="true">←</span> Back to portfolio</Link></div><div className="auth-form-card">{children}</div><p className="auth-main-footer">Secure access to your portfolio workspace</p></section>
        </main>
    </>;
}

function AuthInput({ form, name, label, type = 'text', autoComplete, placeholder, required = true }) {
    return <div className="auth-field"><label htmlFor={name} className="auth-label">{label}</label><div className="auth-input-wrap"><input id={name} className="auth-input" name={name} type={type} autoComplete={autoComplete} placeholder={placeholder} required={required} value={form.data[name] ?? ''} onChange={(event) => form.setData(name, event.target.value)} /></div>{form.errors[name] && <p className="auth-error">{form.errors[name]}</p>}</div>;
}

function AuthForm({ page, token = '', email = '' }) {
    const { props } = usePage();
    const initial = page === 'register' ? { name: '', email: '', password: '', password_confirmation: '' }
        : page === 'reset-password' ? { token, email, password: '', password_confirmation: '' }
            : page === 'confirm-password' ? { password: '' }
                : { email: '', password: '', remember: false };
    const form = useForm(initial);
    const titles = {
        login: 'Sign in',
        register: 'Create account',
        'forgot-password': 'Reset password',
        'reset-password': 'Choose a new password',
        'confirm-password': 'Confirm password',
        'verify-email': 'Verify your email',
    };
    const routes = {
        login: '/login', register: '/register', 'forgot-password': '/forgot-password',
        'reset-password': '/reset-password', 'confirm-password': '/confirm-password',
    };
    const submit = (event) => {
        event.preventDefault();
        if (page === 'login') form.post('/login');
        else if (page === 'register') form.post('/register');
        else if (page === 'forgot-password') form.post('/forgot-password');
        else if (page === 'reset-password') form.post('/reset-password');
        else if (page === 'confirm-password') form.post('/confirm-password');
    };
    const title = titles[page] ?? 'Sign in';
    return <AuthLayout title={title}>
        <div className="auth-heading"><p className="auth-form-eyebrow">Portfolio workspace</p><h2>{title}</h2><p>{page === 'login' ? 'Enter your details below to continue.' : page === 'register' ? 'Create an account to manage your portfolio.' : page === 'verify-email' ? 'Check your inbox to finish setting up your account.' : 'Follow the steps below to continue.'}</p></div>
        {props.flash?.status && <p role="status" className="auth-session-status">{props.flash.status}</p>}
        {page === 'verify-email' ? <div className="space-y-5"><p className="text-sm text-muted">A verification link was sent to your email address. Open it to verify your account.</p><form onSubmit={(event) => { event.preventDefault(); form.post('/email/verification-notification'); }}><button className="auth-submit-button">Resend verification email</button></form><button type="button" onClick={() => router.post('/logout')} className="auth-back-link">Log out</button></div>
            : <form onSubmit={submit} className="auth-form">
                {page === 'register' && <AuthInput form={form} name="name" label="Name" autoComplete="name" />}
                <AuthInput form={form} name="email" label="Email address" type="email" autoComplete="username" placeholder="you@example.com" />
                {page === 'login' && <div className="auth-label-row"><span /><Link href="/forgot-password" className="auth-forgot-link">Forgot password?</Link></div>}
                {['login', 'register', 'reset-password', 'confirm-password'].includes(page) && <AuthInput form={form} name="password" label="Password" type="password" autoComplete={page === 'login' ? 'current-password' : 'new-password'} />}
                {['register', 'reset-password'].includes(page) && <AuthInput form={form} name="password_confirmation" label="Confirm password" type="password" autoComplete="new-password" />}
                {page === 'reset-password' && <input type="hidden" name="token" value={form.data.token} />}
                {page === 'login' && <label className="auth-remember"><input type="checkbox" checked={Boolean(form.data.remember)} onChange={(event) => form.setData('remember', event.target.checked)} /><span>Remember me</span></label>}
                {Object.values(form.errors).length > 0 && <p role="alert" className="auth-error">{Object.values(form.errors)[0]}</p>}
                <button type="submit" disabled={form.processing} className="auth-submit-button"><span>{form.processing ? 'Please wait…' : page === 'login' ? 'Sign in' : page === 'register' ? 'Register' : page === 'forgot-password' ? 'Email Password Reset Link' : page === 'reset-password' ? 'Reset Password' : 'Confirm password'}</span><span aria-hidden="true">→</span></button>
                {page === 'login' && <p className="auth-signup-note">Your portfolio workspace, all in one place.</p>}
                {page === 'register' && <p className="auth-signup-note">Already registered? <Link href="/login">Sign in</Link></p>}
                {page === 'forgot-password' && <p className="auth-signup-note"><Link href="/login">Back to sign in</Link></p>}
            </form>}
    </AuthLayout>;
}

export default function Auth(pageProps) {
    return <AuthForm {...pageProps} />;
}
