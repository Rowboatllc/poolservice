<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PageRequest extends FormRequest
{
    protected $redirect = 'admin/page';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias'    => 'Required',
            'title'    => 'Required|Min:3|Max:200',
            'content'    => 'Required|Min:3|Max:10000',
            'keywords'    => 'Required',
            'description'    => 'Required'
        ];
    }
    public function after($validator)
    {
        // $keywords = Request::input('keywords');
        // if (!isset($keywords[0])) {
        //     $validator->errors()->add('keywords', 'The keywords field is required.');
        // }
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator) {
            $this->after($validator);
        });
    }
}
