<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // da definire in un secondo momento, quando nella funzione store() usiamo fill()
    protected $fillable = ['ISBN', 'title', 'author', 'pages', 'price', 'thumb', 'year', 'soldout'];
}
