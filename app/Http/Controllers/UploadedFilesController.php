<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia;
use App\Http\Requests\UploadedFiles\SaveRequest as UploadedFilesSaveRequest;
use App\Http\Requests\UploadedFiles\UpdateRequest as UploadedFilesUpdateRequest;
use App\Models\UploadedFile;



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

        return $query;
    }


    public function create()
    {
        return Inertia::render('UploadedFiles/Create');
    }


    public function store(UploadedFilesSaveRequest $request)
    {
        $inputFiles = $request->file('files');

        foreach ($inputFiles as $key => $inputFile){
            $data = $request->validated();
            $data['name'] = $inputFile->getClientOriginalName();
            $data['extension'] = $inputFile->extension();

            $uploadedFile = UploadedFile::create($data);
            $uploadedFile->name = $uploadedFile->processFile($inputFile, 'name', ['imageSizes'=>$uploadedFile->imageSizes, 'preserveName'=>true]);
            $uploadedFile->full_url = url("/storage" . $uploadedFile->uploadsFolder . "/name/" . $uploadedFile->name);

            $uploadedFile->save();
        }


        return redirect()->route('uploaded-files.index')->with('notification', config('app-notifications')['record.saved']);
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


    public function update(UploadedFilesUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $data['extension'] = pathinfo($data['name'], PATHINFO_EXTENSION);
        $uploadedFile = UploadedFile::findOrFail($id);

        $validator = Validator::make($request->all(), []);

        if ($data['extension'] != $uploadedFile->extension) {
            $validator->after(function ($validator) {
                $validator->errors()->add(
                    'name', 'File extensions do not match.'
                );
            });

            return redirect()->route('uploaded-files.edit', [ $uploadedFile->id ])->withErrors($validator)->withInput();
        }

        $oldFileName = '/public'.$uploadedFile->uploadsFolder . "/name/" . $uploadedFile->name;
        $newFileName = $uploadedFile->uploadsFolder . "/name/" . $data['name'];
        //dd([$oldFileName, $newFileName]);
        $data['full_url'] = url('storage'.$newFileName);
        Storage::move($oldFileName, '/public' . $newFileName);

        if (!in_array($uploadedFile->extension, ['mp3', 'wav'])){
            foreach ($uploadedFile->imageSizes as $size => $options){
                $oldFileName = '/public'.$uploadedFile->uploadsFolder . "/name/" . $size . "-" . $uploadedFile->name;
                $newFileName = $uploadedFile->uploadsFolder . "/name/" . $size . "-" . $data['name'];
                //dd([$oldFileName, $newFileName]);
                Storage::move($oldFileName, '/public' . $newFileName);
            }
        }

        $uploadedFile->update($data);

        return redirect()->route('uploaded-files.index')->with('notification', config('app-notifications')['record.saved']);
    }

    /* delete permanently */
    public function destroy(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        Storage::deleteDirectory('public' . $uploadedFile->getUploadsFolder());
        $uploadedFile->delete();
        return redirect()->route('uploaded-files.index')->with('notification', config('app-notifications')['record.deleted']);
    }


    public function download(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        $filePath = public_path("storage" . $uploadedFile->uploadsFolder . "/name/" . $uploadedFile->name);

        if (!File::exists($filePath))
            return redirect()->route('uploaded-files.index')->with('notification', config('app-notifications')['file.not_found']);

        $uploadedFile->downloaded = ++$uploadedFile->downloaded;
        $uploadedFile->save();
        return response()->download($filePath);
   }


    public function preview(string $id)
    {
        $uploadedFile = UploadedFile::findOrFail($id);
        return response()->json(compact('uploadedFile'));
    }

}
