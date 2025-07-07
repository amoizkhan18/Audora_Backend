<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiobook extends Model
{
    use HasFactory;

    protected $table = 'audiobooks';
    public $timestamps = false; 


    protected $fillable = [
        'title',
        'author',
        'imageurl',
        'extra',
        'genres',
        'bookdesc',
        'bookurl',
        'audiolinks',
    ];
}
