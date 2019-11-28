<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Accommodation extends Model  {

    protected $table = 'accommodations';

    protected $fillable = [
        'name', 'rating', 'category', 'location_id', 'images', 'reputation', 'reputations_badge', 'price', 'availability'
    ];

    public function location() {
        return $this->belongsTo('App\Location', 'location_id');
    }


}
