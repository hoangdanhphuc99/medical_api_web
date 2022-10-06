<?php

namespace App\Http\Requests\User\UserTest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTestRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'result_0'=>'required',
            'result_1'=>'required',
            'result_2'=>'required',

        ];
    }
    public function messages()
    {
        return [

            'user_id.required' => 'Bệnh nhân không được để trống',
            'result_0.required' => 'Xét nghiệm miễn dịch không được để trống',
            'result_1.required' => 'Xét nghiệm bệnh lý, ung thư không được để trống',
            'result_2.required' => 'Xét nghiệm khác không được để trống',






        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(\errorResponse(
            getFirstKeyValue($validator->errors()->messages())
        ));
}
}
