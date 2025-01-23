<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

class MediaUploadService
{
    public function uploadMedia($files, $model, $path_file_name, $info = null)
    {
        // Ensure $files is an array for handling multiple files or single file.
        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            $now = \Carbon\Carbon::now();
            $randomString = \Str::random(10);
            $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();

            // Move file to the appropriate directory
              $file->move(base_path('files/' . $path_file_name), $filename);

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
