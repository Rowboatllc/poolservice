<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Request;

class OptionController extends Controller {

    private $repo;

    public function __construct() {
        $this->repo = app('App\Repositories\OptionRepository');
    }

    public function create() {
        //$list = $this->repo->;
       // return view('admin.option')->with('options', $list);
    }
    
    public function index() {
        $options = $this->repo->getGroupOption(0);
        $options = collect($options)->map(function ($option) {
            $option['value'] = unserialize($option->value);
            $v = $option->getAttributes();
            $option['mykey'] = $v['key'];
            return $option;
        });
        //dd($options);
        return view('admin.options.optioncustom', compact(['options']));
    }
    
    public function listOption($group) {
        $options = $this->repo->getGroupOption($group);
        dd($options);
    }
    
    public function removeOption() {
        $key = Request::input('key');
        $result = $this->repo->deleteOption($key);
        return response()->json($result);
    }
    
    public function saveOption() {
        //$data = Request::all();
        $key = Request::input('option_key');
        $value = [
            'label' => Request::input('option_label'),
            'value' => Request::input('option_value')
        ];
        $group = Request::input('group');
        $result = $this->repo->createOrReplaceOption($key, $value, $group);
        return response()->json(['returnvalue'=>$result]);
    }
    
    public function saveGroup() {
        $key = Request::input('alias');
        $value = [
            'name' => Request::input('name')
        ];
        $group = Request::input('alias');
        $result = $this->repo->createOrReplaceOption($key, $value, $group);
        return response()->json(['returnvalue'=>$result]);
    }

}
