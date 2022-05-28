<?php

namespace Phpsa\FilamentMedia\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaManager extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'disk'
    ];
}
