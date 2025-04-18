<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendapatanTenants extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'total_pendapatan',
        'setoran_tenant',
    ];
}
