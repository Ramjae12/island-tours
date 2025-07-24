<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SecureFileController extends Controller
{
    public function download($fileName)
    {
        $filePath = "ids/{$fileName}";
        if (!Storage::disk('secure_ids')->exists($filePath)) {
            abort(404);
        }
        $mime = Storage::disk('secure_ids')->mimeType($filePath);
        return Storage::disk('secure_ids')->response($filePath, $fileName, [
            'Content-Type' => $mime,
        ]);
    }
}
