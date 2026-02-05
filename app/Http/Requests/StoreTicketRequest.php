<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest {
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array 
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'topic' => ['required', 'string'],
            'phone_number' => ['required', 'phone:INTERNATIONAL,KZ,RU'],
            'body' => ['required', 'string'],

            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx',
                'max:5120'
            ],
        ];
    }
}