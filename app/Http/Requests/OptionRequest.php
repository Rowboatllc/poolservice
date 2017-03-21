<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
{
     protected $redirect = 'manager';
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
            'contact_title'    => 'Required|Min:3|Max:100',
            'contact_description'    => 'Required|Min:3|Max:1000',
            'call_title'    => 'Required|Min:3|Max:100',
            'call_number'    => 'Required|Min:8|Max:15',
            'email_title'    => 'Required|Min:3|Max:100',
            'email_address'    => 'Required|email',
            
        ];
    }
}
