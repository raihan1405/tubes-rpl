<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $fillable = ['nama', 'harga', 'gambar', 'user_id', 'cafe_id'];

    public function cafes()
{
    return $this->belongsToMany(Cafe::class);
}
}
