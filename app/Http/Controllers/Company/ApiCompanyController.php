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

    /*public function acceptOffer(Request $request) {
        return $this->common->responseJson($this->company->changeOfferStatus($request->all()));
    }
    
    public function denyOffer(Request $request) {
        return $this->common->responseJson($this->company->changeOfferStatus($request->all()));
    }*/
    
    public function changeOfferStatus(Request $request) {
        return $this->common->responseJson($this->company->changeOfferStatus($request->all()));
    }
    
    
    public function listTechnician(Request $request) {
        $technicianRepo = new \App\Repositories\TechnicianRepository;
        $user = Auth::user();
        $result = $technicianRepo->listTechnicians($user->id, $request->all());
        if ($result)
            return $this->common->responseJson(true, 200, '', ['list' => $result]);
        return $this->common->responseJson(false);
        //return $this->common->responseJson(true, 200, '', ['path' => $result]);
        //return $this->common->responseJson($technicianRepo->listTechnicians($user->id));
    }
    
    public function saveTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        return $this->common->responseJson($repoTech->saveTechnician($request->all()));
    }
    
    public function removeTechnician(Request $request) {
        $repoTech = new TechnicianRepository;
        return $this->common->responseJson($repoTech->removeTechnician($request->all()));
    }
    
    public function changeServiceOffer(Request $request) {
        return $this->common->responseJson($this->company->changeServiceOffer($request->all()));
    }
}
