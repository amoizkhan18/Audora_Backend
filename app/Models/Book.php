<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'mytable'; // 👈 change this to match your real table name

    protected $fillable = [
        'title',
        'author',
        'bookdesc',
        'extra',
        'extraa',
        'downurl',
        'genres',
        'imageurl',
        'bookurl',
    ];
}
