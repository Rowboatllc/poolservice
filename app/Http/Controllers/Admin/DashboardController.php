<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\OptionRepositoryInterface;
use App\Http\Requests\OptionRequest;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {

    protected $option;

    public function __construct(OptionRepositoryInterface $option) {
        $this->option = $option;
    }

    public function index() {
        $block_contact_left = $this->option->getOption(config('app.key_block_contact_left'));
        return view('admin.option', compact('block_contact_left'));
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
