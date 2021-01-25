<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules()
    {
        return [
            'item_name' => 'required|string|min:3|max:255',
            'item_number' => 'required|integer|min:1|max:100',
            'item_amount' => 'required|integer|min:100|max:100000',
            'published' => 'required|date|before_or_equal:' . Carbon::today(),
            'item_img' => 'file|image|dimensions:min_width=100,min_height=100',
        ];
    }
}
