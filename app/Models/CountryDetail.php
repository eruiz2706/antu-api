<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryDetail extends Model
{
    protected $table = 'country_detail';

    protected $fillable = [
        'code','name','capital_city','phone_code','continent_code','currency_code','flag','languaje'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
