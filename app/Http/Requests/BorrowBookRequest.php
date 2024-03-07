<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BorrowBookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['required', Rule::exists(Client::class, 'id')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
