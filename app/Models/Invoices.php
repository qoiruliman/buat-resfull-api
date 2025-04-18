<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_produk',
        'qty',
        'harga_jual',
        'total',
        'dibayar',
        'dikembalikan',
    ];
}
