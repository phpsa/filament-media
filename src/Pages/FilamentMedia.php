<?php

namespace Phpsa\FilamentMedia\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\File;

class FilamentMedia extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament-media::media.browser';

    protected static ?string $navigationGroup = 'Settings';

    protected static function getNavigationLabel(): string
    {
        return __('Media Manager');
    }

    protected function getViewData(): array
    {

        $disks = config('filament-media.disks');

        return [
            "disks"        => $disks,
            "current_path" => ""
        ];
    }
}
