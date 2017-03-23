<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OptionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OptionRequest;
use Illuminate\Support\MessageBag;

class ManagerController extends Controller
{
    //
    protected $option;

    public function __construct(OptionRepositoryInterface $option)
    {
        $this->option=$option;
    }

    public function index(){
        $block_contact_left = $this->option->getOption(config('app.key_block_contact_left'));
        return view('admin.manager', compact('block_contact_left'));
        
    }

    public function contact(OptionRequest $request){
        $val = $this->option->createOrReplaceOption(config('app.key_block_contact_left'),$request->all());
        $my_errors = ['page'=>'contact','contact'=>'bloc_contact_left'];
        if($val)
            return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($my_errors)
                        ->with('success', true);

        return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($my_errors)
                        ->with('error', false);
    }
}