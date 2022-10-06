<?php

namespace App\Http\Requests\User\Post;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'image_url' => 'required',
            'name'=>'required',
            'status'=>'required|integer',
            'description'=>'required',
            'detail'=>'required',
            'category_id'=>'required|integer',


        ];
    }
    public function messages()
    {
        return [
            'image_url.required' => 'Hình ảnh không được để trống',
            'name.required' => 'Tên không được để trống',
            'status.required' => 'Trạng thái không được để trống',
            'description.required' => 'Nội dung không được để trống',
            'detail.required' => 'Nội dung chi tiết không được để trống',
            'category_id.required' => 'Danh mục bài viết không được để trống',





        ];
    }

    protected function failedValidation(Validator $validator) {

        throw new HttpResponseException(\errorResponse(
            getFirstKeyValue($validator->errors()->messages())
        ));
}
}
