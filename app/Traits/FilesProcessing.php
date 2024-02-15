<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

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


    public function processFile($fileInput, string $field, array $options=[]){
        if (!empty($this->{$field}))
            Storage::deleteDirectory( 'public' .$this->getUploadsFolderFile($field));

        $ext = $fileInput->extension();
        $mime = $fileInput->getMimeType();

        if (!empty($options['preserveName']))
            $fileName = $fileInput->getClientOriginalName();
        else
            $fileName = time() . '.' . $ext;

        $fileInput->storeAs( 'public' . $this->getUploadsFolderFile($field), $fileName);

        if (stristr($mime, 'image') && !empty($options['imageSizes']))
        {
            foreach ($options['imageSizes'] as $size => $options)
            {
                $thumbName = $size . "-" . $fileName;
                $fileInput->storeAs('public' . $this->getUploadsFolderFile($field), $thumbName);
                $smallthumbnailpath = public_path( 'storage' . $this->getUploadsFolderFile($field) . '/' . $thumbName);
                $this->createThumbnail($smallthumbnailpath, $options['w'], $options['h']);
            }
        }

        return $fileName;
    }


    public function createThumbnail($path, $width, $height)
    {
        $img = ImageManager::imagick()->read($path);
        $img->coverDown($width, $height);
        $img->save($path);
    }
}
