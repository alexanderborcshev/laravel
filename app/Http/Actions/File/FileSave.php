<?php

namespace App\Http\Actions\File;

use App\Http\Actions\ActionInterface;
use App\Models\File;
use Illuminate\Database\Eloquent\Model;

class FileSave implements ActionInterface
{
    public function execute(array $data): File|Model
    {
        return File::saveFile($data['file'], ['thumbnail' => true, 'toJpeg' => true, 'watermark' => true, 'resize'=>['width'=>1920,'height'=>1080]]);
    }
}
