<?php

namespace App\Http\Requests\Admin\Login;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginAdminRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|max:255|min:6',
            'phone_number' => 'required|max:10|min:10',
        ];
    }
    public function messages()
    {
        return [

            'password.required' => 'mật khẩu không được để trống',
            'password.min' => 'mật khẩu phải dài hơn 6 kí tự',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.min' => 'Số điện thoại phải đủ 10 số',
            'phone_number.max' => 'Số điện thoại chỉ có 10 số',

        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(\errorResponse(
            getFirstKeyValue($validator->errors()->messages())
        ));
}
}
