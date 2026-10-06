import React, { useEffect, useState } from 'react';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import '../../css/admin.css';

function ProfileSection({ title, description, children }) {
    return <section className="admin-card p-4 sm:p-8"><header><h2 className="text-lg font-medium text-slate-900">{title}</h2><p className="mt-1 text-sm text-slate-600">{description}</p></header>{children}</section>;
}

function ProfileField({ form, name, label, type = 'text', autoComplete }) {
    return <div><label htmlFor={name} className="admin-label">{label}</label><input id={name} name={name} type={type} autoComplete={autoComplete} value={form.data[name] ?? ''} onChange={(event) => form.setData(name, event.target.value)} className="admin-input" />{form.errors[name] && <p className="admin-field-error">{form.errors[name]}</p>}</div>;
}

export default function Profile({ user }) {
    const { props } = usePage();
    const [deleteOpen, setDeleteOpen] = useState(Boolean(props.errors?.userDeletion?.password));
    const infoForm = useForm({ name: user.name, email: user.email });
    const passwordForm = useForm({ current_password: '', password: '', password_confirmation: '' });
    const deleteForm = useForm({ password: '' });
    useEffect(() => {
        document.documentElement.classList.add('admin-root');
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.toggle('admin-dark', localStorage.getItem('admin-theme') === 'dark');
    }, []);
    const submitProfile = (event) => { event.preventDefault(); infoForm.patch('/profile'); };
    const submitPassword = (event) => { event.preventDefault(); passwordForm.put('/password', { onSuccess: () => passwordForm.reset() }); };
    const submitDelete = (event) => {
        event.preventDefault();
        if (window.confirm('Deleting your account permanently removes your account and its data. Continue?')) deleteForm.delete('/profile');
    };
    const logout = () => router.post('/logout');
    return <>
        <Head title="Profile" />
        <div className="min-h-screen bg-slate-100 py-10"><div className="mx-auto max-w-4xl space-y-6 px-4 sm:px-6">
            <header className="flex items-center justify-between"><div><p className="admin-eyebrow">Account</p><h1 className="admin-page-title">Profile</h1></div><div className="flex gap-3"><Link href="/admin" className="admin-btn-secondary">Admin</Link><button type="button" onClick={logout} className="admin-btn-secondary">Log out</button></div></header>
            <ProfileSection title="Profile Information" description="Update your account's profile information and email address.">
                <form onSubmit={submitProfile} className="mt-6 max-w-xl space-y-6"><ProfileField form={infoForm} name="name" label="Name" autoComplete="name" /><ProfileField form={infoForm} name="email" label="Email" type="email" autoComplete="username" />
                    {user.email_verified_at == null && <div className="text-sm text-slate-700">Your email address is unverified. <button type="button" onClick={() => router.post('/email/verification-notification')} className="underline">Resend verification email</button></div>}
                    {props.flash?.status === 'profile-updated' && <p className="text-sm text-slate-600">Saved.</p>}<button disabled={infoForm.processing} className="admin-btn-primary">Save</button>
                </form>
            </ProfileSection>
            <ProfileSection title="Update Password" description="Ensure your account is using a long, random password to stay secure.">
                <form onSubmit={submitPassword} className="mt-6 max-w-xl space-y-6"><ProfileField form={passwordForm} name="current_password" label="Current password" type="password" autoComplete="current-password" /><ProfileField form={passwordForm} name="password" label="New password" type="password" autoComplete="new-password" /><ProfileField form={passwordForm} name="password_confirmation" label="Confirm password" type="password" autoComplete="new-password" />{props.flash?.status === 'password-updated' && <p className="text-sm text-slate-600">Saved.</p>}<button disabled={passwordForm.processing} className="admin-btn-primary">Save</button></form>
            </ProfileSection>
            <ProfileSection title="Delete Account" description="Once your account is deleted, all of its resources and data will be permanently deleted.">
                {!deleteOpen ? <button type="button" onClick={() => setDeleteOpen(true)} className="admin-btn-danger mt-5">Delete Account</button>
                    : <form onSubmit={submitDelete} className="mt-5 max-w-xl space-y-4"><p className="text-sm text-slate-600">Enter your password to confirm permanent account deletion.</p><ProfileField form={deleteForm} name="password" label="Password" type="password" autoComplete="current-password" />{deleteForm.errors.password && <p className="admin-field-error">{deleteForm.errors.password}</p>}<div className="flex gap-3"><button className="admin-btn-danger">Delete Account</button><button type="button" onClick={() => setDeleteOpen(false)} className="admin-btn-secondary">Cancel</button></div></form>}
            </ProfileSection>
        </div></div>
    </>;
}
