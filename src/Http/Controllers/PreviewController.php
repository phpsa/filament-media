<?php

namespace Phpsa\FilamentMedia\Http\Controllers;

use Illuminate\Routing\Controller;
use Phpsa\FilamentMedia\Models\MediaManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PreviewController extends Controller
{
    public function __invoke(Media $media)
    {

        return $media;
    }
}
