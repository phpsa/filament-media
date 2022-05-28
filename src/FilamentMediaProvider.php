<?php

namespace Phpsa\FilamentMedia;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Phpsa\FilamentMedia\Pages\FilamentMedia;

class FilamentMediaProvider extends PluginServiceProvider
{
    public static string $name = 'filament-media';



    protected array $pages = [
        FilamentMedia::class
    ];

    public function configurePackage(Package $package): void
    {
        $package->name('filament-media')
        ->hasMigration('create_media_manager_table')
        ->hasViews()
        ->hasConfigFile();
    }
}
