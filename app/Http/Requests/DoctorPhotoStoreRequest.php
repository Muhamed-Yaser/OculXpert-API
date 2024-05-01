<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorPhotoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
       // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                'doctor_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2500',
            ];
        } else {
            return [
                'doctor_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2500',
            ];
        }
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'doctor_photo.required' => 'Image is required!',
            ];
        }
    }
}
