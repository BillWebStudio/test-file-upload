<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

trait FilesProcessing
{
    private $uploadsFolder = "/uploads";
/* example:
    public $imageSizes = [
        'small' => [
            'w' => 150,
            'h' => 150,
        ],
        'medium' => [
            'w' => 300,
            'h' => 300,
        ],
        'large' => [
            'w' => 540,
            'h' => 540,
        ]
    ];
*/

    public function getUploadsFolder() {
        $folder = $this->uploadsFolder;

        if (!empty($this->uploadsModelFolder))
            $folder .= '/' . $this->uploadsModelFolder ;

        if (!empty($this->id))
            $folder .= '/' . $this->id ;

        return $folder;
    }


    public function getUploadsFolderFile(string $field) {
        return $this->getUploadsFolder() . '/' . $field;
    }


    public function processImage(Request $request, string $field, array $options=[]){
        if (!empty($this->{$field}))
            Storage::deleteDirectory( 'public' .$this->getUploadsFolderFile($field));

        $fileName = time() . '.' . $request->file($field)->extension();
        $request->file($field)->storeAs( 'public' . $this->getUploadsFolderFile($field), $fileName);
        $this->{$field} = $fileName;

        if (!empty($options['imageSizes']))
        {
            foreach ($options['imageSizes'] as $size => $options)
            {
                $thumbName = $size . "-" . $fileName;
                $request->{$field}->storeAs('public' . $this->getUploadsFolderFile($field), $thumbName);
                $smallthumbnailpath = public_path( 'storage' . $this->getUploadsFolderFile($field) . '/' . $thumbName);
                $this->createThumbnail($smallthumbnailpath, $options['w'], $options['h']);
            }
        }
    }


    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
