<?php

namespace App\Http\Controllers\Api;

use App\Http\Actions\File\FileSave;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFileRequest;
use App\Http\Resources\Public\FileResource;

class FileController extends Controller
{
    public function file(StoreFileRequest $request, FileSave $action): FileResource
    {
        $files = $request->allFiles();
        $file = $action->execute(['file' => array_shift($files)]);
        $file->key = $request->input('key');
        return new FileResource($file);
    }
}
