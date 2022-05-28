<?php

namespace Phpsa\FilamentMedia\Models;

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
}
