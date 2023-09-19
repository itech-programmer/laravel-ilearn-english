<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FileUploadService
{

    public function image_store($request, $input_name, $data, $path_name)
    {
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $file_path = 'public/uploads/' . $path_name . '/';
            if (!file_exists($data->image)){
                $image = Image::make($file)
                    ->insert($file)
                    ->resize(512, 512, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $name = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
                $image->save($file_path . $name);
                $image_save = $file_path . $name;
                $data->image = $image_save;
            }
        }
    }

    public function image_update($request, $input_name, $data, $path_name)
    {
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $file_path = 'public/uploads/' . $path_name . '/';
            if (file_exists($data->image)){
                $image = Image::make($file)
                    ->insert($file)
                    ->resize(512, 512, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $name = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
                if (file_exists($data->image)) {
                    File::delete($data->image);
                }
                $image->save($file_path . $name);
                $image_save = $file_path . $name;
                $data->image = $image_save;
            }else{
                $image = Image::make($file)
                    ->insert($file)
                    ->resize(512, 512, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                $name = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
                $image->save($file_path . $name);
                $image_save = $file_path . $name;
                $data->image = $image_save;
            }
        }
    }
}
