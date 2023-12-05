<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cafe extends Model
{
    use HasFactory;

    protected $table = 'cafe';
    protected $fillable = ['nama','alamat','gambar','content'];

    public function reviews()
    {
        // Assuming there's a cafe_id foreign key in the reviews table
        return $this->hasMany(Review::class, 'cafe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
    return $this->hasMany(Menu::class);
    }

}
