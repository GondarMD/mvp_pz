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

        $url = 'uploads/' . $path;
        $flash_message = asset($url);

        // Flash data to the session
        $request->session()->flash('flash_message', $flash_message);
        $request->session()->flash('file_uploaded', true);
        $request->session()->flash('file_upload', Storage::url($path));
        $request->session()->flash('file_name', basename($path));
        

        // Return a response
        return back()->with([       
            'status' => 'success',
            'data' => [
                'file_name' => basename($path),
                'file_path' => Storage::url($path),
            ]   
        ]);
    }
}
