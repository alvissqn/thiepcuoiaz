<?php

namespace App\Http\Requests\admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /*
     * Check các điều kiện khác, return false để từ chối
     */
    public function authorize()
    {
        return true;
    }

    /*
     * Kiểm tra dữ liệu
     */
    public function rules()
    {
        return [
            'name'        => [
                'required',
                'max:50',
            ],
            'color'        => [
                'required',
                'max:10',
            ]
        ];
    }

    /*
     * Trả về thông báo
     */
    public function messages()
    {
        return [
            '*.*'                 => __('admin/permission.data_is_incorrect'),
        ];
    }

    /*
     * Trả về dữ liệu JSON
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors], 200)
        );
    }
}