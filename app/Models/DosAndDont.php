<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosAndDont extends Model
{
    protected $table = 'dos_and_donts';

    protected $fillable = [
        'category',
        'type',
        'title',
        'description',
        'tip_or_consequence',
        'icon',
        'sort_order',
    ];
}

