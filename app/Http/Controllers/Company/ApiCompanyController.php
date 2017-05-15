<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\TechnicianRepository;
use Auth;

class ApiCompanyController extends Controller {

    private $company;
    private $common;

    public function __construct(CompanyRepositoryInterface $company) 
    {
        $this->company = $company;
        $this->common = app('App\Common\Common');
    }

    public function acceptDenyOffer(Request $request) {
        return $this->common->responseJson($this->company->acceptDenyOffer($request->all()));
    }
    /*
    public function changeOfferStatus(Request $request) {
        return $this->common->responseJson($this->company->changeOfferStatus($request->all()));
    }*/
    
    public function listTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        $user = Auth::user();
        $result = $repoTech->listTechnicians($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['list' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function getTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        $user = Auth::user();
        $result = $repoTech->getTechnician($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['item' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function saveTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        return $this->common->responseJson($repoTech->saveTechnician($request->all()));
    }
    
    public function removeTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        return $this->common->responseJson($repoTech->removeTechnician($request->all()));
    }
    
    public function listCustomers(Request $request) {
        $user = Auth::user();
        $result = $this->company->listCustomers($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['list' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function uploadAvatar($folder, $name) {
        $repoTech = new TechnicianRepository;
        $result = $repoTech->uploadAvatar($folder, $name);
        if ($result)
            return $this->common->responseJson(true, 200, '', ['path' => $result]);
        return $this->common->responseJson(false);
    }
    
    public function changeServiceOffer(Request $request) {
        return $this->common->responseJson($this->company->changeServiceOffer($request->all()));
    }
}
