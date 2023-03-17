<?php

namespace App\Http\Controllers;

use App\Events\MediaFileDeleted;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    private $storage_path;
    private $path;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storage_path = public_path('uploads/');
        $this->path = 'uploads/';
    }

    public function index()
    {
        $chk = Media::whereUser_Id(auth()->id())->count();
        if ($chk > 0) {
            $media = Media::whereUser_Id(auth()->id())->paginate(5);
            return $this->statusCode(200, 'Record available', ['media' => $media]);
        } else {
            return $this->statusCode(404, "No record available");
        }
    }

    public function create(Request $request)
    {

        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'max:50'],
                    'media' => ['required', 'max:20480'], //not more than 20mb
                ]
            );

            if ($validate->fails()) {
                return $this->statusCode(403, "Error in input field(s)", ['error' => $validate->errors()]);
            }

            $file = $request->file('media');
             // validate files
                // check if file is within acceptable formats
                $acceptTypes = ['pdf', 'doc', 'docx'];
                $file_type = $file->getClientOriginalExtension();
                $hasMatch = false;

                // check if extension match type
                foreach ($acceptTypes as $types) {
                    (strtolower($types) == strtolower($file_type)) ? $hasMatch = true : '';
                }
                if (!$hasMatch) {
                    return $this->statusCode(400, 'Invalid file type. Acceptable types are [' . implode(', ', $acceptTypes) . ']');
                }
            // remove all whitespaces from filename
            $strip = preg_replace('/\s+/', '', $file->getClientOriginalName());
            $file_name = time() . '_' . $strip;
            $file->move($this->storage_path . auth()->id() . '/', $file_name);
            $this->path .= auth()->id() . '/' . $file_name;

            $media = new Media();
            $media->user_id = auth()->id();
            $media->name = trim(ucwords(strtolower($request->name)));
            $media->doc = $this->path;
            return $media->save() ? $this->statusCode(200, 'Media saved', ['media' => $media]) : $this->statusCode(500, 'error occured');
        } catch (\Throwable $e) {
            return $this->statusCode(500, $e->getMessage());
        }
    }

    public function delete(Media $media)
    {
        if ($media) {
            if ($media->delete()) {
                unlink(public_path($media->doc));
                return  $this->statusCode(200, 'File deleted successfully.');
            }
            return $this->statusCode(500, "Error occured whiles processing your request");
        }
        $this->statusCode(404, 'Record unavailable');
    }

    public function update(Media $media, Request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'max:50'],
                ]
            );

            if ($validate->fails()) {
                return $this->statusCode(403, "Error in input field(s)", ['error' => $validate->errors()]);
            }

            $media->update(['name' => trim(ucwords(strtolower($request->name)))]);
            return $this->statusCode(200, 'record updated successfully', ['media' => $media]);
        } catch (\Throwable $e) {
            return $this->statusCode(500, $e->getMessage());
        }
    }
}
