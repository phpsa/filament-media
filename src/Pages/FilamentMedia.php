<?php

namespace Phpsa\FilamentMedia\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Phpsa\FilamentMedia\Models\MediaManager;

class FilamentMedia extends Page
{
    use WithPagination;
    use WithFileUploads;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static string $view = 'filament-media::media.browser';

    protected static ?string $navigationGroup = 'Settings';

    public int $selectedDisk;

    public ?string $currentPath = null;

    public $uploads = [];

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
        $this->currentPath = null;
    }

    public function updatedUploads()
    {

        foreach ($this->uploads as $idx => $upload) {
            // dd($upload, $upload->getFilename(), $this);
            MediaManager::create(['disk' => $this->disks[$this->selectedDisk]])
                 ->addMedia($upload)
                 ->toMediaCollection('images', $this->disks[$this->selectedDisk]);
        //    unset($this->uploads[$idx]);
        }

        $this->notify('success', 'Saved');
    // here you can store immediately on any change of the property
    }


    protected function getViewData(): array
    {
        return [
         //   'currentFiles' => MediaManager::whereDisk($this->disks[$this->selectedDisk]),
            'currentFiles' => MediaManager::whereDisk($this->disks[$this->selectedDisk])->paginate(6),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('uploads')
                ->image()
                ->imagePreviewHeight('50')
                ->preserveFilenames()
                ->panelLayout('grid')
                ->multiple()
                ->reactive(),
        ];
    }
}
