<?php

namespace App\Common;

use Illuminate\Support\Facades\Storage;
use Request;
use Auth;
use Mail;

class Common {

    public function __construct() {
        
    }

    public function getEloquentById($eloquent, $id) {
        $result = $eloquent->find($id);
        return $result ? $eloquent->find($id) : $this->getDefaultEloquentAttibutes($eloquent);
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

    public function verifyEmail($info) {
        Mail::send('emails.verifytpl', ['confirmation_code' => $info['code'], 'email' => $info['email']], function($message)
                use ($info) {
            $message->subject('Authentication your new account');
            $message->to($info['email']);
        });   
    }
    
    public function checkValidZipcode($code) {
        return $code;
    }
    
    public function getSupportedStates() {
        return [];
    }

}
