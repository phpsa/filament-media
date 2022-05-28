<?php

namespace Phpsa\FilamentMedia\Pages;

use Filament\Pages\Page;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Filament\Pages\Actions\Action;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
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

    public $files = [];

    public bool $uploading = false;

    public array $disks;

    public array $imgSelect = [];

    protected static function getNavigationLabel(): string
    {
        return __('Media Manager');
    }

    public function mount()
    {
        $this->selectedDisk = 0;
        $this->disks = config('filament-media.disks');
    }

    protected function getActions(): array
    {
        return [
            Action::make('Close Uploader')
                ->action(fn() => $this->toggleUploading(false))
                ->hidden(fn() => ! $this->uploading),
            Action::make('Upload Files')
                ->action('toggleUploading')
                ->hidden(fn() => $this->uploading),
            Action::make('Delete_Selected')
                ->action(fn () => MediaManager::whereIn('id', $this->imgSelect)->delete())
                ->requiresConfirmation()
                ->color('danger')
                ->hidden(fn() =>  $this->uploading || blank($this->imgSelect))

        ];
    }

    public function toggleUploading(bool $state = true)
    {
        $this->uploading = $state;
    }

    public function selectDisk(int $diskIdx)
    {
        $this->toggleUploading(false);
        if ($diskIdx === $this->selectedDisk) {
            return;
        }
        $this->resetPage();
        $this->selectedDisk = $diskIdx;
        $this->currentPath = null;
    }

    public function updatedUploads()
    {

        // foreach ($this->uploads as $upload) {
        //     array_push($this->files, $upload);
        // }
        // foreach ($this->uploads as $idx => $upload) {
        //     MediaManager::create(['disk' => $this->disks[$this->selectedDisk]])
        //          ->addMedia($upload)
        //          ->toMediaCollection('images', $this->disks[$this->selectedDisk]);
        // }

      //  $this->notify('success', 'Saved');
    }


    protected function getViewData(): array
    {

        return [
         //   'currentFiles' => MediaManager::whereDisk($this->disks[$this->selectedDisk]),
            'currentFiles' => $this->uploading ? null : MediaManager::whereDisk($this->disks[$this->selectedDisk])->paginate(6),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('uploads')
                ->image()
                ->imagePreviewHeight('50')
                ->preserveFilenames()
                ->panelLayout('compact')
                ->multiple(true)
                ->disablePreview()
               ->reactive(),
        ];
    }

    public function finishUpload($name, $tmpPath, $isMultiple)
    {
        $this->cleanupOldUploads();

        $files = collect($tmpPath)->map(function ($i) {
            $file = TemporaryUploadedFile::createFromLivewire($i);
             MediaManager::create(['disk' => $this->disks[$this->selectedDisk]])
                  ->addMedia($file)->toMediaCollection('images', $this->disks[$this->selectedDisk]);
            return false;
        })->filter()->toArray();
        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

    // merge it to persist uploaded images
        $files = array_merge($this->uploads, $files);
        $this->syncInput($name, $files);
    }
}
