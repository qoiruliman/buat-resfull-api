<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_tenant',
        'detail',
    ];
}
