<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use DB;

class TechnicianRepository {
    private $common;
    private $techinician;
    
    public function __construct() {
        $this->common = app('App\Common\Common');
        $this->techinician = app('App\Models\Technician');
    }
    
    public function listBuilder($id) {
        return DB::table('profiles')
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('technicians', 'technicians.user_id', '=', 'users.id')
            ->join('companies', 'companies.id', '=', 'technicians.company_id')
            ->where('companies.user_id', $id)
            ->select('profiles.fullname', 'profiles.phone', 'profiles.avatar', 'users.email', 'users.status', 'users.id', 'companies.id as company_id', 'technicians.is_owner');
    }
    
    public function getList($id, $data=[]) {
        $list = $this->listBuilder($id);
        return $this->common->pagingSort($list, $data);
    }

    public function listTechnicians($id, $data) {
        $list = $this->listBuilder($id);
        return $this->common->pagingSort($list, $data)->toJson();
    }
    
    public function getTechnician($id, $data) {
        return $this->listBuilder($id)->where('technicians.user_id', $data['id'])->first();
    }
    
    public function saveTechnician($data) {
        $profile = new Profile;
        $user = new User;
        $is_owner = empty($data['is_owner']) ? 0 : 1;
        DB::beginTransaction();
        if(!empty($data['id'])) {
            $profile = Profile::find($data['id']);
            $user = User::find($data['id']);
            $technician = $this->techinician->find($data['id']);
            $profile->fullname = $data['fullname'];
            $profile->phone = $data['phone'];
            if(!empty($data['avatar'])){
                Storage::delete($profile->avatar);
                $profile->avatar = $data['avatar'];
            }
            $user->email = $data['email'];
            $technician->is_owner = $is_owner;
            try {
                $profile->save();
                $user->save();
                $technician->save();
                DB::commit();
                return true;
            } catch (Exception $e) {
                DB::rollback();
                return false;
            }
        }
        try {
            $code = str_random(30);
            $result = $user->create([
                'email' => $data['email'],
                'password' => \Hash::make(str_random(9)),
                'confirmation_code' => $code,
                'status' => 'pending',
            ]);
            
            $profileData = [
                'user_id' => $result->id,
                'fullname' => $data['fullname'],
                'phone' => $data['phone']
            ];
            if(!empty($data['avatar']))
                $profileData['avatar'] = $data['avatar'];
            $profile->create($profileData);
            
            $this->techinician->create([
                'user_id' => $result->id,
                'company_id' => $data['company_id'],
                'is_owner' => $is_owner
            ]);
            
            DB::commit();
            //Verify mail
            $data = [
                'email' => [$data['email']],
                'subject' => 'Verify email',
                'data' => [
                    'link' => route('technician-verify', $code)
                ]
            ];
            $this->common->sendmail('emails.technician-verify', $data);
            return true;
        } catch (Exception $e) { 
            DB::rollback();
            return false;
        }
    }
    
    public function removeTechnician($data) {
        $profile = new Profile;
        $user = new User;
        DB::beginTransaction();
        try {
            $this->techinician->find($data['id'])->delete();
            $profile->find($data['id'])->delete();
            $user->find($data['id'])->delete();
            DB::commit();
            return true;
        } catch (Exception $e) { 
            DB::rollback();
            return false;
        }
    }
    
     public function uploadAvatar($folder, $inputname) {
        $rename = date('YmdHis');
        return $this->common->uploadImage($folder, $inputname, $rename);
        /*if ($result)
            return $this->common->responseJson(true, 200, '', ['path' => $result]);
        return $this->common->responseJson(false);*/
    }
    
}