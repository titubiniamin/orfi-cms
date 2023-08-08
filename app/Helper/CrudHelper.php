<?php

namespace App\Helper;

use App\Services\FileUploadInCloud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CrudHelper
{

    protected $model;
    protected $type;
    protected $redirectRoute;

    public function __construct($model, $type = null, $redirectRoute = null)
    {
        $this->model = $model;
        $this->type = $type;
        $this->redirectRoute = $redirectRoute;
    }


    public function store($request, $fileFieldName = null)
    {
        $data = $request->all();

        // Store file in cloud
        if ($request->hasFile($fileFieldName)) {
            $data[$fileFieldName] = FileUploadInCloud::uploadFile($request->file($fileFieldName), $fileFieldName);
        }

        $this->model->create($data);
        Session::flash('success', $this->type . ' Stored Successfully');

        return $this->redirectRoute ? redirect()->route($this->redirectRoute) : back();
    }

    public function destroy(Model $model, string $fileFieldName = null)
    {
        if ($fileFieldName) {
            $file = $model->{$fileFieldName};
            self::deleteOldFile($file);
        }
        $model->delete();

        Session::flash('danger', $this->type . ' Deleted Successfully');
        return $this->redirectRoute ? redirect()->route($this->redirectRoute) : back();
    }

    public function update($request, $model, $fileFieldName = null)
    {
        $data = $request->all();
        // Store file in cloud
        if ($request->hasFile($fileFieldName)) {
            $data[$fileFieldName] = FileUploadInCloud::uploadFile($request->file($fileFieldName), $fileFieldName);
            self::deleteOldFile($model->{$fileFieldName});
        }

        $model->update($data);
        Session::flash('success', $this->type . ' is successfully updated.');
        return $this->redirectRoute ? redirect()->route($this->redirectRoute) : back();
    }


    public function deleteOldFile($fileName)
    {
        if (Storage::disk('s3')->exists($fileName)) {
            Storage::disk('s3')->delete($fileName);
        }
    }
}
