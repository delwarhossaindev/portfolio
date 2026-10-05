<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Trim whitespace so "   " can't pass as a name or message. */
    protected function prepareForValidation(): void
    {
        $this->merge(collect($this->only(['name', 'email', 'subject', 'message']))
            ->map(fn ($value) => is_string($value) ? trim($value) : $value)
            ->all());
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email:rfc|max:255',
            'subject' => 'required|string|min:3|max:150',
            'message' => 'required|string|min:10|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell me your name.',
            'email.required' => 'I need an email address to reply to.',
            'email.email' => 'That email address doesn\'t look right.',
            'subject.required' => 'Please add a short subject.',
            'message.required' => 'Please write a message.',
            'message.min' => 'Your message is a little short — could you add a bit more detail?',
        ];
    }
}
