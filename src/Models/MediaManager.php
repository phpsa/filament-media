<?php

namespace Phpsa\FilamentMedia\Models;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaManager extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'disk'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        // $this
        // ->addMediaConversion('preview')
        // ->fit(Manipulations::FIT_CROP, 300, 300)
        // ->nonQueued();
        $this->addMediaConversion('preview')
              ->width(300)
              ->height(300)
              ->sharpen(10)
              ->nonQueued();
    }

    public function fileManagerPreviewUrl(): Attribute
    {
        return Attribute::get(fn() => $this->getTemporaryUrl());
    }

    public function name(): Attribute
    {
        return Attribute::get(fn() => $this->getFirstMedia('images')->name);
    }

    protected function getTemporaryUrl(): string
    {
        $media = $this->getFirstMedia('images');
        $driver = config('filesystems.disks.' . $media->conversions_disk . '.driver');
        $disk = Storage::disk($media->conversions_disk);
        $file = $media->getUrlGenerator('preview')->getPathRelativeToRoot('preview');

        if ($driver === 'local') {
            $disk->buildTemporaryUrlsUsing(fn($path, $expire, $options = [])=> URL::temporarySignedRoute(
                'filament.filament-media.preview',
                $expire,
                array_merge($options, ['filename' => $media->name, 'media' => $media->uuid])
            ));
        }

        return $disk->temporaryUrl($file, now()->addMinutes(5));
    }
}
