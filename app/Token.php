<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Token extends Model
{
    protected $table = 'token';
    protected $fillable = ['token', 'user_id'];
    protected $hidden = ['updated_at', 'created_at'];

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
