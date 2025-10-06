<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kantinProduk extends Model
{
    use HasFactory;

    // kasih tahu Laravel nama tabel sebenarnya
    protected $table = '_product';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
    ];
}
