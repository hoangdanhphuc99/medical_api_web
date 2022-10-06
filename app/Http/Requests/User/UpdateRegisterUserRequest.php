<?php

namespace App\Http\Requests\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegisterUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'phone_number' => 'required|max:11|min:10|unique:users,phone_number,'.$this->id,
            'email' => 'unique:users,email,'.$this->id,

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.min' => 'Số điện thoại không đúng định dạng',
            'phone_number.unique' => 'Số điện thoại đã có trong cơ sở dữ liệu',
            'phone_number.max' => 'Số điện thoại không đúng định dạng',
            'email.required' => 'email không được để trống',
            'email.email' => 'phải là một địa chỉ email hợp lệ',
            'email.unique' => 'Email đã có trong cơ sở dữ liệu',

        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(\errorResponse(
            getFirstKeyValue($validator->errors()->messages())
        ));
}
}
