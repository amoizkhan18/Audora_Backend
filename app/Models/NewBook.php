<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewBook extends Model
{
    protected $table = 'Sheet1';

    protected $fillable = [
        'bookid' , 'title', 'author', 'bookdesc', 'imageurl',
        'audiolinks', 'bookurl', 'genres'
    ];
}
