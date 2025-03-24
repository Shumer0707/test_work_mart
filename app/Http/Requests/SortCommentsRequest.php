<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SortCommentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sort' => 'nullable|in:user,date,likes',
            'order' => 'nullable|in:asc,desc',
        ];
    }
    public function sortField(): string
    {
        return $this->input('sort', 'date'); // по умолчанию сортируем по дате
    }

    public function sortOrder(): string
    {
        return $this->input('order', 'desc'); // по умолчанию убывание
    }
    protected function prepareForValidation()
    {
        $allowed = ['sort', 'order', 'page'];

        $extra = collect($this->all())->keys()->diff($allowed);

        if ($extra->isNotEmpty()) {
            abort(response()->json([
                'message' => 'Недопустимые параметры запроса: ' . $extra->implode(', '),
                'errors' => [
                    'unexpected' => $extra->values()
                ]
            ], 422));
        }
    }
}
