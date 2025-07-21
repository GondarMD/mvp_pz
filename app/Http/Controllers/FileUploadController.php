<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{

    /**
     * Handle the file upload request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store the file
        $path = $request->file('file')->store('', 'uploads');

        // Return a response
        return back()->with([
            'file_uploaded' => true,
            'file_path' => Storage::url($path),
            'file_name' => basename($path),
        ]);
    }
}
