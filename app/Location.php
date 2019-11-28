<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Location extends Model  {

    protected $table = 'locations';

    protected $fillable = [
        'city', 'state', 'country', 'zip_code', 'address'
    ];



}
