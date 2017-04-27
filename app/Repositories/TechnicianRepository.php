<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use App\Models\Technician;
use DB;

class TechnicianRepository {
    private $common;
    private $techinician;
    
    public function __construct() {
        $this->common = app('App\Common\Common');
        $this->techinician = app('App\Models\Technician');
    }
    
    public function getList($id) {
        return DB::table('profiles')
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('technicians', 'technicians.user_id', '=', 'users.id')
            ->join('companies', 'companies.id', '=', 'technicians.company_id')
            ->select('profiles.fullname', 'profiles.phone', 'users.email', 'users.status', 'users.id', 'companies.id as company_id')
            ->where ('companies.user_id', $id)
            ->paginate(5);
    }
    
    public function listTechnicians($id) {
        $objs = DB::table('profiles')
            ->join('users', 'users.id', '=', 'profiles.user_id')
            ->join('technicians', 'technicians.user_id', '=', 'users.id')
            ->join('companies', 'companies.id', '=', 'technicians.company_id')
            ->select('profiles.fullname', 'profiles.phone', 'users.email', 'users.status', 'users.id', 'companies.id as company_id')
            ->where ('companies.user_id', $id)
            ->paginate(5);
        //dd($objs);
        return $objs->toJson();
    }
    
    public function saveTechnician($data) {
        $profile = new Profile;
        $user = new User;
        //$technician = new Technician;
        $is_owner = empty($data['is_owner']) ? 0 : 1;
        DB::beginTransaction();
        if(!empty($data['id'])) {
            $profile = Profile::find($data['id']);
            $user = User::find($data['id']);
            $technician = $this->techinician->find($data['id']);
            $profile->fullname = $data['fullname'];
            $profile->phone = $data['phone'];
            $user->email = $data['email'];
            $technician->is_owner = $is_owner;
            try {
                $profile->save();
                $user->save();
                $this->techinician->save();
                DB::commit();
                return true;
            } catch (Exception $e) {
                DB::rollback();
                return false;
            }
        }
        try {
            $result = $user->create([
                'email' => $data['fullname'],
                'password' => \Hash::make(str_random(9)),
                'status' => 'pending',
            ]);
            $profile->create([
                'user_id' => $result->id,
                'fullname' => $data['fullname'],
                'phone' => $data['phone']
            ]);
            $this->techinician->create([
                'user_id' => $result->id,
                'company_id' => $data['company'],
                'is_owner' => $is_owner
            ]);
            DB::commit();
            //send email......
            //$this->common->sendmail('emails.offer-notification', $data);
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
    
}