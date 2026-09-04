<?php

use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceAdminController;
use App\Http\Controllers\Admin\PackageAdminController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ServiceAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\SkillAdminController;
use App\Http\Controllers\Admin\TestimonialAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('projects', ProjectAdminController::class)->except(['show']);
Route::resource('blog', BlogAdminController::class)->except(['show']);
Route::resource('services', ServiceAdminController::class)->except(['show']);
Route::resource('packages', PackageAdminController::class)->except(['show']);
Route::resource('experience', ExperienceAdminController::class)->except(['show']);
Route::resource('skills', SkillAdminController::class)->except(['show']);
Route::resource('testimonials', TestimonialAdminController::class)->except(['show']);
Route::resource('messages', ContactAdminController::class)->only(['index', 'show', 'update', 'destroy'])->parameters(['messages' => 'contact']);
Route::get('settings', [SettingAdminController::class, 'edit'])->name('settings.edit');
Route::put('settings', [SettingAdminController::class, 'update'])->name('settings.update');
