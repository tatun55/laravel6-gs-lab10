<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules()
    {
        //共通のルール
        $rules = [
            'item_number' => 'required|integer|min:1|max:100',
            'alphabet_title' => 'required|string|min:3|max:255|alpha_dash',
            'katakana_title' => 'required|string|min:3|max:255|katakana',
            'item_amount' => 'required|integer|min:100|max:100000',
            'published' => 'required|date|before_or_equal:' . Carbon::today(),
        ];

        $route = $this->route()->getName();
        switch ($route) {
            case 'books.store':
                // 新規登録独自のルール
                $storeRules = [
                    'item_name' => 'required|string|min:3|max:255|unique:books',
                    'item_img' => 'file|image|dimensions:min_width=100,min_height=100',
                ];
                // 共通のルールと独自ルールをマージ
                $rules = array_merge($rules, $storeRules);
                break;
            case 'books.update':
                // 編集独自のルール
                $updateRules = [
                    'item_name' => 'required|string|min:3|max:255|unique:books,item_name,' . $this->id, // 今回は$this->idでIDを取得できるが違うことが多い
                    'item_img' => 'file|image|dimensions:min_width=100,min_height=100',
                ];
                // 共通のルールと独自ルールをマージ
                $rules = array_merge($rules, $updateRules);
                break;
        }

        return $rules;
    }
}
