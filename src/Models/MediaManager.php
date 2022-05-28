<?php

namespace Phpsa\FilamentMedia\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
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
              ->width(368)
              ->height(232)
              ->sharpen(10)
              ->nonQueued();
    }

    public function fileManagerPreviewUrl(): Attribute
    {
        return Attribute::get(fn() => route('filament.filament-media.preview', [
            'media'    => $this->getFirstMedia('images')->uuid,
            'filename' => $this->getFirstMedia('images')->getPath()
        ]));
    }
}
