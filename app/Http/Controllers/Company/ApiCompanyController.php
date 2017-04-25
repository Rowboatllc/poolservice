<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepositoryInterface;

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
    
}
