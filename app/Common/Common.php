<?php

namespace App\Common;

use Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class Common {

    public function __construct() {
        
    }

    public function getEloquentById($eloquent, $id) {
        $result = $eloquent->find($id);
        return $result ? $eloquent->find($id) : $this->getDefaultEloquenAttibutes($eloquent);
    }

    public function getDefaultEloquentAttibutes($eloquent) {
        $arr = $eloquent->getFillable();
        foreach ($arr as $item) {
            $eloquent->setAttribute($item, '');
        }
        return $eloquent;
    }

    public function uploadResizeImage($imageFolder) {
        //$imageFolder = 'uploads/profile';
        $file = Request::file('avatar');
        $extension = $file->extension();
        $user = Auth::user();
        $image_name = md5($user->email) . '.' . $extension;
        $filename = $imageFolder . '/' . $image_name;

        if (!($file->isValid()) || $extension == 'exe' || !in_array($extension, ['jpg', 'png', 'jpeg'])) {
            return false;
        }

        //resize
        //$result = Image::make($avatarFolder.'/'.$image_name)->resize(100, 100)->save($avatarFolder.'/'.$image_name);
        try {
            if (Storage::exists($filename))
                Storage::delete($filename);
            $result = Storage::putFileAs($imageFolder, $file, $image_name);
            return $filename;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getListZipCode() {
        return [
            111,
            70000
        ];
    }

}
