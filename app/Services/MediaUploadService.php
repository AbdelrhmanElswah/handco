<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MediaUploadService
{
    public function uploadMedia($files, $model, $path_file_name, $info = null)
    {
        // Ensure $files is an array for handling multiple files or single file.
        $files = is_array($files) ? $files : [$files];

        // Check if we should use local storage
        // Use local only if: environment is 'local' OR S3 is not configured (no key or no URL)
        $s3Key = config('filesystems.disks.s3.key');
        $s3Url = config('filesystems.disks.s3.url');
        $isLocal = app()->environment('local') || !$s3Key || !$s3Url;

        foreach ($files as $file) {
            $now = Carbon::now();
            $randomString = Str::random(10);
            $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();

            if ($isLocal) {
                // Upload to local storage (public/files/)
                try {
                    // Ensure directory exists
                    $uploadPath = public_path('files/' . $path_file_name);
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }

                    // Move file to public directory
                    $file->move($uploadPath, $filename);
                } catch (\Exception $e) {
                    Log::error('Local Upload Error: ' . $e->getMessage(), [
                        'path' => $uploadPath,
                        'filename' => $filename,
                    ]);
                    throw $e;
                }
            } else {
                // Upload to S3 (production)
                $s3Path = 'handco/' . $path_file_name . '/' . $filename;

                try {
                    // Read file content and upload to S3
                    $fileContents = file_get_contents($file->getRealPath());

                    if ($fileContents === false) {
                        throw new \Exception('Failed to read file contents');
                    }

                    // Upload to S3 with public visibility using options
                    $uploaded = Storage::disk('s3')->put($s3Path, $fileContents, [
                        'visibility' => 'public',
                        'ContentType' => $file->getMimeType(),
                    ]);

                    if (!$uploaded) {
                        throw new \Exception('Failed to upload file to S3');
                    }
                } catch (\Exception $e) {
                    Log::error('S3 Upload Error: ' . $e->getMessage(), [
                        'path' => $s3Path,
                        'filename' => $filename,
                    ]);
                    throw $e;
                }
            }

            // Use the appropriate relationship based on 'info' parameter
            if ($info === 'main') {
                // For main image, use the 'mainImage' relationship
                $model->mainImage()->create([
                    'media' => $filename,
                    'info' => $info,
                    'path_file_name' => $path_file_name,
                ]);
            } else {
                // For additional images, use the 'images' relationship
                $model->images()->create([
                    'media' => $filename,
                    'info' => $info,
                    'path_file_name' => $path_file_name,
                ]);
            }
        }

        return true;
    }


    public function editMedia($files, $model, $info = null, $path_file_name = 'media/')
    {
        foreach ($files as $file) {
            $now = Carbon::now();
            $randomString = Str::random(10);
            $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('files/' . $path_file_name), $filename);

            // Fetch the existing media record (assuming there's only one per model)
            $mediaRecord = $model->media()->first();

            if ($mediaRecord) {
                // Delete the old file
                if (file_exists(public_path('files/' . $path_file_name . $mediaRecord->media))) {
                    unlink(public_path('files/' . $path_file_name . $mediaRecord->media));
                }

                // Update the existing record
                $mediaRecord->update([
                    'media' => $filename,
                    'info' => $info,
                    'path_file_name' => $path_file_name,
                ]);
            } else {
                // Create a new record if none exists
                $model->media()->create([
                    'media' => $filename,
                    'info' => $info,
                    'path_file_name' => $path_file_name,
                ]);
            }
        }

        return true;
    }


    public function deleteMedia($images, $model, $publicPath = '/media/')
    {

        $mediaQuery = ($images === null)
            ? $model->media()
            : $model->media()->whereIn('id', $images);

        $mediaItems = $mediaQuery->get();

        foreach ($mediaItems as $image) {
            if (file_exists(public_path($publicPath.$image->media))) {
                unlink(public_path($publicPath.$image->media));
            }
            $image->delete();
        }
    }
}
