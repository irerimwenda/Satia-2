<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['user_id', 'link_type', 'link'];

    public $with = ['user'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
