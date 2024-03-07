<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Penerbit;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    public $timestamps = false;

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id',  'id');
    }
}