<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // dd(explode('/',request()->requestUri)[2]);
        $request = request();
        return [
            'name'       => 'required|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'book'       => Rule::requiredIf(function () use ($request) {
                $data = explode('/',$request->requestUri);
                $ok = end($data) > 0;
                return !$ok;
            }),
        ];
    }
}
