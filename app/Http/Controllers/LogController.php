<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LogController extends Controller
{
    public function downloadLog(): BinaryFileResponse
    {
        $filePath = storage_path('logs/laravel.log');

        if (!file_exists($filePath)) {
            abort(404, 'Log file does not exist.');
        }

        return response()->download($filePath);
    }
}
