<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cafe extends Model
{
    use HasFactory;

    protected $table = 'cafe';

    protected $fillable = ['nama','alamat','gambar','content'];
}
