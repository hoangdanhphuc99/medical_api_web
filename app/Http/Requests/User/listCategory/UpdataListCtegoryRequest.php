<?php

namespace App\Http\Requests\User\listCategory;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdataListCtegoryRequest extends FormRequest
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
            'title' => 'required',
            'description'=>'required',


        ];
    }
    public function messages()
    {
        return [

            'title.required' => 'Tiêu đề không được để trống',
            'description.required' => 'Nội dung được để trống',
        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(\errorResponse(
            getFirstKeyValue($validator->errors()->messages())
        ));
}
}
