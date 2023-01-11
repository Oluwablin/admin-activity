<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ActivityFormRequest extends FormRequest
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
        $rule = request()->is('*/v1/admin/activities/*') ? 'sometimes' : 'required';

        return [
            'title' => [$rule, 'string', 'max:250'],
            'description' => ['nullable', 'string', 'max:250'],
            'user_id' => ['sometimes', 'numeric',
                function ($attribute, $value, $fail) {
                    if (!User::find($value) instanceof User) {
                        $fail('User not found.');
                    }
                }
            ],
            'images' => ['sometimes', 'min:1', 'max:1'],
            'images.*' => ['sometimes', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:1024']
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Please give the activity a title',
            'title.max' => 'Activity title must not exceed 250 characters',
            'description.max' => 'Activity description must not exceed 250 characters',
            'user_id.numeric' => 'User ID must be ID of the user the activity belongs to',
            'images.min' => 'Please add at aleast one image.',
            'images.max' => 'You can only upload one image at a time.',
            'images.*.image' => 'Please upload a valid image file.',
            'images.*.mimes' => 'Please upload a valid image file e.g. .jpg, .png, .jpeg, .gif, .svg',
            'images.*.max' => 'Image file must not exceed 1mb file size.'
        ];
    }
}
