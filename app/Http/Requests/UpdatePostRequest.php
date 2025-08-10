<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // We'll use Laravel's Authorization gates/policies here
        // For a simple check, we can verify the post belongs to the user
        return $this->user()->id === $this->route('post')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'sometimes' ensures we only validate the field if it's present
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'user_id' => ['sometimes', 'required', 'exists:users,id'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:posts,slug,' . $this->route('post')->id],
            'status' => ['sometimes', 'required', 'in:draft,published'],
            'image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
        ];
    }
}
