<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuarioUid',
        'input',
        'uid',
        'sanitizedInput',
        'results',
        'isSafe'
     ];

     protected $table = 'requests';
}
