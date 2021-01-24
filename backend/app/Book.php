<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['item_name', 'item_number', 'item_amount', 'published', 'alphabet_title', 'isbn'];
    // protected $guarded = [];
    // protected $guarded = ['id'];
    // protected $guarded = ['id','created_at','updated_at'];
    protected $appends = ['total_price', 'isbn13'];

    protected $casts = [
        'published' => 'date',
    ];


    public function getTotalPriceAttribute()
    {
        return $this->item_number * $this->item_amount;
    }

    public function getIsbn13Attribute()
    {
        $char = str_split($this->isbn);
        $char_out = array();
        $j = 0;
        for ($i = 0; $i < sizeof($char); $i++) {
            if (is_numeric($char[$i]) || $char[$i] === 'x' || $char[$i] === 'X') {
                $char_out[$j] = $char[$i];
                $j = $j + 1;
            }
        }

        $sum = 0;
        for ($j = 0; $j < 9; $j = $j + 2) $sum = $sum + (int)$char_out[$j];
        $sum = 3 * ($sum + 7)  + 17;
        for ($j = 1; $j < 9; $j = $j + 2) $sum = $sum + (int)$char_out[$j];
        $amari = $sum % 10;
        $digit = 10 - $amari;

        $isbn13 = "978";
        for ($i = 0; $i < 9; $i++) $isbn13 = $isbn13 . $char_out[$i];
        if ($digit === 10) $digit = 0;
        $isbn13 = $isbn13 . (string)$digit;

        return $isbn13;
    }

    public function setIsbnAttribute($isbn)
    {
        if (strlen($isbn) === 10) {
            $this->attributes['isbn'] = $isbn;
        } else {
            $char = str_split($isbn);
            $char_out = array();
            $j = 0;
            for ($i = 0; $i < sizeof($char); $i++) {
                if (is_numeric($char[$i])) {
                    $char_out[$j] = $char[$i];
                    $j = $j + 1;
                }
            }

            if ($j === 10) for ($i = 0; $i < 10; $i++) $char_isbn[$i] = $char_out[$i];
            else {
                $j   = 0;
                $sum = 0;
                for ($i = 3; $i < 12; $i++) {
                    $char_isbn[$j] = $char_out[$i];
                    $sum = (10 - $j) * (int)$char_isbn[$j] + $sum;
                    $j = $j + 1;
                }
                $amari = $sum % 11;
                $digit = 11 - $amari;
                if ($digit == 10) $char_isbn[$j] = 'X';
                else if ($digit == 11) $char_isbn[$j] = '0';
                else $char_isbn[$j] = (string)$digit;
            }

            $isbn10 = $char_isbn[0];
            for ($i = 1; $i < 10; $i++) $isbn10 = $isbn10 . $char_isbn[$i];

            $this->attributes['isbn'] = $isbn10;
        }
    }

    public function comments()
    {
        return $this->hasMany('App\BookComment');
    }
}
