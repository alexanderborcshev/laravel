<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

/**
 * App\Models\File
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $path
 * @property string|null $name
 * @property string|null $preview
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereName($value)
 * @method static Builder|File wherePath($value)
 * @method static Builder|File wherePreview($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @mixin Eloquent
 */
class File extends Model
{
    use HasFactory;

    public string $key = '';
    protected $fillable = [
        'path',
        'name',
        'preview',
    ];

    public static function saveFile(UploadedFile $file, $params = []): Model|File
    {
        $preview = null;
        $extension = $file->extension();
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $imageName = Str::random(40);
            if (isset($params['toJpeg'])) {
                $imageName .= '.jpg';
            } else {
                if($extension == 'png'){
                    $imageName .= '.png';
                } else {
                    $imageName .= '.jpg';
                }
            }
            $path = env('APP_PATH_FILE_STORE').$imageName;
            $preview = env('APP_PATH_FILE_STORE').'thumbnail/'.$imageName;
            // create image manager with desired driver
            $manager = new ImageManager('gd');
            // open an image file

            $managerFile = $manager->make($file->path());
            if (isset($params['resize'])) {
                $managerFile->scaleDown($params['resize']['width'], $params['resize']['height']);
            }
            if (isset($params['watermark'])) {
                $managerFile->place(env('APP_PATH_FILE_STORE').'/services/watermark.png', 'center');
            }
            if (isset($params['toJpeg'])) {
                $saveFile = $managerFile->toJpeg();
            } else {
                if ($extension == 'png') {
                    $saveFile = $managerFile->toPng();
                } else {
                    $saveFile = $managerFile->toJpeg();
                }
            }

            Storage::put('public/' . $imageName, $saveFile);
            if (isset($params['thumbnail'])) {
                Storage::put('public/thumbnail/'.$imageName, $manager->make($file->path())
                    ->scaleDown(320, 240)
                    ->toJpeg());
            }

        } else {
            $imageName = $file->hashName();
            Storage::putFileAs('public', $file, $imageName);
            $path = env('APP_PATH_FILE_STORE').$imageName;
        }

        return File::create([
            'path'=>$path,
            'name'=>$file->getClientOriginalName(),
            'preview'=>$preview,
        ]);
    }
}
