<?php

use Filament\Facades\Filament;
use Filament\Http\Controllers\AssetController;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Illuminate\Support\Facades\Route;
use Phpsa\FilamentMedia\Http\Controllers\PreviewController;

Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base') + config('filament.middleware.auth'))
    ->name('filament.')
    ->prefix(config('filament.core_path'))
    ->group(function () {
        Route::get('/filament-media/preview/{media}/{filename}', PreviewController::class)->name('filament-media.preview');
    });
