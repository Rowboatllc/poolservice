<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class TechnicianRequest extends FormRequest
{
    // protected $redirect = '/create/password/';

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
    public function rules(Request $request)
    {
        $confirmCode = $request->input('confirmCode');
        if(isset($token)){
            $this->redirect =   '/technician/verify/'.$confirmCode;
        }
        return [
            '_token' => 'required',
            'email'    => 'Required|Between:3,64|Email',
            'password'  => 'Required|AlphaNum|Between:4,8|Confirmed',
            'password_confirmation'=> 'Required|AlphaNum|Between:4,8'
        ];
    }

}
