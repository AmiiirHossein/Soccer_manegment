<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;

class UploadHelper
{


    public static function upload($f, $file, $name, $target_location)
    {
        if (Request::hasFile($f)) {
            $filename = $name . '.' . $file->getClientOriginalExtension();
            $extension = $file->getClientOriginalExtension();
            $file->move($target_location, $filename);
            return $filename;
        } else {
            return null;
        }
    }



    public static function update($f, $file, $name, $target_location, $old_location)
    {
        //delete the old file
        $target_location = $target_location . '/';
        if (File::exists($target_location . $old_location)) {
            File::delete($target_location . $old_location);
        }

        $filename = $name . '.' . $file->getClientOriginalExtension();
        $file->move($target_location, $filename);
        return $filename;
    }


    public static function deleteFile($location)
    {
        if (File::exists($location)) {
            File::delete($location);
        }
    }
}
