<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Http\Requests\UploadedFiles\SaveRequest as UploadedFilesSaveRequest;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UploadedFilesController extends Controller
{
    public function index()
    {
        $query = UploadedFile::sortable(['created_at' => 'desc']);
        $query = $this->_searchParams($query);

        $uploadedFiles = $query->paginate(20);

        $search = request()->all();

        return Inertia::render('UploadedFiles/Index', [
            'uploadedFiles' => $uploadedFiles,
            ...$search
        ]);
    }


    private function _searchParams($query)
    {
        $search = request()->all();

        if (!empty($search['s']))
        {
            $query->where(function($q) use ($search){
                $q->where('name', 'LIKE', "%{$search['s']}%");
            });
        }

        if (!empty($search['from_date']))
        {
            $query->whereDate('created_at', '>=', $search['from_date']);
        }

        if (!empty($search['to_date']))
        {
            $query->whereDate('created_at', '<=', $search['to_date']);
        }

        return $query;
    }


    public function create()
    {
        return Inertia::render('UploadedFiles/Create');
    }


    public function store(UploadedFilesSaveRequest $request)
    {
        $data = $request->validated();
        $data['name'] = $data['name']['name'];
        $uploadedFile = UploadedFile::create($data);
        $uploadedFile->processImage($request, 'name', ['imageSizes'=>$uploadedFile->imageSizes]);
        $uploadedFile->save();

        return redirect()->route('uploaded_files.index')->with('notification', config('app-notifications')['record.saved']);
    }


    public function show(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        return Inertia::render('UploadedFiles/Show', compact('uploadedFile'));
    }


    public function edit(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        return Inertia::render('UploadedFiles/Edit', compact('uploadedFile'));
    }


    public function update(UploadedFilesSaveRequest $request, string $id)
    {
        $data = $request->validated();
        $data['name'] = $data['name']['name'];

        $uploadedFile = UploadedFile::findOrFail($id);
        $uploadedFile->processImage($request, 'name', ['imageSizes'=>$uploadedFile->imageSizes]);
        $uploadedFile->update($data);

        return redirect()->route('uploaded_files.show', [ $uploadedFile->id ])->with('notification', config('app-notifications')['record.saved']);
    }

    /* delete permanently */
    public function delete(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        Storage::deleteDirectory('public' . $uploadedFile->getUploadsFolder());
        $uploadedFile->delete();
        return redirect()->route('uploaded_files.index')->with('notification', config('app-notifications')['record.deleted']);
    }

}
