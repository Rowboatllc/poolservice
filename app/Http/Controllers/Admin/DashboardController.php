<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\OptionRepositoryInterface;
use App\Http\Requests\OptionRequest;
use App\Http\Controllers\Controller;
use App\Repositories\OptionRepository;

class DashboardController extends Controller {

    protected $option;

    public function __construct(OptionRepositoryInterface $option) {
        $this->option = $option;
    }

    public function index() {
        
        $block_contact_left = $this->option->getOption(config('app.key_block_contact_left'));

        $optionRepo = new OptionRepository;
        $options = $optionRepo->getGroupOption('asdf');
        for ($i = 0; $i < count($options); $i++) {
            $a = $options[$i]->getAttributes();
            //echo $a['key'];
        }
        $options = collect($options)->map(function ($option) {
            $aa = $option->getAttributes();
            $option['mykey'] = $aa['key'];
            $aaa = unserialize('s:48:"a:2:{s:5:"label";s:3:"xxx";s:5:"value";s:1:"x";}";');
            var_dump($aaa);
            $option['xvalue'] = $aaa;
            return $option;
        });
        return view('admin.admin', compact(['block_contact_left', 'options']));
    }

    public function contact(OptionRequest $request) {
        $result = $this->option->createOrReplaceOption(config('app.key_block_contact_left'), $request->all());
        $my_errors = ['page' => 'contact', 'contact' => 'bloc_contact_left'];
        if ($result)
            return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors($my_errors)
                            ->with('success', true);

        return redirect()->back()
                        ->withInput($request->all())
                        ->withErrors($my_errors)
                        ->with('error', true);
    }

}
