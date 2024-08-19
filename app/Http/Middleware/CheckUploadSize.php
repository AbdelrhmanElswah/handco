<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUploadSize
{
    public function handle(Request $request, Closure $next)
    {
        // Get the maximum file size allowed by the PHP configuration
        $maxSize = $this->getMaxUploadSize();

        // Check if the Content-Length exceeds the max upload size
        if ($request->server('CONTENT_LENGTH') > $maxSize) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'The uploaded file exceeds the maximum allowed size of ' . $this->formatSize($maxSize) . '.');
        }

        return $next($request);
    }

    private function getMaxUploadSize()
    {
        $postMaxSize = $this->parseSize(ini_get('post_max_size'));
        $uploadMaxSize = $this->parseSize(ini_get('upload_max_filesize'));

        return min($postMaxSize, $uploadMaxSize);
    }

    private function parseSize($size)
    {
        $unit = strtoupper(substr($size, -1));
        $size = (int) $size;

        switch ($unit) {
            case 'G':
                $size *= 1024;
            case 'M':
                $size *= 1024;
            case 'K':
                $size *= 1024;
        }

        return $size;
    }

    private function formatSize($size)
    {
        if ($size >= 1073741824) {
            return number_format($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        } else {
            return $size . ' bytes';
        }
    }
}
