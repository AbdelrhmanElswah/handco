<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

class MediaUploadService
{
    public function uploadMedia($files, $model, $path_file_name,$info = null)
    {

        foreach ($files as $file) {
            $now = Carbon::now();
            $randomString = Str::random(10);
            $filename = $now->format('Ymdh').'_'.$randomString.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('files/'.$path_file_name), $filename);
            $model->media()->create([
                'media' => $filename,
                'info'=>$info,
                'path_file_name' => $path_file_name,
            ]);
        }

        return true;
    }

    public function editMedia($files, $model, $info = null, $path_file_name = 'media/')
    {
        // Loop through each file
        foreach ($files as $file) {
            // Generate a new filename
            $now = Carbon::now();
            $randomString = Str::random(10);
            $filename = $now->format('Ymdh') . '_' . $randomString . '.' . $file->getClientOriginalExtension();
            
            // Move the new file to the public path
            $file->move(public_path('files/' . $path_file_name), $filename);
            
            // Find the media record associated with the file
            $mediaRecord = $model->media()->where('media', $file->getClientOriginalName())->first();
            
            if ($mediaRecord) {
                // Delete the old file if it exists
                if (file_exists(public_path('files/' . $path_file_name . $mediaRecord->media))) {
                    unlink(public_path('files/' . $path_file_name . $mediaRecord->media));
                }
                
                // Update the media record
                $mediaRecord->update([
                    'media' => $filename,
                    'info' => $info,
                    'path_file_name' => $path_file_name,
                ]);
            } else {
                // If no media record is found, create a new one
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
