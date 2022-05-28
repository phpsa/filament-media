<?php

namespace Phpsa\FilamentMedia\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\File;
use Livewire\WithPagination;
use Phpsa\FilamentMedia\Models\MediaManager;

class FilamentMedia extends Page
{
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament-media::media.browser';

    protected static ?string $navigationGroup = 'Settings';

    public int $selectedDisk;

    public string $currentPath = '';

    //public array $currentFiles = [];

    public array $disks;

    protected static function getNavigationLabel(): string
    {
        return __('Media Manager');
    }

    public function mount()
    {
        $this->selectedDisk = 0;
        $this->disks = config('filament-media.disks');
    }

    public function selectDisk(int $diskIdx)
    {
        if ($diskIdx === $this->selectedDisk) {
            return;
        }
        $this->resetPage();
        $this->selectedDisk = $diskIdx;
    }


    protected function getViewData(): array
    {
        return [
         //   'currentFiles' => MediaManager::whereDisk($this->disks[$this->selectedDisk]),
            'currentFiles' => MediaManager::whereDisk($this->disks[$this->selectedDisk])->paginate(6),
        ];
    }
}
