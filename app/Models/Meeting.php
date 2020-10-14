<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['time', 'title', 'description'];

    public function users(){
        return $this->belongsToMany('App\Models\User');
    }

}
