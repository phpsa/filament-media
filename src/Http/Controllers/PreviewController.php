<?php

namespace Phpsa\FilamentMedia\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Phpsa\FilamentMedia\Models\MediaManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\ConversionCollection;

class PreviewController extends Controller
{
    public function __invoke(Media $media)
    {

        $disk = Storage::disk($media->conversions_disk);
        $file = $media->getUrlGenerator('preview')->getPathRelativeToRoot('preview');

        return $disk->response($file);
    }
}
