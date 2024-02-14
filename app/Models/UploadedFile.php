<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Kyslik\ColumnSortable\Sortable;
use App\Traits\FilesProcessing;


class UploadedFile extends Model
{
    use HasFactory;
    use Sortable;
    use FilesProcessing;


    protected $fillable = [
        'name',
        'extension',
        'full_url',
        'downloaded',
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at'  => 'date:Y-m-d H:i',
    ];


    public $sortable = [
        'id',
        'name',
        'extension',
        'full_url',
        'downloaded',
        'created_at',
        'updated_at',
        ];


    public $uploadsModelFolder = "uploaded_files";

    public $imageSizes = [
        'small' => [
            'w' => 150,
            'h' => 150,
        ],
        'medium' => [
            'w' => 300,
            'h' => 300,
        ],
    ];

    protected $appends = ['uploadsFolder'];


    function getUploadsFolderAttribute() {
        return $this->getUploadsFolder();
    }
}
