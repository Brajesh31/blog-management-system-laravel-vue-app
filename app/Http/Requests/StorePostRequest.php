<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // <-- Import Rule


class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         // return true; // Or more specific authorization if needed
         return Auth::check(); // Checks if a user is logged in
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
             // Make content required only if publishing, handled by backend logic or can be optional here
            'content' => ['nullable', 'string'],
            // 'image' => ['nullable', 'image', 'max:2048'], // Optional image upload, max 2MB
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], // max:2048 = 2MB
            'visibility' => ['required', 'string', Rule::in(['draft', 'published'])], // <-- Added validation rule
        ];

          // 'tags' => ['nullable', 'array'], // Example if you add tag handling later
            // 'tags.*' => ['string', 'max:50']
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The post title is too long (maximum 255 characters).',
            'content.required' => 'Post content cannot be empty',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image may not be greater than 2MB.',
            'visibility.required' => 'The visibility status (draft/published) is missing.',
            'visibility.in' => 'Invalid visibility status selected.',
            // Add more custom messages as needed
        ];
    }
}
